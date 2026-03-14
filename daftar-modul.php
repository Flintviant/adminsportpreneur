<?php
include 'atas.php';

// Ambil modul + jumlah sub modul
$sql = "
    SELECT m.*, COUNT(sm.id_sub_modul) as total_sub
    FROM modul m
    LEFT JOIN sub_modul sm ON sm.id_modul = m.id_modul
    GROUP BY m.id_modul
    ORDER BY m.id_modul DESC
";

$result = $conn->query($sql);
?>

<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
          <i class="mdi mdi-book-open"></i>
        </span> Daftar Modul
      </h3>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Gambar</th>
                  <th>Nama Modul</th>
                  <th>Deskripsi</th>
                  <th>Total Sub Modul</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                  <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                      <td>
                        <?php if (!empty($row['gambar'])): ?>
                          <img src="<?=$url_admin?>uploads/modul/<?= htmlspecialchars($row['gambar']) ?>" width="80">
                        <?php else: ?>
                          <img src="<?=$url_admin?>assets/images/no-image.png" width="80">
                        <?php endif; ?>
                      </td>

                      <td><?= htmlspecialchars($row['nama_modul']) ?></td>
                      <td><?= htmlspecialchars(substr($row['deskripsi'],0,100)) ?>...</td>
                      <td><?= $row['total_sub'] ?></td>
                      <td>
                        <?php if ($row['status'] == 'aktif'): ?>
                          <span class="badge bg-success">Aktif</span>
                        <?php else: ?>
                          <span class="badge bg-danger">Nonaktif</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <a href="sub-modul.php?id_modul=<?= $row['id_modul'] ?>" 
                           class="btn btn-sm btn-info">Lihat Sub</a>

                        <a href="edit-modul.php?id=<?= $row['id_modul'] ?>" 
                           class="btn btn-sm btn-warning">Edit</a>

                        <a href="hapus-modul.php?id=<?= $row['id_modul'] ?>" 
                           class="btn btn-sm btn-danger"
                           onclick="return confirm('Hapus modul ini?')">
                           Hapus
                        </a>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="6" class="text-center">Belum ada modul.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

<?php include 'bawah.php'; ?>