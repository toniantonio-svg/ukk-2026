<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once "cek_session.php";
    cek_admin();
    require_once "config.php";

    // Menghitung jumlah guru
    $query_guru = mysqli_query($conn, "SELECT COUNT(*) AS total FROM t_guru");
    if (!$query_guru) {
        die("query guru gagal: " . mysqli_error($conn));
    }
    $data_guru = mysqli_fetch_assoc($query_guru);
    $total_guru = $data_guru['total'];

    // Mengambil semua data guru
    $result = mysqli_query($conn, "SELECT * FROM t_guru ORDER BY id ASC");
    if (!$result) {
        die("ambil data gagal: " . mysqli_error($conn));
    }

    // Mendeteksi kolom updated secara otomatis
    $sample = mysqli_fetch_assoc($result);
    $kolom_updated = null;
    foreach ($sample as $nama => $nilai) {
        if (stripos($nama, 'updated') !== false) {
            $kolom_updated = $nama;
            break;
        }
    }
    mysqli_data_seek($result, 0);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KELOLA DATA GURU</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">
</head>
<body>
<?php include "menu.php"; ?>
<div class="col-md-9 col-lg-10 p-4">
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>JUMLAH DATA GURU</h5>
                    <h2><?= $total_guru ?></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>NO</th>
                            <th>ID</th>
                            <th>NIP</th>
                            <th>NAMA</th>
                            <th>EMAIL</th>
                            <th>STATUS AKTIF</th>
                            <th>ID USER</th>
                            <th>DIBUAT</th>
                            <th>DIUPDATE</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $nilai_updated = $kolom_updated ? $row[$kolom_updated] : $row['created_at'];
                            if (empty($nilai_updated) || $nilai_updated === '0000-00-00 00:00:00') {
                                $nilai_updated = $row['created_at'];
                            }
                        ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['nip'] ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['status_aktif'] ?></td>
                            <td><?= $row['user_id'] ?></td>
                            <td><?= $row['created_at'] ?></td>
                            <td><?= $nilai_updated ?></td>
                            <td>
                                <a href="edit_guru.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">UBAH</a>
                                <a href="hapus_guru.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('yakin ingin menghapus?')">HAPUS</a>
                            </td>
                        </tr>
                        <?php
                            $no++;
                        }
                        ?>
                        <tr>
                            <td colspan="9"></td>
                            <td>
                                <a href="tambah_data_guru.php" class="btn btn-sm btn-success w-100">TAMBAH GURU</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>