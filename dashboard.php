<?php
require_once "cek_session.php";
cek_login();

$nama = $_SESSION['name'];
$role = $_SESSION['role'];
?>

<h2>Dashboard</h2>

<p>Selamat datang, <?= $nama ?></p>
<p>Role: <?= $role ?></p>

<hr>

<h3>Menu</h3>

<?php if ($role == "admin") { ?>

    <a href="siswa.php">Siswa</a>
    <br><br>

    <a href="guru.php">Guru</a>
    <br><br

<?php } ?>

<a href="pelanggaran.php">Pelanggaran</a>
<br><br>

<a href="kelas.php">Kelas</a>
<br><br>

<a href="tentang.php">Tentang</a>
<br><br>

<a href="logout.php">Logout</a>

<?php include "footer.php"; ?>