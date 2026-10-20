<?php
require_once "config.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "cek_session.php";
cek_login();
$nama = $_SESSION['name'];
$role = strtolower(trim($_SESSION['role']));

// === HANYA ADMIN & WALI KELAS ===
if ($role !== 'admin' && $role !== 'wali_kelas') {
    echo "<script>alert('Anda tidak berhak mengakses halaman ini!');location.href='dashboard.php';</script>";
    exit;
}

// === AMBIL DATA KELAS ===
$nama_kelas = '';
$kelas_id = 0;
if ($role === 'wali_kelas') {
    $q = mysqli_query($conn, "
        SELECT w.kelas_id, k.nama AS nama_kelas
        FROM t_wali_kelas w
        JOIN t_kelas k ON w.kelas_id = k.id
        LEFT JOIN t_guru g ON w.guru_id = g.id
        WHERE w.status_aktif = 1
        AND g.nama LIKE '%" . mysqli_real_escape_string($conn, $nama) . "%'
        LIMIT 1
    ");
    if ($q && $r = mysqli_fetch_assoc($q)) {
        $kelas_id = $r['kelas_id'];
        $nama_kelas = $r['nama_kelas'];
    }
} else {
    $nama_kelas = 'Semua Kelas';
}

// === AMBIL DATA SISWA YANG MELANGGAR SAJA + JUMLAH KALI ===
$daftar_siswa = [];
if ($role === 'wali_kelas' && $kelas_id > 0) {
    $q_siswa = mysqli_query($conn, "
        SELECT s.id, s.nama, s.nis,
               COUNT(p.id) AS jumlah_kali,
               COALESCE(SUM(p.poin), 0) AS total_poin
        FROM t_siswa s
        INNER JOIN t_kelas_siswa ks ON s.id = ks.siswa_id
        INNER JOIN t_pelanggaran_siswa p ON s.id = p.siswa_id
        WHERE ks.kelas_id = '$kelas_id'
        GROUP BY s.id, s.nama, s.nis
        ORDER BY jumlah_kali DESC, total_poin DESC, s.nama ASC
    ");
} elseif ($role === 'admin') {
    $q_siswa = mysqli_query($conn, "
        SELECT s.id, s.nama, s.nis, k.nama AS nama_kelas,
               COUNT(p.id) AS jumlah_kali,
               COALESCE(SUM(p.poin), 0) AS total_poin
        FROM t_siswa s
        INNER JOIN t_kelas_siswa ks ON s.id = ks.siswa_id
        INNER JOIN t_kelas k ON ks.kelas_id = k.id
        INNER JOIN t_pelanggaran_siswa p ON s.id = p.siswa_id
        GROUP BY s.id, s.nama, s.nis, k.nama
        ORDER BY k.nama ASC, jumlah_kali DESC, total_poin DESC, s.nama ASC
    ");
}

if (!empty($q_siswa)) {
    while ($row = mysqli_fetch_assoc($q_siswa)) {
        $daftar_siswa[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Pelanggaran - SMK Muhammadiyah Kota Tasikmalaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include "menu.php"; ?>
        <main class="col-md-9 col-lg-10 p-4">
            <h2 class="mb-3">Laporan Pelanggaran Siswa</h2>
            <p>Selamat datang, <strong><?= htmlspecialchars($nama) ?></strong>!</p>
            
            <?php if ($role === 'wali_kelas'): ?>
                <div class="alert alert-info mb-4">
                    Role: Wali Kelas | Kelas : <strong><?= htmlspecialchars($nama_kelas) ?></strong>
                </div>
            <?php else: ?>
                <div class="alert alert-info mb-4">
                    Role: Administrator
                </div>
            <?php endif; ?>

            <?php if (empty($daftar_siswa)): ?>
                <div class="alert alert-warning">
                    Belum ada siswa yang melanggar. Semua siswa tertib 😊
                    <a href="catat_pelanggaran.php" class="alert-link d-block mt-2">Klik di sini untuk mencatat pelanggaran pertama</a>
                </div>
            <?php else: ?>
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">NIS</th>
                                        <th width="35%">Nama Siswa</th>
                                        <?php if ($role === 'admin'): ?>
                                            <th width="15%">Kelas</th>
                                        <?php endif; ?>
                                        <th width="15%" class="text-center">Jumlah Melanggar</th>
                                        <th width="15%" class="text-center">Total Poin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($daftar_siswa as $s):
                                        $poin = (int)$s['total_poin'];
                                        $warna = $poin > 50 ? 'table-danger' : ($poin > 20 ? 'table-warning' : '');
                                    ?>
                                    <tr class="<?= $warna ?>">
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($s['nis']) ?></td>
                                        <td><?= htmlspecialchars($s['nama']) ?></td>
                                        <?php if ($role === 'admin'): ?>
                                            <td><?= htmlspecialchars($s['nama_kelas'] ?? '-') ?></td>
                                        <?php endif; ?>
                                        <td class="text-center">
                                            <span class="badge bg-danger rounded-pill">
                                                <?= (int)$s['jumlah_kali'] ?> kali
                                            </span>
                                        </td>
                                        <td class="text-center fw-bold">
                                            <?= $poin ?> poin
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="catat_pelanggaran.php" class="btn btn-primary">Catat Pelanggaran Baru</a>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>
<?php if (file_exists("footer.php")) include "footer.php"; ?>
</body>
</html>