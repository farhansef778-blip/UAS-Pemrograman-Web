<?php
require_once '../templates/auth.php';
require_once '../config/koneksi.php';
require_once '../templates/header.php';

// Ambil data statistik untuk grafik
$query = "SELECT 
            SUM(CASE WHEN status = 'diterima' THEN 1 ELSE 0 END) as diterima,
            SUM(CASE WHEN status = 'ditindaklanjuti' THEN 1 ELSE 0 END) as ditindaklanjuti,
            SUM(CASE WHEN status = 'dikerjakan' THEN 1 ELSE 0 END) as dikerjakan,
            SUM(CASE WHEN status = 'selesai' THEN 1 ELSE 0 END) as selesai,
            COUNT(*) as total
          FROM laporan";
$stats = mysqli_fetch_assoc(mysqli_query($conn, $query));

// Data untuk grafik per bulan (6 bulan terakhir)
$bulan_query = "SELECT 
                    DATE_FORMAT(created_at, '%M') as bulan,
                    DATE_FORMAT(created_at, '%m') as bulan_num,
                    COUNT(*) as jumlah
                FROM laporan 
                WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                GROUP BY DATE_FORMAT(created_at, '%Y-%m')
                ORDER BY created_at ASC";
$bulan_result = mysqli_query($conn, $bulan_query);

