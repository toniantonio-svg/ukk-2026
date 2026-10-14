<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "config.php";
require_once "cek_session.php";
cek_admin();

$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nip = trim($_POST['nip'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $status_aktif = $_POST['status_aktif'] ?? 1;

    if ($nip && $nama && $email) {
        $cek_nip = mysqli_query($conn, "SELECT id FROM t_guru WHERE nip = '".mysqli_real_escape_string($conn, $nip)."'");
        if ($cek_nip && mysqli_num_rows($cek_nip) > 0) {
            $pesan = '<div class="alert alert-danger">NIP sudah terdaftar!</div>';
        } else {
            // Ambil nomor urut berikutnya untuk user_id
            $cek_id = mysqli_query($conn, "SELECT MAX(id) AS max_id FROM t_guru");
            $row = mysqli_fetch_assoc($cek_id);
            $next_id = ($row['max_id'] ?? 0) + 1;

            // Simpan langsung ke t_guru
            $simpan = mysqli_query($conn, "
                INSERT INTO t_guru (nip, nama, email, status_aktif, user_id)
                VALUES (
                    '".mysqli_real_escape_string($conn, $nip)."',
                    '".mysqli_real_escape_string($conn, $nama)."',
                    '".mysqli_real_escape_string($conn, $email)."',
                    '".mysqli_real_escape_string($conn, $status_aktif)."',
                    '$next_id'
                )
            ");

            if ($simpan) {
                header("Location: guru.php");
                exit;
            } else {
                $pesan = '<div class="alert alert-danger">Gagal simpan: ' . mysqli_error($conn) . '</div>';
            }
        }
    } else {
        $pesan = '<div class="alert alert-warning">Lengkapi semua data!</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include "menu.php"; ?>

        <main class="col-md-9 col-lg-10 p-4">
            <h2 class="mb-4">Tambah Data Guru</h2>
            <?= $pesan ?>

            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status Aktif</label>
                            <select name="status_aktif" class="form-select" required>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
                        </div>
                        <a href="guru.php" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-success">Simpan Guru</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>