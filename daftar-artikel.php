<?php
include 'atas.php';

  // Ambil semua artikel
  $sql = "SELECT * FROM tb_artikel ORDER BY id DESC";
  $result = $conn->query($sql);
?>

<div class="main-panel">
  <div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
          <i class="mdi mdi-home"></i>
        </span> Daftar Artikel
      </h3>
      <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page">
            <span></span>Overview 
            <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
          </li>
        </ul>
      </nav>
    </div>

    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <table class="table table-striped">
            <thead>
              <tr>
                <th> Tanggal </th>
                <th> Gambar </th>
                <th> Judul </th>
                <th> Kategori </th>
                <th> Deskripsi </th>
                <th> Aksi </th>
              </tr>
            </thead>
            <tbody>
              <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                  <tr>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                    <td class="py-1">
                      <?php if (!empty($row['gambar'])): ?>
                        <img src="<?=$url_admin?>uploads/<?= htmlspecialchars($row['gambar']) ?>" alt="image" width="80" />
                      <?php else: ?>
                        <img src="<?=$url_admin?>assets/images/no-image.png" alt="image" width="80" />
                      <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['judul']) ?></td>
                    <td><?= htmlspecialchars($row['kategori']) ?></td>
                    <td><?= htmlspecialchars($row['deskripsi']) ?></td>
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

<?php include 'bawah.php'; ?>