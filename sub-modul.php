<?php
include 'atas.php';

$id_modul = $_GET['id_modul'] ?? 0;

// Ambil nama modul
$modul = $conn->query("SELECT * FROM modul WHERE id_modul = $id_modul")->fetch_assoc();

// Ambil sub modul
$sql = "
    SELECT * FROM sub_modul 
    WHERE id_modul = $id_modul
    ORDER BY urutan ASC
";

$result = $conn->query($sql);
?>

<div class="main-panel">
  <div class="content-wrapper">

    <div class="page-header">
      <h3 class="page-title">
        Sub Modul - <?= htmlspecialchars($modul['nama_modul'] ?? '') ?>
      </h3>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Urutan</th>
                <th>Nama Sub Modul</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                  <tr>
                    <td><?= $row['urutan'] ?></td>
                    <td><?= htmlspecialchars($row['nama_sub_modul']) ?></td>
                    <td><?= htmlspecialchars(substr($row['deskripsi'],0,120)) ?>...</td>
                    <td>
                      <?php if ($row['status'] == 'aktif'): ?>
                        <span class="badge bg-success">Aktif</span>
                      <?php else: ?>
                        <span class="badge bg-danger">Nonaktif</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <a href="soal-sub-modul.php?id_sub_modul=<?= $row['id_sub_modul'] ?>" 
                         class="btn btn-sm btn-primary">
                         Soal
                      </a>
                      
                      <a href="hasil_quiz.php?id_sub_modul=<?= $row['id_sub_modul'] ?>" 
                         class="btn btn-sm btn-info">
                         Hasil Quiz
                      </a>

                      <a href="edit-sub-modul.php?id=<?= $row['id_sub_modul'] ?>" 
                         class="btn btn-sm btn-warning">Edit</a>

                      <a href="hapus-sub-modul.php?id=<?= $row['id_sub_modul'] ?>" 
                         class="btn btn-sm btn-danger"
                         onclick="return confirm('Hapus sub modul ini?')">
                         Hapus
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" class="text-center">Belum ada sub modul.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

<?php include 'bawah.php'; ?>