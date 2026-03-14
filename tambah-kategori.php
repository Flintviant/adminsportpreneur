<?php
include 'session_admin.php';
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nama_kategori = trim($_POST['nama_kategori']);
    $tgl_input = date('Y-m-d H:i:s');

    if (!empty($nama_kategori)) {

        $stmt = $conn->prepare("
            INSERT INTO kategori 
            (nama_kategori, tgl_input)
            VALUES (?, ?)
        ");

        $stmt->bind_param(
            "ss",
            $nama_kategori,
            $tgl_input
        );

        $stmt->execute();

        header("Location: kategori.php?success=1");
        exit;
    }
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
        Tambah Kategori Belanja
      </h3>
    </div>

    <div class="card">
      <div class="card-body">

        <form method="POST">

          <div class="form-group mb-4">
            <label>Nama Kategori</label>
            <input 
                type="text" 
                name="nama_kategori" 
                class="form-control" 
                placeholder="Masukkan nama kategori"
                required>
          </div>

          <button type="submit" class="btn btn-primary">
            Simpan Kategori
          </button>

          <a href="kategori.php" class="btn btn-light">
            Batal
          </a>

        </form>

      </div>
    </div>

<?php include 'bawah.php'; ?>