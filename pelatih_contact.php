<?php
include 'koneksi.php';

if(isset($_GET['read'])){
mysqli_query($conn,"UPDATE pelatih_contact SET is_read=1 WHERE is_read=0");
}
?>