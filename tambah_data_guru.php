<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "cek_session.php";
cek_admin();
require_once "config.php";

$pesan = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nip = trim($_POST['nip'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $status_aktif = trim($_POST['status_aktif'] ?? '1');
    $name_user = trim($_POST['name_user'] ?? '');
    $password = trim($_POST['password'] ?? '123456');

    if (empty($nip) || empty($nama) || empty($name_user)) {
        $pesan = '<div class="alert alert-danger">NIP, Nama, dan Username WAJIB diisi!</div>';
    } else {
        $sql_user = "INSERT INTO t_users (name, email, password, created_at) VALUES (?, ?, ?, NOW())";
        $stmt_user = mysqli_prepare($conn, $sql_user);
        mysqli_stmt_bind_param($stmt_user, "sss", $name_user, $email, $password);
        
        if (mysqli_stmt_execute($stmt_user)) {
            $user_id_baru = mysqli_insert_id($conn);
            mysqli_stmt_close($stmt_user);

            $sql_guru = "INSERT INTO t_guru (nip, nama, email, status_aktif, user_id, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt_guru = mysqli_prepare($conn, $sql_guru);
            mysqli_stmt_bind_param($stmt_guru, "sssii", $nip, $nama, $email, $status_aktif, $user_id_baru);

            if (mysqli_stmt_execute($stmt_guru)) {
                $pesan = '<div class="alert alert-success">BERHASIL! User & Data Guru tersimpan! <a href="guru.php" class="alert-link">Lihat Daftar</a></div>';
            } else {
                $pesan = '<div class="alert alert-danger">Guru gagal disimpan: ' . mysqli_error($conn) . '</div>';
            }
            mysqli_stmt_close($stmt_guru);
        } else {
            $pesan = '<div class="alert alert-danger">User gagal dibuat: ' . mysqli_error($conn) . '</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include "menu.php"; ?>
<div class="col-md-9 col-lg-10 p-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">TAMBAH DATA GURU + BUAT AKUN OTOMATIS</h5>
        </div>
        <div class="card-body">
            <?= $pesan ?>
            <form method="POST" action="">
                <h6 class="mb-3">Data Guru</h6>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label fw-bold">NIP </label>
                    <div class="col-sm-9">
                        <input type="text" name="nip" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label fw-bold">Nama Lengkap </label>
                    <div class="col-sm-9">
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" name="email" class="form-control" >
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Status Aktif</label>
                    <div class="col-sm-9">
                        <select name="status_aktif" class="form-select">
                            <option value="1" selected>Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <hr class="my-4">
                <h6 class="mb-3">Data Akun Login</h6>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label fw-bold">Nama User </label>
                    <div class="col-sm-9">
                        <input type="text" name="name_user" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                        <input type="text" name="password" class="form-control">
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">SIMPAN</button>
                    <a href="guru.php" class="btn btn-secondary">KEMBALI</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>