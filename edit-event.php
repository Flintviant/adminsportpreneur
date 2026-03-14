<?php
include 'session_admin.php';
include 'koneksi.php';

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("SELECT * FROM list_event WHERE id_event=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if(!$data){
    echo "Data tidak ditemukan";
    exit;
}

$olahraga = $conn->query("SELECT * FROM cabang_olahraga");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id_event         = $_POST['id_event'];
    $nama_event       = $_POST['nama_event'];
    $tipe_event       = $_POST['tipe_event'];
    $nama_eo          = $_POST['nama_eo'];
    $id_olahraga      = $_POST['id_olahraga'];
    $lokasi_kegiatan  = $_POST['lokasi_kegiatan'];
    $tgl_daftar       = $_POST['tgl_daftar'];
    $tgl_tutup        = $_POST['tgl_tutup'];

    $stmt = $conn->prepare("
        UPDATE list_event SET
        nama_event=?,
        tipe_event=?,
        nama_eo=?,
        id_olahraga=?,
        lokasi_kegiatan=?,
        tgl_daftar=?,
        tgl_tutup=?
        WHERE id_event=?
    ");

    $stmt->bind_param(
        "sssisssi",
        $nama_event,
        $tipe_event,
        $nama_eo,
        $id_olahraga,
        $lokasi_kegiatan,
        $tgl_daftar,
        $tgl_tutup,
        $id
    );

    if ($stmt->execute()) {
        echo "<script>
                alert('Data berhasil diperbarui');
                window.location='daftar-event.php';
              </script>";
        exit;
    } else {
        echo "<div class='alert alert-danger'>Gagal update data</div>";
    }
}

include 'atas.php';
?>

<div class="main-panel">
	<div class="content-wrapper">

		<div class="page-header">
			<h3 class="page-title">Edit Event</h3>
		</div>

		<div class="card">
			<div class="card-body">

				<form method="POST">

					<div class="mb-3">
						<label>Nama Event</label>
						<input type="text" name="nama_event"
						value="<?= $data['nama_event'] ?>"
						class="form-control">
					</div>

					<div class="mb-3">
						<label>Tipe Event</label>
						<input type="text" name="tipe_event"
						value="<?= $data['tipe_event'] ?>"
						class="form-control">
					</div>

					<div class="mb-3">
						<label>Event Organizer</label>
						<input type="text" name="nama_eo"
						value="<?= $data['nama_eo'] ?>"
						class="form-control">
					</div>

					<div class="mb-3">
						<label>Cabang Olahraga</label>

						<select name="id_olahraga" class="form-control">

							<?php while($o = $olahraga->fetch_assoc()): ?>

							<option value="<?= $o['id_olahraga'] ?>"
							<?= ($data['id_olahraga'] == $o['id_olahraga']) ? 'selected' : '' ?>>

							<?= $o['nama_olahraga'] ?>

							</option>

							<?php endwhile; ?>

						</select>

					</div>

					<div class="mb-3">
						<label>Lokasi</label>
						<input type="text" name="lokasi_kegiatan"
						value="<?= $data['lokasi_kegiatan'] ?>"
						class="form-control">
					</div>

					<div class="mb-3">
						<label>Tanggal Daftar</label>
						<input type="date" name="tgl_daftar"
						value="<?= $data['tgl_daftar'] ?>"
						class="form-control">
					</div>

					<div class="mb-3">
						<label>Tanggal Tutup</label>
						<input type="date" name="tgl_tutup"
						value="<?= $data['tgl_tutup'] ?>"
						class="form-control">
					</div>

					<button class="btn btn-warning">
					Update Event
					</button>

					<a href="daftar-event.php" class="btn btn-light">
					Kembali
					</a>

				</form>

			</div>
		</div>

<?php include 'bawah.php'; ?>