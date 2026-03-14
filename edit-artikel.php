<?php
include 'atas-artikel.php';

function buat_slug($text) {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9]+/i', '-', $text);
    return trim($text, '-');
}

// Pastikan ada parameter ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<div class='alert alert-danger'>ID artikel tidak valid!</div>");
}

$id = (int) $_GET['id'];

// Ambil data artikel lama
$stmt = $conn->prepare("SELECT * FROM tb_artikel WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$artikel = $result->fetch_assoc();

if (!$artikel) {
    die("<div class='alert alert-danger'>Artikel tidak ditemukan!</div>");
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul     = $_POST['judul'];
    $keywords  = $_POST['keywords'];
    $deskripsi = $_POST['deskripsi'];
    $kategori  = $_POST['kategori'];
    $isi       = $_POST['isi'];
    $slug      = buat_slug($judul);

    $gambar = $artikel['gambar']; // default gambar lama

    // Jika upload gambar baru
    if (!empty($_FILES['gambar']['name'])) {
        $targetDir = 'uploads/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $fileName = time() . '_' . basename($_FILES['gambar']['name']);
        $targetFile = $targetDir . $fileName;
        $allowedTypes = ['image/jpeg','image/png','image/gif','image/webp'];

        if (in_array($_FILES['gambar']['type'], $allowedTypes)) {
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
                // hapus gambar lama jika ada
                if (!empty($artikel['gambar']) && file_exists($targetDir . $artikel['gambar'])) {
                    unlink($targetDir . $artikel['gambar']);
                }
                $gambar = $fileName;
            }
        }
    }

    // Update ke database
    $stmt = $conn->prepare("UPDATE tb_artikel SET judul=?, slug=?, keywords=?, deskripsi=?, kategori=?, isi=?, gambar=? WHERE id=?");
    $stmt->bind_param("sssssssi", $judul, $slug, $keywords, $deskripsi, $kategori, $isi, $gambar, $id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>✅ Artikel berhasil diperbarui!</div>";
        // refresh halaman
        echo "<meta http-equiv='refresh' content='1;url=index.php'>";
    } else {
        echo "<div class='alert alert-danger'>❌ Gagal memperbarui artikel.</div>";
    }
}
?>

<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
          <i class="mdi mdi-pencil"></i>
        </span> Edit Artikel
      </h3>
    </div>

    <div class="col-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <form class="forms-sample" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="judul">Judul</label>
              <input type="text" class="form-control" id="judul" name="judul" value="<?= htmlspecialchars($artikel['judul']) ?>" required>
            </div>
            <div class="form-group">
              <label for="keywords">Keywords</label>
              <input type="text" class="form-control" id="keywords" name="keywords" value="<?= htmlspecialchars($artikel['keywords']) ?>">
            </div>
            <div class="form-group">
              <label for="deskripsi">Deskripsi</label>
              <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="<?= htmlspecialchars($artikel['deskripsi']) ?>">
            </div>
            <div class="form-group">
              <label for="kategori-artikel">Kategori</label>
              <select class="form-control" id="kategori-artikel" name="kategori">
                <option value="Umum" <?= $artikel['kategori']=='Umum'?'selected':'' ?>>Umum</option>
                <option value="Produk" <?= $artikel['kategori']=='Produk'?'selected':'' ?>>Produk</option>
              </select>
            </div>
            <div class="form-group">
              <label>Upload Gambar (opsional)</label>
              <?php if (!empty($artikel['gambar'])): ?>
                <div class="mb-2">
                  <img src="uploads/<?= htmlspecialchars($artikel['gambar']) ?>" alt="Gambar" width="200" class="rounded shadow-sm">
                </div>
              <?php endif; ?>
              <input type="file" name="gambar" class="form-control">
            </div>
            <div class="form-group">
              <label for="isi">Isi Artikel</label>
              <textarea class="form-control" id="isi" name="isi" rows="6"><?= htmlspecialchars($artikel['isi']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-gradient-primary me-2">Simpan Perubahan</button>
            <a href="daftar-artikel.php" class="btn btn-light">Kembali</a>
          </form>
        </div>
      </div>
    </div>

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
      ClassicEditor
        .create(document.querySelector('#isi'), {
          toolbar: [
            'heading', '|',
            'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
            'blockQuote', 'insertTable', 'undo', 'redo'
          ]
        })
        .catch(error => console.error(error));
    </script>

<?php include 'bawah-artikel.php'; ?>