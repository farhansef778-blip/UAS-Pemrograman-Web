<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Sistem Pelaporan Banjir BPBD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --bpbd-primary: #0d6efd;
            --bpbd-dark: #0a58ca;
            --bpbd-light: #e7f1ff;
        }
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.9);
            padding: 12px 20px;
            margin: 5px 0;
            border-radius: 10px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
        }
        .sidebar .nav-link i {
            width: 25px;
            margin-right: 10px;
        }
        .card-modern {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.2s;
        }
        .card-modern:hover {
            transform: translateY(-3px);
        }
        .badge-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
        }
        .status-diterima { background: #ffc107; color: #000; }
        .status-ditindaklanjuti { background: #17a2b8; color: #fff; }
        .status-dikerjakan { background: #fd7e14; color: #fff; }
        .status-selesai { background: #28a745; color: #fff; }
        .btn-bpbd {
            background: #0d6efd;
            color: white;
            border-radius: 10px;
            padding: 10px 20px;
        }
        .btn-bpbd:hover {
            background: #0a58ca;
            color: white;
        }
        .gps-location {
            background: #e7f1ff;
            padding: 10px;
            border-radius: 10px;
            font-size: 14px;
        }
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>