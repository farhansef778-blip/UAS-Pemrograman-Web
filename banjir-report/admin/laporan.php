<?php
require_once '../templates/auth.php';
require_once '../config/koneksi.php';
require_once '../templates/header.php';

$query = "SELECT * FROM laporan ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 mb-4">
            <?php require_once '../templates/sidebar_admin.php'; ?>
        </div>
        <div class="col-md-9">
            <div class="card card-modern">
                <div class="card-header bg-white">
                    <h4><i class="fas fa-list me-2"></i>Semua Laporan Banjir</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th><th>Pelapor</th><th>Alamat</th><th>Foto</th><th>Status</th><th>Tanggal</th><th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td>#<?= $row['id'] ?></td>
                                    <td><?= htmlspecialchars($row['nama_pelapor']) ?></td>
                                    <td><?= htmlspecialchars(substr($row['alamat'],0,40)) ?></td>
                                    <td>
                                        <?php if($row['foto']): ?>
                                            <img src="../uploads/<?= $row['foto'] ?>" width="50" class="rounded">
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form action="update_status.php" method="POST" class="d-flex gap-2">
                                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                            <select name="status" class="form-select form-select-sm" style="width:150px">
                                                <option value="diterima" <?= $row['status']=='diterima'?'selected':'' ?>>Diterima</option>
                                                <option value="ditindaklanjuti" <?= $row['status']=='ditindaklanjuti'?'selected':'' ?>>Ditindaklanjuti</option>
                                                <option value="dikerjakan" <?= $row['status']=='dikerjakan'?'selected':'' ?>>Dikerjakan</option>
                                                <option value="selesai" <?= $row['status']=='selesai'?'selected':'' ?>>Selesai</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                        </form>
                                    </td>
                                    <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                                    <td>
                                        <a href="detail.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info">Detail</a>
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

<?php require_once '../templates/footer.php'; ?>