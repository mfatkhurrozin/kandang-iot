@extends('layout.main')

@section('judul')
    Grafik Data Sensor
@endsection

@section('isi')
<div class="container mt-2">
    <div id="monthData">
        @php
        // Buat array kosong untuk menyimpan data yang dikelompokkan berdasarkan bulan
        $groupedData = [];

        // Loop melalui data sensor Anda
        foreach ($sensordata as $item) {
            // Ubah string timestamp menjadi objek Carbon
            $timestamp = \Carbon\Carbon::parse($item['timestamp']);

            // Buat kunci berdasarkan bulan dan tahun (misal: "Januari 2023")
            $key = $timestamp->format('F Y');

            // Tambahkan data ke dalam array grup berdasarkan kunci bulan
            if (!isset($groupedData[$key])) {
                $groupedData[$key] = [];
            }

            $groupedData[$key][] = $item;
        }
        @endphp

        <!-- Dropdown untuk memilih bulan -->
        <div class="mb-3">
            <label for="bulan" class="form-label">Pilih Bulan:</label>
            <select id="bulan" class="form-select">
                @php
                $latestMonth = null;
        
                // Determine the latest month from the grouped data
                if (!empty($groupedData)) {
                    $latestMonth = array_key_last($groupedData);
                }
                @endphp
        
                @if (!empty($latestMonth))
                    @foreach ($groupedData as $month => $data)
                        <option value="{{ $month }}" {{ $month === $latestMonth ? 'selected' : '' }}>{{ $month }}</option>
                    @endforeach
                @else
                    <option value="" selected>Tidak ada data yang tersedia</option>
                @endif
            </select>
        </div>

        @foreach ($groupedData as $month => $data)
        <div class="table-container" data-bulan="{{ $month }}" style="display: none;">
                <h3>{{ $month }}</h3>
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
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item['temperature'] }}</td>
                                <td>{{ $item['humidity'] }}</td>
                                <td>{{ $item['lux'] }}</td>
                                <td>{{ $item['air_quality'] }}</td>
                                <td>{{ $item['timestamp'] }}</td>
                                <!-- Tambahkan kolom lain sesuai data Anda -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
        <canvas id="sensorChart" width="400" height="200"></canvas>
        <canvas id="chartKelembaban" width="400" height="200"></canvas>
        <canvas id="chartLux" width="400" height="200"></canvas>
        <canvas id="chartAir" width="400" height="200"></canvas>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const dropdown = document.getElementById("bulan");
    const sensorChart = document.getElementById("sensorChart").getContext("2d");

    let data = [];
    let labels = [];
    let chart;

    // Fungsi untuk menggambar chart berdasarkan data yang dipilih
    function drawChart(selectedData, selectedLabels) {
        if (chart) {
            chart.destroy();
        }

        const formattedLabels = selectedData.map(item => {
            const timestamp = new Date(item.timestamp);
            const year = timestamp.getFullYear();
            const month = (timestamp.getMonth() + 1).toString().padStart(2, '0');
            const day = timestamp.getDate().toString().padStart(2, '0');
            return `${day}/${month}/${year}`;
        });

        chart = new Chart(sensorChart, {
            type: "bar", // Ganti dengan jenis chart yang sesuai (line, bar, dll.)
            data: {
                labels: formattedLabels, // Label tanggal yang sudah diformat
                datasets: [
                    {
                        label: "Suhu",
                        data: selectedData.map(item => item.temperature),
                        borderColor: "rgba(75, 192, 192, 1)",
                        borderWidth: 1,
                        fill: false,
                    },
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        });
    }
    

    // Tambahkan event listener untuk menangani perubahan pada dropdown
    dropdown.addEventListener("change", function () {
        const selectedMonth = this.value;
        const tableContainers = document.querySelectorAll(".table-container");

        // Sembunyikan semua tabel
        tableContainers.forEach(function (container) {
            container.style.display = "none";
        });

        // Tampilkan tabel yang sesuai dengan bulan yang dipilih
        const selectedTable = document.querySelector(`[data-bulan="${selectedMonth}`);
        if (selectedTable) {
            // Ambil data dari tabel yang sesuai
            const tableRows = selectedTable.querySelectorAll("tbody tr");
            const selectedData = Array.from(tableRows).map(function (row) {
                const columns = row.querySelectorAll("td");
                return {
                    timestamp: columns[4].textContent,
                    temperature: parseFloat(columns[0].textContent),
                    humidity: parseFloat(columns[1].textContent),
                    lightIntensity: parseFloat(columns[2].textContent),
                    airQuality: parseFloat(columns[3].textContent),
                };
            });

            // Ambil label bulan dan tahun
            const selectedLabel = selectedMonth.split(" ");
            const selectedLabels = selectedData.map(() => selectedLabel.join(" "));

            // Update data dan label pada chart
            data = selectedData;
            labels = selectedLabels;

            // Gambar chart berdasarkan data yang dipilih
            drawChart(data, labels);
        }
    });
    const latestMonthOption = document.querySelector("#bulan option:last-child");
        if (latestMonthOption) {
            latestMonthOption.selected = true;
            dropdown.dispatchEvent(new Event("change"));
        }
});

