<?php
require_once "config.php";
require_once "cek_session.php";
cek_admin();

$query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM t_kelas");
if (!$query) die("Query kelas gagal: " . mysqli_error($conn));
$total = mysqli_fetch_assoc($query)['total'];

$result = mysqli_query($conn, "SELECT * FROM t_kelas ORDER BY id ASC");
if (!$result) die("Ambil data kelas gagal: " . mysqli_error($conn));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
<div class="row">
<?php include "menu.php"; ?>
<main class="col-md-9 col-lg-10 p-4">
    <h2 class="mb-4">Kelola Data Kelas</h2>
    <div class="card mb-4 shadow-sm"><div class="card-body">
        <h5>JUMLAH DATA KELAS</h5><h2><?= (int)$total ?></h2>
    </div></div>

    <div class="card shadow-sm"><div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-primary">
                <tr><th>No</th><th>ID</th><th>Nama</th><th>Tingkat</th><th>Jurusan</th><th>Status Aktif</th><th>Dibuat</th><th>Diupdate</th></tr>
            </thead>
            <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($result)):
                    $updated = $row['updated_at'] ?? '';
                    if (empty($updated) || $updated === '0000-00-00 00:00:00') $updated = $row['created_at'] ?? '-';
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars((string)$row['id']) ?></td>
                    <td><?= htmlspecialchars((string)($row['nama'] ?? '-')) ?></td>
                    <td><?= htmlspecialchars((string)($row['tingkat'] ?? '-')) ?></td>
                    <td><?= htmlspecialchars((string)($row['jurusan'] ?? '-')) ?></td>
                    <td><?= htmlspecialchars((string)($row['status_aktif'] ?? '-')) ?></td>
                    <td><?= htmlspecialchars((string)($row['created_at'] ?? '-')) ?></td>
                    <td><?= htmlspecialchars((string)$updated) ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8" class="text-center">Belum ada data kelas.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
        </div>
    </div></div>
</main>
</div>
</div>
<?php include "footer.php"; ?>
</body>
</html>