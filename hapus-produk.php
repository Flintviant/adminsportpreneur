<?php
include 'session_admin.php';
include 'koneksi.php';

$id = $_GET['id'];

$conn->query("DELETE FROM barang WHERE id_barang='$id'");

echo "<script>
alert('Produk berhasil dihapus');
location='daftar-produk.php';
</script>";