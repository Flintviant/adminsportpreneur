<?php
include 'atas.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

// Ambil data sub modul
$stmt = $conn->prepare("SELECT * FROM sub_modul WHERE id_sub_modul = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    echo "<script>alert('Data tidak ditemukan'); window.location='daftar-modul.php';</script>";
    exit;
}

// Ambil daftar modul untuk dropdown
$modul = $conn->query("SELECT id_modul, nama_modul FROM modul ORDER BY nama_modul ASC");

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_modul       = (int) ($_POST['id_modul'] ?? 0);
    $nama_sub_modul = $_POST['nama_sub_modul'] ?? '';
    $deskripsi      = $_POST['deskripsi'] ?? '';
    $materi         = $_POST['materi'] ?? '';
    $urutan         = (int) ($_POST['urutan'] ?? 0);
    $status         = $_POST['status'] ?? 'aktif';

    // 🔥 Auto convert link YouTube biasa ke embed
    if (strpos($materi, 'watch?v=') !== false) {
        $video_id = explode('watch?v=', $materi)[1];
        $video_id = strtok($video_id, '&'); // hapus parameter tambahan
        $materi = "https://www.youtube.com/embed/" . $video_id;
    }

    $update = $conn->prepare("
        UPDATE sub_modul 
        SET id_modul=?, nama_sub_modul=?, deskripsi=?, materi=?, urutan=?, status=? 
        WHERE id_sub_modul=?
    ");

    $update->bind_param(
        "isssisi",
        $id_modul,
        $nama_sub_modul,
        $deskripsi,
        $materi,
        $urutan,
        $status,
        $id
    );

    if ($update->execute()) {
        echo "<script>
                alert('Sub Modul berhasil diperbarui');
                window.location='sub-modul.php?id_modul=$id_modul';
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
      <h3 class="page-title">Edit Sub Modul</h3>
    </div>

    <div class="col-lg-8 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">

          <form method="POST">

            <div class="form-group mb-3">
              <label>Pilih Modul</label>
              <select name="id_modul" class="form-control" required>
                <?php while ($m = $modul->fetch_assoc()): ?>
                  <option value="<?= $m['id_modul'] ?>"
                    <?= $data['id_modul'] == $m['id_modul'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($m['nama_modul']) ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>

            <div class="form-group mb-3">
              <label>Nama Sub Modul</label>
              <input type="text"
                     name="nama_sub_modul"
                     class="form-control"
                     value="<?= htmlspecialchars($data['nama_sub_modul']) ?>"
                     required>
            </div>

            <div class="form-group mb-3">
              <label>Deskripsi</label>
              <textarea name="deskripsi"
                        class="form-control"
                        rows="4"
                        required><?= htmlspecialchars($data['deskripsi']) ?></textarea>
            </div>

            <div class="form-group mb-3">
              <label>Link Video YouTube</label>
              <input type="text"
                     name="materi"
                     class="form-control"
                     value="<?= htmlspecialchars($data['materi']) ?>">
              <small class="text-muted">
                Bisa paste link biasa (watch?v=...) atau embed link.
              </small>
            </div>

            <?php if (!empty($data['materi'])): ?>
              <div class="mb-3">
                <label>Preview Video</label>
                <div class="ratio ratio-16x9">
                  <iframe src="<?= htmlspecialchars($data['materi']) ?>" allowfullscreen></iframe>
                </div>
              </div>
            <?php endif; ?>

            <div class="form-group mb-3">
              <label>Urutan</label>
              <input type="number"
                     name="urutan"
                     class="form-control"
                     value="<?= $data['urutan'] ?>"
                     required>
            </div>

            <div class="form-group mb-4">
              <label>Status</label>
              <select name="status" class="form-control">
                <option value="aktif" <?= $data['status']=='aktif'?'selected':'' ?>>Aktif</option>
                <option value="nonaktif" <?= $data['status']=='nonaktif'?'selected':'' ?>>Nonaktif</option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="sub-modul.php?id_modul=<?= $data['id_modul'] ?>" class="btn btn-light">Batal</a>

          </form>

        </div>
      </div>
    </div>

<?php include 'bawah.php'; ?>