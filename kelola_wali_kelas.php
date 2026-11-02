
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

require_once "config.php";
require_once "cek_session.php";
cek_admin();

function e($v) {
    return htmlspecialchars((string)($v ?? '-'), ENT_QUOTES, 'UTF-8');
}

$pesan = '';

/* SIMPAN WALI KELAS */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $gid = (int)($_POST['guru_id'] ?? 0);
    $kid = (int)($_POST['kelas_id'] ?? 0);
    $tid = (int)($_POST['tahun_ajaran_id'] ?? 0);
    $transaksi = false;

    try {
        if (!$gid || !$kid || !$tid) {
            throw new Exception("Lengkapi semua data!");
        }

        mysqli_begin_transaction($conn);
        $transaksi = true;

        // Ambil guru
        $stmt = $conn->prepare("SELECT * FROM t_guru WHERE id=? AND status_aktif=1");
        $stmt->bind_param("i", $gid);
        $stmt->execute();
        $guru = $stmt->get_result()->fetch_assoc();

        if (!$guru) throw new Exception("Guru tidak ditemukan!");

        // Cek kelas
        $stmt = $conn->prepare("SELECT id FROM t_kelas WHERE id=? AND status_aktif=1");
        $stmt->bind_param("i", $kid);
        $stmt->execute();
        if (!$stmt->get_result()->num_rows) throw new Exception("Kelas tidak ditemukan!");

        // Ambil tahun ajaran
        $stmt = $conn->prepare("SELECT tanggal_mulai,tanggal_selesai FROM t_tahun_ajaran WHERE id=? AND status_aktif=1");
        $stmt->bind_param("i", $tid);
        $stmt->execute();
        $tahun = $stmt->get_result()->fetch_assoc();

        if (!$tahun) throw new Exception("Tahun ajaran tidak ditemukan!");

        // Cek guru sudah menjadi wali kelas
        $stmt = $conn->prepare("SELECT id FROM t_wali_kelas WHERE guru_id=? AND status_aktif=1");
        $stmt->bind_param("i", $gid);
        $stmt->execute();
        if ($stmt->get_result()->num_rows) throw new Exception("Guru sudah menjadi wali kelas!");

        // Cek kelas sudah memiliki wali kelas
        $stmt = $conn->prepare("SELECT id FROM t_wali_kelas WHERE kelas_id=? AND tahun_ajaran_id=? AND status_aktif=1");
        $stmt->bind_param("ii", $kid, $tid);
        $stmt->execute();
        if ($stmt->get_result()->num_rows) throw new Exception("Kelas sudah memiliki wali kelas!");

        // Buat atau hubungkan akun
        $email = trim($guru['email'] ?? '');

        if (!$email) {
            $email = !empty($guru['nip'])
                ? $guru['nip'].'@sekolah.sch.id'
                : 'g'.$gid.'@sekolah.sch.id';
        }

        $akun = null;

        if (!empty($guru['user_id'])) {
            $uid = (int)$guru['user_id'];
            $stmt = $conn->prepare("SELECT id,role FROM t_users WHERE id=?");
            $stmt->bind_param("i", $uid);
            $stmt->execute();
            $akun = $stmt->get_result()->fetch_assoc();
        }

        if (!$akun) {
            $stmt = $conn->prepare("SELECT id,role FROM t_users WHERE email=?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $akun = $stmt->get_result()->fetch_assoc();
        }

        if ($akun) {
            if ($akun['role'] === 'admin') {
                throw new Exception("Email digunakan oleh administrator!");
            }

            $user_id = (int)$akun['id'];

            $stmt = $conn->prepare("UPDATE t_users SET name=?,role='wali_kelas' WHERE id=?");
            $stmt->bind_param("si", $guru['nama'], $user_id);
            $stmt->execute();

        } else {
            $password = password_hash('guru123', PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO t_users (name,email,email_verified_at,password,remember_token,role) VALUES (?,?,NOW(),?,NULL,'wali_kelas')");
            $stmt->bind_param("sss", $guru['nama'], $email, $password);
            $stmt->execute();

            $user_id = $conn->insert_id;
        }

        // Hubungkan akun ke guru
        $stmt = $conn->prepare("UPDATE t_guru SET user_id=? WHERE id=?");
        $stmt->bind_param("ii", $user_id, $gid);
        $stmt->execute();

        // Simpan wali kelas
        $stmt = $conn->prepare("INSERT INTO t_wali_kelas (tahun_ajaran_id,kelas_id,guru_id,tanggal_mulai,tanggal_selesai,status_aktif) VALUES (?,?,?,?,?,1)");
        $stmt->bind_param("iiiss", $tid, $kid, $gid, $tahun['tanggal_mulai'], $tahun['tanggal_selesai']);
        $stmt->execute();

        mysqli_commit($conn);
        $transaksi = false;

        header("Location: kelola_wali_kelas.php?berhasil=1");
        exit;

    } catch (Throwable $err) {
        if ($transaksi) mysqli_rollback($conn);
        $pesan = '<div class="alert alert-danger">'.e($err->getMessage()).'</div>';
    }
}

/* CABUT STATUS */
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];

    $stmt = $conn->prepare("UPDATE t_wali_kelas SET status_aktif=0 WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: kelola_wali_kelas.php");
    exit;
}

