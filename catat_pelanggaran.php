<?php
require_once "config.php";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once "cek_session.php"; cek_login();

function e($v) { return htmlspecialchars((string)($v??''), ENT_QUOTES, 'UTF-8'); }

$nama = $_SESSION['name'];
$role = strtolower(trim($_SESSION['role']));
if ($role !== 'guru' && $role !== 'wali_kelas') {
    echo "<script>alert('Anda tidak berhak!');location.href='dashboard.php';</script>"; exit;
}

$kelas_id = 0; $nama_kelas = '';
if ($role === 'wali_kelas') {
    $q = mysqli_query($conn, "SELECT w.kelas_id,k.nama FROM t_wali_kelas w JOIN t_kelas k ON w.kelas_id=k.id LEFT JOIN t_guru g ON w.guru_id=g.id WHERE w.status_aktif=1 AND g.nama LIKE '%".mysqli_real_escape_string($conn,$nama)."%' LIMIT 1");
    if ($q && $r = mysqli_fetch_assoc($q)) { $kelas_id = $r['kelas_id']; $nama_kelas = $r['nama']; }
}

$daftar_s = [];
if ($role === 'wali_kelas' && $kelas_id > 0) {
    $q_s = mysqli_query($conn, "SELECT id,nama,nis FROM t_siswa s INNER JOIN t_kelas_siswa ks ON s.id=ks.siswa_id WHERE ks.kelas_id='$kelas_id' ORDER BY nama");
} else {
    $q_s = mysqli_query($conn, "SELECT id,nama,nis FROM t_siswa ORDER BY nama");
}
if ($q_s) while ($r = mysqli_fetch_assoc($q_s)) $daftar_s[] = $r;

$daftar_k = [];
$q_k = mysqli_query($conn, "SELECT * FROM t_pelanggaran_kategori WHERE status_aktif=1 ORDER BY poin,nama");
if ($q_k) while ($r = mysqli_fetch_assoc($q_k)) $daftar_k[] = $r;

$pesan = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['siswa_id'])) {
    $sid = (int)$_POST['siswa_id'];
    $kid = (int)($_POST['kategori_id']??0);
    $ket = trim($_POST['keterangan']??'');
    $poin = 0;
    if ($kid) {
        $p = mysqli_fetch_assoc(mysqli_query($conn, "SELECT poin FROM t_pelanggaran_kategori WHERE id=$kid"));
        $poin = (int)($p['poin']??0);
    }
    if ($role === 'wali_kelas' && $kelas_id) {
        $cek = mysqli_num_rows(mysqli_query($conn, "SELECT 1 FROM t_kelas_siswa WHERE siswa_id=$sid AND kelas_id=$kelas_id"));
        if (!$cek) $pesan = '<div class="alert alert-danger">Siswa tidak terdaftar di kelas Anda!</div>';
    }
    if (!$pesan) {
        $sql = "INSERT INTO t_pelanggaran_siswa VALUES ('',$sid,$kid,'".mysqli_real_escape_string($conn,$ket)."',$poin,NOW())";
        if (mysqli_query($conn,$sql)) $pesan = '<div class="alert alert-success">Berhasil disimpan! Poin: '.$poin.'</div>';
        else $pesan = '<div class="alert alert-danger">Gagal: '.mysqli_error($conn).'</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catat Pelanggaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
    <div class="container-fluid"><div class="row">
    <?php include "menu.php"; ?>
    <main class="col-md-9 col-lg-10 p-4">
    <h2 class="mb-3">Catat Pelanggaran Siswa</h2>
    <p>Selamat datang, <strong><?=e($nama)?></strong>!</p>
    <?php if ($role==='wali_kelas'): ?>
    <div class="alert alert-info mb-4">Anda hanya mencatat pelanggaran di kelas: <strong><?=e($nama_kelas)?></strong></div>
    <?php endif; ?>
    <?=$pesan?>
    <?php if (!$daftar_k): ?><div class="alert alert-warning">Kategori pelanggaran belum ada!</div><?php endif; ?>

<form method="post" class="card shadow-sm p-4">
<div class="mb-3">
<label class="form-label fw-bold">Nama Siswa</label>
<input type="text" id="cariS" class="form-control mb-2" placeholder="Ketik nama/NIS..." onkeyup="filterS()">
<select name="siswa_id" id="selectS" class="form-select form-select-lg" required size="8">
<option value="">-- Pilih Siswa --</option>
<?php foreach($daftar_s as $s): ?>
<option value="<?=$s['id']?>" data-nm="<?=strtolower(e($s['nama']))?>" data-ns="<?=e($s['nis'])?>">
<?=e($s['nama'])?> — NIS: <?=e($s['nis'])?>
</option>
<?php endforeach; ?>
</select>
</div>

<div class="mb-3">
<label class="form-label fw-bold">Kategori Pelanggaran</label>
<select name="kategori_id" id="kat" class="form-select form-select-lg" required onchange="setPoin()">
<option value="">-- Pilih Jenis --</option>
<?php foreach($daftar_k as $k): ?>
<option value="<?=$k['id']?>" data-poin="<?=$k['poin']?>"><?=e($k['nama'])?></option>
<?php endforeach; ?>
</select>
</div>

<div class="mb-3">
<label class="form-label fw-bold">Keterangan Tambahan</label>
<textarea name="keterangan" class="form-control" rows="2" placeholder="Tulis jika ada..."></textarea>
</div>

<div class="mb-4">
<label class="form-label fw-bold">Poin</label>
<input type="number" id="poin" class="form-control form-select-lg" min="1" readonly placeholder="Muncul otomatis">
</div>

<button type="submit" class="btn btn-primary btn-lg w-100">Simpan Pelanggaran</button>
</form>
</main>
</div></div>

<script>
function filterS() {
const k = document.getElementById('cariS').value.toLowerCase().trim();
const ops = document.querySelectorAll('#selectS option');
let a = false;
ops.forEach(o=>{
if(!o.value)return;
if(o.dataset.nm.includes(k)||o.dataset.ns.includes(k)){o.style.display='';a=true}else o.style.display='none';
});
document.querySelector('#selectS option[value=""]').textContent = k&&!a?'Tidak ditemukan — coba kata lain':'-- Pilih Siswa --';
}
function setPoin() {
const s = document.getElementById('kat');
document.getElementById('poin').value = s.selectedIndex?s.options[s.selectedIndex].dataset.poin:'';
}
</script>
<?php file_exists("footer.php") && include "footer.php"; ?>
</body>
</html>