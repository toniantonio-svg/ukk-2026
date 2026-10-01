<?php
$halaman = basename($_SERVER['PHP_SELF']);
$role = $_SESSION['role'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Sidebar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- SIDEBAR -->
            <div class="col-md-3 col-lg-2 min-vh-100 p-3" style="background-color: #0d6efd;">
                <h2 class="text-white mb-4">SMK Muhammadiyah Kota Tasikmalaya</h2>
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item mb-2">
                        <a href="dashboard.php" class="nav-link <?= ($halaman == 'dashboard.php') ? 'active' : 'text-white' ?>">Dashboard</a>
                    </li>

                    <?php if ($role === 'admin'): ?>
                    <li class="nav-item mb-2">
                        <a href="guru.php" class="nav-link <?= ($halaman == 'guru.php') ? 'active' : 'text-white' ?>">Kelola Guru</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="siswa.php" class="nav-link <?= ($halaman == 'siswa.php') ? 'active' : 'text-white' ?>">Kelola Siswa</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="kelas.php" class="nav-link <?= ($halaman == 'kelas.php') ? 'active' : 'text-white' ?>">Kelola Kelas</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="kelola_tahun_ajaran.php" class="nav-link <?= ($halaman == 'kelola_tahun_ajaran.php') ? 'active' : 'text-white' ?>">Kelola Tahun Ajaran</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="penempatan_siswa.php" class="nav-link <?= ($halaman == 'penempatan_siswa.php') ? 'active' : 'text-white' ?>">Penempatan Siswa</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="wali_kelas.php" class="nav-link <?= ($halaman == 'wali_kelas.php') ? 'active' : 'text-white' ?>">Kelola Wali Kelas</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="kelola_kategori_pelanggaran.php" class="nav-link <?= ($halaman == 'kelola_kategori_pelanggaran.php') ? 'active' : 'text-white' ?>">Kelola Kategori Pelanggaran</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="kelola_jenis_pelanggaran.php" class="nav-link <?= ($halaman == 'kelola_jenis_pelanggaran.php') ? 'active' : 'text-white' ?>">Kelola Jenis Pelanggaran</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="laporan.php" class="nav-link <?= ($halaman == 'laporan.php') ? 'active' : 'text-white' ?>">Laporan</a>
                    </li>
                    <?php endif; ?>

                    <?php if ($role === 'guru'): ?>
                    <li class="nav-item mb-2">
                        <a href="catat_pelanggaran.php" class="nav-link <?= ($halaman == 'catat_pelanggaran.php') ? 'active' : 'text-white' ?>">Catat Pelanggaran</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="tindakan.php" class="nav-link <?= ($halaman == 'tindakan.php') ? 'active' : 'text-white' ?>">Tindakan</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="laporan.php" class="nav-link <?= ($halaman == 'laporan.php') ? 'active' : 'text-white' ?>">Laporan</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="riwayat.php" class="nav-link <?= ($halaman == 'riwayat.php') ? 'active' : 'text-white' ?>">Riwayat</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="rekap_poin.php" class="nav-link <?= ($halaman == 'rekap_poin.php') ? 'active' : 'text-white' ?>">Rekap Poin</a>
                    </li>
                    <?php endif; ?>

                    <hr class="text-white">
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link text-danger">Logout</a>
                    </li>
                </ul>
            </div>