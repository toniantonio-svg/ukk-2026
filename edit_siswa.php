<?php
require_once "config.php";
require_once "cek_session.php";
cek_admin();

$id = $_GET['id'] ?? 0;
if (!$id) {
    header("Location: siswa.php");
    exit;
}

$siswa = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM t_siswa WHERE id = '$id'"));
if (!$siswa) {
    header("Location: siswa.php");
    exit;
}

$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis = trim($_POST['nis']);
    $nama = trim($_POST['nama']);
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = trim($_POST['alamat']);

    $cek_nis = mysqli_query($conn, "SELECT id FROM t_siswa WHERE nis = '$nis' AND id != '$id'");
    if (mysqli_num_rows($cek_nis) > 0) {
        $pesan = '<div class="alert alert-danger">NIS sudah dipakai siswa lain!</div>';
    } else {
        $update = mysqli_query($conn, "
            UPDATE t_siswa SET
                nis = '$nis',
                nama = '$nama',
                jenis_kelamin = '$jenis_kelamin',
                tanggal_lahir = '$tanggal_lahir',
                alamat = '$alamat',
                updated_at = NOW()
            WHERE id = '$id'
        ");
        if ($update) {
            header("Location: siswa.php");
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
    <title>Ubah Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include "menu.php"; ?>
        <main class="col-md-9 col-lg-10 p-4">
            <h2 class="mb-4">Ubah Data Siswa</h2>
            <?= $pesan ?>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">NIS</label>
                            <input type="text" name="nis" class="form-control" value="<?= htmlspecialchars($siswa['nis']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($siswa['nama']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="L" <?= $siswa['jenis_kelamin'] === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="P" <?= $siswa['jenis_kelamin'] === 'P' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="<?= htmlspecialchars($siswa['tanggal_lahir']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" required><?= htmlspecialchars($siswa['alamat']) ?></textarea>
                        </div>
                        <a href="siswa.php" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>