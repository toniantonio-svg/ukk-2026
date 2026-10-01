<?php
    require_once "cek_session.php";
    cek_login();
    $nama = $_SESSION['name'];
    $role = $_SESSION['role'];
    require_once "config.php";
    
    $query_pelanggaran = mysqli_query($conn, "SELECT COUNT(*) AS total FROM t_pelanggaran");
    if (!$query_pelanggaran) {
        die("query pelanggaran gagal: " . mysqli_error($conn));
    }
    $data_pelanggaran = mysqli_fetch_assoc($query_pelanggaran);
    $total_pelanggaran = $data_pelanggaran['total'];
    
    $result = mysqli_query($conn, "SELECT * FROM t_pelanggaran ORDER BY id ASC");
    if (!$result) {
        die("ambil data gagal: " . mysqli_error($conn));
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KELOLA JENIS PELANGGARAN</title>
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
                    <h5>DATA JENIS PELANGGARAN</h5>
                    <h2><?= $total_pelanggaran ?></h2>
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
                            <th>KODE</th>
                            <th>NAMA</th>
                            <th>POIN</th>
                            <th>DESKRIPSI</th>
                            <th>STATUS AKTIF</th>
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
                            <td><?= $row['kode'] ?></td>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['poin'] ?></td>
                            <td><?= $row['deskripsi'] ?></td>
                            <td><?= $row['status_aktif'] ?></td>
                            <td><?= $row['created_at'] ?></td>
                            <td><?= $updated_tampil ?></td>
                            <td>
                                <a href="edit_jenis_pelanggaran.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">UBAH</a>
                                <a href="hapus_jenis_pelanggaran.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('yakin ingin menghapus?')">HAPUS</a>
                            </td>
                        </tr>
                        <?php
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include "footer.php"; ?>
</body>
</html>