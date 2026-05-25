<?php
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $latitude = mysqli_real_escape_string($conn, $_POST['latitude']);
    $longitude = mysqli_real_escape_string($conn, $_POST['longitude']);
    
    // Upload foto
    $foto_name = '';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            $foto_name = time() . '_' . uniqid() . '.' . $ext;
            $target = '../uploads/' . $foto_name;
            
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
                // Success upload
            }
        }
    }
    
    $query = "INSERT INTO laporan (nama_pelapor, email, alamat, foto, keterangan, latitude, longitude, status) 
              VALUES ('$nama', '$email', '$alamat', '$foto_name', '$keterangan', '$latitude', '$longitude', 'diterima')";
    
    if (mysqli_query($conn, $query)) {
        $last_id = mysqli_insert_id($conn);
        header("Location: laporan.php?success=1&id=$last_id");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: laporan.php");
}
?>