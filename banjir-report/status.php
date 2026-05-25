<?php
require_once './templates/header.php';
require_once './templates/navbar.php';
require_once './config/koneksi.php';

// Ambil semua laporan untuk ditampilkan
$query = "SELECT * FROM laporan ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card card-modern">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-chart-line me-2"></i>Status Laporan Banjir</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Pelapor</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td>#<?= $row['id'] ?></td>
                                    <td><?= htmlspecialchars($row['nama_pelapor']) ?></td>
                                    <td><?= htmlspecialchars(substr($row['alamat'], 0, 30)) ?>...</td>
                                    <td>
                                        <?php
                                        $statusClass = '';
                                        switch($row['status']) {
                                            case 'diterima': $statusClass = 'status-diterima'; break;
                                            case 'ditindaklanjuti': $statusClass = 'status-ditindaklanjuti'; break;
                                            case 'dikerjakan': $statusClass = 'status-dikerjakan'; break;
                                            case 'selesai': $statusClass = 'status-selesai'; break;
                                        }
                                        ?>
                                        <span class="badge-status <?= $statusClass ?>"><?= ucfirst($row['status']) ?></span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($row['created_at'])) ?></td>
                                    <td>
                                        <a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Detail</a>
                                    </td>
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

<?php require_once './templates/footer.php'; ?>