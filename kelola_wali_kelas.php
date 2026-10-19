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

// Total wali kelas
$query_total = mysqli_query($conn, "SELECT COUNT(*) AS total FROM t_wali_kelas");
$total = ($query_total) ? (int)mysqli_fetch_assoc($query_total)['total'] : 0;

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
                    $email = !empty($guru['nip']) ? $guru['nip'].'@sekolah.sch.id' : 'guru_'.$guru_id.'@sekolah.sch.id';
                    $password = password_hash('123456', PASSWORD_DEFAULT);
                    $nama_pengguna = $guru['nama'];
                    $role = 'wali_kelas';

                    mysqli_begin_transaction($conn);
                    try {
                        $sql1 = "INSERT INTO t_wali_kelas (guru_id, kelas_id, tahun_ajaran_id, status_aktif) 
                            VALUES ('$guru_id', '$kelas_id', '$tahun_ajaran_id', 1)";
                        if (!mysqli_query($conn, $sql1)) {
                            throw new Exception("Tabel Wali Kelas: " . mysqli_error($conn));
                        }

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

// Cabut status
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
    <link href="https://cdn.datatables.net/2.3.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .table th, .table td {
            vertical-align: middle;
            white-space: nowrap;
        }
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .btn-sm {
            padding: 0.2rem 0.5rem;
            font-size: 0.75rem;
        }
        #tabelWali td:last-child {
            width: 140px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include "menu.php"; ?>
        <main class="col-md-9 col-lg-10 p-4">
            <h2 class="mb-4">Kelola Wali Kelas</h2>

            <!-- Jumlah Wali Kelas -->
            <div class="row mb-4">
                <div class="col-md-5 col-lg-4">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title text-muted fs-6">JUMLAH WALI KELAS</h5>
                            <h2 class="text-primary fw-bold"><?= $total ?></h2>
                            <p class="text-muted small mt-2">
                                Sisa guru belum ditetapkan:
                                <strong class="text-success"><?= $sisa_guru ?></strong> orang
                            </p>
                            <p class="text-success small mb-0">
                                💡 Klik <b>Cabut Status</b> → status dicabut, data guru TETAP tersimpan
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Tetapkan Wali Kelas -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="mb-3 fw-semibold">Tetapkan Wali Kelas Baru</h5>
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
                                            <?= e($g['nama']) ?>
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
                                        <option value="<?= $k['id'] ?>"><?= e($k['nama']) ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tahun Ajaran</label>
                                <select name="tahun_ajaran_id" class="form-select" required>
                                    <option value="">-- Pilih Tahun --</option>
                                    <?php while ($t = mysqli_fetch_assoc($tahun_list)): ?>
                                        <option value="<?= $t['id'] ?>"><?= e($t['nama']) ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <button type="submit" name="simpan" class="btn btn-primary">
                                    Tetapkan & Buat Akun
                                </button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Daftar Wali Kelas -->
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="mb-3 fw-semibold">Daftar Wali Kelas</h5>
                    <div class="table-responsive">
                        <table id="tabelWali" class="table table-bordered table-striped table-hover align-middle w-100">
                            <thead class="table-primary text-white">
                                <tr>
                                    <th class="text-center" width="5%">No.</th>
                                    <th width="25%">Nama Guru</th>
                                    <th width="22%">NIP / Email Akun</th>
                                    <th width="18%">Kelas</th>
                                    <th width="15%">Tahun Ajaran</th>
                                    <th class="text-center" width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($result)):
                                    $email_akun = !empty($row['nip']) ? $row['nip'].'@sekolah.sch.id' : '-';
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= e($row['nama_guru']) ?></td>
                                        <td>
                                            <div><?= e($row['nip']) ?></div>
                                            <small class="text-muted"><?= e($email_akun) ?></small>
                                        </td>
                                        <td><?= e($row['nama_kelas']) ?></td>
                                        <td><?= e($row['nama_tahun_ajaran']) ?></td>
                                        <td class="text-center text-nowrap">
                                            <a href="?hapus=<?= $row['id'] ?>"
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Mencabut status wali kelas — Guru TIDAK dihapus. Lanjutkan?')">
                                                Cabut Status
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
    $('#tabelWali').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.3.4/i18n/id.json'
        },
        pageLength: 10,
        lengthMenu: [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, 'Semua']
        ],
        order: [[0, 'asc']],
        columnDefs: [
            {
                targets: [0, 5],
                orderable: false,
                searchable: false
            },
            {
                targets: [0, 5],
                className: 'text-center'
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