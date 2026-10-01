<?php
    require_once "cek_session.php";
    cek_login();
    $nama = $_SESSION['name'];
    $role = $_SESSION['role'];
    require_once "config.php";

    $query_siswa = mysqli_query($conn, "SELECT COUNT(*) AS total FROM t_siswa");
    if (!$query_siswa) {
        die("query siswa gagal: " . mysqli_error($conn));
    }
    $data_siswa = mysqli_fetch_assoc($query_siswa);
    $total_siswa = $data_siswa['total'];

    $result = mysqli_query($conn, "SELECT * FROM t_siswa ORDER BY id ASC");
    if (!$result) {
        die("ambil data gagal: " . mysqli_error($conn));
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>data siswa</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
        crossorigin="anonymous">
</head>
<body>
<?php include "menu.php"; ?>

<div class="col-md-9 col-lg-10 p-4">
    <!-- Kartu Total Siswa -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>JUMLAH DATA SISWA</h5>
                    <h2><?= $total_siswa ?></h2>
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
                            <th>NIS</th>
                            <th>NAMA</th>
                            <th>JENIS KELAMIN</th>
                            <th>TANGGAL LAHIR</th>
                            <th>ALAMAT</th>
                            <th>DIBUAT</th>
                            <th>DIUPDATE</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                            $updated_tampil = $row['updated_at'];
                            if (empty($updated_tampil) || $updated_tampil === '0000-00-00 00:00:00') {
                                $updated_tampil = $row['created_at'];
                            }
                        ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['nis'] ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['jenis_kelamin'] ?></td>
                            <td><?= $row['tanggal_lahir'] ?></td>
                            <td><?= $row['alamat'] ?></td>
                            <td><?= $row['created_at'] ?></td>
                            <td><?= $updated_tampil ?></td>
                            <td>
                                <a href="edit_siswa.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">UBAH</a>
                                <a href="hapus_siswa.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('yakin ingin menghapus?')">HAPUS</a>
                            </td>
                        </tr>
                        <?php
                            $no++;
                        }
                        ?>
                        <tr>
                            <td colspan="9"></td>
                            <td>
                                <a href="tambah_data_siswa.php" class="btn btn-sm btn-success w-100">TAMBAH SISWA</a>
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