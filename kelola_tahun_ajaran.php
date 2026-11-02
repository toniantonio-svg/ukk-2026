<?php
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

// Hitung total tahun ajaran
$query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM t_tahun_ajaran");
if (!$query) die("Query tahun ajaran gagal: " . mysqli_error($conn));
$total = (int)(mysqli_fetch_assoc($query)['total'] ?? 0);

// Ambil semua data tahun ajaran
$result = mysqli_query($conn, "SELECT * FROM t_tahun_ajaran ORDER BY id ASC");
if (!$result) die("Ambil data tahun ajaran gagal: " . mysqli_error($conn));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Tahun Ajaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include "menu.php"; ?>
        <main class="col-md-9 col-lg-10 p-4">
            <h2 class="mb-4">Kelola Tahun Ajaran</h2>

            <!-- Jumlah Tahun Ajaran -->
            <div class="row mb-4">
                <div class="col-md-5 col-lg-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title text-muted fs-6">JUMLAH TAHUN AJARAN</h5>
                            <h2 class="text-primary fw-bold"><?= $total ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover mb-0">
                            <thead class="table-primary">
                                <tr>
                                    <th width="5%" class="text-center">No</th>
                                    <th width="8%" class="text-center">ID</th>
                                    <th>Nama Tahun</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th width="12%" class="text-center">Status Aktif</th>
                                    <th width="15%">Dibuat</th>
                                    <th width="15%">Diupdate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($result) > 0): ?>
                                    <?php 
                                    $no = 1;
                                    while ($row = mysqli_fetch_assoc($result)):
                                        // Tangani tanggal update
                                        $updated = $row['updated_at'] ?? '';
                                        if (empty($updated) || $updated === '0000-00-00 00:00:00') {
                                            $updated = $row['created_at'] ?? '-';
                                        }

                                        // Tentukan tampilan status
                                        $status = (string)($row['status_aktif'] ?? '');
                                        if ($status === '1') {
                                            $status_badge = '<span class="badge bg-success">Aktif</span>';
                                        } elseif ($status === '0') {
                                            $status_badge = '<span class="badge bg-secondary">Tidak Aktif</span>';
                                        } else {
                                            $status_badge = e($status);
                                        }
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td class="text-center"><?= e($row['id']) ?></td>
                                        <td><?= e($row['nama']) ?></td>
                                        <td><?= e($row['tanggal_mulai']) ?></td>
                                        <td><?= e($row['tanggal_selesai']) ?></td>
                                        <td class="text-center"><?= $status_badge ?></td>
                                        <td><?= e($row['created_at']) ?></td>
                                        <td><?= e($updated) ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-3">Belum ada data tahun ajaran.</td>
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