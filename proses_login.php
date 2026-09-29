<?php
require_once "config.php";

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

if (isset($_POST['login'])) {

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username == "" || $password == "") {
        header("Location: index.php?pesan=kosong");
        exit;
    }

    $query = "SELECT * FROM t_users
              WHERE name = ? OR email = ?
              LIMIT 1";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param(
        $stmt,
        "ss",
        $username,
        $username
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && $password === $user['password']) {

        $role = strtolower(trim($user['role']));

        if ($role != "admin" && $role != "guru") {
            header("Location: index.php?pesan=role");
            exit;
        }

        session_regenerate_id(true);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $role;
        $_SESSION['login'] = true;

        header("Location: dashboard.php");
        exit;

    } else {
        header("Location: index.php?pesan=gagal");
        exit;
    }

    mysqli_stmt_close($stmt);
}
?>