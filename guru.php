<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "config.php";
require_once "cek_session.php";

cek_admin();

// Menghitung jumlah guru
$query_guru = mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM t_guru"
);

if (!$query_guru) {
    die("Query guru gagal: " . mysqli_error($conn));
}

$data_guru = mysqli_fetch_assoc($query_guru);
$total_guru = $data_guru['total'];

// Mengambil data guru
$result = mysqli_query(
    $conn,
    "SELECT * FROM t_guru ORDER BY id ASC"
);

if (!$result) {
    die("Pengambilan data guru gagal: " . mysqli_error($conn));
}

// Mendeteksi kolom updated secara otomatis
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

    <title>Kelola Guru</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body>

<div class="container-fluid">
    <div class="row">

        <?php include "menu.php"; ?>

        <main class="col-md-9 col-lg-10 p-4">

            <h2 class="mb-4">Kelola Data Guru</h2>

            <div class="row mb-4">
                <div class="col-md-5 col-lg-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5>JUMLAH DATA GURU</h5>
                            <h2><?= (int)$total_guru ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">

                    <div class="d-flex justify-content-between
                                align-items-center mb-3">
                        <h5 class="mb-0">Daftar Guru</h5>

                        <a href="tambah_guru.php"
                           class="btn btn-success">
                            + Tambah Guru
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered
                                      table-striped table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>No.</th>
                                    <th>ID</th>
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
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php $no = 1; ?>

                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <?php
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
                                        <td><?= htmlspecialchars((string)($row['id'] ?? '-')) ?></td>
                                        <td><?= htmlspecialchars((string)($row['nip'] ?? '-')) ?></td>
                                        <td><?= htmlspecialchars((string)($row['nama'] ?? '-')) ?></td>
                                        <td><?= htmlspecialchars((string)($row['email'] ?? '-')) ?></td>
                                        <td><?= htmlspecialchars((string)($row['status_aktif'] ?? '-')) ?></td>
                                        <td><?= htmlspecialchars((string)($row['user_id'] ?? '-')) ?></td>
                                        <td><?= htmlspecialchars((string)($row['created_at'] ?? '-')) ?></td>
                                        <td><?= htmlspecialchars((string)$nilai_updated) ?></td>
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

                            <?php else: ?>
                                <tr>
                                    <td colspan="10"
                                        class="text-center">
                                        Belum ada data guru.
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </main>

    </div>
</div>

<?php include "footer.php"; ?>

</body>
</html>