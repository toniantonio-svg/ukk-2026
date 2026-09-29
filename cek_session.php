<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function cek_login()
{
    if (
        !isset($_SESSION['login']) ||
        $_SESSION['login'] !== true ||
        !isset($_SESSION['user_id'])
    ) {
        header("Location: index.php");
        exit;
    }
}

function cek_admin()
{
    cek_login();

    if ($_SESSION['role'] !== 'admin') {

        echo "<h2>Mohon Maaf, Akses Anda Ditolak!</h2>";
        echo "<p>Anda tidak memiliki izin mengakses halaman ini.</p>";
        echo "<a href='dashboard.php'>Kembali ke Dashboard</a>";

        exit;
    }
}
?>