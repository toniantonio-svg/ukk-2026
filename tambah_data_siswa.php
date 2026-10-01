<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "cek_session.php";
cek_admin();
require_once "config.php";

$pesan = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nis = trim($_POST['nis'] ?? '');
    $nisn = trim($_POST['nisn'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $jenis_kelamin = trim($_POST['jenis_kelamin'] ?? '');
    $tanggal_lahir = trim($_POST['tanggal_lahir'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $status_aktif = trim($_POST['status_aktif'] ?? '1');

    if (empty($nis) || empty($nama)) {
        $pesan = '<div class="alert alert-danger">NIS dan Nama wajib diisi!</div>';
    } else {
        $sql = "INSERT INTO t_siswa (nis, nisn, nama, jenis_kelamin, tanggal_lahir, alamat, status_aktif, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssssss", $nis, $nisn, $nama, $jenis_kelamin, $tanggal_lahir, $alamat, $status_aktif);

        if (mysqli_stmt_execute($stmt)) {
            $pesan = '<div class="alert alert-success">Data siswa berhasil disimpan! <a href="siswa.php" class="alert-link">Lihat Daftar Siswa</a></div>';
        } else {
            $pesan = '<div class="alert alert-danger">Gagal: ' . mysqli_error($conn) . '</div>';
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Siswa</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">
</head>
<body>
<?php include "menu.php"; ?>

<div class="col-md-9 col-lg-10 p-4">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">TAMBAH DATA SISWA</h5>
        </div>
        <div class="card-body">
            <?= $pesan ?>

            <form method="POST" action="">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label fw-bold">NIS</label>
                    <div class="col-sm-9">
                        <input type="text" name="nis" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">NISN</label>
                    <div class="col-sm-9">
                        <input type="text" name="nisn" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label fw-bold">Nama Lengkap</label>
                    <div class="col-sm-9">
                        <input type="text" name="nama" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-9">
                        <select name="jenis_kelamin" class="form-select">
                            <option value="">-Pilih-</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                    <div class="col-sm-9">
                        <input type="date" name="tanggal_lahir" class="form-control">
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Alamat</label>
                    <div class="col-sm-9">
                        <textarea name="alamat" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label">Status Aktif</label>
                    <div class="col-sm-9">
                        <select name="status_aktif" class="form-select">
                            <option value="1" selected>Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">SIMPAN</button>
                    <a href="siswa.php" class="btn btn-secondary">KEMBALI</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "footer.php"; ?>
</body>
</html>