</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dropdown = document.getElementById("bulan");
        const chartKelembaban = document.getElementById("chartKelembaban").getContext("2d");
    
        let data = [];
        let labels = [];
        let chart;
    
        // Fungsi untuk menggambar chart berdasarkan data yang dipilih
        function drawChart(selectedData, selectedLabels) {
            if (chart) {
                chart.destroy();
            }
    
            const formattedLabels = selectedData.map(item => {
                const timestamp = new Date(item.timestamp);
                const year = timestamp.getFullYear();
                const month = (timestamp.getMonth() + 1).toString().padStart(2, '0');
                const day = timestamp.getDate().toString().padStart(2, '0');
                return `${day}/${month}/${year}`;
            });
    
            chart = new Chart(chartKelembaban, {
                type: "bar", // Ganti dengan jenis chart yang sesuai (line, bar, dll.)
                data: {
                    labels: formattedLabels, // Label tanggal yang sudah diformat
                    datasets: [
                        {
                            label: "Kelembaban",
                            data: selectedData.map(item => item.humidity),
                            borderColor: "rgba(255, 99, 132, 1)",
                            borderWidth: 1,
                            fill: false,
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
        }
    
        // Tambahkan event listener untuk menangani perubahan pada dropdown
        dropdown.addEventListener("change", function () {
            const selectedMonth = this.value;
            const tableContainers = document.querySelectorAll(".table-container");
    
            // Sembunyikan semua tabel
            tableContainers.forEach(function (container) {
                container.style.display = "none";
            });
    
            // Tampilkan tabel yang sesuai dengan bulan yang dipilih
            const selectedTable = document.querySelector(`[data-bulan="${selectedMonth}`);
            if (selectedTable) {
                // Ambil data dari tabel yang sesuai
                const tableRows = selectedTable.querySelectorAll("tbody tr");
                const selectedData = Array.from(tableRows).map(function (row) {
                    const columns = row.querySelectorAll("td");
                    return {
                        timestamp: columns[4].textContent,
                        temperature: parseFloat(columns[0].textContent),
                        humidity: parseFloat(columns[1].textContent),
                        lightIntensity: parseFloat(columns[2].textContent),
                        airQuality: parseFloat(columns[3].textContent),
                    };
                });
    
                // Ambil label bulan dan tahun
                const selectedLabel = selectedMonth.split(" ");
                const selectedLabels = selectedData.map(() => selectedLabel.join(" "));
    
                // Update data dan label pada chart
                data = selectedData;
                labels = selectedLabels;
    
                // Gambar chart berdasarkan data yang dipilih
                drawChart(data, labels);
            }
        });
        const latestMonthOption = document.querySelector("#bulan option:last-child");
        if (latestMonthOption) {
            latestMonthOption.selected = true;
            dropdown.dispatchEvent(new Event("change"));
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dropdown = document.getElementById("bulan");
        const chartLux = document.getElementById("chartLux").getContext("2d");
    
        let data = [];
        let labels = [];
        let chart;
    
        // Fungsi untuk menggambar chart berdasarkan data yang dipilih
        function drawChart(selectedData, selectedLabels) {
            if (chart) {
                chart.destroy();
            }
    
            const formattedLabels = selectedData.map(item => {
                const timestamp = new Date(item.timestamp);
                const year = timestamp.getFullYear();
                const month = (timestamp.getMonth() + 1).toString().padStart(2, '0');
                const day = timestamp.getDate().toString().padStart(2, '0');
                return `${day}/${month}/${year}`;
            });
    
            chart = new Chart(chartLux, {
                type: "bar", // Ganti dengan jenis chart yang sesuai (line, bar, dll.)
                data: {
                    labels: formattedLabels, // Label tanggal yang sudah diformat
                    datasets: [
                        {
                            label: "Intensitas Cahaya",
                            data: selectedData.map(item => item.lightIntensity),
                            borderColor: "rgba(255, 165, 0, 0.5)",
                            borderWidth: 1,
                            fill: false,
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
        }
    
        // Tambahkan event listener untuk menangani perubahan pada dropdown
        dropdown.addEventListener("change", function () {
            const selectedMonth = this.value;
            const tableContainers = document.querySelectorAll(".table-container");
    
            // Sembunyikan semua tabel
            tableContainers.forEach(function (container) {
                container.style.display = "none";
            });
    
            // Tampilkan tabel yang sesuai dengan bulan yang dipilih
            const selectedTable = document.querySelector(`[data-bulan="${selectedMonth}`);
            if (selectedTable) {
                // Ambil data dari tabel yang sesuai
                const tableRows = selectedTable.querySelectorAll("tbody tr");
                const selectedData = Array.from(tableRows).map(function (row) {
                    const columns = row.querySelectorAll("td");
                    return {
                        timestamp: columns[4].textContent,
                        temperature: parseFloat(columns[0].textContent),
                        humidity: parseFloat(columns[1].textContent),
                        lightIntensity: parseFloat(columns[2].textContent),
                        airQuality: parseFloat(columns[3].textContent),
                    };
                });
    
                // Ambil label bulan dan tahun
                const selectedLabel = selectedMonth.split(" ");
                const selectedLabels = selectedData.map(() => selectedLabel.join(" "));
    
                // Update data dan label pada chart
                data = selectedData;
                labels = selectedLabels;
    
                // Gambar chart berdasarkan data yang dipilih
                drawChart(data, labels);
            }
        });
        const latestMonthOption = document.querySelector("#bulan option:last-child");
        if (latestMonthOption) {
            latestMonthOption.selected = true;
            dropdown.dispatchEvent(new Event("change"));
        }
    });
    
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dropdown = document.getElementById("bulan");
        const chartAir = document.getElementById("chartAir").getContext("2d");
    
        let data = [];
        let labels = [];
        let chart;
    
        // Fungsi untuk menggambar chart berdasarkan data yang dipilih
        function drawChart(selectedData, selectedLabels) {
            if (chart) {
                chart.destroy();
            }
    
            const formattedLabels = selectedData.map(item => {
                const timestamp = new Date(item.timestamp);
                const year = timestamp.getFullYear();
                const month = (timestamp.getMonth() + 1).toString().padStart(2, '0');
                const day = timestamp.getDate().toString().padStart(2, '0');
                return `${day}/${month}/${year}`;
            });
    
            chart = new Chart(chartAir, {
                type: "bar", // Ganti dengan jenis chart yang sesuai (line, bar, dll.)
                data: {
                    labels: formattedLabels, // Label tanggal yang sudah diformat
                    datasets: [
                        {
                            label: "Kualitas Udara",
                            data: selectedData.map(item => item.airQuality),
                            borderColor: "rgba(173, 216, 230, 0.5)",
                            borderWidth: 1,
                            fill: false,
                        },
                    ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
        }
    
        // Tambahkan event listener untuk menangani perubahan pada dropdown
        dropdown.addEventListener("change", function () {
            const selectedMonth = this.value;
            const tableContainers = document.querySelectorAll(".table-container");
    
            // Sembunyikan semua tabel
            tableContainers.forEach(function (container) {
                container.style.display = "none";
            });
    
            // Tampilkan tabel yang sesuai dengan bulan yang dipilih
            const selectedTable = document.querySelector(`[data-bulan="${selectedMonth}`);
            if (selectedTable) {
                // Ambil data dari tabel yang sesuai
                const tableRows = selectedTable.querySelectorAll("tbody tr");
                const selectedData = Array.from(tableRows).map(function (row) {
                    const columns = row.querySelectorAll("td");
                    return {
                        timestamp: columns[4].textContent,
                        temperature: parseFloat(columns[0].textContent),
                        humidity: parseFloat(columns[1].textContent),
                        lightIntensity: parseFloat(columns[2].textContent),
                        airQuality: parseFloat(columns[3].textContent),
                    };
                });
    
                // Ambil label bulan dan tahun
                const selectedLabel = selectedMonth.split(" ");
                const selectedLabels = selectedData.map(() => selectedLabel.join(" "));
    
                // Update data dan label pada chart
                data = selectedData;
                labels = selectedLabels;
    
                // Gambar chart berdasarkan data yang dipilih
                drawChart(data, labels);
            }
        });
        const latestMonthOption = document.querySelector("#bulan option:last-child");
        if (latestMonthOption) {
            latestMonthOption.selected = true;
            dropdown.dispatchEvent(new Event("change"));
        }
    });
    
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
