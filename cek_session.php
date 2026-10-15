<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function cek_login()
{
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || !isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
        header("Location: index.php");
        exit;
    }
}

function cek_admin()
{
    cek_login();
    if ($_SESSION['role'] !== 'admin') {
        header("Location: dashboard.php?pesan=akses_ditolak");
        exit;
    }
}

function cek_guru()
{
    cek_login();
    if ($_SESSION['role'] !== 'guru') {
        header("Location: dashboard.php?pesan=akses_ditolak");
        exit;
    }
}

function cek_admin_atau_guru()
{
    cek_login();
    if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'guru') {
        header("Location: dashboard.php?pesan=akses_ditolak");
        exit;
    }
}

// ✅ FUNGSI BARU: Khusus Wali Kelas
function cek_wali_kelas()
{
    cek_login();
    if ($_SESSION['role'] !== 'wali_kelas') {
        header("Location: dashboard.php?pesan=akses_ditolak");
        exit;
    }
}

// ✅ FUNGSI BARU: Boleh Admin / Guru / Wali Kelas
function cek_admin_atau_guru_atau_wali()
{
    cek_login();
    $role = $_SESSION['role'];
    if ($role !== 'admin' && $role !== 'guru' && $role !== 'wali_kelas') {
        header("Location: dashboard.php?pesan=akses_ditolak");
        exit;
    }
}