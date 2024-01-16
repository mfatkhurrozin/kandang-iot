@extends('layout.main')

@section('judul')
    Halaman Laporan
@endsection

@section('isi')
<div class="container mt-2">
    <div id="sensorData">
        <div class="form">
            <label for="tanggalAwal" class="form-label">Tanggal Awal:</label>
            <input type="date" id="tanggalAwal" class="form-control">
        </div>
        <div class="form">
            <label for="tanggalAkhir" class="form-label">Tanggal Akhir:</label>
            <input type="date" id="tanggalAkhir" class="form-control">
        </div>
        <div class="mb-3 float-right" style="margin-top: 10px">
            <button class="btn btn-warning" id="filterButton">
                <i class="fas fa-filter" style="margin-right: 5px;"></i> Filter Data
            </button>
            <button class="btn btn-warning" id="resetFilterButton">
                <i class="fas fa-undo" style="margin-right: 5px;"></i> Reset Filter
            </button>
            @php
                $inputtanggalAwal = isset($inputtanggalAwal) ? $inputtanggalAwal : null;
                $inputtanggalAkhir = isset($inputtanggalAkhir) ? $inputtanggalAkhir : null;
            @endphp
                <button class="btn btn-primary" id="cetakPdfButton" style="background-color: #004080; border-color: #004080;">
                    <i class="fas fa-print" style="margin-right: 5px;"></i> Cetak PDF
                </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Suhu</th>
                        <th>Kelembaban</th>
                        <th>Intensitas Cahaya</th>
                        <th>Kualitas Udara</th>
                        <th>Tanggal</th>
                        <!-- Tambahkan kolom lain sesuai data Anda -->
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
            {{ $sensordata->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const filterButton = document.getElementById("filterButton");
        const tanggalAwalInput = document.getElementById("tanggalAwal");
        const tanggalAkhirInput = document.getElementById("tanggalAkhir");
        const resetFilterButton = document.getElementById("resetFilterButton");
        const cetakPdfButton = document.getElementById("cetakPdfButton");
        // Tambahkan event listener untuk tombol filter
        filterButton.addEventListener("click", function () {
            const tanggalAwal = tanggalAwalInput.value;
            const tanggalAkhir = tanggalAkhirInput.value;
    
            // Perbarui URL untuk filter data berdasarkan tanggal
            const filterUrl = `{{ route('filter-data') }}?tanggalAwal=${tanggalAwal}&tanggalAkhir=${tanggalAkhir}`;
            window.location.href = filterUrl;
        });

        resetFilterButton.addEventListener("click", function () {
            // Reset input tanggalAwal dan tanggalAkhir
            tanggalAwalInput.value = "";
            tanggalAkhirInput.value = "";

            // Kembalikan URL ke URL asal (tanpa parameter tanggalAwal dan tanggalAkhir)
            window.location.href = "{{ route('filter-data') }}";
        });

        cetakPdfButton.addEventListener("click", function () {
            const tanggalAwal = tanggalAwalInput.value;
            const tanggalAkhir = tanggalAkhirInput.value;
    
            // Perbarui URL untuk mencetak PDF berdasarkan tanggal
            const pdfUrl = `{{ route('laporan.pdf') }}?tanggalAwal=${tanggalAwal}&tanggalAkhir=${tanggalAkhir}`;
            window.location.href = pdfUrl;
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
