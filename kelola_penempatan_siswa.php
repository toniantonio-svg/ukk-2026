<?php
require_once "config.php";
require_once "cek_session.php";
cek_admin();

// Hitung total penempatan
$query_total = mysqli_query($conn, "SELECT COUNT(*) AS total FROM t_kelas_siswa");
if (!$query_total) die("Query total gagal: " . mysqli_error($conn));
$total = mysqli_fetch_assoc($query_total)['total'];

// Ambil data penempatan — SESUAI SEMUA KOLOM
$result = mysqli_query($conn, "
    SELECT ks.*, 
           s.nama AS nama_siswa, 
           k.nama AS nama_kelas, 
           ta.nama AS nama_tahun_ajaran
    FROM t_kelas_siswa ks
    LEFT JOIN t_siswa s ON ks.siswa_id = s.id
    LEFT JOIN t_kelas k ON ks.kelas_id = k.id
    LEFT JOIN t_tahun_ajaran ta ON ks.tahun_ajaran_id = ta.id
    ORDER BY ks.id DESC
");
if (!$result) die("Ambil data gagal: " . mysqli_error($conn));

// Data untuk dropdown — SESUAI KOLOM
$siswa_list = mysqli_query($conn, "SELECT id, nama FROM t_siswa ORDER BY nama");
$kelas_list = mysqli_query($conn, "SELECT id, nama FROM t_kelas ORDER BY nama");
$tahun_list = mysqli_query($conn, "SELECT id, nama FROM t_tahun_ajaran WHERE status_aktif = 1 ORDER BY nama");

// Simpan penempatan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $siswa_id = $_POST['siswa_id'] ?? '';
    $kelas_id = $_POST['kelas_id'] ?? '';
    $tahun_ajaran_id = $_POST['tahun_ajaran_id'] ?? '';

    if ($siswa_id && $kelas_id && $tahun_ajaran_id) {
        // Cek duplikasi
        $cek = mysqli_query($conn, "SELECT id FROM t_kelas_siswa 
            WHERE siswa_id = '$siswa_id' AND kelas_id = '$kelas_id' AND tahun_ajaran_id = '$tahun_ajaran_id'");
        
        if (mysqli_num_rows($cek) > 0) {
            $pesan = '<div class="alert alert-warning">Siswa sudah ditempatkan di kelas ini untuk tahun ajaran tersebut!</div>';
        } else {
            $sql = "INSERT INTO t_kelas_siswa (siswa_id, kelas_id, tahun_ajaran_id) 
                    VALUES ('$siswa_id', '$kelas_id', '$tahun_ajaran_id')";
            mysqli_query($conn, $sql);
            header("Location: kelola_penempatan_siswa.php");
            exit;
        }
    }
}

// Hapus penempatan
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM t_kelas_siswa WHERE id = '$id'");
    header("Location: kelola_penempatan_siswa.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Penempatan Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
<div class="row">
<?php include "menu.php"; ?>
<main class="col-md-9 col-lg-10 p-4">
    <h2 class="mb-4">Kelola Penempatan Siswa ke Kelas</h2>

    <!-- Jumlah Data -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5>JUMLAH PENEMPATAN</h5>
            <h2><?= (int)$total ?></h2>
        </div>
    </div>

    <!-- Form Tambah -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Tambah Penempatan</h5>
            <?php if (isset($pesan)) echo $pesan; ?>
            <form method="post" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Siswa</label>
                    <select name="siswa_id" class="form-select" required>
                        <option value="">-- Pilih Siswa --</option>
                        <?php while ($s = mysqli_fetch_assoc($siswa_list)): ?>
                        <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['nama']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kelas</label>
                    <select name="kelas_id" class="form-select" required>
                        <option value="">-- Pilih Kelas --</option>
                        <?php while ($k = mysqli_fetch_assoc($kelas_list)): ?>
                        <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tahun Ajaran</label>
                    <select name="tahun_ajaran_id" class="form-select" required>
                        <option value="">-- Pilih Tahun --</option>
                        <?php while ($t = mysqli_fetch_assoc($tahun_list)): ?>
                        <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nama']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-12">
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan Penempatan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars((string)$row['id']) ?></td>
                            <td><?= htmlspecialchars((string)($row['nama_siswa'] ?? '-')) ?></td>
                            <td><?= htmlspecialchars((string)($row['nama_kelas'] ?? '-')) ?></td>
                            <td><?= htmlspecialchars((string)($row['nama_tahun_ajaran'] ?? '-')) ?></td>
                            <td>
                                <a href="?hapus=<?= $row['id'] ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Yakin hapus penempatan ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data penempatan.</td>
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