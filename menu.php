<?php
$halaman = basename($_SERVER['PHP_SELF']);
?>
<div class="col-md-3 col-lg-2 min-vh-100 p-3 position-fixed top-0 start-0"
     style="background-color: #0d6efd;">
<h2 class="text-white mb-4">
    SMK Muhammadiyah Kota Tasikmalaya
</h2>

<ul class="nav nav-pills flex-column">
    <li class="nav-item mb-2">
        <a href="dashboard.php"
           class="nav-link <?= ($halaman == 'dashboard.php') ? 'active text-white' : 'text-white' ?>">
            Dashboard
        </a>
    </li>

    <li class="nav-item mb-2">
        <a href="siswa.php"
           class="nav-link <?= ($halaman == 'siswa.php') ? 'active text-white' : 'text-white' ?>">
            Data Siswa
        </a>
    </li>

    <li class="nav-item mb-2">
        <a href="guru.php"
           class="nav-link <?= ($halaman == 'guru.php') ? 'active text-white' : 'text-white' ?>">
            Data Guru
        </a>
    </li>

    <li class="nav-item mb-2">
        <a href="kelas.php"
           class="nav-link <?= ($halaman == 'kelas.php') ? 'active text-white' : 'text-white' ?>">
            Kelas
        </a>
    </li>

    <li class="nav-item mb-2">
        <a href="tentang.php"
           class="nav-link <?= ($halaman == 'tentang.php') ? 'active text-white' : 'text-white' ?>">
            Tentang
        </a>
    </li>

    <hr class="text-white">

    <li class="nav-item">
        <a href="logout.php" class="nav-link text-danger">
            Logout
        </a>
    </li>
</ul>
</div>