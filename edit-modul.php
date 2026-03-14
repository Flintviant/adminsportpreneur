<?php
include 'atas.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Ambil data modul
$stmt = $conn->prepare("SELECT * FROM modul WHERE id_modul = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$modul = $result->fetch_assoc();

if (!$modul) {
    echo "<script>alert('Data tidak ditemukan'); window.location='daftar-modul.php';</script>";
    exit;
}

// Proses Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama_modul = $_POST['nama_modul'] ?? '';
    $deskripsi  = $_POST['deskripsi'] ?? '';
    $status     = $_POST['status'] ?? 'aktif';

    $gambar = $modul['gambar']; // default gambar lama

    // Jika upload gambar baru
    if (!empty($_FILES['gambar']['name'])) {

        $target_dir  = "uploads/";
        $file_name   = time() . '_' . basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {

            // Hapus gambar lama jika ada
            if (!empty($modul['gambar']) && file_exists($target_dir . $modul['gambar'])) {
                unlink($target_dir . $modul['gambar']);
            }

            $gambar = $file_name;
        }
    }

    $update = $conn->prepare("
        UPDATE modul 
        SET nama_modul=?, deskripsi=?, gambar=?, status=? 
        WHERE id_modul=?
    ");

    $update->bind_param("ssssi", $nama_modul, $deskripsi, $gambar, $status, $id);

    if ($update->execute()) {
        echo "<script>
                alert('Modul berhasil diperbarui');
                window.location='daftar-modul.php';
              </script>";
        exit;
    } else {
        echo "<div class='alert alert-danger'>Gagal update data</div>";
    }
}
?>

<div class="main-panel">
  <div class="content-wrapper">

    <div class="page-header">
      <h3 class="page-title">Edit Modul</h3>
    </div>

    <div class="col-lg-8 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">

          <form method="POST" enctype="multipart/form-data">

            <div class="form-group mb-3">
              <label>Nama Modul</label>
              <input type="text" 
                     name="nama_modul" 
                     class="form-control" 
                     value="<?= htmlspecialchars($modul['nama_modul']) ?>" 
                     required>
            </div>

            <div class="form-group mb-3">
              <label>Deskripsi</label>
              <textarea name="deskripsi" 
                        class="form-control" 
                        rows="5" 
                        required><?= htmlspecialchars($modul['deskripsi']) ?></textarea>
            </div>

            <div class="form-group mb-3">
              <label>Gambar Saat Ini</label><br>
              <?php if (!empty($modul['gambar'])): ?>
                <img src="uploads/modul/<?= htmlspecialchars($modul['gambar']) ?>" width="120" class="mb-2">
              <?php else: ?>
                <p>Tidak ada gambar</p>
              <?php endif; ?>
            </div>

            <div class="form-group mb-3">
              <label>Ganti Gambar (Opsional)</label>
              <input type="file" name="gambar" class="form-control">
            </div>

            <div class="form-group mb-4">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="aktif" <?= $modul['status']=='aktif'?'selected':'' ?>>Aktif</option>
                <option value="nonaktif" <?= $modul['status']=='nonaktif'?'selected':'' ?>>Nonaktif</option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="daftar-modul.php" class="btn btn-light">Batal</a>

          </form>

        </div>
      </div>
    </div>

<?php include 'bawah.php'; ?>