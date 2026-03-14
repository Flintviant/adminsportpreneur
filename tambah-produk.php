<?php
include 'session_admin.php';
include 'koneksi.php';

// ambil data kategori untuk dropdown
$kategori = $conn->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
$jenis = $conn->query("SELECT * FROM jenis ORDER BY nama_jenis ASC");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_barang     = $_POST['id_barang'];
    $id_kategori     = (int)$_POST['id_kategori'];
    $id_jenis     = (int)$_POST['id_jenis'];
    $nama_barang     = trim($_POST['nama_barang']);
    $merk            = trim($_POST['merk']);
    $kota            = trim($_POST['kota']);
    $harga_beli      = trim($_POST['harga_beli']);
    $harga_jual      = trim($_POST['harga_jual']);
    $satuan_barang   = trim($_POST['satuan_barang']);
    $stok            = trim($_POST['stok']);
    $tgl_input       = date('Y-m-d H:i:s');
    $tgl_update      = date('Y-m-d H:i:s');

    // upload foto
    $foto_produk = '';
    if (!empty($_FILES['foto_produk']['name'])) {

        $namaFile = time() . '_' . $_FILES['foto_produk']['name'];
        $tmpName  = $_FILES['foto_produk']['tmp_name'];
        $folder   = "uploads/produk/";

        move_uploaded_file($tmpName, $folder . $namaFile);
        $foto_produk = $namaFile;
    }

    $stmt = $conn->prepare("
        INSERT INTO barang 
        (id_barang, id_kategori, id_jenis, nama_barang, merk, kota, harga_beli, harga_jual, 
         satuan_barang, stok, foto_produk, tgl_input, tgl_update)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "siissssssssss",
        $id_barang,
        $id_kategori,
        $id_jenis,
        $nama_barang,
        $merk,
        $kota,
        $harga_beli,
        $harga_jual,
        $satuan_barang,
        $stok,
        $foto_produk,
        $tgl_input,
        $tgl_update
    );

    $stmt->execute();

    header("Location: daftar-produk.php?success=1");
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
        Tambah Produk
      </h3>
    </div>

    <div class="card">
      <div class="card-body">

        <form method="POST" enctype="multipart/form-data">

          <div class="row">

            <div class="col-md-6 mb-3">
              <label>Kategori</label>
              <select name="id_kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                <?php while($k = $kategori->fetch_assoc()): ?>
                  <option value="<?= $k['id_kategori']; ?>">
                    <?= htmlspecialchars($k['nama_kategori']); ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label>Nama Produk</label>
              <input type="text" name="nama_barang" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
              <label>Merk</label>
              <input type="text" name="merk" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
              <label>Kode Barang</label>
              <input type="text" name="id_barang" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
              <label>Jenis Barang</label>
              <select name="id_kategori" class="form-control" required>
                <option value="">-- Pilih Jenis Barang --</option>
                <?php while($j = $jenis->fetch_assoc()): ?>
                  <option value="<?= $j['id_jenis']; ?>">
                    <?= htmlspecialchars($j['nama_jenis']); ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label>Kota</label>
              <input type="text" name="kota" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
              <label>Harga Beli</label>
              <input type="number" name="harga_beli" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
              <label>Harga Jual</label>
              <input type="number" name="harga_jual" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
              <label>Satuan Barang</label>
              <input type="text" name="satuan_barang" class="form-control" placeholder="Contoh: pcs, box">
            </div>

            <div class="col-md-6 mb-3">
              <label>Stok</label>
              <input type="number" name="stok" class="form-control" required>
            </div>

            <div class="col-md-6 mb-4">
              <label>Foto Produk</label>
              <input type="file" name="foto_produk" class="form-control">
            </div>

          </div>

          <button type="submit" class="btn btn-primary">
            Simpan Produk
          </button>

          <a href="produk.php" class="btn btn-light">
            Batal
          </a>

        </form>

      </div>
    </div>

<?php include 'bawah.php'; ?>