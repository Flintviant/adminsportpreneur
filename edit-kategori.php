<?php
include 'session_admin.php';
include 'koneksi.php';
include 'atas.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// ambil data kategori
$stmt = $conn->prepare("SELECT * FROM kategori WHERE id_kategori = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// jika data tidak ditemukan
if (!$data) {
    header("Location: kategori.php");
    exit;
}

// proses update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nama_kategori = trim($_POST['nama_kategori']);

    if (!empty($nama_kategori)) {

        $stmtUpdate = $conn->prepare("
            UPDATE kategori 
            SET nama_kategori = ?
            WHERE id_kategori = ?
        ");

        $stmtUpdate->bind_param("si", $nama_kategori, $id);
        $stmtUpdate->execute();

        header("Location: kategori.php?update=1");
        exit;
    }
}
?>

<div class="main-panel">
  <div class="content-wrapper">

    <div class="page-header">
      <h3 class="page-title">
        <span class="page-title-icon bg-gradient-warning text-white me-2">
          <i class="mdi mdi-pencil"></i>
        </span>
        Edit Kategori Belanja
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
                value="<?= htmlspecialchars($data['nama_kategori']); ?>"
                required>
          </div>

          <button type="submit" class="btn btn-warning">
            Update Kategori
          </button>

          <a href="kategori.php" class="btn btn-light">
            Batal
          </a>

        </form>

      </div>
    </div>

  </div>
</div>

<?php include 'bawah.php'; ?>