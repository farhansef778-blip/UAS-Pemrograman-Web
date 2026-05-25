<?php
require_once './templates/header.php';
require_once './templates/navbar.php';
?>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-modern">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-upload me-2"></i>Form Laporan Banjir</h4>
                </div>
                <div class="card-body">
                    <?php if(isset($_GET['success'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Laporan berhasil dikirim! Kode laporan: <?= htmlspecialchars($_GET['id']) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form action="kirim_laporan.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Nama Pelapor *</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat/Jalan *</label>
                            <textarea name="alamat" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Foto Banjir *</label>
                            <input type="file" name="foto" class="form-control" accept="image/*" required>
                            <small class="text-muted">Format: JPG, PNG, JPEG (Max 2MB)</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control" rows="3" placeholder="Deskripsikan kondisi banjir..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lokasi GPS (Otomatis)</label>
                            <div id="gpsStatus" class="gps-location">
                                <i class="fas fa-spinner fa-spin"></i> Mengambil lokasi...
                            </div>
                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">
                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="getLocation()">
                                <i class="fas fa-sync-alt"></i> Refresh Lokasi
                            </button>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-paper-plane"></i> Kirim Laporan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function getLocation() {
    const statusDiv = document.getElementById('gpsStatus');
    statusDiv.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengambil lokasi...';
    
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
                statusDiv.innerHTML = '<i class="fas fa-check-circle text-success"></i> Lokasi ditemukan: ' + 
                    position.coords.latitude.toFixed(6) + ', ' + position.coords.longitude.toFixed(6);
            },
            function(error) {
                statusDiv.innerHTML = '<i class="fas fa-exclamation-triangle text-warning"></i> Gagal mengambil lokasi. Silakan refresh atau izinkan akses lokasi.';
            }
        );
    } else {
        statusDiv.innerHTML = '<i class="fas fa-exclamation-triangle text-danger"></i> Browser tidak mendukung Geolocation.';
    }
}

// Panggil otomatis saat halaman load
getLocation();
</script>

<?php require_once '../templates/footer.php'; ?>