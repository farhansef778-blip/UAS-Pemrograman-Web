<?php
session_start();

// Catat aktivitas logout sebelum session dihapus
if(isset($_SESSION['admin_id'])) {
    require_once '../config/koneksi.php';
    $admin_id = $_SESSION['admin_id'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $aksi = "Logout";
    $detail = "Admin logout dari sistem";
    
    mysqli_query($conn, "INSERT INTO log_aktivitas (admin_id, aksi, detail, ip_address) VALUES ('$admin_id', '$aksi', '$detail', '$ip')");
}

// Hapus semua session
$_SESSION = array();

// Hapus session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hancurkan session
session_destroy();

// Redirect ke halaman login dengan pesan sukses
header("Location: login.php?message=logout_success");
exit();
?>