if (isset($_GET['berhasil'])) {
    $pesan = '<div class="alert alert-success">Wali kelas berhasil ditetapkan dan akun berhasil dibuat atau dihubungkan!</div>';
}

/* DATA WALI KELAS */
$total = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) AS x FROM t_wali_kelas WHERE status_aktif=1"
))['x'];

$result = mysqli_query($conn,
    "SELECT wk.*,g.nama AS guru,g.nip,k.nama AS kelas,ta.nama AS tahun
     FROM t_wali_kelas wk
     LEFT JOIN t_guru g ON wk.guru_id=g.id
     LEFT JOIN t_kelas k ON wk.kelas_id=k.id
     LEFT JOIN t_tahun_ajaran ta ON wk.tahun_ajaran_id=ta.id
     WHERE wk.status_aktif=1 ORDER BY wk.id DESC"
);

/* PILIHAN GURU */
$guru_list = mysqli_query($conn,
    "SELECT id,nama,nip FROM t_guru
     WHERE status_aktif=1
     AND id NOT IN (
         SELECT guru_id FROM t_wali_kelas
         WHERE status_aktif=1 AND guru_id IS NOT NULL
     )
     ORDER BY nama"
);

$daftar_g = [];
while ($g = mysqli_fetch_assoc($guru_list)) $daftar_g[] = $g;
$sisa_g = count($daftar_g);

/* PILIHAN KELAS */
$kelas_list = mysqli_query($conn,
    "SELECT id,nama FROM t_kelas WHERE status_aktif=1 ORDER BY nama"
);

$daftar_k = [];
while ($k = mysqli_fetch_assoc($kelas_list)) $daftar_k[] = $k;

