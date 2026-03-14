<?php
include 'koneksi.php';

if(isset($_GET['read'])){
mysqli_query($conn,"UPDATE orders SET is_read=1 WHERE is_read=0");
}
?>