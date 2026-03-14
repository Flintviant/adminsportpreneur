<?php
include 'session_admin.php';
include 'koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$id_sub_modul = isset($_GET['id_sub_modul']) ? (int)$_GET['id_sub_modul'] : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $pertanyaan = $_POST['pertanyaan'];
    $opsi_a = $_POST['opsi_a'];
    $opsi_b = $_POST['opsi_b'];
    $opsi_c = $_POST['opsi_c'];
    $opsi_d = $_POST['opsi_d'];
    $jawaban_benar = $_POST['jawaban_benar'];

    $stmt = $conn->prepare("
        UPDATE soal_sub_modul 
        SET pertanyaan=?, opsi_a=?, opsi_b=?, opsi_c=?, opsi_d=?, jawaban_benar=?
        WHERE id_soal=?
    ");

    $stmt->bind_param(
        "ssssssi",
        $pertanyaan,
        $opsi_a,
        $opsi_b,
        $opsi_c,
        $opsi_d,
        $jawaban_benar,
        $id
    );

    $stmt->execute();

    header("Location: soal-sub-modul.php?id_sub_modul=" . $id_sub_modul);
    exit;
}

include 'atas.php';

$stmt = $conn->prepare("SELECT * FROM soal_sub_modul WHERE id_soal = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
?>

<div class="main-panel">
  <div class="content-wrapper">

    <div class="page-header">
      <h3 class="page-title">
        <span class="page-title-icon bg-gradient-warning text-white me-2">
          <i class="mdi mdi-pencil"></i>
        </span>
        Edit Soal
      </h3>
    </div>

    <div class="card">
      <div class="card-body">

        <form method="POST">

          <div class="form-group mb-3">
            <label>Pertanyaan</label>
            <textarea name="pertanyaan" class="form-control" rows="4" required><?= htmlspecialchars($data['pertanyaan']) ?></textarea>
          </div>

          <div class="form-group mb-3">
            <label>Opsi A</label>
            <input type="text" name="opsi_a" class="form-control" value="<?= htmlspecialchars($data['opsi_a']) ?>" required>
          </div>

          <div class="form-group mb-3">
            <label>Opsi B</label>
            <input type="text" name="opsi_b" class="form-control" value="<?= htmlspecialchars($data['opsi_b']) ?>" required>
          </div>

          <div class="form-group mb-3">
            <label>Opsi C</label>
            <input type="text" name="opsi_c" class="form-control" value="<?= htmlspecialchars($data['opsi_c']) ?>" required>
          </div>

          <div class="form-group mb-3">
            <label>Opsi D</label>
            <input type="text" name="opsi_d" class="form-control" value="<?= htmlspecialchars($data['opsi_d']) ?>" required>
          </div>

          <div class="form-group mb-4">
            <label>Jawaban Benar</label>
            <select name="jawaban_benar" class="form-control" required>
              <option value="a" <?= $data['jawaban_benar']=='a'?'selected':'' ?>>A</option>
              <option value="b" <?= $data['jawaban_benar']=='b'?'selected':'' ?>>B</option>
              <option value="c" <?= $data['jawaban_benar']=='c'?'selected':'' ?>>C</option>
              <option value="d" <?= $data['jawaban_benar']=='d'?'selected':'' ?>>D</option>
            </select>
          </div>

          <button type="submit" class="btn btn-warning">
            Update Soal
          </button>

          <a href="soal-sub-modul.php?id_sub_modul=<?= $id_sub_modul ?>" 
             class="btn btn-light">
             Batal
          </a>

        </form>

      </div>
    </div>

  </div>
</div>

<?php include 'bawah.php'; ?>