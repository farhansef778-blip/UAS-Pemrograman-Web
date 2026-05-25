<?php
session_start();
require_once '../config/koneksi.php';

if(!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $query = "UPDATE laporan SET status='$status' WHERE id='$id'";
    
    if(mysqli_query($conn, $query)) {
        // Log aktivitas
        $admin_id = $_SESSION['admin_id'];
        $ip = $_SERVER['REMOTE_ADDR'];
        mysqli_query($conn, "INSERT INTO log_aktivitas (admin_id, aksi, detail, ip_address) VALUES ('$admin_id', 'Update Status', 'Update status laporan ID $id menjadi $status', '$ip')");
        
        header("Location: laporan.php?success=1");
    } else {
        header("Location: laporan.php?error=1");
    }
}
?>