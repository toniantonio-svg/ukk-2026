<?php
require_once "config.php";
require_once "cek_session.php";
cek_admin();

// Total wali kelas
$query_total = mysqli_query($conn, "SELECT COUNT(*) AS total FROM t_wali_kelas");
$total = ($query_total) ? mysqli_fetch_assoc($query_total)['total'] : 0;

// Data wali kelas
$result = mysqli_query($conn, "
    SELECT wk.*, g.nama AS nama_guru, g.nip, k.nama AS nama_kelas, ta.nama AS nama_tahun_ajaran
    FROM t_wali_kelas wk
    LEFT JOIN t_guru g ON wk.guru_id = g.id
    LEFT JOIN t_kelas k ON wk.kelas_id = k.id
    LEFT JOIN t_tahun_ajaran ta ON wk.tahun_ajaran_id = ta.id
    ORDER BY wk.id DESC
");

// Guru yang belum jadi wali kelas
$guru_list = mysqli_query($conn, "
    SELECT id, nama, nip
    FROM t_guru
    WHERE id NOT IN (
        SELECT DISTINCT guru_id 
        FROM t_wali_kelas 
        WHERE guru_id IS NOT NULL
    )
    ORDER BY nama
");
$sisa_guru = ($guru_list) ? mysqli_num_rows($guru_list) : 0;

$kelas_list = mysqli_query($conn, "SELECT id, nama FROM t_kelas ORDER BY nama");
$tahun_list = mysqli_query($conn, "SELECT id, nama FROM t_tahun_ajaran WHERE status_aktif = 1 ORDER BY nama");

// Simpan wali kelas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $guru_id = trim($_POST['guru_id'] ?? '');
    $kelas_id = trim($_POST['kelas_id'] ?? '');
    $tahun_ajaran_id = trim($_POST['tahun_ajaran_id'] ?? '');

    if (empty($guru_id) || empty($kelas_id) || empty($tahun_ajaran_id)) {
        $pesan = '<div class="alert alert-danger">Harap pilih Guru, Kelas, dan Tahun Ajaran!</div>';
    } else {
        $cek_guru = mysqli_query($conn, "SELECT id FROM t_wali_kelas WHERE guru_id = '$guru_id'");
        if (mysqli_num_rows($cek_guru) > 0) {
            $pesan = '<div class="alert alert-warning">Guru ini sudah menjadi wali kelas!</div>';
        } else {
            $cek_kelas = mysqli_query($conn, "SELECT id FROM t_wali_kelas 
                WHERE kelas_id = '$kelas_id' AND tahun_ajaran_id = '$tahun_ajaran_id'");
            if (mysqli_num_rows($cek_kelas) > 0) {
                $pesan = '<div class="alert alert-warning">Kelas ini sudah punya wali kelas di tahun ajaran tersebut!</div>';
            } else {
                $guru = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama, nip FROM t_guru WHERE id = '$guru_id'"));
                if (!$guru) {
                    $pesan = '<div class="alert alert-danger">Data guru tidak ditemukan!</div>';
                } else {
                    // Sesuai struktur tabel kamu: pakai email sebagai identitas unik, name sebagai nama
                    $email = !empty($guru['nip']) ? $guru['nip'].'@sekolah.sch.id' : 'guru_'.$guru_id.'@sekolah.sch.id';
                    $password = password_hash('123456', PASSWORD_DEFAULT);
                    $nama_pengguna = $guru['nama'];
                    $role = 'wali_kelas';

                    mysqli_begin_transaction($conn);
                    try {
                        // Simpan ke t_wali_kelas
                        $sql1 = "INSERT INTO t_wali_kelas (guru_id, kelas_id, tahun_ajaran_id, status_aktif) 
                            VALUES ('$guru_id', '$kelas_id', '$tahun_ajaran_id', 1)";
                        if (!mysqli_query($conn, $sql1)) {
                            throw new Exception("Tabel Wali Kelas: " . mysqli_error($conn));
                        }

                        // Buat akun di t_users — SESUAI STRUKTUR TABEL KAMU
                        $cek_user = mysqli_query($conn, "SELECT id FROM t_users WHERE email = '$email'");
                        if (mysqli_num_rows($cek_user) == 0) {
                            $sql2 = "INSERT INTO t_users (name, email, password, role, created_at, updated_at) 
                                VALUES ('$nama_pengguna', '$email', '$password', '$role', NOW(), NOW())";
                            if (!mysqli_query($conn, $sql2)) {
                                throw new Exception("Tabel Akun: " . mysqli_error($conn));
                            }
                        }

                        mysqli_commit($conn);
                        header("Location: kelola_wali_kelas.php");
                        exit;
                    } catch (Exception $e) {
                        mysqli_rollback($conn);
                        $pesan = '<div class="alert alert-danger"><strong>Gagal!</strong> ' . $e->getMessage() . '</div>';
                    }
                }
            }
        }
    }
}

// Cabut status — HAPUS HANYA DI t_wali_kelas, GURU TETAP ADA
if (isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM t_wali_kelas WHERE id = '$id_hapus'");
    header("Location: kelola_wali_kelas.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Wali Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
<div class="row">
<?php include "menu.php"; ?>
<main class="col-md-9 col-lg-10 p-4">
    <h2 class="mb-4">Kelola Wali Kelas</h2>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5>JUMLAH WALI KELAS: <?= $total ?></h5>
            <p class="text-muted">Sisa guru yang belum ditetapkan: <strong class="text-success"><?= $sisa_guru ?></strong> orang</p>
            <p class="text-success small">💡 Klik <b>Cabut Status</b> → status dicabut, data guru TETAP tersimpan</p>
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Tetapkan Wali Kelas Baru</h5>
            <?php if (isset($pesan)) echo $pesan; ?>

            <?php if ($sisa_guru == 0): ?>
                <div class="alert alert-info">
                    Semua guru sudah menjadi wali kelas.<br>
                    Klik <b>Cabut Status</b> di bawah untuk mengubah wali kelas.
                </div>
            <?php else: ?>
                <form method="post" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Nama Guru</label>
                        <select name="guru_id" class="form-select" required>
                            <option value="">-- Pilih Guru --</option>
                            <?php while ($g = mysqli_fetch_assoc($guru_list)): ?>
                            <option value="<?= $g['id'] ?>">
                                <?= htmlspecialchars($g['nama']) ?>
                                <?= !empty($g['nip']) ? " (NIP: {$g['nip']})" : '' ?>
                            </option>
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
                        <button type="submit" name="simpan" class="btn btn-primary">Tetapkan & Buat Akun</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama Guru</th>
                            <th>NIP / Email Akun</th>
                            <th>Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($result && mysqli_num_rows($result) > 0): ?>
                        <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['nama_guru'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($row['nip'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($row['nama_kelas'] ?? '-') ?></td>
                            <td><?= htmlspecialchars($row['nama_tahun_ajaran'] ?? '-') ?></td>
                            <td>
                                <a href="?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger"
                                   onclick="return confirm('Mencabut status wali kelas — Guru TIDAK dihapus. Lanjutkan?')">
                                    Cabut Status
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center">Belum ada data wali kelas.</td></tr>
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