<?php
include 'session_admin.php';
include 'koneksi.php';

$event = $conn->query("
SELECT 
    e.*, 
    c.nama_olahraga
FROM list_event e
LEFT JOIN cabang_olahraga c 
ON e.id_olahraga = c.id_olahraga
ORDER BY e.id_event DESC
");

include 'atas.php';
?>

<div class="main-panel">
    <div class="content-wrapper">

        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-calendar"></i>
                </span>
                Daftar Event
            </h3>

            <a href="tambah-event.php" class="btn btn-primary">
            Tambah Event
            </a>

        </div>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-striped">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Event</th>
                                <th>Tipe Event</th>
                                <th>Event Organizer</th>
                                <th>Olahraga</th>
                                <th>Lokasi</th>
                                <th>Tgl Daftar</th>
                                <th>Tgl Tutup</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php 
                            $no=1; 
                            while($row = $event->fetch_assoc()): 

                            $status = (strtotime($row['tgl_tutup']) >= time()) ? 'Open' : 'Closed';

                            ?>

                            <tr>

                                <td><?= $no++ ?></td>

                                <td><?= htmlspecialchars($row['nama_event']) ?></td>

                                <td><?= htmlspecialchars($row['tipe_event']) ?></td>

                                <td><?= htmlspecialchars($row['nama_eo']) ?></td>

                                <td><?= htmlspecialchars($row['nama_olahraga']) ?></td>

                                <td><?= htmlspecialchars($row['lokasi_kegiatan']) ?></td>

                                <td><?= date('d M Y', strtotime($row['tgl_daftar'])) ?></td>

                                <td><?= date('d M Y', strtotime($row['tgl_tutup'])) ?></td>

                                <td>

                                <?php if($status=='Open'): ?>
                                <span class="badge bg-success">OPEN</span>
                                <?php else: ?>
                                <span class="badge bg-danger">CLOSED</span>
                                <?php endif; ?>

                                </td>

                                <td>

                                    <a href="edit-event.php?id=<?= $row['id_event'] ?>" class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <a href="hapus-event.php?id=<?= $row['id_event'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data event ini?')">
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