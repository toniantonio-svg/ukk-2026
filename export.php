<?php
require_once "config.php";
if (session_status() === PHP_SESSION_NONE) session_start();
require_once "cek_session.php";
cek_login();

$nama = $_SESSION['name'];
$role = strtolower(trim($_SESSION['role']));

if ($role !== 'admin') {
    echo "<script>alert('Anda tidak berhak mengakses halaman ini!\\nHanya Administrator yang dapat mencetak laporan.');location.href='dashboard.php';</script>";
    exit;
}

$daftar_siswa = [];
$q_siswa = mysqli_query($conn, "
    SELECT s.id, s.nama, s.nis, k.nama AS nama_kelas,
           COUNT(p.id) AS jumlah_melanggar,
           COALESCE(SUM(p.poin), 0) AS total_poin
    FROM t_siswa s
    LEFT JOIN t_kelas_siswa ks ON s.id = ks.siswa_id
    LEFT JOIN t_kelas k ON ks.kelas_id = k.id
    LEFT JOIN t_pelanggaran_siswa p ON s.id = p.siswa_id
    GROUP BY s.id, s.nama, s.nis, k.nama
    HAVING total_poin > 0
    ORDER BY k.nama ASC, total_poin DESC, s.nama ASC
");
if ($q_siswa) while ($row = mysqli_fetch_assoc($q_siswa)) $daftar_siswa[] = $row;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cetak Laporan Pelanggaran - SMK Muhammadiyah Kota Tasikmalaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: #fff; }
            .card { border: none; box-shadow: none !important; }
            table { width: 100%; }
            thead { display: table-header-group; }
            tr { page-break-inside: avoid; }
        }
    </style>
</head>
<body>
<div class="container-fluid py-4">
    <div class="no-print mb-4 d-flex justify-content-between align-items-center">
        <div>
            <h4>Laporan Pelanggaran Siswa — Cetak / Export</h4>
            <p class="text-muted mb-0">Dibuat oleh: <strong><?= htmlspecialchars($nama) ?></strong> — <?= date('d/m/Y H:i') ?></p>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-primary me-2">🖨️ Cetak / Simpan PDF</button>
            <a href="laporan.php" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="text-center mb-4">
                <h3 class="fw-bold">LAPORAN REKAPITULASI PELANGGARAN SISWA</h3>
                <h5>SMK Muhammadiyah Kota Tasikmalaya</h5>
                <p class="text-muted">Periode: Semua Data — <?= date('d F Y') ?></p>
                <hr>
            </div>

            <?php if (empty($daftar_siswa)): ?>
                <div class="alert alert-info text-center">Belum ada data pelanggaran untuk dicetak.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="12%">NIS</th>
                                <th width="30%">Nama Siswa</th>
                                <th width="20%">Kelas</th>
                                <th width="13%" class="text-center">Jumlah Melanggar</th>
                                <th width="15%" class="text-center">Total Poin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1; $total_semua = 0;
                            foreach ($daftar_siswa as $s):
                                $poin = (int)$s['total_poin'];
                                $jml = (int)$s['jumlah_melanggar'];
                                $total_semua += $poin;
                                $baris = '';
                                if ($poin >= 50) $baris = 'table-danger';
                                elseif ($poin >= 20) $baris = 'table-warning';
                            ?>
                            <tr class="<?= $baris ?>">
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= htmlspecialchars($s['nis']) ?></td>
                                <td><?= htmlspecialchars($s['nama']) ?></td>
                                <td><?= htmlspecialchars($s['nama_kelas'] ?? '-') ?></td>
                                <td class="text-center"><?= $jml ?> kali</td>
                                <td class="text-center fw-bold"><?= $poin ?> poin</td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="table-secondary fw-bold">
                                <td colspan="5" class="text-end">Total Akumulasi Poin:</td>
                                <td class="text-center"><?= $total_semua ?> poin</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php if (file_exists("footer.php")) include "footer.php"; ?>
</body>
</html>