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

// === TAMBAHAN: Menghitung Jumlah Guru ===
$query_guru = mysqli_query($conn, "SELECT COUNT(*) AS total FROM t_guru");
$data_guru = mysqli_fetch_assoc($query_guru);
$total_guru = $data_guru['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
<?php include "menu.php"; ?>
        <div class="col-md-9 col-lg-10 p-4">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>JUMLAH DATA SISWA</h5>
                            <h2><?= $total_siswa ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>JUMLAH DATA GURU</h5>
                            <h2><?= $total_guru ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5>JUMLAH PELANGGARAN</h5>
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