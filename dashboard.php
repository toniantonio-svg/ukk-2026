<?php

require_once "cek_session.php";

cek_login();

$nama = $_SESSION['name'];
$role = $_SESSION['role'];

require_once "config.php";

$query_siswa = mysqli_query($conn, "SELECT COUNT(*) AS total FROM t_siswa");
$data_siswa = mysqli_fetch_assoc($query_siswa);
$total_siswa = $data_siswa['total'];

$query_pelanggaran = mysqli_query($conn, "SELECT COUNT(*) AS total FROM t_pelanggaran");
$data_pelanggaran = mysqli_fetch_assoc($query_pelanggaran);
$total_pelanggaran = $data_pelanggaran['total'];

?>
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
</head>

<body>
<body>
<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-3 col-lg-2 min-vh-100 p-3" style="background-color: #0d6efd;">

            <h2 class="text-white mb-4">
                SMK Muhammadiyah Kota Tasikmalaya
            </h2>

            <ul class="nav nav-pills flex-column">

                <li class="nav-item mb-2">
                    <a href="dashboard.php" class="nav-link active">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="siswa.php" class="nav-link text-white">
                        Data Siswa
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="guru.php" class="nav-link text-white">
                        Data Guru
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="kelas.php" class="nav-link text-white">
                        Kelas
                    </a>
                </li>

                <li class="nav-item mb-2">
                    <a href="tentang.php" class="nav-link text-white">
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

        <div class="col-md-9 col-lg-10 p-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Data Siswa</h5>
                            <h2><?= $total_siswa ?></h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>Pelanggaran</h5>
                            <h2 class="bs-secondary-bg-rgb"><?= $total_pelanggaran ?></h2>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>
    <?php include "footer.php"; ?>
</body>
</html>