<?php
include 'session_admin.php';
include 'koneksi.php';

$sponsor = $conn->query("SELECT * FROM sponsor ORDER BY created_at DESC");

include 'atas.php';
?>

<div class="main-panel">
<div class="content-wrapper">

<div class="page-header">
<h3 class="page-title">
<span class="page-title-icon bg-gradient-primary text-white me-2">
<i class="mdi mdi-handshake"></i>
</span>
Daftar Sponsor
</h3>

<a href="tambah-sponsor.php" class="btn btn-primary">
Tambah Sponsor
</a>
</div>

<div class="card">
<div class="card-body">

<div class="table-responsive">

<table class="table table-bordered table-striped">

<thead>
<tr>
<th>No</th>
<th>Nama Kegiatan</th>
<th>Kategori</th>
<th>Jenis</th>
<th>Kota</th>
<th>Dana</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

<?php $no=1; while($row = $sponsor->fetch_assoc()): ?>

<tr>

<td><?= $no++ ?></td>

<td><?= htmlspecialchars($row['nama_kegiatan']) ?></td>

<td><?= htmlspecialchars($row['kategori']) ?></td>

<td><?= ucfirst($row['jenis_kegiatan']) ?></td>

<td><?= htmlspecialchars($row['kota_kegiatan']) ?></td>

<td>
Rp <?= number_format($row['dana'],0,',','.') ?>
</td>

<td>

<?php if($row['status']=='Open'): ?>
<span class="badge bg-success">OPEN</span>
<?php else: ?>
<span class="badge bg-danger">CLOSED</span>
<?php endif; ?>

</td>

<td>

<a href="edit-sponsor.php?id=<?= $row['id_sponsor'] ?>" 
class="btn btn-sm btn-warning">
Edit
</a>

<a href="hapus-sponsor.php?id=<?= $row['id_sponsor'] ?>"
class="btn btn-sm btn-danger"
onclick="return confirm('Hapus data sponsor ini?')">
Hapus
</a>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</div>
</div>

<?php include 'bawah.php'; ?>