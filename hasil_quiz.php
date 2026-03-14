<?php
include 'session_admin.php';
include 'koneksi.php';
include 'atas.php';

$id_sub_modul = isset($_GET['id_sub_modul']) ? (int)$_GET['id_sub_modul'] : 0;

// ambil nama sub modul
$stmtNama = $conn->prepare("SELECT nama_sub_modul FROM sub_modul WHERE id_sub_modul = ?");
$stmtNama->bind_param("i", $id_sub_modul);
$stmtNama->execute();
$namaResult = $stmtNama->get_result();
$subModul = $namaResult->fetch_assoc();

// ambil daftar quiz
$stmt = $conn->prepare("
    SELECT h.*, m.nm_member
    FROM hasil_sub_modul h
    JOIN member m ON h.id_member = m.id_member
    WHERE h.id_sub_modul = ?
    ORDER BY h.tanggal DESC
");
$stmt->bind_param("i", $id_sub_modul);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="main-panel">
  <div class="content-wrapper">

    <div class="page-header">
      <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
          <i class="mdi mdi-clipboard-text"></i>
        </span>
        Daftar Hasil Quiz - <?= htmlspecialchars($subModul['nama_sub_modul'] ?? '-') ?>
      </h3>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">

          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Member</th>
                  <th>Skor</th>
                  <th>Status</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody>

                <?php if ($result && $result->num_rows > 0): ?>
                  <?php 
                  $no = 1;
                  while ($row = $result->fetch_assoc()): 
                  ?>
                    <tr>
                      <td><?= $no++ ?></td>

                      <td><?= htmlspecialchars($row['nm_member']) ?></td>

                      <td><?= $row['skor'] ?></td>

                      <td>
                        <?php if ($row['status'] == 'LULUS'): ?>
                          <span class="badge bg-success">LULUS</span>
                        <?php else: ?>
                          <span class="badge bg-danger">TIDAK LULUS</span>
                        <?php endif; ?>
                      </td>

                      <td><?= date('d M Y H:i', strtotime($row['tanggal'])) ?></td>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5" class="text-center">
                      Belum ada peserta yang mengerjakan quiz.
                    </td>
                  </tr>
                <?php endif; ?>

              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>

<?php include 'bawah.php'; ?>