<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit();
}
?>
<div class="sidebar p-3">
    <div class="text-center text-white mb-4">
        <i class="fas fa-shield-alt fa-3x mb-2"></i>
        <h5>Panel Admin</h5>
        <small>BPBD Kota</small>
        <hr class="text-white-50">
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'laporan.php' ? 'active' : '' ?>" href="laporan.php">
                <i class="fas fa-list"></i> Semua Laporan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'grafik.php' ? 'active' : '' ?>" href="grafik.php">
                <i class="fas fa-chart-bar"></i> Grafik Laporan
            </a>
        </li>
        <li class="nav-item mt-4">
            <a class="nav-link text-danger" href="logout.php">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</div>