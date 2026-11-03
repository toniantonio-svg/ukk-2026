<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "config.php";
require_once "cek_session.php";
cek_admin();

function e($val) {
    return htmlspecialchars((string)($val ?? '-'), ENT_QUOTES, 'UTF-8');
}

// === FUNGSI: Sinkron email ke t_users ===
function sinkron_email_user($conn, $nama_guru, $email_baru) {
    $nama_esc = mysqli_real_escape_string($conn, trim($nama_guru));
    $email_esc = mysqli_real_escape_string($conn, trim($email_baru));

    // Cari user berdasarkan nama guru, lalu perbarui email
    mysqli_query($conn, "
        UPDATE t_users 
        SET email = '$email_esc'
        WHERE name = '$nama_esc'
        LIMIT 1
    ");
}

// === PROSES EDIT ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $id = (int)($_POST['id'] ?? 0);
    $nip = trim($_POST['nip'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $status_aktif = (int)($_POST['status_aktif'] ?? 1);

    if (!$id || !$nama) {
        header("Location: edit_guru.php?pesan=kurang");
        exit;
    }

    // Perbarui data guru
    $stmt = mysqli_prepare($conn, "
        UPDATE t_guru 
        SET nip=?, nama=?, email=?, status_aktif=?
        WHERE id=?
    ");
    mysqli_stmt_bind_param($stmt, "sssii", $nip, $nama, $email, $status_aktif, $id);

    if (mysqli_stmt_execute($stmt)) {
        // === SINKRONISASI EMAIL OTOMATIS ===
        sinkron_email_user($conn, $nama, $email);

        header("Location: guru.php?pesan=diperbarui");
        exit;
    } else {
        $pesan = "Gagal menyimpan: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
}

// === BACA DATA ===
$query_guru = mysqli_query($conn, "SELECT COUNT(*) AS total FROM t_guru");
$total_guru = (int)(mysqli_fetch_assoc($query_guru)['total'] ?? 0);

$result = mysqli_query($conn, "SELECT * FROM t_guru ORDER BY id ASC");

// Deteksi kolom updated
$kolom_updated = null;
$fields = mysqli_fetch_fields($result);
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include "menu.php"; ?>
        <main class="col-md-9 col-lg-10 p-4">
            <h2 class="mb-4">Kelola Data Guru</h2>

            <div class="row mb-4">
                <div class="col-md-5 col-lg-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="text-muted fs-6">JUMLAH DATA GURU</h5>
                            <h2 class="text-primary fw-bold"><?= $total_guru ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <h5 class="mb-0 fw-semibold">Daftar Guru</h5>
                        <a href="tambah_guru.php" class="btn btn-success">+ Tambah Guru</a>
                    </div>
                    <div class="table-responsive">
                        <table id="tabelGuru" class="table table-bordered table-striped table-hover align-middle w-100">
                            <thead class="table-primary text-white">
                                <tr>
                                    <th class="text-center" width="5%">No.</th>
                                    <th width="12%">NIP</th>
                                    <th>Nama</th>
                                    <th width="18%">Email</th>
                                    <th class="text-center" width="10%">Status Aktif</th>
                                    <th class="text-center" width="8%">ID User</th>
                                    <th width="12%">Dibuat</th>
                                    <th width="12%">Diupdate</th>
                                    <th class="text-center" width="14%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; while ($row = mysqli_fetch_assoc($result)):
                                    $nilai_updated = $kolom_updated ? ($row[$kolom_updated] ?? '') : '';
                                    if (empty($nilai_updated) || $nilai_updated === '0000-00-00 00:00:00') {
                                        $nilai_updated = $row['created_at'] ?? '-';
                                    }

                                    $status = $row['status_aktif'] ?? '';
                                    if ((string)$status === '1') {
                                        $status_badge = '<span class="badge bg-success">Aktif</span>';
                                    } elseif (in_array(strtolower((string)$status), ['0', 'tidak aktif', 'nonaktif'], true)) {
                                        $status_badge = '<span class="badge bg-secondary">Tidak Aktif</span>';
                                    } else {
                                        $status_badge = e($status);
                                    }
                                ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= e($row['nip'] ?? '-') ?></td>
                                    <td><?= e($row['nama'] ?? '-') ?></td>
                                    <td><?= e($row['email'] ?? '-') ?></td>
                                    <td class="text-center"><?= $status_badge ?></td>
                                    <td class="text-center"><?= e($row['user_id'] ?? '-') ?></td>
                                    <td><?= e($row['created_at'] ?? '-') ?></td>
                                    <td><?= e($nilai_updated) ?></td>
                                    <td class="text-center text-nowrap">
                                        <a href="form_edit_guru.php?id=<?= urlencode((string)$row['id']) ?>" 
                                           class="btn btn-sm btn-primary me-1">Ubah</a>
                                        <a href="hapus_guru.php?id=<?= urlencode((string)$row['id']) ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Yakin hapus?')">Hapus</a>
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
$(function () {
    $('#tabelGuru').DataTable({
        language: { url: 'https://cdn.datatables.net/plug-ins/2.3.4/i18n/id.json' },
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'Semua']],
        order: [[1, 'asc']],
        columnDefs: [
            { targets: [0, 8], orderable: false, searchable: false },
            { targets: [0, 4, 5, 8], className: 'text-center' }
        ],
        autoWidth: false
    });
});
</script>
</body>
</html>