
<?php
require_once "config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "cek_session.php";
cek_admin();

function e($v) {
    return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');
}

$pesan = '';
$ada_poin = false;

// Periksa apakah kolom poin tersedia
$cek_kolom = mysqli_query($conn, "
    SHOW COLUMNS FROM t_pelanggaran_kategori LIKE 'poin'
");

if ($cek_kolom && mysqli_num_rows($cek_kolom) > 0) {
    $ada_poin = true;
}

// Simpan kategori
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama = trim($_POST['nama'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $poin = (int)($_POST['poin'] ?? 0);
    $status = (int)($_POST['status_aktif'] ?? 1);

    if ($nama === '') {
        $pesan = '<div class="alert alert-danger">Nama kategori wajib diisi!</div>';

    } elseif ($ada_poin && $poin < 1) {
        $pesan = '<div class="alert alert-danger">Poin harus lebih dari 0!</div>';

    } else {

        if ($ada_poin) {

            $stmt = $conn->prepare("
                INSERT INTO t_pelanggaran_kategori
                (nama, deskripsi, poin, status_aktif)
                VALUES (?, ?, ?, ?)
            ");

            $stmt->bind_param(
                "ssii",
                $nama,
                $deskripsi,
                $poin,
                $status
            );

        } else {

            $stmt = $conn->prepare("
                INSERT INTO t_pelanggaran_kategori
                (nama, deskripsi, status_aktif)
                VALUES (?, ?, ?)
            ");

            $stmt->bind_param(
                "ssi",
                $nama,
                $deskripsi,
                $status
            );
        }

        if ($stmt->execute()) {
            header("Location: kelola_kategori_pelanggaran.php?pesan=berhasil");
            exit;
        } else {
            $pesan = '<div class="alert alert-danger">Gagal menyimpan kategori: '
                . e($stmt->error) . '</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Tambah Kategori Pelanggaran</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container-fluid">
<div class="row">

    <?php include "menu.php"; ?>

    <main class="col-md-9 col-lg-10 p-4">

        <h2 class="mb-4">Tambah Kategori Pelanggaran</h2>

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <?= $pesan ?>

                <form method="POST">

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Nama Kategori
                        </label>

                        <input
                            type="text"
                            name="nama"
                            class="form-control"
                            placeholder="Contoh: Kedisiplinan"
                            value="<?= e($_POST['nama'] ?? '') ?>"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Deskripsi
                        </label>

                        <textarea
                            name="deskripsi"
                            class="form-control"
                            rows="3"
                            placeholder="Masukkan deskripsi kategori"
                        ><?= e($_POST['deskripsi'] ?? '') ?></textarea>
                    </div>

                    <?php if ($ada_poin): ?>

                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            Poin Pelanggaran
                        </label>

                        <input
                            type="number"
                            name="poin"
                            class="form-control"
                            min="1"
                            value="<?= e($_POST['poin'] ?? '') ?>"
                            required
                        >
                    </div>

                    <?php endif; ?>

                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            Status
                        </label>

                        <select name="status_aktif" class="form-select">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Simpan Kategori
                    </button>

                    <a href="kelola_kategori_pelanggaran.php"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                </form>

            </div>
        </div>

    </main>

</div>
</div>

<?php
if (file_exists("footer.php")) {
    include "footer.php";
}
?>

</body>
</html>