<?php
include 'atas.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama_modul = $_POST['nama_modul'] ?? '';
    $deskripsi  = $_POST['deskripsi'] ?? '';
    $status     = $_POST['status'] ?? 'aktif';

    $gambar = '';

    // Upload gambar
    if (!empty($_FILES['gambar']['name'])) {
        $target_dir  = "uploads/modul/";
        $file_name   = time() . '_' . basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $gambar = $file_name;
        }
    }

    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO modul (nama_modul, deskripsi, gambar, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama_modul, $deskripsi, $gambar, $status);

    if ($stmt->execute()) {
        echo "<script>
                alert('Modul berhasil ditambahkan');
                window.location='daftar-modul.php';
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
      <h3 class="page-title">
        Tambah Modul
      </h3>
    </div>

    <div class="col-lg-8 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">

          <form method="POST" enctype="multipart/form-data">

            <div class="form-group mb-3">
              <label>Nama Modul</label>
              <input type="text" name="nama_modul" class="form-control" required>
            </div>

            <div class="form-group mb-3">
              <label>Deskripsi</label>
              <textarea name="deskripsi" class="form-control" rows="5" required></textarea>
            </div>

            <div class="form-group mb-3">
              <label>Gambar</label>
              <input type="file" name="gambar" class="form-control">
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