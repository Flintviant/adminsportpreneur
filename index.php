<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

include 'atas.php';

  // Query jumlah artikel
  $sql = "SELECT * FROM tb_artikel ORDER BY id DESC";
  $result = $conn->query($sql);
  $jumlah_artikel = $result ? $result->num_rows : 0;

  // Query jumlah artikel
  $sql_barang = "SELECT * FROM barang ORDER BY id DESC";
  $result_barang = $conn->query($sql_barang);
  $jumlah_barang = $result_barang ? $result_barang->num_rows : 0;

  // Query jumlah artikel
  $sql_sponsor = "SELECT * FROM kontak_sponsor ORDER BY id_sponsor DESC";
  $result_sponsor = $conn->query($sql_sponsor);
  $jumlah_sponsor = $result_sponsor ? $result_sponsor->num_rows : 0;

?>

<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
          <i class="mdi mdi-home"></i>
        </span> Dashboard
      </h3>
      <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">
            <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
          </li>
        </ul>
      </nav>
    </div>

    <div class="row">
      <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
          <div class="card-body">
            <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
            <h4 class="font-weight-normal mb-3">Total Artikel 
              <i class="mdi mdi-book-open mdi-24px float-right"></i>
            </h4>
            <h2 class="mb-5"><?= htmlspecialchars($jumlah_artikel) ?></h2>
          </div>
        </div>
      </div>
      <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
          <div class="card-body">
            <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
            <h4 class="font-weight-normal mb-3">Total Produk 
              <i class="mdi mdi-chart-line mdi-24px float-right"></i>
            </h4>
            <h2 class="mb-5"><?= htmlspecialchars($jumlah_barang) ?></h2>
          </div>
        </div>
      </div>
      <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
          <div class="card-body">
            <img src="assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
            <h4 class="font-weight-normal mb-3">Total Sponsor
              <i class="mdi mdi-walk mdi-24px float-right"></i>
            </h4>
            <h2 class="mb-5"><?= htmlspecialchars($jumlah_sponsor) ?></h2>
          </div>
        </div>
      </div>
    </div>

    <!-- Daftar Artikel -->
    <div class="row">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Daftar Artikel</h4>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th> Gambar </th>
                    <th> Judul Artikel </th>
                    <th> Jumlah Pembaca </th>
                    <th> Tanggal Pembuatan </th>
                    <th> Action </th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                      <tr>
                        <td class="py-1">
                          <?php if (!empty($row['gambar'])): ?>
                            <img src="<?= $url_admin ?>uploads/<?= htmlspecialchars($row['gambar']) ?>" alt="image" width="80" />
                          <?php else: ?>
                            <img src="<?= $url_admin ?>assets/images/no-image.png" alt="image" width="80" />
                          <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['judul']) ?></td>
                        <td>50</td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                        <td>
                          <a href="edit-artikel.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                          <a href="hapus-artikel.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus artikel ini?')">Hapus</a>
                        </td>
                      </tr>
                    <?php endwhile; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="5" class="text-center">Belum ada artikel.</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- content-wrapper ends -->

<?php include 'bawah.php'; ?>