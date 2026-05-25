<?php
require_once '../templates/auth.php';
require_once '../config/koneksi.php';
require_once '../templates/header.php';

// Statistik
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM laporan"))['total'];
$diterima = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM laporan WHERE status='diterima'"))['total'];
$ditindaklanjuti = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM laporan WHERE status='ditindaklanjuti'"))['total'];
$dikerjakan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM laporan WHERE status='dikerjakan'"))['total'];
$selesai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM laporan WHERE status='selesai'"))['total'];

// Laporan terbaru
$recent = mysqli_query($conn, "SELECT * FROM laporan ORDER BY created_at DESC LIMIT 5");
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 mb-4">
            <?php require_once '../templates/sidebar_admin.php'; ?>
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h3>
                <span class="text-muted">Selamat datang, <?= $_SESSION['admin_name'] ?></span>
            </div>
            
            <div class="row">
                <div class="col-md-3 mb-3">
                    <div class="card card-modern bg-primary text-white">
                        <div class="card-body">
                            <h5>Total Laporan</h5>
                            <h2><?= $total ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-modern bg-warning text-dark">
                        <div class="card-body">
                            <h5>Diterima</h5>
                            <h2><?= $diterima ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-modern bg-info text-white">
                        <div class="card-body">
                            <h5>Ditindaklanjuti</h5>
                            <h2><?= $ditindaklanjuti ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card card-modern bg-success text-white">
                        <div class="card-body">
                            <h5>Selesai</h5>
                            <h2><?= $selesai ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card card-modern mt-3">
                <div class="card-header bg-white">
                    <h5>Laporan Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr><th>ID</th><th>Pelapor</th><th>Alamat</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($recent)): ?>
                                <tr>
                                    <td>#<?= $row['id'] ?></td>
                                    <td><?= htmlspecialchars($row['nama_pelapor']) ?></td>
                                    <td><?= htmlspecialchars(substr($row['alamat'],0,30)) ?>...</td>
                                    <td><span class="badge bg-<?= $row['status']=='selesai'?'success':($row['status']=='dikerjakan'?'warning':'secondary') ?>"><?= $row['status'] ?></span></td>
                                    <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                                    <td><a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Detail</a></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../templates/footer.php'; ?>