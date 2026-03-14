<?php
include 'atas.php';

// Ambil semua modul untuk dropdown
$modul = $conn->query("SELECT id_modul, nama_modul FROM modul ORDER BY nama_modul ASC");

// Proses simpan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_modul        = (int) ($_POST['id_modul'] ?? 0);
    $nama_sub_modul  = $_POST['nama_sub_modul'] ?? '';
    $deskripsi       = $_POST['deskripsi'] ?? '';
    $materi          = $_POST['materi'] ?? '';
    $urutan          = (int) ($_POST['urutan'] ?? 0);
    $status          = $_POST['status'] ?? 'aktif';

    $stmt = $conn->prepare("
        INSERT INTO sub_modul 
        (id_modul, nama_sub_modul, deskripsi, materi, urutan, status) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("isssis", 
        $id_modul, 
        $nama_sub_modul, 
        $deskripsi, 
        $materi, 
        $urutan, 
        $status
    );

    if ($stmt->execute()) {
        echo "<script>
                alert('Sub Modul berhasil ditambahkan');
                window.location='sub-modul.php?id_modul=$id_modul';
              </script>";
        exit;
    } else {
        echo "<div class='alert alert-danger'>Gagal menyimpan data</div>";
    }
}
?>

<div class="main-panel">
  <div class="content-wrapper">

    <div class="page-header">
      <h3 class="page-title">Tambah Sub Modul</h3>
    </div>

    <div class="col-lg-8 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">

          <form method="POST">

            <div class="form-group mb-3">
              <label>Pilih Modul</label>
              <select name="id_modul" class="form-control" required>
                <option value="">-- Pilih Modul --</option>
                <?php while ($m = $modul->fetch_assoc()): ?>
                  <option value="<?= $m['id_modul'] ?>">
                    <?= htmlspecialchars($m['nama_modul']) ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>

            <div class="form-group mb-3">
              <label>Nama Sub Modul</label>
              <input type="text" name="nama_sub_modul" class="form-control" required>
            </div>

            <div class="form-group mb-3">
              <label>Deskripsi</label>
              <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
            </div>

            <div class="form-group mb-3">
              <label>Materi (Isi lengkap / HTML diperbolehkan)</label>
              <textarea name="materi" class="form-control" rows="6"></textarea>
            </div>

            <div class="form-group mb-3">
              <label>Urutan</label>
              <input type="number" name="urutan" class="form-control" required>
            </div>

            <div class="form-group mb-4">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="daftar-modul.php" class="btn btn-light">Batal</a>

          </form>

        </div>
      </div>
    </div>

<?php include 'bawah.php'; ?>