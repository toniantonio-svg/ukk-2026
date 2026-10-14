<?php
require_once "config.php";
require_once "cek_session.php";
cek_admin();

$id = $_GET['id'] ?? 0;
if ($id) {
    mysqli_query($conn, "DELETE FROM t_siswa WHERE id = '$id'");
}
header("Location: siswa.php");
exit;