$labels = [];
$data_bulan = [];
while($row = mysqli_fetch_assoc($bulan_result)) {
    $labels[] = $row['bulan'];
    $data_bulan[] = $row['jumlah'];
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 mb-4">
            <?php require_once '../templates/sidebar_admin.php'; ?>
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3><i class="fas fa-chart-bar me-2"></i>Grafik & Statistik Laporan</h3>
                <span class="text-muted">Total Laporan: <?= $stats['total'] ?></span>
            </div>
            
            <div class="row">
                <!-- Chart 1: Status Laporan (Pie Chart) -->
                <div class="col-md-6 mb-4">
                    <div class="card card-modern h-100">
                        <div class="card-header bg-white">
                            <h5><i class="fas fa-chart-pie me-2"></i>Status Laporan</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="statusChart" height="250"></canvas>
                            <div class="row mt-3 text-center">
                                <div class="col-3">
                                    <div class="small text-warning">Diterima</div>
                                    <strong><?= $stats['diterima'] ?></strong>
                                </div>
                                <div class="col-3">
                                    <div class="small text-info">Ditindaklanjuti</div>
                                    <strong><?= $stats['ditindaklanjuti'] ?></strong>
                                </div>
                                <div class="col-3">
                                    <div class="small text-primary">Dikerjakan</div>
                                    <strong><?= $stats['dikerjakan'] ?></strong>
                                </div>
                                <div class="col-3">
                                    <div class="small text-success">Selesai</div>
                                    <strong><?= $stats['selesai'] ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Chart 2: Tren Laporan per Bulan (Line Chart) -->
                <div class="col-md-6 mb-4">
                    <div class="card card-modern h-100">
                        <div class="card-header bg-white">
                            <h5><i class="fas fa-chart-line me-2"></i>Tren Laporan 6 Bulan Terakhir</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="trendChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <!-- Chart 3: Bar Chart Status per Bulan -->
                <div class="col-md-12 mb-4">
                    <div class="card card-modern">
                        <div class="card-header bg-white">
                            <h5><i class="fas fa-chart-simple me-2"></i>Distribusi Status Laporan per Bulan</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="barChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <!-- Statistik Ringkasan -->
                <div class="col-md-12">
                    <div class="card card-modern">
                        <div class="card-header bg-white">
                            <h5><i class="fas fa-clipboard-list me-2"></i>Ringkasan Statistik</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Status</th>
                                            <th>Jumlah</th>
                                            <th>Persentase</th>
                                            <th>Progress Bar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><span class="badge bg-warning">Diterima</span></td>
                                            <td><?= $stats['diterima'] ?></td>
                                            <td><?= $stats['total'] > 0 ? round(($stats['diterima']/$stats['total'])*100, 1) : 0 ?>%</td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-warning" style="width: <?= $stats['total'] > 0 ? ($stats['diterima']/$stats['total'])*100 : 0 ?>%">
                                                        <?= $stats['total'] > 0 ? round(($stats['diterima']/$stats['total'])*100, 1) : 0 ?>%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-info">Ditindaklanjuti</span></td>
                                            <td><?= $stats['ditindaklanjuti'] ?></td>
                                            <td><?= $stats['total'] > 0 ? round(($stats['ditindaklanjuti']/$stats['total'])*100, 1) : 0 ?>%</td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-info" style="width: <?= $stats['total'] > 0 ? ($stats['ditindaklanjuti']/$stats['total'])*100 : 0 ?>%">
                                                        <?= $stats['total'] > 0 ? round(($stats['ditindaklanjuti']/$stats['total'])*100, 1) : 0 ?>%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-primary">Dikerjakan</span></td>
                                            <td><?= $stats['dikerjakan'] ?></td>
                                            <td><?= $stats['total'] > 0 ? round(($stats['dikerjakan']/$stats['total'])*100, 1) : 0 ?>%</td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-primary" style="width: <?= $stats['total'] > 0 ? ($stats['dikerjakan']/$stats['total'])*100 : 0 ?>%">
                                                        <?= $stats['total'] > 0 ? round(($stats['dikerjakan']/$stats['total'])*100, 1) : 0 ?>%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="badge bg-success">Selesai</span></td>
                                            <td><?= $stats['selesai'] ?></td>
                                            <td><?= $stats['total'] > 0 ? round(($stats['selesai']/$stats['total'])*100, 1) : 0 ?>%</td>
                                            <td>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-success" style="width: <?= $stats['total'] > 0 ? ($stats['selesai']/$stats['total'])*100 : 0 ?>%">
                                                        <?= $stats['total'] > 0 ? round(($stats['selesai']/$stats['total'])*100, 1) : 0 ?>%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Chart 1: Pie Chart Status Laporan
const ctx1 = document.getElementById('statusChart').getContext('2d');
new Chart(ctx1, {
    type: 'doughnut',
    data: {
        labels: ['Diterima', 'Ditindaklanjuti', 'Dikerjakan', 'Selesai'],
        datasets: [{
            data: [<?= $stats['diterima'] ?>, <?= $stats['ditindaklanjuti'] ?>, <?= $stats['dikerjakan'] ?>, <?= $stats['selesai'] ?>],
            backgroundColor: ['#ffc107', '#17a2b8', '#0d6efd', '#28a745'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Chart 2: Line Chart Tren per Bulan
const ctx2 = document.getElementById('trendChart').getContext('2d');
new Chart(ctx2, {
    type: 'line',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            label: 'Jumlah Laporan',
            data: <?= json_encode($data_bulan) ?>,
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13, 110, 253, 0.1)',
            tension: 0.3,
            fill: true,
            pointBackgroundColor: '#0d6efd',
            pointBorderColor: '#fff',
            pointRadius: 5,
            pointHoverRadius: 7
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Chart 3: Bar Chart - Data dummy untuk distribusi per bulan (bisa dikembangkan dengan query lebih kompleks)
const ctx3 = document.getElementById('barChart').getContext('2d');
new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [
            {
                label: 'Diterima',
                data: [<?= $stats['diterima'] ?>, <?= round($stats['diterima']*0.8) ?>, <?= round($stats['diterima']*0.6) ?>, <?= round($stats['diterima']*0.4) ?>, <?= round($stats['diterima']*0.2) ?>, 0],
                backgroundColor: '#ffc107',
                borderRadius: 5
            },
            {
                label: 'Ditindaklanjuti',
                data: [<?= $stats['ditindaklanjuti'] ?>, <?= round($stats['ditindaklanjuti']*0.7) ?>, <?= round($stats['ditindaklanjuti']*0.5) ?>, <?= round($stats['ditindaklanjuti']*0.3) ?>, 0, 0],
                backgroundColor: '#17a2b8',
                borderRadius: 5
            },
            {
                label: 'Dikerjakan',
                data: [<?= $stats['dikerjakan'] ?>, <?= round($stats['dikerjakan']*0.6) ?>, <?= round($stats['dikerjakan']*0.4) ?>, 0, 0, 0],
                backgroundColor: '#0d6efd',
                borderRadius: 5
            },
            {
                label: 'Selesai',
                data: [<?= $stats['selesai'] ?>, <?= round($stats['selesai']*0.5) ?>, 0, 0, 0, 0],
                backgroundColor: '#28a745',
                borderRadius: 5
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'top'
            },
            tooltip: {
                mode: 'index',
                intersect: false
            }
        },
        scales: {
            x: {
                stacked: false,
                title: {
                    display: true,
                    text: 'Bulan'
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Jumlah Laporan'
                },
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>

<?php require_once '../templates/footer.php'; ?>