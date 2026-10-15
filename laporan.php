<?php
// 🔴 WAJIB PALING ATAS — Mulai sesi DULU
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "config.php";
require_once "cek_session.php";
cek_login();

$role = $_SESSION['role'] ?? '';

// Hanya Admin, Guru, Wali Kelas yang boleh akses
if ($role !== 'admin' && $role !== 'guru' && $role !== 'wali_kelas') {
    header("Location: dashboard.php?pesan=akses_ditolak");
    exit;
}

$nama = $_SESSION['name'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan - SMK Muhammadiyah Kota Tasikmalaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include "menu.php"; ?>
        <main class="col-md-9 col-lg-10 ms-auto p-4">
            <h2 class="mb-4">Laporan Pelanggaran Siswa</h2>
            <p>Selamat datang, <strong><?= htmlspecialchars($nama) ?></strong>!</p>
            
            <div class="alert alert-info">
                Halaman ini menampilkan laporan pelanggaran siswa.
            </div>
            
            <!-- Isi laporan di sini -->
        </main>
    </div>
</div>
<?php if (file_exists("footer.php")) include "footer.php"; ?>
</body>
</html>