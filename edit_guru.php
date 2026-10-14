<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "config.php";
require_once "cek_session.php";
cek_admin();

$id = $_GET['id'] ?? 0;
if (!$id) {
    header("Location: guru.php");
    exit;
}

$guru = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM t_guru WHERE id = '$id'"));
if (!$guru) {
    header("Location: guru.php");
    exit;
}

$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nip = trim($_POST['nip'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $status_aktif = $_POST['status_aktif'] ?? 1;

    $cek_nip = mysqli_query($conn, "SELECT id FROM t_guru WHERE nip = '".mysqli_real_escape_string($conn, $nip)."' AND id != '$id'");
    if ($cek_nip && mysqli_num_rows($cek_nip) > 0) {
        $pesan = '<div class="alert alert-danger">NIP sudah dipakai guru lain!</div>';
    } else {
        $update = mysqli_query($conn, "
            UPDATE t_guru SET
                nip = '".mysqli_real_escape_string($conn, $nip)."',
                nama = '".mysqli_real_escape_string($conn, $nama)."',
                email = '".mysqli_real_escape_string($conn, $email)."',
                status_aktif = '".mysqli_real_escape_string($conn, $status_aktif)."'
            WHERE id = '$id'
        ");
        if ($update) {
            header("Location: guru.php");
            exit;
        } else {
            $pesan = '<div class="alert alert-danger">Gagal ubah: ' . mysqli_error($conn) . '</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ubah Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include "sidebar.php"; ?>
        <main class="col-md-9 col-lg-10 p-4">
            <h2 class="mb-4">Ubah Data Guru</h2>
            <?= $pesan ?>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip" class="form-control" value="<?= htmlspecialchars($guru['nip']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($guru['nama']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($guru['email']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status Aktif</label>
                            <select name="status_aktif" class="form-select" required>
                                <option value="1" <?= ($guru['status_aktif'] ?? '') == 1 ? 'selected' : '' ?>>Aktif</option>
                                <option value="0" <?= ($guru['status_aktif'] ?? '') == 0 ? 'selected' : '' ?>>Tidak Aktif</option>
                            </select>
                        </div>
                        <a href="guru.php" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>