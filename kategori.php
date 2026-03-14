<?php
include 'session_admin.php';
include 'koneksi.php';
include 'atas.php';

// ambil semua kategori
$result = $conn->query("SELECT * FROM kategori ORDER BY id_kategori DESC");
?>

<div class="main-panel">
  <div class="content-wrapper">

    <div class="page-header">
      <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
          <i class="mdi mdi-format-list-bulleted"></i>
        </span>
        Data Kategori Belanja
      </h3>

      <a href="tambah-kategori.php" class="btn btn-primary btn-sm">
        <i class="mdi mdi-plus"></i> Tambah Kategori
      </a>
    </div>

    <div class="card">
      <div class="card-body">

        <?php if (isset($_GET['success'])) : ?>
          <div class="alert alert-success">
            Kategori berhasil ditambahkan.
          </div>
        <?php endif; ?>

        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead class="table-light">
              <tr>
                <th width="5%">No</th>
                <th>Nama Kategori</th>
                <th>Tanggal Input</th>
                <th width="15%">Aksi</th>
              </tr>
            </thead>
            <tbody>

              <?php if ($result->num_rows > 0) : ?>
                <?php $no = 1; ?>
                <?php while ($row = $result->fetch_assoc()) : ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
                    <td><?= htmlspecialchars($row['tgl_input']); ?></td>
                    <td>
                      <a href="edit-kategori.php?id=<?= $row['id_kategori']; ?>" 
                         class="btn btn-warning btn-sm">
                         Edit
                      </a>

                      <a href="hapus-kategori.php?id=<?= $row['id_kategori']; ?>" 
                         class="btn btn-danger btn-sm"
                         onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                         Hapus
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else : ?>
                <tr>
                  <td colspan="4" class="text-center">
                    Belum ada data kategori.
                  </td>
                </tr>
              <?php endif; ?>

            </tbody>
          </table>
        </div>

      </div>
    </div>

<?php include 'bawah.php'; ?>