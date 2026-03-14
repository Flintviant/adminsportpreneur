<?php
include 'session_admin.php';
include 'koneksi.php';

$olahraga = $conn->query("SELECT * FROM cabang_olahraga");

if(isset($_POST['simpan'])){

$nama_event = $_POST['nama_event'];
$tipe_event = $_POST['tipe_event'];
$nama_eo = $_POST['nama_eo'];
$id_olahraga = $_POST['id_olahraga'];
$lokasi = $_POST['lokasi_kegiatan'];
$tgl_daftar = $_POST['tgl_daftar'];
$tgl_tutup = $_POST['tgl_tutup'];

$conn->query("
INSERT INTO list_event 
(nama_event, tipe_event, nama_eo, id_olahraga, lokasi_kegiatan, tgl_daftar, tgl_tutup)
VALUES
('$nama_event','$tipe_event','$nama_eo','$id_olahraga','$lokasi','$tgl_daftar','$tgl_tutup')
");

echo "<script>
alert('Event berhasil ditambahkan');
location='daftar-event.php';
</script>";

}

include 'atas.php';
?>

<div class="main-panel">
	<div class="content-wrapper">

		<div class="page-header">
			<h3 class="page-title">Tambah Event</h3>
		</div>

		<div class="card">
			<div class="card-body">

				<form method="POST">
					<div class="mb-3">
						<label>Nama Event</label>
						<input type="text" name="nama_event" class="form-control" required>
					</div>

					<div class="mb-3">
						<label>Tipe Event</label>
						<input type="text" name="tipe_event" class="form-control">
					</div>

					<div class="mb-3">
						<label>Event Organizer</label>
						<input type="text" name="nama_eo" class="form-control">
					</div>

					<div class="mb-3">
						<label>Cabang Olahraga</label>
						<select name="id_olahraga" class="form-control">

						<?php while($o = $olahraga->fetch_assoc()): ?>

						<option value="<?= $o['id_olahraga'] ?>">
						<?= $o['nama_olahraga'] ?>
						</option>

						<?php endwhile; ?>

						</select>
					</div>

					<div class="mb-3">
						<label>Lokasi Kegiatan</label>
						<input type="text" name="lokasi_kegiatan" class="form-control">
					</div>

					<div class="mb-3">
						<label>Tanggal Daftar</label>
						<input type="date" name="tgl_daftar" class="form-control">
					</div>

					<div class="mb-3">
						<label>Tanggal Tutup</label>
						<input type="date" name="tgl_tutup" class="form-control">
					</div>

					<button type="submit" name="simpan" class="btn btn-primary">
					Simpan Event
					</button>

					<a href="daftar-event.php" class="btn btn-light">
					Kembali
					</a>
				</form>
			</div>
		</div>

<?php include 'bawah.php'; ?>