/* PILIHAN TAHUN AJARAN */
$tahun_list = mysqli_query($conn,
    "SELECT id,nama FROM t_tahun_ajaran WHERE status_aktif=1 ORDER BY nama"
);
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
.table td,.table th {vertical-align:middle;white-space:nowrap}
.rel {position:relative}
.list {
    position:absolute;z-index:100;width:100%;max-height:240px;
    overflow-y:auto;background:white;border:1px solid #ced4da;
    box-shadow:0 4px 12px rgba(0,0,0,.15);display:none;
}
.itm {padding:8px 12px;cursor:pointer;border-bottom:1px solid #eee}
.itm:hover {background:#e3f2fd}
.emp {padding:12px;color:#777}
.sel {margin-top:8px;padding:8px;background:#e3f2fd;border-radius:5px;display:none}
</style>
</head>

<body>
<div class="container-fluid">
<div class="row">

<?php include "menu.php"; ?>

<main class="col-md-9 col-lg-10 p-4">

<h2 class="mb-4">Kelola Wali Kelas</h2>

<div class="row mb-4">
<div class="col-md-5 col-lg-4">
<div class="card shadow-sm border-0">
<div class="card-body">
<h6 class="text-muted">JUMLAH WALI KELAS AKTIF</h6>
<h2 class="text-primary fw-bold"><?= $total ?></h2>
<p class="text-muted small">Sisa guru: <strong class="text-success"><?= $sisa_g ?></strong> orang</p>
</div>
</div>
</div>
</div>

<div class="card shadow-sm border-0 mb-4">
<div class="card-body">

<h5 class="mb-3">Tetapkan Wali Kelas Baru</h5>
<?= $pesan ?>

<?php if (!$sisa_g): ?>
<div class="alert alert-info">Semua guru sudah menjadi wali kelas.</div>
<?php else: ?>

<form method="POST" class="row g-3">

<div class="col-md-4 rel">
<label class="form-label">Nama Guru</label>
<input type="text" id="cg" class="form-control" placeholder="Ketik nama guru..." autocomplete="off">
<input type="hidden" name="guru_id" id="gid" required>

<div class="sel" id="gs">
Dipilih: <span id="gn"></span>
<button type="button" class="btn btn-sm btn-outline-secondary" onclick="rg()">Ubah</button>
</div>

<div class="list" id="dg">
<?php foreach ($daftar_g as $g): ?>
<div class="itm" data-id="<?= $g['id'] ?>" data-teks="<?= e(strtolower($g['nama'].' '.$g['nip'])) ?>">
<?= e($g['nama']) ?> <small class="text-muted"><?= e($g['nip']) ?></small>
</div>
<?php endforeach; ?>
</div>
</div>

<div class="col-md-4 rel">
<label class="form-label">Kelas</label>
<input type="text" id="ck" class="form-control" placeholder="Ketik nama kelas..." autocomplete="off">
<input type="hidden" name="kelas_id" id="kid" required>

<div class="sel" id="ks">
Dipilih: <span id="kn"></span>
<button type="button" class="btn btn-sm btn-outline-secondary" onclick="rk()">Ubah</button>
</div>

<div class="list" id="dk">
<?php foreach ($daftar_k as $k): ?>
<div class="itm" data-id="<?= $k['id'] ?>" data-teks="<?= e(strtolower($k['nama'])) ?>">
<?= e($k['nama']) ?>
</div>
<?php endforeach; ?>
</div>
</div>

<div class="col-md-4">
<label class="form-label">Tahun Ajaran</label>
<select name="tahun_ajaran_id" class="form-select" required>
<option value="">-- Pilih Tahun --</option>
<?php while ($t = mysqli_fetch_assoc($tahun_list)): ?>
<option value="<?= $t['id'] ?>"><?= e($t['nama']) ?></option>
<?php endwhile; ?>
</select>
</div>

<div class="col-12">
<button type="submit" name="simpan" value="1" class="btn btn-primary">
Tetapkan & Buat Akun
</button>
</div>

</form>
<?php endif; ?>

</div>
</div>

<div class="card shadow-sm border-0">
<div class="card-body">

<h5 class="mb-3">Daftar Wali Kelas</h5>

<div class="table-responsive">
<table id="t" class="table table-bordered table-striped table-hover w-100">
<thead class="table-primary">
<tr>
<th>No</th>
<th>Nama Guru</th>
<th>NIP/Email</th>
<th>Kelas</th>
<th>Tahun</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>
<?php $no=1; while ($r=mysqli_fetch_assoc($result)): ?>
<tr>
<td><?= $no++ ?></td>
<td><?= e($r['guru']) ?></td>
<td>
<?= e($r['nip']) ?><br>
<small class="text-muted">
<?= e($r['nip'] ? $r['nip'].'@sekolah.sch.id' : '-') ?>
</small>
</td>
<td><?= e($r['kelas']) ?></td>
<td><?= e($r['tahun']) ?></td>
<td>
<a href="?hapus=<?= (int)$r['id'] ?>"
class="btn btn-sm btn-danger"
onclick="return confirm('Cabut status wali kelas? Guru dan akun tidak dihapus.')">
Cabut
</a>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>

</div>
</div>

</main>
</div>
</div>

<?php include "footer.php"; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<script>
function setup(input,list,hidden,nama,selected) {
    const c=document.getElementById(input);
    const l=document.getElementById(list);
    const v=document.getElementById(hidden);
    const n=document.getElementById(nama);
    const s=document.getElementById(selected);
    const items=[...l.querySelectorAll('.itm')];

    c.addEventListener('input',()=>{
        const q=c.value.toLowerCase().trim();
        let jumlah=0;

        items.forEach(i=>{
            i.style.display=i.dataset.teks.includes(q)?'block':'none';
            if(i.dataset.teks.includes(q)) jumlah++;
        });

        let emp=l.querySelector('.emp');
        if(!jumlah && !emp){
            emp=document.createElement('div');
            emp.className='emp';
            emp.textContent='Tidak ditemukan';
            l.appendChild(emp);
        } else if(jumlah && emp) emp.remove();

        l.style.display=q?'block':'none';
    });

    l.addEventListener('click',e=>{
        const i=e.target.closest('.itm');
        if(!i)return;
        v.value=i.dataset.id;
        n.textContent=i.textContent.trim();
        c.style.display='none';
        l.style.display='none';
        s.style.display='block';
    });

    return ()=>{
        c.value='';
        v.value='';
        c.style.display='block';
        s.style.display='none';
        l.style.display='none';
        items.forEach(i=>i.style.display='block');
        l.querySelector('.emp')?.remove();
        c.focus();
    };
}

const rg=setup('cg','dg','gid','gn','gs');
const rk=setup('ck','dk','kid','kn','ks');

document.addEventListener('click',e=>{
    if(!e.target.closest('.rel'))
        document.querySelectorAll('.list').forEach(l=>l.style.display='none');
});

$(function(){
    $('#t').DataTable({
        language:{url:'https://cdn.datatables.net/plug-ins/2.3.4/i18n/id.json'},
        pageLength:10,
        lengthMenu:[5,10,25,50],
        order:[[0,'asc']],
        columnDefs:[{targets:[0,5],orderable:false,searchable:false}],
        autoWidth:false
    });
});
</script>

</body>
</html>