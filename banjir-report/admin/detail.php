<?php
require_once '../templates/auth.php';
require_once '../config/koneksi.php';
require_once '../templates/header.php';

$id = $_GET['id'];
$query = "SELECT * FROM laporan WHERE id='$id'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if(!$data) {
    header("Location: laporan.php");
    exit();
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 mb-4">
            <?php require_once '../templates/sidebar_admin.php'; ?>
        </div>
        <div class="col-md-9">
            <div class="card card-modern">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4><i class="fas fa-file-alt me-2"></i>Detail Laporan #<?= $data['id'] ?></h4>
                    <a href="laporan.php" class="btn btn-secondary btn-sm">Kembali</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th width="35%">Nama Pelapor</th>
                                    <td><?= htmlspecialchars($data['nama_pelapor']) ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?= htmlspecialchars($data['email']) ?></td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td><?= nl2br(htmlspecialchars($data['alamat'])) ?></td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td><?= nl2br(htmlspecialchars($data['keterangan'])) ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <?php
                                        $badgeClass = '';
                                        switch($data['status']) {
                                            case 'diterima': $badgeClass = 'bg-warning'; break;
                                            case 'ditindaklanjuti': $badgeClass = 'bg-info'; break;
                                            case 'dikerjakan': $badgeClass = 'bg-primary'; break;
                                            case 'selesai': $badgeClass = 'bg-success'; break;
                                        }
                                        ?>
                                        <span class="badge <?= $badgeClass ?> fs-6 p-2"><?= strtoupper($data['status']) ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Laporan</th>
                                    <td><?= date('d F Y H:i:s', strtotime($data['created_at'])) ?></td>
                                </tr>
                                <tr>
                                    <th>Terakhir Update</th>
                                    <td><?= date('d F Y H:i:s', strtotime($data['updated_at'])) ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-primary text-white">
                                    <i class="fas fa-map-marker-alt me-2"></i>Lokasi GPS
                                </div>
                                <div class="card-body">
                                    <?php if($data['latitude'] && $data['longitude']): ?>
                                        <p><strong>Latitude:</strong> <?= $data['latitude'] ?></p>
                                        <p><strong>Longitude:</strong> <?= $data['longitude'] ?></p>
                                        <a href="https://www.google.com/maps?q=<?= $data['latitude'] ?>,<?= $data['longitude'] ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-external-link-alt"></i> Buka di Google Maps
                                        </a>
                                    <?php else: ?>
                                        <p class="text-muted">Tidak ada data GPS</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <?php if($data['foto']): ?>
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <i class="fas fa-image me-2"></i>Foto Banjir
                                </div>
                                <div class="card-body text-center">
                                    <img src="../uploads/<?= $data['foto'] ?>" class="img-fluid rounded" alt="Foto Banjir" style="max-height: 300px;">
                                    <br>
                                    <a href="../uploads/<?= $data['foto'] ?>" download class="btn btn-sm btn-success mt-2">
                                        <i class="fas fa-download"></i> Download Foto
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <form action="update_status.php" method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?= $data['id'] ?>">
                            <select name="status" class="form-select d-inline-block w-auto">
                                <option value="diterima" <?= $data['status']=='diterima'?'selected':'' ?>>Diterima</option>
                                <option value="ditindaklanjuti" <?= $data['status']=='ditindaklanjuti'?'selected':'' ?>>Ditindaklanjuti</option>
                                <option value="dikerjakan" <?= $data['status']=='dikerjakan'?'selected':'' ?>>Dikerjakan</option>
                                <option value="selesai" <?= $data['status']=='selesai'?'selected':'' ?>>Selesai</option>
                            </select>
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once '../templates/footer.php'; ?>