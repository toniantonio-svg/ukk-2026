<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "config.php";
require_once "cek_session.php";
cek_admin();

function e($value) {
    return htmlspecialchars((string)($value ?? '-'), ENT_QUOTES, 'UTF-8');
}

$query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM t_pelanggaran");
if (!$query) die("Query jenis pelanggaran gagal: " . mysqli_error($conn));
$total = (int)(mysqli_fetch_assoc($query)['total'] ?? 0);

$result = mysqli_query($conn, "SELECT * FROM t_pelanggaran ORDER BY id ASC");
if (!$result) die("Ambil data jenis pelanggaran gagal: " . mysqli_error($conn));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Jenis Pelanggaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .table th, .table td { vertical-align: middle; white-space: nowrap; }
        .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .btn-sm { padding: 0.2rem 0.5rem; font-size: 0.75rem; }
        #tabelPelanggaran td:last-child { width: 130px; }
        .badge { font-size: 0.8rem; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include "menu.php"; ?>
        <main class="col-md-9 col-lg-10 p-4">
            <h2 class="mb-4">Kelola Jenis Pelanggaran</h2>

            <div class="row mb-4">
                <div class="col-md-5 col-lg-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title text-muted fs-6">JUMLAH JENIS PELANGGARAN</h5>
                            <h2 class="text-primary fw-bold"><?= $total ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <h5 class="mb-0 fw-semibold">Daftar Jenis Pelanggaran</h5>
                        <a href="tambah_jenis_pelanggaran.php" class="btn btn-success">+ Tambah Pelanggaran</a>
                    </div>
                    <div class="table-responsive">
                        <table id="tabelPelanggaran" class="table table-bordered table-striped table-hover align-middle w-100">
                            <thead class="table-primary text-white">
                                <tr>
                                    <th class="text-center" width="4%">No.</th>
                                    <th class="text-center" width="4%">ID</th>
                                    <th width="10%">Kode</th>
                                    <th width="15%">Nama</th>
                                    <th class="text-center" width="6%">Poin</th>
                                    <th width="20%">Deskripsi</th>
                                    <th class="text-center" width="9%">Status Aktif</th>
                                    <th width="11%">Dibuat</th>
                                    <th width="11%">Diupdate</th>
                                    <th class="text-center" width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; while ($row = mysqli_fetch_assoc($result)):
                                    $updated = $row['updated_at'] ?? '';
                                    if (empty($updated) || $updated === '0000-00-00 00:00:00') {
                                        $updated = $row['created_at'] ?? '-';
                                    }
                                    $status = $row['status_aktif'] ?? '';
                                    if ((string)$status === '1') {
                                        $status_badge = '<span class="badge bg-success">Aktif</span>';
                                    } elseif (in_array(strtolower((string)$status), ['0','tidak aktif','nonaktif'], true)) {
                                        $status_badge = '<span class="badge bg-secondary">Tidak Aktif</span>';
                                    } else {
                                        $status_badge = e($status);
                                    }
                                ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td class="text-center"><?= e($row['id']) ?></td>
                                    <td><?= e($row['kode']) ?></td>
                                    <td><?= e($row['nama']) ?></td>
                                    <td class="text-center"><?= e($row['poin']) ?></td>
                                    <td><?= e($row['deskripsi']) ?></td>
                                    <td class="text-center"><?= $status_badge ?></td>
                                    <td><?= e($row['created_at']) ?></td>
                                    <td><?= e($updated) ?></td>
                                    <td class="text-center text-nowrap">
                                        <a href="edit_jenis_pelanggaran.php?id=<?= urlencode((string)$row['id']) ?>" 
                                           class="btn btn-sm btn-primary me-1" title="Ubah">Ubah</a>
                                        <a href="hapus_jenis_pelanggaran.php?id=<?= urlencode((string)$row['id']) ?>" 
                                           class="btn btn-sm btn-danger" title="Hapus"
                                           onclick="return confirm('Yakin ingin menghapus jenis pelanggaran ini?')">Hapus</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?php include "footer.php"; ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function () {
    $('#tabelPelanggaran').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/2.3.4/i18n/id.json' },
        pageLength: 10,
        lengthMenu: [[5,10,25,50,100,-1],[5,10,25,50,100,'Semua']],
        order: [[1,'asc']],
        columnDefs: [
            { targets: [0,9], orderable:false, searchable:false },
            { targets: [0,1,4,6,9], className:'text-center' }
        ],
        autoWidth: false,
        layout: { topStart:'pageLength', topEnd:'search', bottomStart:'info', bottomEnd:'paging' }
    });
});
</script>
</body>
</html>