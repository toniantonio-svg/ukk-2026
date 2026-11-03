<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "config.php";
require_once "cek_session.php";
cek_admin();

function e($val) {
    return htmlspecialchars((string)($val ?? ''), ENT_QUOTES, 'UTF-8');
}

// === Fungsi Sinkron Email ke t_users ===
function sinkron_email_user($conn, $nama_guru, $email_baru) {
    $nama_esc = mysqli_real_escape_string($conn, trim($nama_guru));
    $email_esc = mysqli_real_escape_string($conn, trim($email_baru));
    mysqli_query($conn, "
        UPDATE t_users 
        SET email = '$email_esc'
        WHERE name = '$nama_esc'
        LIMIT 1
    ");
}

$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nip = trim($_POST['nip'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $status_aktif = (int)($_POST['status_aktif'] ?? 1);

    if ($nip && $nama && $email) {
        // Cek NIP duplikat
        $cek_nip = mysqli_query($conn, "SELECT id FROM t_guru WHERE nip = '".mysqli_real_escape_string($conn, $nip)."'");
        if (mysqli_num_rows($cek_nip) > 0) {
            $pesan = '<div class="alert alert-danger">NIP sudah terdaftar!</div>';
        } else {
            // Ambil nomor urut untuk user_id
            $next_id = (int)(mysqli_fetch_assoc(mysqli_query($conn, "SELECT MAX(id) AS max_id FROM t_guru"))['max_id'] ?? 0) + 1;

            // Simpan ke t_guru
            $simpan = mysqli_query($conn, "
                INSERT INTO t_guru (nip, nama, email, status_aktif, user_id)
                VALUES (
                    '".mysqli_real_escape_string($conn, $nip)."',
                    '".mysqli_real_escape_string($conn, $nama)."',
                    '".mysqli_real_escape_string($conn, $email)."',
                    $status_aktif,
                    $next_id
                )
            ");

            if ($simpan) {
                // === SINKRONISASI OTOMATIS ===
                sinkron_email_user($conn, $nama, $email);
                
                header("Location: guru.php?pesan=berhasil");
                exit;
            }
            $pesan = '<div class="alert alert-danger">Gagal simpan: ' . mysqli_error($conn) . '</div>';
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
                            <label class="form-label fw-bold">NIP</label>
                            <input type="text" name="nip" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" required>
                            <small class="text-muted">Email otomatis disinkronkan ke akun pengguna</small>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Status Aktif</label>
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