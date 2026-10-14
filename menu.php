<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$halaman = basename($_SERVER['PHP_SELF']);
$role = $_SESSION['role'] ?? '';
?>
<div class="col-md-3 col-lg-2"
     style="background-color: #0d6efd;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;">
    <div class="p-3">
        <h2 class="text-white mb-4">
            SMK Muhammadiyah Kota Tasikmalaya
        </h2>
        <ul class="nav nav-pills flex-column">
            <!-- DASHBOARD: ADMIN DAN GURU -->
            <li class="nav-item mb-2">
                <a href="dashboard.php"
                   class="nav-link <?= $halaman === 'dashboard.php'
                       ? 'active text-white'
                       : 'text-white' ?>">
                    Dashboard
                </a>
            </li>
            <?php if ($role === 'admin'): ?>
                <li class="nav-item mb-2">
                    <a href="guru.php"
                       class="nav-link <?= $halaman === 'guru.php'
                           ? 'active text-white' : 'text-white' ?>">
                        Kelola Guru
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="siswa.php"
                       class="nav-link <?= $halaman === 'siswa.php'
                           ? 'active text-white' : 'text-white' ?>">
                        Kelola Siswa
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelas.php"
                       class="nav-link <?= $halaman === 'kelas.php'
                           ? 'active text-white' : 'text-white' ?>">
                        Kelola Kelas
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelola_tahun_ajaran.php"
                       class="nav-link <?= $halaman === 'kelola_tahun_ajaran.php'
                           ? 'active text-white' : 'text-white' ?>">
                        Kelola Tahun Ajaran
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelola_kategori_pelanggaran.php"
                       class="nav-link <?= $halaman === 'kelola_kategori_pelanggaran.php'
                           ? 'active text-white' : 'text-white' ?>">
                        Kelola Kategori Pelanggaran
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="kelola_jenis_pelanggaran.php"
                       class="nav-link <?= $halaman === 'kelola_jenis_pelanggaran.php'
                           ? 'active text-white' : 'text-white' ?>">
                        Kelola Jenis Pelanggaran
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="laporan.php"
                       class="nav-link <?= $halaman === 'laporan.php'
                           ? 'active text-white' : 'text-white' ?>">
                        Laporan
                    </a>
                </li>
            <?php elseif ($role === 'guru'): ?>
                <li class="nav-item mb-2">
                    <a href="catat_pelanggaran.php"
                       class="nav-link <?= $halaman === 'catat_pelanggaran.php'
                           ? 'active text-white' : 'text-white' ?>">
                        Catat Pelanggaran
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="tindakan.php"
                       class="nav-link <?= $halaman === 'tindakan.php'
                           ? 'active text-white' : 'text-white' ?>">
                        Tindakan
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="riwayat.php"
                       class="nav-link <?= $halaman === 'riwayat.php'
                           ? 'active text-white' : 'text-white' ?>">
                        Riwayat
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="rekap_poin.php"
                       class="nav-link <?= $halaman === 'rekap_poin.php'
                           ? 'active text-white' : 'text-white' ?>">
                        Rekap Poin
                    </a>
                </li>
            <?php endif; ?>
            <hr class="text-white">
            <li class="nav-item mb-2">
                <a href="logout.php" class="nav-link text-white">
                    Logout
                </a>
            </li>
        </ul>
    </div>
</div>