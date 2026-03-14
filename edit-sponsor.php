<?php
include 'session_admin.php';
include 'koneksi.php';

$id = $_GET['id'] ?? 0;

$data = $conn->query("SELECT * FROM sponsor WHERE id_sponsor='$id'")->fetch_assoc();

if(!$data){
    echo "Data tidak ditemukan";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nama_kegiatan   = $_POST['nama_kegiatan'];
    $kategori        = $_POST['kategori'];
    $jenis_kegiatan  = $_POST['jenis_kegiatan'];
    $kebutuhan       = $_POST['kebutuhan'];
    $kota_kegiatan   = $_POST['kota_kegiatan'];
    $target          = $_POST['target'];
    $dana            = $_POST['dana'];
    $timeline        = $_POST['timeline'];
    $status          = $_POST['status'];

    $stmt = $conn->prepare("
        UPDATE sponsor SET
        nama_kegiatan=?,
        kategori=?,
        jenis_kegiatan=?,
        kebutuhan=?,
        kota_kegiatan=?,
        target=?,
        dana=?,
        timeline=?,
        status=?
        WHERE id_sponsor=?
    ");

    $stmt->bind_param(
        "ssssssdssi",
        $nama_kegiatan,
        $kategori,
        $jenis_kegiatan,
        $kebutuhan,
        $kota_kegiatan,
        $target,
        $dana,
        $timeline,
        $status,
        $id
    );

    $stmt->execute();

    header("Location: daftar-sponsor.php?update=1");
    exit;
}

include 'atas.php';
?>

<div class="main-panel">
<div class="content-wrapper">

<div class="page-header">
<h3 class="page-title">
Edit Sponsor
</h3>
</div>

<div class="card">
<div class="card-body">

<form method="POST">

<div class="row">

<div class="col-md-6 mb-3">
<label>Nama Kegiatan</label>
<input type="text" name="nama_kegiatan" class="form-control"
value="<?= htmlspecialchars($data['nama_kegiatan']) ?>" required>
</div>

<div class="col-md-6 mb-3">
<label>Kategori</label>
<input type="text" name="kategori" class="form-control"
value="<?= htmlspecialchars($data['kategori']) ?>">
</div>

<div class="col-md-6 mb-3">
<label>Jenis Kegiatan</label>
<select name="jenis_kegiatan" class="form-control">

<option value="pelatihan" <?= $data['jenis_kegiatan']=='pelatihan'?'selected':'' ?>>Pelatihan</option>

<option value="pengadaan" <?= $data['jenis_kegiatan']=='pengadaan'?'selected':'' ?>>Pengadaan</option>

<option value="beasiswa" <?= $data['jenis_kegiatan']=='beasiswa'?'selected':'' ?>>Beasiswa</option>

</select>
</div>

<div class="col-md-6 mb-3">
<label>Kebutuhan</label>
<select name="kebutuhan" class="form-control">

<option value="CSR/Hibah" <?= $data['kebutuhan']=='CSR/Hibah'?'selected':'' ?>>CSR / Hibah</option>

<option value="Sponsor" <?= $data['kebutuhan']=='Sponsor'?'selected':'' ?>>Sponsor</option>

<option value="In-kind" <?= $data['kebutuhan']=='In-kind'?'selected':'' ?>>In-kind</option>

</select>
</div>

<div class="col-md-6 mb-3">
<label>Kota Kegiatan</label>
<input type="text" name="kota_kegiatan" class="form-control"
value="<?= htmlspecialchars($data['kota_kegiatan']) ?>">
</div>

<div class="col-md-6 mb-3">
<label>Dana</label>
<input type="number" step="0.01" name="dana" class="form-control"
value="<?= $data['dana'] ?>">
</div>

<div class="col-md-6 mb-3">
<label>Timeline</label>
<input type="text" name="timeline" class="form-control"
value="<?= htmlspecialchars($data['timeline']) ?>">
</div>

<div class="col-md-6 mb-3">
<label>Status</label>
<select name="status" class="form-control">

<option value="open" <?= $data['status']=='Open'?'selected':'' ?>>Open</option>

<option value="closed" <?= $data['status']=='Closed'?'selected':'' ?>>Closed</option>

</select>
</div>

<div class="col-md-12 mb-3">
<label>Target</label>
<textarea name="target" class="form-control" rows="4"><?= htmlspecialchars($data['target']) ?></textarea>
</div>

</div>

<button class="btn btn-primary">
Update Sponsor
</button>

<a href="daftar-sponsor.php" class="btn btn-light">
Kembali
</a>

</form>

</div>
</div>

<?php include 'bawah.php'; ?>