<?php
include 'session_admin.php';
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nama_kegiatan   = trim($_POST['nama_kegiatan']);
    $kategori        = trim($_POST['kategori']);
    $jenis_kegiatan  = $_POST['jenis_kegiatan'];
    $kebutuhan       = $_POST['kebutuhan'];
    $kota_kegiatan   = trim($_POST['kota_kegiatan']);
    $target          = trim($_POST['target']);
    $dana            = $_POST['dana'];
    $timeline        = trim($_POST['timeline']);
    $status          = $_POST['status'];
    $created_at      = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("
        INSERT INTO sponsor
        (nama_kegiatan, kategori, jenis_kegiatan, kebutuhan, kota_kegiatan, target, dana, timeline, status, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "ssssssdsss",
        $nama_kegiatan,
        $kategori,
        $jenis_kegiatan,
        $kebutuhan,
        $kota_kegiatan,
        $target,
        $dana,
        $timeline,
        $status,
        $created_at
    );

    $stmt->execute();

    header("Location: daftar-sponsor.php?success=1");
    exit;
}

include 'atas.php';
?>

<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-plus"></i>
                </span>
                Tambah Pengajuan Sponsor
            </h3>
        </div>

        <div class="card">
            <div class="card-body">

                <form method="POST">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Nama Kegiatan</label>
                            <input type="text" name="nama_kegiatan" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Kategori</label>
                            <input type="text" name="kategori" class="form-control" placeholder="Contoh: Olahraga, Pendidikan">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Jenis Kegiatan</label>
                            <select name="jenis_kegiatan" class="form-control" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="pelatihan">Pelatihan</option>
                                <option value="pengadaan">Pengadaan</option>
                                <option value="beasiswa">Beasiswa</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Kebutuhan</label>
                            <select name="kebutuhan" class="form-control" required>
                                <option value="">-- Pilih Kebutuhan --</option>
                                <option value="CSR/Hibah">CSR / Hibah</option>
                                <option value="Sponsor">Sponsor</option>
                                <option value="In-kind">In-kind</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Kota Kegiatan</label>
                            <input type="text" name="kota_kegiatan" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Dana yang Dibutuhkan</label>
                            <input type="number" step="0.01" name="dana" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Timeline</label>
                            <input type="text" name="timeline" class="form-control" placeholder="Contoh: Juli - September 2026">
                        </div>

                        <div class="col-md-6 mb-3">
                        <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="open">Open</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label>Target</label>
                            <textarea name="target" class="form-control" rows="4"></textarea>
                        </div>

                    </div>

                    <button type="submit" class="btn btn-primary">
                    Simpan Pengajuan
                    </button>

                    <a href="daftar-sponsor.php" class="btn btn-light">
                    Batal
                    </a>

                </form>

            </div>
        </div>

<?php include 'bawah.php'; ?>