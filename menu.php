<?php
    require_once "auth.php";
    wajib_login();

    $halaman = (int) ($_GET['halaman'] ?? 0);

    if ($halaman == 1 || $halaman == 2) {

        wajib_admin();

    } elseif ($halaman == 3 || $halaman == 4) {

        wajib_guru();

    } else {

        header("Location: dashboard.php");
        exit;
    }
?>