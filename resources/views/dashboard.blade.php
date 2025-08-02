@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Dashboard</title>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <!-- Title -->
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
                <p class="mt-1 text-sm text-gray-500">
                    Selamat datang di sistem manajemen ERP Anda
                </p>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="mt-6 grid grid-cols-2 gap-6 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4">
            <!-- Data Produk -->
            <div class="rounded-xl bg-blue-600 p-5 text-white shadow">
                <div class="text-3xl font-bold">{{ $totalProduk }}</div>
                <div class="mt-1 text-sm">Data Produk</div>
            </div>

            <!-- Produk Masuk -->
            <div class="rounded-xl bg-orange-500 p-5 text-white shadow">
                <div class="text-3xl font-bold">{{ $produkMasuk }}</div>
                <div class="mt-1 text-sm">Produk Masuk</div>
            </div>

            <!-- Produk Keluar -->
            <div class="rounded-xl bg-red-500 p-5 text-white shadow">
                <div class="text-3xl font-bold">{{ $produkKeluar }}</div>
                <div class="mt-1 text-sm">Produk Keluar</div>
            </div>

            <!-- Pengguna -->
            <div class="rounded-xl bg-green-500 p-5 text-white shadow">
                <div class="text-3xl font-bold">{{ $totalUser }}</div>
                <div class="mt-1 text-sm">Pengguna</div>
            </div>
        </div>

        <!-- Main Dashboard Row -->
        <div class="mt-6 flex flex-col gap-6 lg:flex-row">
            <!-- Left Column (Sales) -->
            <section class="w-full space-y-6 lg:w-7/12">
                <!-- Filter & Action Buttons -->
                <form method="GET" action="{{ route('dashboard') }}" class="mb-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <select name="filter" onchange="this.form.submit()"
                            class="rounded-md border border-gray-300 px-4 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="daily" {{ $filter == 'daily' ? 'selected' : '' }}>
                                Per Hari
                            </option>
                            <option value="weekly" {{ $filter == 'weekly' ? 'selected' : '' }}>
                                Per Minggu
                            </option>
                            <option value="monthly" {{ $filter == 'monthly' ? 'selected' : '' }}>
                                Per Bulan
                            </option>
                            <option value="yearly" {{ $filter == 'yearly' ? 'selected' : '' }}>
                                Per Tahun
                            </option>
                        </select>
                        <div class="relative inline-block text-left">
                            <div>
                                <button type="button" onclick="toggleDownloadDropdown(event)"
                                    class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow transition hover:bg-indigo-700">
                                    Download
                                    <svg class="-mr-1 ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 20 20" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7l3-3 3 3m0 6l-3 3-3-3" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Dropdown menu -->
                            <div id="downloadDropdown"
                                class="absolute right-0 z-10 mt-2 hidden w-64 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                                <div class="py-1">
                                    <button type="button" onclick="downloadChartAsPDF()"
                                        class="w-full rounded px-4 py-2 text-left text-sm font-medium text-black no-underline transition hover:bg-gray-100">
                                        Download PDF
                                    </button>
                                    <button type="button" onclick="downloadChartAsExcel()"
                                        class="mt-1 w-full rounded px-4 py-2 text-left text-sm font-medium text-black no-underline transition hover:bg-gray-100">
                                        Download Excel
                                    </button>
                                    <button type="button" onclick="downloadAllCharts()"
                                        class="mt-1 w-full rounded px-4 py-2 text-left text-sm font-medium text-black no-underline transition hover:bg-gray-100">
                                        Download Semua (PDF)
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Sales Charts -->
                @foreach ([['title' => 'Penjualan per Hari', 'id' => 'salesDayChart', 'wrapper' => 'salesChartWrapperDay'], ['title' => 'Penjualan per Minggu', 'id' => 'salesWeekChart', 'wrapper' => 'salesChartWrapperWeek'], ['title' => 'Penjualan per Bulan', 'id' => 'sales6MonthsChart', 'wrapper' => 'salesChartWrapperMonth'], ['title' => 'Penjualan per Tahun', 'id' => 'salesYearChart', 'wrapper' => 'salesChartWrapperYear']] as $chart)
                    <div class="rounded-xl bg-white p-4 shadow">
                        <h3 class="mb-2 text-lg font-semibold text-gray-800">
                            {{ $chart['title'] }}
                        </h3>
                        <div id="{{ $chart['wrapper'] }}" class="relative h-[300px] w-full md:h-[400px]">
                            <canvas id="{{ $chart['id'] }}" class="h-full w-full"></canvas>
                        </div>
                    </div>
                @endforeach
            </section>

            <div id="pdfExportArea" style="display: none; padding: 20px; font-family: Arial, sans-serif">
                <h2 style="text-align: center; margin-bottom: 20px">{{ $title }}</h2>
                <div
                    style="
                        display: flex;
                        gap: 20px;
                        align-items: flex-start;
                        justify-content: space-between;
                    ">
                    <!-- Tabel Penjualan -->
                    <table style="border-collapse: collapse; width: 35%; font-size: 11px">
                        <thead>
                            <tr style="background-color: #f2f2f2">
                                <th style="border: 1px solid #ddd; padding: 8px">Produk</th>
                                @foreach ($labels as $label)
                                    <th style="border: 1px solid #ddd; padding: 8px">
                                        {{ $label }}
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($values as $row)
                                <tr>
                                    <td style="border: 1px solid #ddd; padding: 8px">
                                        {{ $row['label'] }}
                                    </td>
                                    @foreach ($row['data'] as $val)
                                        <td
                                            style="
                                                border: 1px solid #ddd;
                                                padding: 8px;
                                                text-align: center;
                                            ">
                                            {{ $val }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Grafik Chart -->
                    <div style="width: 40%">
                        <canvas id="pdfChart" width="430" height="350"></canvas>
                    </div>
                </div>
            </div>

            <!-- Export Semua Grafik & Data -->
            <div id="pdfExportAll"
                style="
                    display: none;
                    padding: 20px;
                    font-family: Arial, sans-serif;
                    font-size: 11px;
                ">
                <h2 style="text-align: center; margin-bottom: 20px">
                    Laporan Lengkap - Sistem Inventory
                </h2>

                {{-- === Data Produk === --}}
                <h4>Stok Produk</h4>
                <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; margin-bottom: 20px">
                    <thead style="background: #f2f2f2">
                        <tr>
                            <th>Produk</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productNames as $i => $name)
                            <tr>
                                <td>{{ $name }}</td>
                                <td>{{ $productStocks[$i] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- === Produk Masuk === --}}
                <h4>Produk Masuk</h4>
                <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; margin-bottom: 20px">
                    <thead style="background: #f2f2f2">
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($inLabels as $i => $name)
                            <tr>
                                <td>{{ $name }}</td>
                                <td>{{ $inQtys[$i] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- === Produk Keluar === --}}
                <h4>Produk Keluar</h4>
                <table border="1" cellpadding="5" cellspacing="0" style="width: 100%; margin-bottom: 20px">
                    <thead style="background: #f2f2f2">
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah Keluar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($outLabels as $i => $name)
                            <tr>
                                <td>{{ $name }}</td>
                                <td>{{ $outQtys[$i] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- === Penjualan Harian - Chart + Tabel === --}}
                <h4>Penjualan per Hari</h4>
                @include('partials.export-section', [
                    'labels' => $dailyLabels,
                    'values' => $dailyValues,
                    'chartId' => 'chartExportDaily',
                ])

                {{-- === Penjualan Mingguan - Chart + Tabel === --}}
                <h4>Penjualan per Minggu</h4>
                @include('partials.export-section', [
                    'labels' => $weekLabels,
                    'values' => $weekValues,
                    'chartId' => 'chartExportWeek',
                ])

                {{-- === Penjualan Bulanan - Chart + Tabel === --}}
                <h4>Penjualan per Bulan</h4>
                @include('partials.export-section', [
                    'labels' => $monthLabels,
                    'values' => $monthValues,
                    'chartId' => 'chartExportMonth',
                ])

                {{-- === Penjualan Tahunan - Chart + Tabel === --}}
                <h4>Penjualan per Tahun</h4>
                @include('partials.export-section', [
                    'labels' => $yearLabels,
                    'values' => $yearValues,
                    'chartId' => 'chartExportYear',
                ])
            </div>

            <!-- Right Column (Produk) -->
            <section class="w-full space-y-6 lg:w-5/12">
                <!-- Product Charts -->
                @foreach ([['title' => 'Data Produk', 'id' => 'productChart'], ['title' => 'Produk Masuk', 'id' => 'productInChart'], ['title' => 'Produk Keluar', 'id' => 'productOutChart']] as $product)
                    <div class="rounded-xl bg-white p-4 shadow">
                        <h3 class="mb-2 text-lg font-semibold text-gray-800">
                            {{ $product['title'] }}
                        </h3>
                        <div class="relative h-[300px] w-full md:h-[400px]">
                            <canvas id="{{ $product['id'] }}" class="h-full w-full"></canvas>
                        </div>
                    </div>
                @endforeach
            </section>

        </div>
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        function downloadAllCharts() {
            const chartConfigs = [{
                    id: 'chartExportDaily',
                    labels: @json($dailyLabels),
                    datasets: @json($dailyValues),
                },
                {
                    id: 'chartExportWeek',
                    labels: @json($weekLabels),
                    datasets: @json($weekValues),
                },
                {
                    id: 'chartExportMonth',
                    labels: @json($monthLabels),
                    datasets: @json($monthValues),
                },
                {
                    id: 'chartExportYear',
                    labels: @json($yearLabels),
                    datasets: @json($yearValues),
                },
            ]

            chartConfigs.forEach((cfg) => {
                const ctx = document.getElementById(cfg.id).getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: cfg.labels,
                        datasets: cfg.datasets.map((d, i) => ({
                            ...d,
                            backgroundColor: generateColors(cfg.datasets.length)[i],
                        })),
                    },
                    options: {
                        responsive: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                            },
                        },
                    },
                })
            })

            setTimeout(() => {
                const element = document.getElementById('pdfExportAll');
                element.style.display = 'block'
                html2pdf()
                    .from(element)
                    .set({
                        margin: 0.4,
                        filename: 'Laporan-Sistem-Inventory.pdf',
                        html2canvas: {
                            scale: 2,
                            // useCORS: true
                        },
                        jsPDF: {
                            orientation: 'landscape',
                            unit: 'cm',
                            format: 'A3',
                        },
                    })
                    .save()
                    .then(() => {
                        element.style.display = 'none'
                    })
            }, 800) // beri delay agar chart sempat render
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // ✅ Fungsi download PDF grafik
            window.downloadChartAsPDF = function() {
                const labels = {!! json_encode($labels ?? []) !!};
                const values = {!! json_encode($values ?? []) !!};
                const title = {!! json_encode($title ?? 'Laporan Penjualan') !!};

                const ctx = document.getElementById('pdfChart').getContext('2d');

                // Hapus chart lama jika ada
                if (window.pdfChartInstance) {
                    window.pdfChartInstance.destroy();
                }

                // Buat chart baru untuk export PDF
                window.pdfChartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: values,
                    },
                    options: {
                        responsive: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            title: {
                                display: false
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            },
                        },
                    },
                });

                // Tampilkan dan convert jadi PDF
                setTimeout(() => {
                    const element = document.getElementById('pdfExportArea');
                    element.style.display = 'block';

                    const now = new Date().toLocaleDateString('id-ID', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                    });

                    html2pdf()
                        .from(element)
                        .set({
                            margin: 0.3,
                            filename: title + ' - ' + now + '.pdf',
                            html2canvas: {
                                scale: 2
                            },
                            jsPDF: {
                                orientation: 'landscape'
                            },
                        })
                        .save()
                        .then(() => {
                            element.style.display = 'none';
                        });
                }, 500); // beri jeda agar chart sempat render
            };

            // ✅ Fungsi download Excel grafik
            window.downloadChartAsExcel = function() {
                const labels = {!! json_encode($labels ?? []) !!};
                const values = {!! json_encode($values ?? []) !!};
                const title = {!! json_encode($title ?? 'Laporan Penjualan') !!};

                const wb = XLSX.utils.book_new();
                const wsData = [
                    ['Produk', ...labels]
                ];

                values.forEach((ds) => {
                    wsData.push([ds.label, ...ds.data]);
                });

                const ws = XLSX.utils.aoa_to_sheet(wsData);
                XLSX.utils.book_append_sheet(wb, ws, 'Data Penjualan');
                XLSX.writeFile(wb, title + '.xlsx');
            };

        });
    </script>


    <script>
        // === Generate Dynamic Warna Berdasarkan Index ===
        function generateColors(count, alpha = 0.6) {
            const colors = []
            for (let i = 0; i < count; i++) {
                const hue = (i * 50) % 360
                colors.push(`hsl(${hue}, 70%, 60%, ${alpha})`)
            }
            return colors
        }

        // === Chart Config Helper ===
        function createBarChart(ctxId, labels, datasets) {
            const ctx = document.getElementById(ctxId).getContext('2d')
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: datasets,
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        },
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            })
        }

        function createDonutChart(ctxId, labels, data) {
            const ctx = document.getElementById(ctxId).getContext('2d')
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Stok Produk',
                        data: data,
                        backgroundColor: generateColors(data.length),
                    }, ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        },
                    },
                },
            })
        }

        // === 🧩 Data from backend ===
        const productNames = @json($productNames ?? []);
        const productStocks = @json($productStocks ?? []);
        const inLabels = @json($inLabels ?? []);
        const inQtys = @json($inQtys ?? []);
        const outLabels = @json($outLabels ?? []);
        const outQtys = @json($outQtys ?? []);
        const dailyLabels = @json($dailyLabels ?? []);
        const dailyValues = @json($dailyValues ?? []);
        const weekLabels = @json($weekLabels ?? []);
        const weekValues = @json($weekValues ?? []);
        const monthLabels = @json($monthLabels ?? []);
        const monthValues = @json($monthValues ?? []);
        const yearLabels = @json($yearLabels ?? []);
        const yearValues = @json($yearValues ?? []);

        // === Render All Charts ===

        // 1. Donut Chart - Stok Produk
        createDonutChart('productChart', productNames, productStocks)

        // 2. Bar Chart - Produk Masuk
        createBarChart('productInChart', inLabels, [{
            label: 'Produk Masuk',
            data: inQtys,
            backgroundColor: 'rgba(255, 206, 86, 0.7)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1,
        }, ])

        // 3. Bar Chart - Produk Keluar
        createBarChart('productOutChart', outLabels, [{
            label: 'Produk Keluar',
            data: outQtys,
            backgroundColor: 'rgba(255, 99, 132, 0.6)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1,
        }, ])

        // 4. Bar Chart - Penjualan Harian (by Produk)
        // dailyValues = array of dataset per produk
        dailyValues.forEach((d, i) => (d.backgroundColor = generateColors(dailyValues.length)[i]))
        createBarChart('salesDayChart', dailyLabels, dailyValues)

        // 5. Bar Chart - Penjualan Mingguan (by Produk)
        weekValues.forEach((d, i) => (d.backgroundColor = generateColors(weekValues.length)[i]))
        createBarChart('salesWeekChart', weekLabels, weekValues)

        // 6. Bar Chart - Penjualan Bulanan (by Produk)
        monthValues.forEach((d, i) => (d.backgroundColor = generateColors(monthValues.length)[i]))
        createBarChart('sales6MonthsChart', monthLabels, monthValues)

        // 7. Bar Chart - Penjualan Tahunan (by Produk)
        yearValues.forEach((d, i) => (d.backgroundColor = generateColors(yearValues.length)[i]))
        createBarChart('salesYearChart', yearLabels, yearValues)
    </script>

    <script>
        function toggleDownloadDropdown(event) {
            event.stopPropagation() // Cegah dropdown langsung tertutup
            const dropdown = document.getElementById('downloadDropdown')
            dropdown.classList.toggle('hidden')
        }

        // Tutup dropdown jika klik di luar
        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('downloadDropdown')
            if (
                !document.getElementById('downloadDropdown').contains(e.target) &&
                !e.target.closest('button[onclick^="toggleDownloadDropdown"]')
            ) {
                dropdown.classList.add('hidden')
            }
        })
    </script>
@endpush
