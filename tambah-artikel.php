<?php
include 'atas-artikel.php';

function buat_slug($text) {
    // huruf kecil semua
    $text = strtolower(trim($text));
    // ubah karakter non alfanumerik jadi strip
    $text = preg_replace('/[^a-z0-9]+/i', '-', $text);
    // hapus strip di awal/akhir
    $text = trim($text, '-');
    return $text;
}

// proses submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul     = $_POST['judul'];
    $keywords  = $_POST['keywords'];
    $deskripsi = $_POST['deskripsi'];
    $kategori  = $_POST['kategori'];
    $isi       = $_POST['isi'];

    // handle upload gambar
    $gambar = '';
    if (!empty($_FILES['gambar']['name'])) {
        $targetDir = 'uploads/';
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        $fileName = time() . '_' . basename($_FILES['gambar']['name']);
        $targetFile = $targetDir . $fileName;

        // Validasi mime type sederhana
        $allowedTypes = ['image/jpeg','image/png','image/gif','image/webp'];
        if (in_array($_FILES['gambar']['type'], $allowedTypes)) {
            move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile);
            $gambar = $fileName;
        }
    }

    $slug = buat_slug($judul);

    // insert ke database
    $stmt = $conn->prepare("INSERT INTO tb_artikel (judul, slug, keywords, deskripsi, kategori, isi, gambar) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssss", $judul, $slug, $keywords, $deskripsi, $kategori, $isi, $gambar);
    $stmt->execute();

    echo "<div class='alert alert-success'>Artikel berhasil ditambahkan!</div>";
}
?>

<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
          <i class="mdi mdi-home"></i>
        </span> Tambah Artikel
      </h3>
    </div>

    <div class="col-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <form class="forms-sample" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="judul">Judul</label>
              <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul" required>
            </div>
            <div class="form-group">
              <label for="keywords">Keywords</label>
              <input type="text" class="form-control" id="keywords" name="keywords" placeholder="Keywords">
            </div>
            <div class="form-group">
              <label for="deskripsi">Deskripsi</label>
              <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi">
            </div>
            <div class="form-group">
              <label for="kategori-artikel">Kategori</label>
              <select class="form-control" id="kategori-artikel" name="kategori">
                <option value="Umum">Umum</option>
                <option value="Produk">Produk</option>
              </select>
            </div>
            <div class="form-group">
              <label>Upload Gambar</label>
              <input type="file" name="gambar" class="form-control">
            </div>
            <div class="form-group">
              <label for="isi">Isi Artikel</label>
              <textarea class="form-control" id="isi" name="isi" rows="6"></textarea>
            </div>
            <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
            <button type="reset" class="btn btn-light">Cancel</button>
          </form>
        </div>
      </div>
    </div>

    <!-- CKEditor CDN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
      ClassicEditor
        .create( document.querySelector( '#isi' ), {
          toolbar: [
            'heading', '|',
            'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
            'blockQuote', 'insertTable', 'undo', 'redo'
          ]
        })
        .catch( error => {
            console.error( error );
        } );
    </script>

<?php include 'bawah-artikel.php'; ?>