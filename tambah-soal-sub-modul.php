<?php
include 'session_admin.php';
include 'koneksi.php';
include 'atas.php';

$id_sub_modul = isset($_GET['id_sub_modul']) ? (int)$_GET['id_sub_modul'] : 0;

// ambil nama sub modul
$stmtNama = $conn->prepare("SELECT nama_sub_modul FROM sub_modul WHERE id_sub_modul = ?");
$stmtNama->bind_param("i", $id_sub_modul);
$stmtNama->execute();
$subModul = $stmtNama->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $pertanyaan = $_POST['pertanyaan'];
    $opsi_a = $_POST['opsi_a'];
    $opsi_b = $_POST['opsi_b'];
    $opsi_c = $_POST['opsi_c'];
    $opsi_d = $_POST['opsi_d'];
    $jawaban_benar = $_POST['jawaban_benar'];

    $stmt = $conn->prepare("
        INSERT INTO soal_sub_modul 
        (id_sub_modul, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "issssss",
        $id_sub_modul,
        $pertanyaan,
        $opsi_a,
        $opsi_b,
        $opsi_c,
        $opsi_d,
        $jawaban_benar
    );

    $stmt->execute();

    // header("Location: soal-sub-modul.php?id_sub_modul=" . $id_sub_modul);
    exit;
}
?>

<div class="main-panel">
  <div class="content-wrapper">

    <div class="page-header">
      <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
          <i class="mdi mdi-plus"></i>
        </span>
        Tambah Soal - <?= htmlspecialchars($subModul['nama_sub_modul'] ?? '-') ?>
      </h3>
    </div>

    <div class="card">
      <div class="card-body">

        <form method="POST">

          <div class="form-group mb-3">
            <label>Pertanyaan</label>
            <textarea name="pertanyaan" class="form-control" rows="4" required></textarea>
          </div>

          <div class="form-group mb-3">
            <label>Opsi A</label>
            <input type="text" name="opsi_a" class="form-control" required>
          </div>

          <div class="form-group mb-3">
            <label>Opsi B</label>
            <input type="text" name="opsi_b" class="form-control" required>
          </div>

          <div class="form-group mb-3">
            <label>Opsi C</label>
            <input type="text" name="opsi_c" class="form-control" required>
          </div>

          <div class="form-group mb-3">
            <label>Opsi D</label>
            <input type="text" name="opsi_d" class="form-control" required>
          </div>

          <div class="form-group mb-4">
            <label>Jawaban Benar</label>
            <select name="jawaban_benar" class="form-control" required>
              <option value="">-- Pilih Jawaban --</option>
              <option value="a">A</option>
              <option value="b">B</option>
              <option value="c">C</option>
              <option value="d">D</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary">
            Simpan Soal
          </button>

          <a href="soal-sub-modul.php?id_sub_modul=<?= $id_sub_modul ?>" 
             class="btn btn-light">
             Batal
          </a>

        </form>

      </div>
    </div>

<?php include 'bawah.php'; ?>