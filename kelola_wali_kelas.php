<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
require_once "config.php"; require_once "cek_session.php"; cek_admin();

function e($v) { return htmlspecialchars((string)($v??'-'), ENT_QUOTES, 'UTF-8'); }

// Total & Data
$total = (int)mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) x FROM t_wali_kelas WHERE status_aktif=1"))['x'];
$result = mysqli_query($conn, "SELECT wk.*,g.nama guru,g.nip,k.nama kelas,ta.nama tahun 
    FROM t_wali_kelas wk LEFT JOIN t_guru g ON wk.guru_id=g.id 
    LEFT JOIN t_kelas k ON wk.kelas_id=k.id LEFT JOIN t_tahun_ajaran ta ON wk.tahun_ajaran_id=ta.id 
    WHERE wk.status_aktif=1 ORDER BY wk.id DESC");

// Daftar Pilihan
$guru_list = mysqli_query($conn, "SELECT id,nama,nip FROM t_guru 
    WHERE id NOT IN (SELECT DISTINCT guru_id FROM t_wali_kelas WHERE status_aktif=1 AND guru_id IS NOT NULL) ORDER BY nama");
$daftar_g = []; while ($g = mysqli_fetch_assoc($guru_list)) $daftar_g[] = $g;
$sisa_g = count($daftar_g);

$kelas_list = mysqli_query($conn, "SELECT id,nama FROM t_kelas ORDER BY nama");
$daftar_k = []; while ($k = mysqli_fetch_assoc($kelas_list)) $daftar_k[] = $k;
$tahun_list = mysqli_query($conn, "SELECT id,nama FROM t_tahun_ajaran WHERE status_aktif=1 ORDER BY nama");

// Simpan
if ($_POST['simpan']??'') {
    $gid = trim($_POST['guru_id']??''); $kid = trim($_POST['kelas_id']??''); $tid = trim($_POST['tahun_ajaran_id']??'');
    if (!$gid || !$kid || !$tid) $pesan = '<div class="alert alert-danger">Lengkapi semua data!</div>';
    else {
        $cek = mysqli_query($conn, "SELECT 1 FROM t_wali_kelas WHERE guru_id='$gid' AND status_aktif=1 LIMIT 1");
        if (mysqli_num_rows($cek)) $pesan = '<div class="alert alert-warning">Guru sudah jadi wali kelas!</div>';
        else {
            $cek = mysqli_query($conn, "SELECT 1 FROM t_wali_kelas WHERE kelas_id='$kid' AND tahun_ajaran_id='$tid' AND status_aktif=1 LIMIT 1");
            if (mysqli_num_rows($cek)) $pesan = '<div class="alert alert-warning">Kelas sudah punya wali kelas!</div>';
            else {
                $guru = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama,nip FROM t_guru WHERE id='$gid'"));
                if (!$guru) $pesan = '<div class="alert alert-danger">Guru tidak ditemukan!</div>';
                else {
                    $email = $guru['nip'] ? $guru['nip'].'@sekolah.sch.id' : "g_$gid@sekolah.sch.id";
                    mysqli_begin_transaction($conn);
                    try {
                        mysqli_query($conn, "INSERT INTO t_wali_kelas VALUES ('','$gid','$kid','$tid',1)");
                        if (!mysqli_num_rows(mysqli_query($conn, "SELECT id FROM t_users WHERE email='$email'")))
                            mysqli_query($conn, "INSERT INTO t_users VALUES ('','{$guru['nama']}','$email','".password_hash('123456',PASSWORD_DEFAULT)."','wali_kelas',NOW(),NOW())");
                        mysqli_commit($conn); header("Location: kelola_wali_kelas.php"); exit;
                    } catch(Exception $e) { mysqli_rollback($conn); $pesan = '<div class="alert alert-danger">Gagal!</div>'; }
                }
            }
        }
    }
}

if ($_GET['hapus']??'') { mysqli_query($conn, "UPDATE t_wali_kelas SET status_aktif=0 WHERE id=".(int)$_GET['hapus']); header("Location: kelola_wali_kelas.php"); exit; }
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Kelola Wali Kelas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<style>
.table td,.table th{vertical-align:middle;white-space:nowrap}
.rel{position:relative}
.list{position:absolute;z-index:100;width:100%;max-height:240px;overflow-y:auto;background:#fff;border:1px solid #ced4da;border-top:none;border-radius:0 0 .375rem .375rem;box-shadow:0 4px 12px rgba(0,0,0,.15);display:none}
.list .itm{padding:.5rem .75rem;cursor:pointer;border-bottom:1px solid #f1f1f1}
.list .itm:hover{background:#e3f2fd}
.list .emp{padding:.75rem;color:#6c757d;font-style:italic}
.sel{margin-top:.5rem;padding:.4rem .75rem;background:#e3f2fd;border-radius:.375rem;display:none}
</style>
</head>
<body>
<div class="container-fluid"><div class="row">
<?php include "menu.php"; ?>
<main class="col-md-9 col-lg-10 p-4">
<h2 class="mb-4">Kelola Wali Kelas</h2>

<div class="row mb-4"><div class="col-md-5 col-lg-4">
<div class="card shadow-sm border-0"><div class="card-body">
<h5 class="card-title text-muted fs-6">JUMLAH WALI KELAS AKTIF</h5>
<h2 class="text-primary fw-bold"><?= $total ?></h2>
<p class="text-muted small mt-2">Sisa guru: <strong class="text-success"><?= $sisa_g ?></strong> orang</p>
</div></div></div></div>

<div class="card shadow-sm border-0 mb-4"><div class="card-body">
<h5 class="mb-3">Tetapkan Wali Kelas Baru</h5>
<?= $pesan??'' ?>

<?php if (!$sisa_g): ?>
<div class="alert alert-info">Semua guru sudah jadi wali kelas.<br>Klik <b>Cabut Status</b> di bawah untuk ubah.</div>
<?php else: ?>
<form method="post" class="row g-3">
<div class="col-md-4 rel">
<label class="form-label">Nama Guru</label>
<input type="text" id="cg" class="form-control" placeholder="Ketik nama guru..." autocomplete="off">
<input type="hidden" name="guru_id" id="gid" required>
<div class="sel" id="gs"><strong>Dipilih:</strong> <span id="gn"></span> <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="rg()">Ubah</button></div>
<div class="list" id="dg">
<?php foreach($daftar_g as $g): ?>
<div class="itm" data-id="<?= $g['id'] ?>" data-teks="<?= strtolower($g['nama'].' '.$g['nip']) ?>">
<?= e($g['nama']) ?><?= $g['nip']?" <small class='text-muted'>({$g['nip']})</small>":'' ?>
</div><?php endforeach; ?>
</div></div>

<div class="col-md-4 rel">
<label class="form-label">Kelas</label>
<input type="text" id="ck" class="form-control" placeholder="Ketik nama kelas..." autocomplete="off">
<input type="hidden" name="kelas_id" id="kid" required>
<div class="sel" id="ks"><strong>Dipilih:</strong> <span id="kn"></span> <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="rk()">Ubah</button></div>
<div class="list" id="dk">
<?php foreach($daftar_k as $k): ?>
<div class="itm" data-id="<?= $k['id'] ?>" data-teks="<?= strtolower($k['nama']) ?>"><?= e($k['nama']) ?></div>
<?php endforeach; ?>
</div></div>

<div class="col-md-4">
<label class="form-label">Tahun Ajaran</label>
<select name="tahun_ajaran_id" class="form-select" required>
<option value="">-- Pilih Tahun --</option>
<?php while($t=mysqli_fetch_assoc($tahun_list)): ?>
<option value="<?= $t['id'] ?>"><?= e($t['nama']) ?></option>
<?php endwhile; ?>
</select></div>

<div class="col-12"><button type="submit" name="simpan" class="btn btn-primary">Tetapkan & Buat Akun</button></div>
</form>
<?php endif; ?>
</div></div>

<div class="card shadow-sm border-0"><div class="card-body">
<h5 class="mb-3">Daftar Wali Kelas</h5><div class="table-responsive">
<table id="t" class="table table-bordered table-striped table-hover w-100">
<thead class="table-primary text-white"><tr>
<th class="text-center" width="5%">No</th><th width="25%">Nama Guru</th><th width="22%">NIP/Email</th>
<th width="18%">Kelas</th><th width="15%">Tahun</th><th class="text-center" width="15%">Aksi</th>
</tr></thead><tbody>
<?php $no=1; while($r=mysqli_fetch_assoc($result)): 
$em = $r['nip']?$r['nip'].'@sekolah.sch.id':'-';
?>
<tr>
<td class="text-center"><?=$no++?></td><td><?=e($r['guru'])?></td>
<td><div><?=e($r['nip'])?></div><small class="text-muted"><?=e($em)?></small></td>
<td><?=e($r['kelas'])?></td><td><?=e($r['tahun'])?></td>
<td class="text-center text-nowrap">
<a href="?hapus=<?=$r['id']?>" class="btn btn-sm btn-danger" onclick="return confirm('Cabut status? Guru TIDAK dihapus. Lanjutkan?')">Cabut</a>
</td></tr>
<?php endwhile; ?>
</tbody></table>
</div></div></div>
</main></div></div>
<?php include "footer.php"; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
function setup(cariId,listId,valId,nmId,selId){
const c=document.getElementById(cariId),l=document.getElementById(listId),v=document.getElementById(valId),n=document.getElementById(nmId),s=document.getElementById(selId);
c.addEventListener('input',()=>{
const k=c.value.toLowerCase().trim();
if(!k)return l.style.display='none';
l.style.display='block';let a=0;l.querySelectorAll('.itm').forEach(i=>{i.style.display=i.dataset.teks.includes(k)?(a=1,'block'):'none'});
if(!a)l.innerHTML='<div class="emp">Tidak ditemukan</div>';
});
l.addEventListener('click',e=>{
const i=e.target.closest('.itm');if(!i)return;
v.value=i.dataset.id;n.innerHTML=i.innerHTML;c.style.display='none';l.style.display='none';s.style.display='block';
});
return ()=>{c.value='';c.style.display='block';s.style.display='none';c.focus()};
}
const rg=setup('cg','dg','gid','gn','gs');
const rk=setup('ck','dk','kid','kn','ks');
document.addEventListener('click',e=>{if(!e.target.closest('.rel'))document.querySelectorAll('.list').forEach(x=>x.style.display='none')});
$(function(){$('#t').DataTable({language:{url:'https://cdn.datatables.net/plug-ins/2.3.4/i18n/id.json'},pageLength:10,lengthMenu:[[5,10,25,50,-1],[5,10,25,50,'Semua']],order:[[0,'asc']],columnDefs:[{targets:[0,5],orderable:false,searchable:false,className:'text-center'}],autoWidth:false});});
</script>
</body></html>