<?php
require_once "config.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "cek_session.php";
cek_login();
$nama = $_SESSION['name'];
$role = strtolower(trim($_SESSION['role']));

if ($role !== 'guru' && $role !== 'wali_kelas') {
    echo "<script>alert('Anda tidak berhak!');location.href='dashboard.php';</script>";
    exit;
}

$kelas_id = 0;
$nama_kelas = '';
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

$daftar_siswa = [];
if ($role === 'wali_kelas' && $kelas_id > 0) {
    $q_siswa = mysqli_query($conn, "
        SELECT s.id, s.nama, s.nis, 
               COALESCE(SUM(p.poin), 0) AS total_poin,
               k.nama AS nama_kelas,
               g.nama AS wali_kelas
        FROM t_siswa s
        INNER JOIN t_kelas_siswa ks ON s.id = ks.siswa_id
        LEFT JOIN t_kelas k ON ks.kelas_id = k.id
        LEFT JOIN t_wali_kelas wk ON k.id = wk.kelas_id AND wk.status_aktif = 1
        LEFT JOIN t_guru g ON wk.guru_id = g.id
        LEFT JOIN t_pelanggaran_siswa p ON s.id = p.siswa_id
        WHERE ks.kelas_id = '$kelas_id'
        GROUP BY s.id
        ORDER BY total_poin DESC, s.nama ASC
    ");
} else {
    $q_siswa = mysqli_query($conn, "
        SELECT s.id, s.nama, s.nis, 
               COALESCE(SUM(p.poin), 0) AS total_poin,
               k.nama AS nama_kelas,
               g.nama AS wali_kelas
        FROM t_siswa s
        LEFT JOIN t_kelas_siswa ks ON s.id = ks.siswa_id
        LEFT JOIN t_kelas k ON ks.kelas_id = k.id
        LEFT JOIN t_wali_kelas wk ON k.id = wk.kelas_id AND wk.status_aktif = 1
        LEFT JOIN t_guru g ON wk.guru_id = g.id
        LEFT JOIN t_pelanggaran_siswa p ON s.id = p.siswa_id
        GROUP BY s.id
        ORDER BY total_poin DESC, s.nama ASC
    ");
}

if ($q_siswa) {
    while ($row = mysqli_fetch_assoc($q_siswa)) {
        $daftar_siswa[] = $row;
    }
}

function getTindakan($poin) {
    if ($poin >= 110) {
        return ['label' => 'WAJIB DIKELUARKAN', 'class' => 'bg-danger text-white fw-bold', 'level' => 5];
    }
    if ($poin >= 90 && $poin <= 109) {
        return ['label' => 'Surat Peringatan (SP) 3', 'class' => 'bg-danger text-white', 'level' => 4];
    }
    if ($poin >= 70 && $poin <= 89) {
        return ['label' => 'Surat Peringatan (SP) 2', 'class' => 'bg-warning text-dark', 'level' => 3];
    }
    if ($poin >= 50 && $poin <= 69) {
        return ['label' => 'Surat Peringatan (SP) 1', 'class' => 'bg-primary text-white', 'level' => 2];
    }
    if ($poin >= 30 && $poin <= 49) {
        return ['label' => 'Panggil ke BK', 'class' => 'bg-info text-white', 'level' => 1];
    }
    return ['label' => 'Belum Ada Tindakan', 'class' => 'bg-success text-white', 'level' => 0];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tindakan - SMK Muhammadiyah Kota Tasikmalaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include "menu.php"; ?>
        <main class="col-md-9 col-lg-10 p-4">
            <h2 class="mb-3">Tindakan Siswa</h2>
            <p>Selamat datang, <strong><?= htmlspecialchars($nama) ?></strong>!</p>
            
            <?php if ($role === 'wali_kelas'): ?>
                <div class="alert alert-info mb-4">
                    Anda melihat data siswa kelas: <strong><?= htmlspecialchars($nama_kelas) ?></strong>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="card-title text-muted fs-6 mb-3">ATURAN TINDAKAN</h5>
                    <div class="d-grid gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-info px-3 py-2">30 – 49</span>
                            <span>Panggil ke BK</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary px-3 py-2">50 – 69</span>
                            <span>Surat Peringatan (SP) 1</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-warning text-dark px-3 py-2">70 – 89</span>
                            <span>Surat Peringatan (SP) 2</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-danger px-3 py-2">90 – 109</span>
                            <span>Surat Peringatan (SP) 3</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-dark text-white px-3 py-2">≥ 110</span>
                            <span class="fw-bold text-danger">WAJIB DIKELUARKAN</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="mb-3 fw-semibold">Daftar Siswa & Tindakan</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle">
                            <thead class="table-primary text-white">
                                <tr>
                                    <th width="4%" class="text-center">No</th>
                                    <th width="10%">NIS</th>
                                    <th>Nama Siswa</th>
                                    <th width="12%">Kelas</th>
                                    <th width="15%">Wali Kelas</th>
                                    <th width="10%" class="text-center">Total Poin</th>
                                    <th width="22%" class="text-center">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($daftar_siswa)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">Belum ada data siswa</td>
                                    </tr>
                                <?php else: ?>
                                    <?php $no = 1; foreach ($daftar_siswa as $s): ?>
                                        <?php $tindakan = getTindakan((int)$s['total_poin']); ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= htmlspecialchars($s['nis']) ?></td>
                                            <td><?= htmlspecialchars($s['nama']) ?></td>
                                            <td><?= htmlspecialchars($s['nama_kelas'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($s['wali_kelas'] ?? '-') ?></td>
                                            <td class="text-center fw-bold fs-5">
                                                <?= (int)$s['total_poin'] ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge <?= $tindakan['class'] ?> fs-6 px-3 py-2">
                                                    <?= $tindakan['label'] ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?php if (file_exists("footer.php")) include "footer.php"; ?>
</body>
</html>