<?php

require_once "config.php";

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

if (!isset($_POST['login'])) {
    header("Location: index.php");
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    header("Location: index.php?pesan=kosong");
    exit;
}
$stmt = mysqli_prepare(
    $conn,
    "SELECT *
     FROM t_users
     WHERE name = ? OR email = ?
     LIMIT 1"
);

mysqli_stmt_bind_param(
    $stmt,
    "ss",
    $username,
    $username
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);
if ($user && $password === $user['password']) {

    $role = strtolower(trim($user['role'] ?? ''));

    if ($role === 'admin') {

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name']    = $user['name'];
        $_SESSION['email']   = $user['email'];
        $_SESSION['role']    = 'admin';
        $_SESSION['login']   = true;

        header("Location: dashboard.php");
        exit;
    }
}
$stmt = mysqli_prepare(
    $conn,
    "SELECT *
     FROM t_guru
     WHERE email = ?
        OR nip = ?
        OR LOWER(REPLACE(nama, ' ', '')) = LOWER(?)
     LIMIT 1"
);

mysqli_stmt_bind_param(
    $stmt,
    "sss",
    $username,
    $username,
    $username
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$guru = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);

if ($guru && $password === $guru['password']) {

    if ($guru['status_aktif'] != 1) {
        header("Location: index.php?pesan=nonaktif");
        exit;
    }
    session_regenerate_id(true);

    $_SESSION['user_id'] = $guru['id'];
    $_SESSION['name']    = $guru['nama'];
    $_SESSION['email']   = $guru['email'];
    $_SESSION['role']    = 'guru';
    $_SESSION['login']   = true;

    header("Location: dashboard.php");
    exit;
}
header("Location: index.php?pesan=gagal");
exit;