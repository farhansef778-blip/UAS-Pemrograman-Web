<?php
require_once 'templates/header.php';
require_once 'templates/navbar.php';
?>

<div class="container mt-4">
    <div class="row align-items-center min-vh-80">
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold text-primary">Sistem Pelaporan Banjir</h1>
            <p class="lead mt-3">Laporkan daerah terdampak banjir dengan cepat dan mudah. Tim BPBD akan segera menindaklanjuti laporan Anda.</p>
            <div class="mt-4">
                <a href="laporan.php" class="btn btn-primary btn-lg me-2"><i class="fas fa-upload"></i> Laporkan Banjir</a>
                <a href="status.php" class="btn btn-outline-primary btn-lg"><i class="fas fa-search"></i> Cek Status</a>
            </div>
        </div>
        <div class="col-lg-6 text-center">
            <img src="https://img.icons8.com/color/480/000/flood--v1.png" alt="Banjir Illustration" class="img-fluid">
        </div>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>