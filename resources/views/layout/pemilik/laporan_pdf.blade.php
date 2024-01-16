<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            padding: 20px;
        }
        .content {
            margin: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="header">
        <h1>{{ $title }}</h1>
        <h4>{{ $tanggal_download }}</h4>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Suhu</th>
                <th>Kelembaban</th>
                <th>Intensitas Cahaya</th>
                <th>Kualitas Udara</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sensordata as $item)
            <tr>
                <td>{{ $item['temperature'] }}</td>
                <td>{{ $item['humidity'] }}</td>
                <td>{{ $item['lux'] }}</td>
                <td>{{ $item['air_quality'] }}</td>
                <td>{{ \Carbon\Carbon::parse($item['timestamp'])->format('d/m/Y H:i:s') }}</td>
                <!-- Tambahkan kolom lain sesuai data Anda -->
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</body>
</html>
