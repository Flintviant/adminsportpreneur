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

// ambil daftar soal
$stmt = $conn->prepare("
    SELECT *
    FROM soal_sub_modul
    WHERE id_sub_modul = ?
    ORDER BY id_soal DESC
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
          <i class="mdi mdi-format-list-bulleted"></i>
        </span>
        Daftar Soal - <?= htmlspecialchars($subModul['nama_sub_modul'] ?? '-') ?>
      </h3>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">

          <a href="tambah-soal-sub-modul.php?id_sub_modul=<?= $id_sub_modul ?>" 
             class="btn btn-primary mb-3">
             + Tambah Soal
          </a>

          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th width="50">No</th>
                  <th>Pertanyaan</th>
                  <th>Jawaban Benar</th>
                  <th width="200">Aksi</th>
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

                      <td>
                        <?= htmlspecialchars(substr($row['pertanyaan'], 0, 120)) ?>...
                      </td>

                      <td>
                        <span class="badge bg-success">
                          <?= $row['jawaban_benar'] ?>
                        </span>
                      </td>

                      <td>
                        <a href="edit-soal-sub-modul.php?id=<?= $row['id_soal'] ?>&id_sub_modul=<?= $id_sub_modul ?>" 
                           class="btn btn-sm btn-warning">
                           Edit
                        </a>

                        <a href="hapus-soal-sub-modul.php?id=<?= $row['id_soal'] ?>&id_sub_modul=<?= $id_sub_modul ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Hapus soal ini?')">
                           Hapus
                        </a>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="4" class="text-center">
                      Belum ada soal untuk sub modul ini.
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