<?php
include 'session_admin.php';
include 'koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// ambil data produk
$stmt = $conn->prepare("SELECT * FROM barang WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    header("Location: daftar-produk.php");
    exit;
}

// ambil kategori
$kategori = $conn->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");

// proses update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_kategori     = (int)$_POST['id_kategori'];
    $nama_barang     = trim($_POST['nama_barang']);
    $merk            = trim($_POST['merk']);
    $kota            = trim($_POST['kota']);
    $harga_beli      = trim($_POST['harga_beli']);
    $harga_jual      = trim($_POST['harga_jual']);
    $satuan_barang   = trim($_POST['satuan_barang']);
    $stok            = trim($_POST['stok']);
    $tgl_update      = date('Y-m-d H:i:s');

    $foto_produk = $data['foto_produk'];

    // jika upload foto baru
    if (!empty($_FILES['foto_produk']['name'])) {

        $namaFile = time() . '_' . $_FILES['foto_produk']['name'];
        $tmpName  = $_FILES['foto_produk']['tmp_name'];
        $folder   = "uploads/";

        move_uploaded_file($tmpName, $folder . $namaFile);

        // hapus foto lama jika ada
        if (!empty($data['foto_produk']) && file_exists($folder . $data['foto_produk'])) {
            unlink($folder . $data['foto_produk']);
        }

        $foto_produk = $namaFile;
    }

    $stmtUpdate = $conn->prepare("
        UPDATE barang SET
        id_kategori = ?,
        nama_barang = ?,
        merk = ?,
        kota = ?,
        harga_beli = ?,
        harga_jual = ?,
        satuan_barang = ?,
        stok = ?,
        foto_produk = ?,
        tgl_update = ?
        WHERE id_barang = ?
    ");

    $stmtUpdate->bind_param(
        "isssssssssi",
        $id_kategori,
        $nama_barang,
        $merk,
        $kota,
        $harga_beli,
        $harga_jual,
        $satuan_barang,
        $stok,
        $foto_produk,
        $tgl_update,
        $id
    );

    $stmtUpdate->execute();

    header("Location: daftar-produk.php?update=1");
    exit;
}
include 'atas.php';
?>

<div class="main-panel">
  <div class="content-wrapper">

    <div class="page-header">
      <h3 class="page-title">
        <span class="page-title-icon bg-gradient-warning text-white me-2">
          <i class="mdi mdi-pencil"></i>
        </span>
        Edit Produk
      </h3>
    </div>

    <div class="card">
      <div class="card-body">

        <form method="POST" enctype="multipart/form-data">

          <div class="row">

            <div class="col-md-6 mb-3">
              <label>Kategori</label>
              <select name="id_kategori" class="form-control" required>
                <?php while($k = $kategori->fetch_assoc()): ?>
                  <option value="<?= $k['id_kategori']; ?>"
                    <?= $k['id_kategori'] == $data['id_kategori'] ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($k['nama_kategori']); ?>
                  </option>
                <?php endwhile; ?>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label>Nama Produk</label>
              <input type="text" name="nama_barang" class="form-control"
                     value="<?= htmlspecialchars($data['nama_barang']); ?>" required>
            </div>

            <div class="col-md-6 mb-3">
              <label>Merk</label>
              <input type="text" name="merk" class="form-control"
                     value="<?= htmlspecialchars($data['merk']); ?>" required>
            </div>

            <div class="col-md-6 mb-3">
              <label>Kota</label>
              <input type="text" name="kota" class="form-control"
                     value="<?= htmlspecialchars($data['kota']); ?>">
            </div>

            <div class="col-md-6 mb-3">
              <label>Harga Beli</label>
              <input type="number" name="harga_beli" class="form-control"
                     value="<?= $data['harga_beli']; ?>" required>
            </div>

            <div class="col-md-6 mb-3">
              <label>Harga Jual</label>
              <input type="number" name="harga_jual" class="form-control"
                     value="<?= $data['harga_jual']; ?>" required>
            </div>

            <div class="col-md-6 mb-3">
              <label>Satuan Barang</label>
              <input type="text" name="satuan_barang" class="form-control"
                     value="<?= htmlspecialchars($data['satuan_barang']); ?>">
            </div>

            <div class="col-md-6 mb-3">
              <label>Stok</label>
              <input type="number" name="stok" class="form-control"
                     value="<?= $data['stok']; ?>" required>
            </div>

            <div class="col-md-6 mb-3">
              <label>Foto Lama</label><br>
              <?php if (!empty($data['foto_produk'])): ?>
                <img src="uploads/<?= htmlspecialchars($data['foto_produk']); ?>"
                     width="100" class="img-thumbnail">
              <?php else: ?>
                <span class="text-muted">Tidak ada foto</span>
              <?php endif; ?>
            </div>

            <div class="col-md-6 mb-4">
              <label>Ganti Foto (Opsional)</label>
              <input type="file" name="foto_produk" class="form-control">
            </div>

          </div>

          <button type="submit" class="btn btn-warning">
            Update Produk
          </button>

          <a href="daftar-produk.php" class="btn btn-light">
            Batal
          </a>

        </form>

      </div>
    </div>

<?php include 'bawah.php'; ?>