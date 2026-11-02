<?php
require_once "config.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "cek_session.php";
cek_login();

function e($v) {
    return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');
}

$nama = $_SESSION['name'];
$role = strtolower(trim($_SESSION['role']));

if ($role !== 'guru' && $role !== 'wali_kelas') {
    echo "<script>alert('Anda tidak berhak!');location.href='dashboard.php';</script>";
    exit;
}

// =====================================
// DATA KELAS WALI KELAS
// =====================================

$kelas_id = 0;
$nama_kelas = '';

if ($role === 'wali_kelas') {
    $stmt = $conn->prepare("
        SELECT w.kelas_id, k.nama
        FROM t_wali_kelas w
        JOIN t_kelas k ON w.kelas_id = k.id
        JOIN t_guru g ON w.guru_id = g.id
        WHERE w.status_aktif = 1
          AND g.nama = ?
        LIMIT 1
    ");
    $stmt->bind_param("s", $nama);
    $stmt->execute();
    $r = $stmt->get_result()->fetch_assoc();
    if ($r) {
        $kelas_id = (int)$r['kelas_id'];
        $nama_kelas = $r['nama'];
    }
}

// =====================================
// DAFTAR SISWA
// =====================================

$daftar_s = [];

if ($role === 'wali_kelas' && $kelas_id > 0) {
    $q_s = mysqli_query($conn, "
        SELECT s.id, s.nama, s.nis
        FROM t_siswa s
        INNER JOIN t_kelas_siswa ks ON s.id = ks.siswa_id
        WHERE ks.kelas_id = '$kelas_id'
        ORDER BY s.nama
    ");
} else {
    $q_s = mysqli_query($conn, "
        SELECT s.id, s.nama, s.nis
        FROM t_siswa s
        ORDER BY s.nama
    ");
}

if ($q_s) {
    while ($r = mysqli_fetch_assoc($q_s)) {
        $daftar_s[] = $r;
    }
}

// =====================================
// DAFTAR KATEGORI PELANGGARAN
// =====================================

$daftar_k = [];
$q_k = mysqli_query($conn, "
    SELECT *
    FROM t_pelanggaran_kategori
    WHERE status_aktif = 1
    ORDER BY poin, nama
");
if ($q_k) {
    while ($r = mysqli_fetch_assoc($q_k)) {
        $daftar_k[] = $r;
    }
}

// =====================================
// SIMPAN PELANGGARAN — DIPERBAIKI
// =====================================

$pesan = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['siswa_id'])) {
    $sid = (int)$_POST['siswa_id'];
    $kid = (int)($_POST['kategori_id'] ?? 0);
    $ket = trim($_POST['keterangan'] ?? '');
    $poin = 0;

    if ($kid > 0) {
        $stmt = $conn->prepare("
            SELECT poin
            FROM t_pelanggaran_kategori
            WHERE id = ? AND status_aktif = 1
        ");
        $stmt->bind_param("i", $kid);
        $stmt->execute();
        $p = $stmt->get_result()->fetch_assoc();
        if (!$p) {
            $pesan = '<div class="alert alert-danger">Kategori pelanggaran tidak ditemukan!</div>';
        } else {
            $poin = (int)$p['poin'];
        }
    } else {
        $pesan = '<div class="alert alert-danger">Pilih kategori pelanggaran!</div>';
    }

    if (!$pesan && $role === 'wali_kelas') {
        if ($kelas_id <= 0) {
            $pesan = '<div class="alert alert-danger">Anda belum memiliki kelas wali!</div>';
        } else {
            $stmt = $conn->prepare("
                SELECT 1
                FROM t_kelas_siswa
                WHERE siswa_id = ? AND kelas_id = ?
                LIMIT 1
            ");
            $stmt->bind_param("ii", $sid, $kelas_id);
            $stmt->execute();
            if (!$stmt->get_result()->num_rows) {
                $pesan = '<div class="alert alert-danger">Siswa tidak terdaftar di kelas Anda!</div>';
            }
        }
    }

    if (!$pesan) {
        // === BAGIAN INI DIPERBAIKI ===
        // Sebutkan nama kolom secara eksplisit agar sesuai
        $stmt = $conn->prepare("
            INSERT INTO t_pelanggaran_siswa
            (siswa_id, pelanggaran_kategori_id, keterangan, poin, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param("iisi", $sid, $kid, $ket, $poin);

        if ($stmt->execute()) {
            $pesan = '<div class="alert alert-success">Berhasil disimpan! Poin: '.$poin.'</div>';
        } else {
            $pesan = '<div class="alert alert-danger">Gagal menyimpan pelanggaran: ' . e($stmt->error) . '</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catat Pelanggaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .siswa-list {
            position: absolute;
            z-index: 100;
            width: 100%;
            max-height: 240px;
            overflow-y: auto;
            background: #fff;
            border: 1px solid #ced4da;
            border-top: none;
            border-radius: 0 0 0.375rem 0.375rem;
            box-shadow: 0 4px 12px rgba(0,0,0,.15);
            display: none;
        }
        .siswa-item {
            padding: 0.5rem 0.75rem;
            cursor: pointer;
        }
        .siswa-item:hover, .siswa-item:focus {
            background-color: #e9ecef;
        }
        .siswa-item.selected {
            background-color: #0d6efd;
            color: #fff;
        }
        .input-wrapper {
            position: relative;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php include "menu.php"; ?>
        <main class="col-md-9 col-lg-10 p-4">
            <h2 class="mb-3">Catat Pelanggaran Siswa</h2>
            <p>Selamat datang, <strong><?= e($nama) ?></strong>!</p>

            <?php if ($role === 'wali_kelas'): ?>
            <div class="alert alert-info mb-4">
                Anda hanya mencatat pelanggaran di kelas:
                <strong><?= e($nama_kelas ?: 'Belum ditetapkan') ?></strong>
            </div>
            <?php endif; ?>

            <?= $pesan ?>

            <?php if (!$daftar_k): ?>
            <div class="alert alert-warning">Kategori pelanggaran belum ada!</div>
            <?php endif; ?>

            <form method="post" class="card shadow-sm p-4" id="formCatat">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nama Siswa</label>
                    <div class="input-wrapper">
                        <input
                            type="text"
                            id="cariS"
                            class="form-control"
                            placeholder="Ketik nama/NIS..."
                            autocomplete="off"
                        >
                        <div id="daftarSiswa" class="siswa-list"></div>
                    </div>
                    <input type="hidden" name="siswa_id" id="siswa_id" required>
                    <div id="namaTerpilih" class="mt-2 small text-success" style="display:none;">
                        Terpilih: <strong id="labelSiswa"></strong>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Kategori Pelanggaran</label>
                    <select
                        name="kategori_id"
                        id="kat"
                        class="form-select form-select-lg"
                        required
                        onchange="setPoin()"
                    >
                        <option value="">-- Pilih Jenis --</option>
                        <?php foreach ($daftar_k as $k): ?>
                        <option
                            value="<?= $k['id'] ?>"
                            data-poin="<?= $k['poin'] ?>"
                        >
                            <?= e($k['nama']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Keterangan Tambahan</label>
                    <textarea
                        name="keterangan"
                        class="form-control"
                        rows="2"
                        placeholder="Tulis jika ada..."
                    ></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-bold">Poin</label>
                    <input
                        type="number"
                        id="poin"
                        class="form-control form-select-lg"
                        min="1"
                        readonly
                        placeholder="Muncul otomatis"
                    >
                </div>

                <button
                    type="submit"
                    class="btn btn-primary btn-lg w-100"
                    <?= !$daftar_k ? 'disabled' : '' ?>
                >
                    Simpan Pelanggaran
                </button>
            </form>
        </main>
    </div>
</div>

<script>
const daftarSiswa = <?= json_encode($daftar_s) ?>;
const cariInput = document.getElementById('cariS');
const daftarEl = document.getElementById('daftarSiswa');
const siswaIdEl = document.getElementById('siswa_id');
const namaTerpilihEl = document.getElementById('namaTerpilih');
const labelSiswaEl = document.getElementById('labelSiswa');
let terpilih = null;

function renderDaftar(hasil) {
    daftarEl.innerHTML = '';
    if (hasil.length === 0) {
        daftarEl.innerHTML = '<div class="p-2 text-muted">Tidak ditemukan — coba kata lain</div>';
        daftarEl.style.display = 'block';
        return;
    }
    hasil.forEach(s => {
        const item = document.createElement('div');
        item.className = 'siswa-item' + (terpilih && terpilih.id === s.id ? ' selected' : '');
        item.innerHTML = `${s.nama} — NIS: ${s.nis}`;
        item.addEventListener('click', () => pilihSiswa(s));
        daftarEl.appendChild(item);
    });
    daftarEl.style.display = 'block';
}

function pilihSiswa(s) {
    terpilih = s;
    siswaIdEl.value = s.id;
    cariInput.value = s.nama;
    labelSiswaEl.textContent = `${s.nama} — NIS: ${s.nis}`;
    namaTerpilihEl.style.display = 'block';
    daftarEl.style.display = 'none';
}

function filterS() {
    const k = cariInput.value.trim().toLowerCase();
    if (k === '') {
        daftarEl.style.display = 'none';
        return;
    }
    const hasil = daftarSiswa.filter(s =>
        s.nama.toLowerCase().includes(k) || s.nis.includes(k)
    );
    renderDaftar(hasil);
}

document.addEventListener('click', (e) => {
    if (!cariInput.contains(e.target) && !daftarEl.contains(e.target)) {
        daftarEl.style.display = 'none';
    }
});

cariInput.addEventListener('input', filterS);
cariInput.addEventListener('focus', () => {
    if (cariInput.value.trim() !== '') filterS();
});

function setPoin() {
    const s = document.getElementById('kat');
    document.getElementById('poin').value =
        s.selectedIndex ? s.options[s.selectedIndex].dataset.poin : '';
}
</script>

<?php
if (file_exists("footer.php")) {
    include "footer.php";
}
?>
</body>
</html>