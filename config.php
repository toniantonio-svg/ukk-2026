<?php
$conn = mysqli_connect(
    "localhost",
    "root",
    "",
    "db_ukk_2026"
);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

session_start();
?>