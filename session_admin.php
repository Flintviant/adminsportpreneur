<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// belum login
if (!isset($_SESSION['role_id'])) {
    header("Location: login.php");
    exit();
}

// bukan admin
if ($_SESSION['role_name'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}