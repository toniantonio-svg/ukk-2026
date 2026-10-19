<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "config.php";
require_once "cek_session.php";
cek_admin();
function e($value) {
    return htmlspecialchars(
        (string)($value ?? '-'),
        ENT_QUOTES,
        'UTF-8'
    );
}
// Menghitung jumlah guru
$query_guru = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM t_guru"
);
if (!$query_guru) {
    die("Query guru gagal: " . mysqli_error($conn));
}
$data_guru = mysqli_fetch_assoc($query_guru);
$total_guru = (int)$data_guru['total'];
// Mengambil data guru
$result = mysqli_query(
    $conn,
    "SELECT * FROM t_guru ORDER BY id ASC"
);
if (!$result) {
    die("Pengambilan data guru gagal: " . mysqli_error($conn));
}
// Mendeteksi kolom updated
$fields = mysqli_fetch_fields($result);
$kolom_updated = null;
foreach ($fields as $field) {
    if (stripos($field->name, 'updated') !== false) {
        $kolom_updated = $field->name;
        break;
    }
}
mysqli_data_seek($result, 0);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Data Guru</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link
        href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css"
        rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include "menu.php"; ?>
        <main class="col-md-9 col-lg-10 p-4">
            <h2 class="mb-4">Kelola Data Guru</h2>
            <!-- Jumlah guru -->
            <div class="row mb-4">
                <div class="col-md-5 col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5>JUMLAH DATA GURU</h5>
                            <h2><?= $total_guru ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Daftar guru -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between
                                align-items-center flex-wrap gap-2 mb-3">
                        <h5 class="mb-0">Daftar Guru</h5>
                        <a href="tambah_guru.php"
                           class="btn btn-success">
                            + Tambah Guru
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table id="tabelGuru"
                               class="table table-bordered table-striped
                                      table-hover align-middle w-100">
                            <thead class="table-primary">
                                <tr>
                                    <th>No.</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Status Aktif</th>
                                    <th>ID User</th>
                                    <th>Dibuat</th>
                                    <th>Diupdate</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)):
                                $nilai_updated = $kolom_updated
                                    ? ($row[$kolom_updated] ?? '')
                                    : '';
                                if (
                                    empty($nilai_updated) ||
                                    $nilai_updated === '0000-00-00 00:00:00'
                                ) {
                                    $nilai_updated =
                                        $row['created_at'] ?? '-';
                                }
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= e($row['nip'] ?? '-') ?></td>
                                    <td><?= e($row['nama'] ?? '-') ?></td>
                                    <td><?= e($row['email'] ?? '-') ?></td>
                                    <td>
                                        <?php
                                        $status = $row['status_aktif'] ?? '';
                                        ?>
                                        <?php if ((string)$status === '1'): ?>
                                            <span class="badge bg-success">
                                                Aktif
                                            </span>
                                        <?php elseif (
                                            in_array(
                                                strtolower((string)$status),
                                                ['0', 'tidak aktif', 'nonaktif'],
                                                true
                                            )
                                        ): ?>
                                            <span class="badge bg-secondary">
                                                Tidak Aktif
                                            </span>
                                        <?php else: ?>
                                            <?= e($status) ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= e($row['user_id'] ?? '-') ?></td>
                                    <td><?= e($row['created_at'] ?? '-') ?></td>
                                    <td><?= e($nilai_updated) ?></td>
                                    <td class="text-nowrap">
                                        <a
                                            href="edit_guru.php?id=<?= urlencode((string)$row['id']) ?>"
                                            class="btn btn-sm btn-primary">
                                            Ubah
                                        </a>
                                        <a
                                            href="hapus_guru.php?id=<?= urlencode((string)$row['id']) ?>"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Yakin ingin menghapus data guru ini?')">
                                            Hapus
                                        </a>
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
    $('#tabelGuru').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.3.4/i18n/id.json'
        },
        pageLength: 10,
        lengthMenu: [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, 'Semua']
        ],
        order: [[1, 'asc']],
        columnDefs: [
            {
                targets: [0, 8],
                orderable: false,
                searchable: false
            }
        ],
        autoWidth: false,
        layout: {
            topStart: 'pageLength',
            topEnd: 'search',
            bottomStart: 'info',
            bottomEnd: 'paging'
        }
    });
});
</script>
</body>
</html>