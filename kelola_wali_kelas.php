<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

require_once "config.php";
require_once "cek_session.php";
cek_admin();

function e($v) {
    return htmlspecialchars((string)($v ?? '-'), ENT_QUOTES, 'UTF-8');
}

$pesan = '';

// === AKTIFKAN KEMBALI ===
if (isset($_GET['aktifkan']) && is_numeric($_GET['aktifkan'])) {
    $id = (int)$_GET['aktifkan'];
    $transaksi = false;
    try {
        mysqli_begin_transaction($conn);
        $transaksi = true;

        $stmt = $conn->prepare("SELECT wk.guru_id, wk.kelas_id, wk.tahun_ajaran_id, g.user_id 
                                FROM t_wali_kelas wk LEFT JOIN t_guru g ON wk.guru_id = g.id WHERE wk.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $data = $stmt->get_result()->fetch_assoc();
        if (!$data) throw new Exception("Data tidak ditemukan!");

        // Cek bentrok Guru
        $stmt = $conn->prepare("SELECT id FROM t_wali_kelas 
                                WHERE guru_id = ? AND tahun_ajaran_id = ? AND status_aktif = 1 AND id <> ?");
        $stmt->bind_param("iii", $data['guru_id'], $data['tahun_ajaran_id'], $id);
        $stmt->execute();
        if ($stmt->get_result()->num_rows)
            throw new Exception("Guru ini sudah jadi wali kelas aktif di tahun yang sama!");

        // Cek bentrok Kelas
        $stmt = $conn->prepare("SELECT id FROM t_wali_kelas 
                                WHERE kelas_id = ? AND tahun_ajaran_id = ? AND status_aktif = 1 AND id <> ?");
        $stmt->bind_param("iii", $data['kelas_id'], $data['tahun_ajaran_id'], $id);
        $stmt->execute();
        if ($stmt->get_result()->num_rows)
            throw new Exception("Kelas ini sudah punya wali kelas aktif di tahun yang sama!");

        // Aktifkan
        $stmt = $conn->prepare("UPDATE t_wali_kelas SET status_aktif = 1 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if (!empty($data['user_id'])) {
            $stmt = $conn->prepare("UPDATE t_users SET role = 'wali_kelas' WHERE id = ?");
            $stmt->bind_param("i", $data['user_id']);
            $stmt->execute();
        }

        mysqli_commit($conn);
        header("Location: ?diaktifkan=1");
        exit;
    } catch (Throwable $e) {
        if ($transaksi) mysqli_rollback($conn);
        $pesan = '<div class="alert alert-danger">'.$e->getMessage().'</div>';
    }
}

// === CABUT STATUS ===
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    $transaksi = false;
    try {
        mysqli_begin_transaction($conn);
        $transaksi = true;

        $stmt = $conn->prepare("SELECT wk.guru_id, g.user_id 
                                FROM t_wali_kelas wk LEFT JOIN t_guru g ON wk.guru_id = g.id WHERE wk.id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $data = $stmt->get_result()->fetch_assoc();
        if (!$data) throw new Exception("Data tidak ditemukan!");

        $stmt = $conn->prepare("UPDATE t_wali_kelas SET status_aktif = 0 WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if (!empty($data['user_id'])) {
            $stmt = $conn->prepare("SELECT COUNT(*) AS jml FROM t_wali_kelas 
                                    WHERE guru_id = ? AND status_aktif = 1 AND id <> ?");
            $stmt->bind_param("ii", $data['guru_id'], $id);
            $stmt->execute();
            if ($stmt->get_result()->fetch_assoc()['jml'] == 0) {
                $stmt = $conn->prepare("UPDATE t_users SET role = 'guru' WHERE id = ?");
                $stmt->bind_param("i", $data['user_id']);
                $stmt->execute();
            }
        }

        mysqli_commit($conn);
        header("Location: ?dihapus=1");
        exit;
    } catch (Throwable $e) {
        if ($transaksi) mysqli_rollback($conn);
        $pesan = '<div class="alert alert-danger">'.$e->getMessage().'</div>';
    }
}

// === SIMPAN BARU ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['simpan'])) {
    $gid = (int)($_POST['guru_id'] ?? 0);
    $kid = (int)($_POST['kelas_id'] ?? 0);
    $tid = (int)($_POST['tahun_ajaran_id'] ?? 0);
    $transaksi = false;

    try {
        if (!$gid || !$kid || !$tid) throw new Exception("Lengkapi semua data!");
        mysqli_begin_transaction($conn);
        $transaksi = true;

        // Validasi
        $stmt = $conn->prepare("SELECT * FROM t_guru WHERE id = ? AND status_aktif = 1");
        $stmt->bind_param("i", $gid); $stmt->execute();
        $guru = $stmt->get_result()->fetch_assoc();
        if (!$guru) throw new Exception("Guru tidak ditemukan!");

        $stmt = $conn->prepare("SELECT id FROM t_kelas WHERE id = ? AND status_aktif = 1");
        $stmt->bind_param("i", $kid); $stmt->execute();
        if (!$stmt->get_result()->num_rows) throw new Exception("Kelas tidak ditemukan!");

        $stmt = $conn->prepare("SELECT id, tanggal_mulai, tanggal_selesai FROM t_tahun_ajaran WHERE id = ? AND status_aktif = 1");
        $stmt->bind_param("i", $tid); $stmt->execute();
        $tahun = $stmt->get_result()->fetch_assoc();
        if (!$tahun) throw new Exception("Tahun ajaran tidak ditemukan!");

        // Cek duplikat
        $stmt = $conn->prepare("SELECT id FROM t_wali_kelas 
                                WHERE guru_id = ? AND tahun_ajaran_id = ? AND status_aktif = 1");
        $stmt->bind_param("ii", $gid, $tid); $stmt->execute();
        if ($stmt->get_result()->num_rows)
            throw new Exception("Guru sudah jadi wali kelas di tahun ini! Gunakan tombol Aktifkan.");

        $stmt = $conn->prepare("SELECT id FROM t_wali_kelas 
                                WHERE kelas_id = ? AND tahun_ajaran_id = ? AND status_aktif = 1");
        $stmt->bind_param("ii", $kid, $tid); $stmt->execute();
        if ($stmt->get_result()->num_rows)
            throw new Exception("Kelas sudah punya wali kelas di tahun ini!");

        // Email & Akun
        $email = trim($guru['email'] ?? '') ?: ($guru['nip'] ? $guru['nip'].'@sekolah.sch.id' : 'g'.$gid.'@sekolah.sch.id');
        $akun = null;
        if (!empty($guru['user_id'])) {
            $stmt = $conn->prepare("SELECT id,role FROM t_users WHERE id = ?");
            $stmt->bind_param("i", $guru['user_id']); $stmt->execute();
            $akun = $stmt->get_result()->fetch_assoc();
        }
        if (!$akun) {
            $stmt = $conn->prepare("SELECT id,role FROM t_users WHERE email = ?");
            $stmt->bind_param("s", $email); $stmt->execute();
            $akun = $stmt->get_result()->fetch_assoc();
        }

        if ($akun) {
            if ($akun['role'] === 'admin') throw new Exception("Email dipakai administrator!");
            $user_id = $akun['id'];
            $stmt = $conn->prepare("UPDATE t_users SET name=?, role='wali_kelas' WHERE id=?");
            $stmt->bind_param("si", $guru['nama'], $user_id); $stmt->execute();
        } else {
            $pass = password_hash('guru123', PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO t_users (name,email,email_verified_at,password,role) VALUES (?,?,NOW(),?,'wali_kelas')");
            $stmt->bind_param("sss", $guru['nama'], $email, $pass); $stmt->execute();
            $user_id = $conn->insert_id;
        }

        $stmt = $conn->prepare("UPDATE t_guru SET user_id=? WHERE id=?");
        $stmt->bind_param("ii", $user_id, $gid); $stmt->execute();

        $stmt = $conn->prepare("INSERT INTO t_wali_kelas (tahun_ajaran_id,kelas_id,guru_id,tanggal_mulai,tanggal_selesai,status_aktif) 
                                VALUES (?,?,?,?,?,1)");
        $stmt->bind_param("iiiss", $tid, $kid, $gid, $tahun['tanggal_mulai'], $tahun['tanggal_selesai']);
        $stmt->execute();

        mysqli_commit($conn);
        header("Location: ?berhasil=1");
        exit;
    } catch (Throwable $e) {
        if ($transaksi) mysqli_rollback($conn);
        $pesan = '<div class="alert alert-danger">'.$e->getMessage().'</div>';
    }
}

// Pesan notifikasi
if (isset($_GET['berhasil'])) $pesan = '<div class="alert alert-success">✅ Berhasil ditetapkan!</div>';
if (isset($_GET['dihapus'])) $pesan = '<div class="alert alert-success">✅ Status dicabut!</div>';
if (isset($_GET['diaktifkan'])) $pesan = '<div class="alert alert-success">✅ Diaktifkan kembali!</div>';

// === DATA ===
$total_aktif = (int)mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) x FROM t_wali_kelas WHERE status_aktif=1"))['x'];
$total_tidak_aktif = (int)mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) x FROM t_wali_kelas WHERE status_aktif=0"))['x'];

$result = mysqli_query($conn, "
    SELECT wk.*, g.nama guru, g.nip, k.nama kelas, ta.nama tahun
    FROM t_wali_kelas wk
    LEFT JOIN t_guru g ON wk.guru_id=g.id
    LEFT JOIN t_kelas k ON wk.kelas_id=k.id
    LEFT JOIN t_tahun_ajaran ta ON wk.tahun_ajaran_id=ta.id
    ORDER BY wk.status_aktif DESC, ta.nama DESC, wk.id DESC
");

$daftar_g = [];
$guru_list = mysqli_query($conn, "SELECT id,nama,nip FROM t_guru WHERE status_aktif=1 AND id NOT IN (
    SELECT guru_id FROM t_wali_kelas WHERE status_aktif=1 AND guru_id IS NOT NULL
) ORDER BY nama");
while ($g = mysqli_fetch_assoc($guru_list)) $daftar_g[] = $g;
$sisa_g = count($daftar_g);

$daftar_k = [];
$kelas_list = mysqli_query($conn, "SELECT id,nama FROM t_kelas WHERE status_aktif=1 ORDER BY nama");
while ($k = mysqli_fetch_assoc($kelas_list)) $daftar_k[] = $k;

$tahun_list = mysqli_query($conn, "SELECT id,nama FROM t_tahun_ajaran WHERE status_aktif=1 ORDER BY nama");
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
.table td,.table th{vertical-align:middle;white-space:nowrap}
.rel{position:relative}
.list{position:absolute;z-index:100;width:100%;max-height:240px;overflow-y:auto;background:#fff;border:1px solid #ced4da;box-shadow:0 4px 12px rgba(0,0,0,.15);display:none}
.itm{padding:8px 12px;cursor:pointer;border-bottom:1px solid #eee}
.itm:hover{background:#e3f2fd}
.sel{margin-top:8px;padding:8px;background:#e3f2fd;border-radius:5px;display:none}
.baris-tidak-aktif{background-color:#fff9e6 !important}
.badge-aktif{background:#198754;color:#fff;padding:3px 8px;border-radius:4px;font-size:.75rem}
.badge-nonaktif{background:#fd7e14;color:#fff;padding:3px 8px;border-radius:4px;font-size:.75rem}
</style>
</head>
<body>
<div class="container-fluid"><div class="row">
<?php include "menu.php"; ?>
<main class="col-md-9 col-lg-10 p-4">
<h2 class="mb-4">Kelola Wali Kelas</h2>

<div class="row mb-4 g-3">
    <div class="col-md-4"><div class="card shadow-sm border-0"><div class="card-body">
        <h6 class="text-muted">JUMLAH WALI KELAS AKTIF</h6>
        <h2 class="text-primary fw-bold"><?= $total_aktif ?></h2>
    </div></div></div>
    <div class="col-md-4"><div class="card shadow-sm border-0"><div class="card-body">
        <h6 class="text-muted">JUMLAH TIDAK AKTIF</h6>
        <h2 class="text-secondary fw-bold"><?= $total_tidak_aktif ?></h2>
    </div></div></div>
    <div class="col-md-4"><div class="card shadow-sm border-0"><div class="card-body">
        <h6 class="text-muted">SISA GURU BELUM JADI WALI</h6>
        <h2 class="text-success fw-bold"><?= $sisa_g ?></h2>
    </div></div></div>
</div>

<?= $pesan ?>

<div class="card shadow-sm border-0 mb-4"><div class="card-body">
<h5 class="mb-3">Tetapkan Wali Kelas Baru</h5>
<?php if (!$sisa_g): ?>
    <div class="alert alert-info">Semua guru sudah menjadi wali kelas aktif.</div>
<?php else: ?>
<form method="POST" class="row g-3">
    <div class="col-md-4 rel">
        <label class="form-label">Nama Guru <span class="text-danger">*</span></label>
        <input type="text" id="cg" class="form-control" placeholder="Ketik nama guru..." autocomplete="off" required>
        <input type="hidden" name="guru_id" id="gid" required>
        <div class="sel" id="gs">Dipilih: <span id="gn"></span>
            <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="rg()">Ubah</button>
        </div>
        <div class="list" id="dg">
            <?php foreach ($daftar_g as $g): ?>
            <div class="itm" data-id="<?= $g['id'] ?>" data-teks="<?= e(strtolower($g['nama'].' '.$g['nip'])) ?>">
                <?= e($g['nama']) ?> <small class="text-muted"><?= e($g['nip']) ?></small>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-md-4 rel">
        <label class="form-label">Kelas <span class="text-danger">*</span></label>
        <input type="text" id="ck" class="form-control" placeholder="Ketik nama kelas..." autocomplete="off" required>
        <input type="hidden" name="kelas_id" id="kid" required>
        <div class="sel" id="ks">Dipilih: <span id="kn"></span>
            <button type="button" class="btn btn-sm btn-outline-secondary ms-2" onclick="rk()">Ubah</button>
        </div>
        <div class="list" id="dk">
            <?php foreach ($daftar_k as $k): ?>
            <div class="itm" data-id="<?= $k['id'] ?>" data-teks="<?= e(strtolower($k['nama'])) ?>"><?= e($k['nama']) ?></div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-md-4">
        <label class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
        <select name="tahun_ajaran_id" class="form-select" required>
            <option value="">-- Pilih Tahun --</option>
            <?php while ($t = mysqli_fetch_assoc($tahun_list)): ?>
            <option value="<?= $t['id'] ?>"><?= e($t['nama']) ?></option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="col-12">
        <button type="submit" name="simpan" class="btn btn-primary">Tetapkan & Buat Akun</button>
    </div>
</form>
<?php endif; ?>
</div></div>

<div class="card shadow-sm border-0"><div class="card-body">
<h5 class="mb-3">Daftar Semua Wali Kelas</h5>
<div class="table-responsive">
<table id="t" class="table table-bordered table-hover w-100">
<thead class="table-primary">
    <tr>
        <th>No</th><th>Status</th><th>Nama Guru</th><th>NIP/Email</th><th>Kelas</th><th>Tahun</th><th>Aksi</th>
    </tr>
</thead>
<tbody>
<?php $no=1; while ($r = mysqli_fetch_assoc($result)): ?>
<tr class="<?= $r['status_aktif']==0?'baris-tidak-aktif':'' ?>">
    <td><?= $no++ ?></td>
    <td><?= $r['status_aktif']==1?'<span class="badge-aktif">Aktif</span>':'<span class="badge-nonaktif">Tidak Aktif</span>' ?></td>
    <td><?= e($r['guru']) ?></td>
    <td><?= e($r['nip']) ?><br><small class="text-muted"><?= $r['nip']?e($r['nip'].'@sekolah.sch.id'):'-' ?></small></td>
    <td><?= e($r['kelas']) ?></td>
    <td><?= e($r['tahun']) ?></td>
    <td>
        <?php if ($r['status_aktif']==1): ?>
            <a href="?hapus=<?= $r['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Cabut status ini?')">Cabut</a>
        <?php else: ?>
            <a href="?aktifkan=<?= $r['id'] ?>" class="btn btn-sm btn-success" onclick="return confirm('Aktifkan kembali?')">Aktifkan</a>
        <?php endif; ?>
    </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div></div></div>
</main></div></div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.min.js"></script>

<script>
$(function(){$('#t').DataTable({pageLength:10,language:{search:"Cari:",lengthMenu:"Tampilkan _MENU_ entri",info:"Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",paginate:{previous:"&lt;",next:"&gt;"}}});});

// Pilih Guru
const cg=document.getElementById('cg'),gid=document.getElementById('gid'),gn=document.getElementById('gn'),dg=document.getElementById('dg'),gs=document.getElementById('gs');
dg.querySelectorAll('.itm').forEach(i=>i.onclick=()=>{gid.value=i.dataset.id;gn.textContent=i.textContent;dg.style.display='none';cg.style.display='none';gs.style.display='block';});
cg.oninput=()=>{let v=cg.value.toLowerCase();dg.style.display=v?'block':'none';dg.querySelectorAll('.itm').forEach(i=>i.style.display=i.dataset.teks.includes(v)?'':'none');};
function rg(){gid.value='';cg.value='';cg.style.display='block';gs.style.display='none';dg.style.display='none';}

// Pilih Kelas
const ck=document.getElementById('ck'),kid=document.getElementById('kid'),kn=document.getElementById('kn'),dk=document.getElementById('dk'),ks=document.getElementById('ks');
dk.querySelectorAll('.itm').forEach(i=>i.onclick=()=>{kid.value=i.dataset.id;kn.textContent=i.textContent;dk.style.display='none';ck.style.display='none';ks.style.display='block';});
ck.oninput=()=>{let v=ck.value.toLowerCase();dk.style.display=v?'block':'none';dk.querySelectorAll('.itm').forEach(i=>i.style.display=i.dataset.teks.includes(v)?'':'none');};
function rk(){kid.value='';ck.value='';ck.style.display='block';ks.style.display='none';dk.style.display='none';}
</script>
</body>
</html>