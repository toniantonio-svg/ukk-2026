<?php
require_once "config.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "cek_session.php";
cek_login();
$nama = $_SESSION['name'];
$role = strtolower(trim($_SESSION['role']));

// === HAK AKSES ===
if ($role !== 'admin' && $role !== 'wali_kelas') {
    echo "<script>alert('Anda tidak berhak mengakses halaman ini!');location.href='dashboard.php';</script>";
    exit;
}

// === PROSES HAPUS ===
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $id_hapus = (int)$_GET['hapus'];
    
    // Cek kepemilikan jika wali kelas
    if ($role === 'wali_kelas') {
        $cek = mysqli_query($conn, "
            SELECT 1 FROM t_pelanggaran_siswa p
            LEFT JOIN t_siswa s ON p.siswa_id = s.id
            LEFT JOIN t_kelas_siswa ks ON s.id = ks.siswa_id
            LEFT JOIN t_wali_kelas w ON ks.kelas_id = w.kelas_id
            LEFT JOIN t_guru g ON w.guru_id = g.id
            WHERE p.id = $id_hapus
            AND g.nama LIKE '%" . mysqli_real_escape_string($conn, $nama) . "%'
            AND w.status_aktif = 1
            LIMIT 1
        ");
        if (mysqli_num_rows($cek) === 0) {
            echo "<script>alert('Data tidak ditemukan atau Anda tidak berhak menghapus!');location.href='riwayat.php';</script>";
            exit;
        }
    }
    
    // Hapus data
    mysqli_query($conn, "DELETE FROM t_pelanggaran_siswa WHERE id = $id_hapus");
    echo "<script>alert('Data berhasil dihapus!');location.href='riwayat.php';</script>";
    exit;
}

// === AMBIL DATA KELAS JIKA WALI KELAS ===
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
}

// === AMBIL SEMUA RIWAYAT PELANGGARAN ===
$daftar_riwayat = [];
if ($role === 'wali_kelas' && $kelas_id > 0) {
    $sql = "
        SELECT 
            p.id,
            s.nis,
            s.nama AS nama_siswa,
            k.nama AS kategori,
            p.poin,
            p.keterangan,
            p.tanggal
        FROM t_pelanggaran_siswa p
        LEFT JOIN t_siswa s ON p.siswa_id = s.id
        LEFT JOIN t_pelanggaran_kategori k ON p.kategori_id = k.id
        LEFT JOIN t_kelas_siswa ks ON s.id = ks.siswa_id
        WHERE ks.kelas_id = '$kelas_id'
        ORDER BY p.tanggal DESC, p.id DESC
    ";
} else {
    $sql = "
        SELECT 
            p.id,
            s.nis,
            s.nama AS nama_siswa,
            k.nama AS kategori,
            p.poin,
            p.keterangan,
            p.tanggal
        FROM t_pelanggaran_siswa p
        LEFT JOIN t_siswa s ON p.siswa_id = s.id
        LEFT JOIN t_pelanggaran_kategori k ON p.kategori_id = k.id
        ORDER BY p.tanggal DESC, p.id DESC
    ";
}

$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $daftar_riwayat[] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Pelanggaran - SMK Muhammadiyah Kota Tasikmalaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include "menu.php"; ?>
        <main class="col-md-9 col-lg-10 p-4">
            <h2 class="mb-3">Riwayat Pelanggaran</h2>
            <p>Selamat datang, <strong><?= htmlspecialchars($nama) ?></strong>!</p>
            
            <?php if ($role === 'wali_kelas'): ?>
                <div class="alert alert-info mb-4">
                    Role: Wali Kelas | Kelas : <strong><?= htmlspecialchars($nama_kelas) ?></strong>
                </div>
            <?php else: ?>
                <div class="alert alert-info mb-4">
                    Role: Administrator — Menampilkan semua riwayat
                </div>
            <?php endif; ?>

            <?php if (empty($daftar_riwayat)): ?>
                <div class="alert alert-warning">
                    Belum ada riwayat pelanggaran yang tercatat 😊
                    <a href="catat_pelanggaran.php" class="alert-link d-block mt-2">Klik di sini untuk mencatat pelanggaran baru</a>
                </div>
            <?php else: ?>
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="12%">Tanggal</th>
                                        <th width="12%">NIS</th>
                                        <th width="18%">Nama Siswa</th>
                                        <th width="18%">Kategori Pelanggaran</th>
                                        <th width="8%" class="text-center">Poin</th>
                                        <th>Keterangan</th>
                                        <th width="10%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($daftar_riwayat as $r):
                                        $poin = (int)$r['poin'];
                                        $warna = $poin >= 10 ? 'table-danger' : ($poin >= 5 ? 'table-warning' : 'table-light');
                                        $tgl = date('d/m/Y H:i', strtotime($r['tanggal']));
                                    ?>
                                    <tr class="<?= $warna ?>">
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $tgl ?></td>
                                        <td><?= htmlspecialchars($r['nis']) ?></td>
                                        <td><?= htmlspecialchars($r['nama_siswa']) ?></td>
                                        <td><?= htmlspecialchars($r['kategori'] ?? '-') ?></td>
                                        <td class="text-center fw-bold text-danger">
                                            <?= $poin ?>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?= htmlspecialchars($r['keterangan'] ?? '-') ?>
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <a href="riwayat.php?hapus=<?= $r['id'] ?>" 
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Yakin ingin menghapus data ini? Tindakan tidak dapat dibatalkan!')">
                                                Hapus
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-between">
                    <a href="laporan.php" class="btn btn-secondary">Lihat Laporan Rekap</a>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>
<?php if (file_exists("footer.php")) include "footer.php"; ?>
</body>
</html>