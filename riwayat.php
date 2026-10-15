<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "config.php";
require_once "cek_session.php";
cek_login();

$role = $_SESSION['role'] ?? '';
if ($role !== 'admin' && $role !== 'guru' && $role !== 'wali_kelas') {
    header("Location: dashboard.php?pesan=akses_ditolak");
    exit;
}
// ... sisa kode ...