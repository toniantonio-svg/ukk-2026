<?php
require_once "config.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 🔴 LANGSUNG DI ATAS — Blokir Wali Kelas DULU sebelum apa pun
if (isset($_SESSION['role']) && $_SESSION['role'] === 'wali_kelas') {
    header("Location: laporan.php");
    exit;
}

// Baru setelah itu cek login
require_once "cek_session.php";
cek_login();

$nama = $_SESSION['name'];
$role = strtolower(trim($_SESSION['role']));

$query_siswa = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM t_siswa"
);
if (!$query_siswa) {
    die("Query siswa gagal: " . mysqli_error($conn));
}
$data_siswa = mysqli_fetch_assoc($query_siswa);
$total_siswa = $data_siswa['total'];

$query_pelanggaran = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM t_pelanggaran"
);
if (!$query_pelanggaran) {
    die("Query pelanggaran gagal: " . mysqli_error($conn));
}
$data_pelanggaran = mysqli_fetch_assoc($query_pelanggaran);
$total_pelanggaran = $data_pelanggaran['total'];

$query_guru = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM t_guru"
);
if (!$query_guru) {
    die("Query guru gagal: " . mysqli_error($conn));
}
$data_guru = mysqli_fetch_assoc($query_guru);
$total_guru = $data_guru['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - SMK Muhammadiyah Kota Tasikmalaya</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR -->
        <?php include "menu.php"; ?>
        <!-- KONTEN UTAMA -->
        <main class="col-md-9 col-lg-10 ms-auto p-4">
            <h2 class="mb-4">
                Dashboard
            </h2>
            <p>
                Selamat datang,
                <strong><?= htmlspecialchars($nama) ?></strong>!
            </p>
            <?php if ($role === 'admin'): ?>
                <!-- DASHBOARD ADMIN -->
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5>JUMLAH DATA SISWA</h5>
                                <h2><?= (int)$total_siswa ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5>JUMLAH DATA GURU</h5>
                                <h2><?= (int)$total_guru ?></h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5>JUMLAH PELANGGARAN</h5>
                                <h2><?= (int)$total_pelanggaran ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            <?php elseif ($role === 'guru'): ?>
                <!-- DASHBOARD GURU -->
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5>CATAT PELANGGARAN</h5>
                                <p>Catat pelanggaran siswa.</p>
                                <a href="pelanggaran.php"
                                   class="btn btn-primary">
                                    Buka
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5>RIWAYAT PELANGGARAN</h5>
                                <p>Lihat data pelanggaran siswa.</p>
                                <a href="pelanggaran.php"
                                   class="btn btn-primary">
                                    Buka
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>
<?php
if (file_exists("footer.php")) {
    include "footer.php";
}
?>
</body>
</html>