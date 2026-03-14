<?php
include 'session_admin.php';
include 'koneksi.php';
include 'atas.php';

// ambil data barang + kategori
$query = "
    SELECT b.*, k.nama_kategori 
    FROM barang b
    LEFT JOIN kategori k ON b.id_kategori = k.id_kategori
";

$result = $conn->query($query);
?>

<div class="main-panel">
  <div class="content-wrapper">

    <div class="page-header">
      <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
          <i class="mdi mdi-package-variant"></i>
        </span>
        Daftar Produk
      </h3>

      <a href="tambah-produk.php" class="btn btn-primary btn-sm">
        <i class="mdi mdi-plus"></i> Tambah Produk
      </a>
    </div>

    <div class="card">
      <div class="card-body">

        <?php if (isset($_GET['success'])): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            Produk berhasil ditambahkan.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <?php if (isset($_GET['update'])): ?>
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            Produk berhasil diupdate.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <?php if (isset($_GET['hapus'])): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Produk berhasil dihapus.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th width="5%">No</th>
                <th>Foto</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Merk</th>
                <th>Kota</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                <th width="15%">Aksi</th>
              </tr>
            </thead>
            <tbody>

            <?php if ($result->num_rows > 0): ?>
              <?php $no = 1; ?>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                  <td><?= $no++; ?></td>

                  <td>
                    <?php if (!empty($row['foto_produk'])): ?>
                      <img src="uploads/<?= htmlspecialchars($row['foto_produk']); ?>" 
                           width="60" 
                           class="img-thumbnail">
                    <?php else: ?>
                      <span class="text-muted">No Image</span>
                    <?php endif; ?>
                  </td>

                  <td><?= htmlspecialchars($row['nama_barang']); ?></td>
                  <td><?= htmlspecialchars($row['nama_kategori'] ?? '-'); ?></td>
                  <td><?= htmlspecialchars($row['merk']); ?></td>
                  <td><?= htmlspecialchars($row['kota']); ?></td>
                  <td>
                    Rp <?= number_format($row['harga_jual'], 0, ',', '.'); ?>
                  </td>
                  <td>
                    <?php if ($row['stok'] > 0): ?>
                      <span class="badge bg-success"><?= $row['stok']; ?></span>
                    <?php else: ?>
                      <span class="badge bg-danger">Habis</span>
                    <?php endif; ?>
                  </td>

                  <td>
                    <a href="edit-produk.php?id=<?= $row['id']; ?>" 
                       class="btn btn-warning btn-sm">
                       Edit
                    </a>

                    <a href="hapus-produk.php?id=<?= $row['id_barang']; ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin ingin menghapus produk ini?')">
                       Hapus
                    </a>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="9" class="text-center">
                  Belum ada produk.
                </td>
              </tr>
            <?php endif; ?>

            </tbody>
          </table>
        </div>

      </div>
    </div>

<?php include 'bawah.php'; ?>