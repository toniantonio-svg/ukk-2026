<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$halaman = basename($_SERVER['PHP_SELF']);
$role = strtolower(trim($_SESSION['role'] ?? ''));
?>
<div class="col-md-3 col-lg-2 bg-primary text-white"
     style="position: sticky; top: 0; height: 100vh; overflow-y: auto; scrollbar-width: none;">
    <style>
        div::-webkit-scrollbar { display: none; width: 0; }
    </style>
    <div class="p-3">
        <h5 class="fw-bold mb-4">SMK Muhammadiyah Kota Tasikmalaya</h5>
        <ul class="nav nav-pills flex-column gap-1">

            <!-- DASHBOARD: SEMUA ROLE -->
            <?php if ($role === 'admin' || $role === 'guru' || $role === 'wali_kelas'): ?>
            <li class="nav-item">
                <a href="dashboard.php"
                   class="nav-link px-3 py-2 <?= $halaman === 'dashboard.php' ? 'active bg-white text-primary fw-semibold' : 'text-white-50 hover-bg-white-10' ?>">
                    Dashboard
                </a>
            </li>
            <?php endif; ?>

            <!-- MENU KHUSUS ADMIN SAJA -->
            <?php if ($role === 'admin'): ?>
            <li class="nav-item">
                <a href="guru.php"
                   class="nav-link px-3 py-2 <?= $halaman === 'guru.php' ? 'active bg-white text-primary fw-semibold' : 'text-white-50' ?>">
                    Kelola Guru
                </a>
            </li>
            <li class="nav-item">
                <a href="siswa.php"
                   class="nav-link px-3 py-2 <?= $halaman === 'siswa.php' ? 'active bg-white text-primary fw-semibold' : 'text-white-50' ?>">
                    Kelola Siswa
                </a>
            </li>
            <li class="nav-item">
                <a href="kelas.php"
                   class="nav-link px-3 py-2 <?= $halaman === 'kelas.php' ? 'active bg-white text-primary fw-semibold' : 'text-white-50' ?>">
                    Kelola Kelas
                </a>
            </li>
            <li class="nav-item">
                <a href="kelola_tahun_ajaran.php"
                   class="nav-link px-3 py-2 <?= $halaman === 'kelola_tahun_ajaran.php' ? 'active bg-white text-primary fw-semibold' : 'text-white-50' ?>">
                    Kelola Tahun Ajaran
                </a>
            </li>
            <li class="nav-item">
                <a href="kelola_penempatan_siswa.php"
                   class="nav-link px-3 py-2 <?= $halaman === 'kelola_penempatan_siswa.php' ? 'active bg-white text-primary fw-semibold' : 'text-white-50' ?>">
                    Kelola Penempatan Siswa
                </a>
            </li>
            <li class="nav-item">
                <a href="kelola_wali_kelas.php"
                   class="nav-link px-3 py-2 <?= $halaman === 'kelola_wali_kelas.php' ? 'active bg-white text-primary fw-semibold' : 'text-white-50' ?>">
                    Kelola Wali Kelas
                </a>
            </li>
            <li class="nav-item">
                <a href="kelola_kategori_pelanggaran.php"
                   class="nav-link px-3 py-2 <?= $halaman === 'kelola_kategori_pelanggaran.php' ? 'active bg-white text-primary fw-semibold' : 'text-white-50' ?>">
                    Kelola Kategori Pelanggaran
                </a>
            </li>
            <li class="nav-item">
                <a href="kelola_jenis_pelanggaran.php"
                   class="nav-link px-3 py-2 <?= $halaman === 'kelola_jenis_pelanggaran.php' ? 'active bg-white text-primary fw-semibold' : 'text-white-50' ?>">
                    Kelola Jenis Pelanggaran
                </a>
            </li>
            <?php endif; ?>

            <!-- CATAT & TINDAKAN: GURU & WALI KELAS -->
            <?php if ($role === 'guru' || $role === 'wali_kelas'): ?>
            <li class="nav-item">
                <a href="catat_pelanggaran.php"
                   class="nav-link px-3 py-2 <?= $halaman === 'catat_pelanggaran.php' ? 'active bg-white text-primary fw-semibold' : 'text-white-50' ?>">
                    Catat Pelanggaran
                </a>
            </li>
            <li class="nav-item">
                <a href="tindakan.php"
                   class="nav-link px-3 py-2 <?= $halaman === 'tindakan.php' ? 'active bg-white text-primary fw-semibold' : 'text-white-50' ?>">
                    Tindakan
                </a>
            </li>
            <?php endif; ?>

            <!-- REKAP POIN: GURU & WALI KELAS -->
            <?php if ($role === 'guru' || $role === 'wali_kelas'): ?>
            <li class="nav-item">
                <a href="rekap_poin.php"
                   class="nav-link px-3 py-2 <?= $halaman === 'rekap_poin.php' ? 'active bg-white text-primary fw-semibold' : 'text-white-50' ?>">
                    Rekap Poin
                </a>
            </li>
            <?php endif; ?>

            <!-- LAPORAN: ADMIN & WALI KELAS -->
            <?php if ($role === 'admin' || $role === 'wali_kelas'): ?>
            <li class="nav-item">
                <a href="laporan.php"
                   class="nav-link px-3 py-2 <?= $halaman === 'laporan.php' ? 'active bg-white text-primary fw-semibold' : 'text-white-50' ?>">
                    Laporan
                </a>
            </li>
            <?php endif; ?>

            <!-- RIWAYAT: GURU & WALI KELAS -->
            <?php if ($role === 'guru' || $role === 'wali_kelas'): ?>
            <li class="nav-item">
                <a href="riwayat.php"
                   class="nav-link px-3 py-2 <?= $halaman === 'riwayat.php' ? 'active bg-white text-primary fw-semibold' : 'text-white-50' ?>">
                    Riwayat
                </a>
            </li>
            <?php endif; ?>

            <!-- EXPORT: KHUSUS ADMIN -->
            <?php if ($role === 'admin'): ?>
            <li class="nav-item">
                <a href="export.php"
                   class="nav-link px-3 py-2 <?= $halaman === 'export.php' ? 'active bg-white text-primary fw-semibold' : 'text-white-50' ?>">
                    Cetak/Export
                </a>
            </li>
            <?php endif; ?>

            <li><hr class="my-3 text-white-50"></li>

            <li class="nav-item">
                <a href="logout.php" class="nav-link px-3 py-2 text-white-50">
                    Keluar
                </a>
            </li>
        </ul>
    </div>
</div>