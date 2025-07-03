@extends('layouts.master')
@section('title')
    <title>Sistem Inventory Iyan | Dashboard</title>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header py-5 bg-light rounded">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="mb-0 text-black">Dashboard</h1>
                </div>
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-decoration-none text-secondary">
                                    <i class="fa fa-dashboard"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>{{ $totalProduk }}</h3>
                        <p>Data Produk</p>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-orange">
                    <div class="inner">
                        <h3>{{ $produkMasuk }}</h3>
                        <p>Produk Masuk</p>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ $produkKeluar }}</h3>
                        <p>Produk Keluar</p>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $totalUser }}</h3>
                        <p>Pengguna</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">
                <form method="GET" action="{{ route('dashboard') }}" class="mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <select name="filter" onchange="this.form.submit()" class="form-select w-auto">
                            <option value="daily" {{ $filter == 'daily' ? 'selected' : '' }}>Per Hari</option>
                            <option value="weekly" {{ $filter == 'weekly' ? 'selected' : '' }}>Per Minggu</option>
                            <option value="monthly" {{ $filter == 'monthly' ? 'selected' : '' }}>Per Bulan</option>
                            <option value="yearly" {{ $filter == 'yearly' ? 'selected' : '' }}>Per Tahun</option>
                        </select>

                        <button type="button" onclick="downloadChartAsPDF()" class="btn btn-sm btn-danger">Download
                            PDF</button>
                        <button type="button" onclick="downloadChartAsExcel()" class="btn btn-sm btn-success">Download
                            Excel</button>
                    </div>
                </form>

                <!-- Sales Graph per Day -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Penjualan per Hari</h3>
                    </div>
                    <div class="box-body" id="salesChartWrapperDay">
                        <canvas id="salesDayChart" height="200"></canvas>
                    </div>
                </div>


                <!-- Sales Graph per Week -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Penjualan per Minggu</h3>
                    </div>
                    <div class="box-body" id="salesChartWrapperWeek">
                        <canvas id="salesWeekChart" height="200"></canvas>
                    </div>
                </div>

                <!-- Sales Graph per 6 Months -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Penjualan per Bulan</h3>
                    </div>
                    <div class="box-body" id="salesChartWrapperMonth">
                        <canvas id="sales6MonthsChart" height="200"></canvas>
                    </div>
                </div>

                <!-- Sales Graph per Year -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Penjualan per Tahun</h3>
                    </div>
                    <div class="box-body" id="salesChartWrapperYear">
                        <canvas id="salesYearChart" height="200"></canvas>
                    </div>
                </div>
            </section>
            <!-- /.Left col -->

            <!-- PDF Content (Hidden Only for Download) -->
            <!-- Hidden PDF Export Area -->
            <div id="pdfExportArea" style="display:none; padding: 20px; font-family: Arial, sans-serif;">
                <h2 style="text-align: center; margin-bottom: 20px;">{{ $title }}</h2>
                <div style="display: flex; gap: 20px; align-items: flex-start; justify-content: space-between;">
                    <!-- Tabel Penjualan -->
                    <table style="border-collapse: collapse; width: 35%; font-size: 11px;">
                        <thead>
                            <tr style="background-color: #f2f2f2;">
                                <th style="border: 1px solid #ddd; padding: 8px;">Produk</th>
                                @foreach ($labels as $label)
                                    <th style="border: 1px solid #ddd; padding: 8px;">{{ $label }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($values as $row)
                                <tr>
                                    <td style="border: 1px solid #ddd; padding: 8px;">{{ $row['label'] }}</td>
                                    @foreach ($row['data'] as $val)
                                        <td style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                                            {{ $val }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Grafik Chart -->
                    <div style="width: 40%;">
                        <canvas id="pdfChart" width="430" height="350"></canvas>
                    </div>
                </div>
            </div>


            <!-- Right col (Products, Product In, Product Out) -->
            <section class="col-lg-5 connectedSortable">
                <!-- Product Graph -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Data Produk</h3>
                    </div>
                    <div class="box-body">
                        <canvas id="productChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Product In Graph -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Produk Masuk</h3>
                    </div>
                    <div class="box-body">
                        <canvas id="productInChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Product Out Graph -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Produk Keluar</h3>
                    </div>
                    <div class="box-body">
                        <canvas id="productOutChart" height="300"></canvas>
                    </div>
                </div>
            </section>
            <!-- /.Right col -->
        </div>
        <!-- /.row (main row) -->
    </section>
    <!-- /.content -->
@endsection


@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>


    <script>
        function downloadChartAsPDF() {
            const labels = @json($labels);
            const values = @json($values);
            const title = @json($title);

            const ctx = document.getElementById('pdfChart').getContext('2d');

            // Hapus chart sebelumnya kalau ada
            if (window.pdfChartInstance) {
                window.pdfChartInstance.destroy();
            }

            window.pdfChartInstance = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: values
                },
                options: {
                    responsive: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        title: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Tampilkan elemen export dan render PDF
            setTimeout(() => {
                const element = document.getElementById('pdfExportArea');
                element.style.display = 'block';

                const now = new Date().toLocaleDateString('id-ID', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

                html2pdf().from(element).set({
                    margin: 0.3,
                    filename: title + ' - ' + now + '.pdf',
                    html2canvas: {
                        scale: 2
                    },
                    jsPDF: {
                        orientation: 'landscape'
                    }
                }).save().then(() => {
                    element.style.display = 'none';
                });
            }, 500);
        }



        function downloadChartAsExcel() {
            const wb = XLSX.utils.book_new();
            const wsData = [
                ['Produk', ...@json($labels)]
            ];

            @json($values).forEach(ds => {
                wsData.push([ds.label, ...ds.data]);
            });

            const ws = XLSX.utils.aoa_to_sheet(wsData);
            XLSX.utils.book_append_sheet(wb, ws, "Data Penjualan");
            XLSX.writeFile(wb, '{{ $title }}.xlsx');
        }
    </script>


    <script>
        // === 🎨 Generate Dynamic Warna Berdasarkan Index ===
        function generateColors(count, alpha = 0.6) {
            const colors = [];
            for (let i = 0; i < count; i++) {
                const hue = (i * 50) % 360;
                colors.push(`hsl(${hue}, 70%, 60%, ${alpha})`);
            }
            return colors;
        }

        // === 📊 Chart Config Helper ===
        function createBarChart(ctxId, labels, datasets) {
            const ctx = document.getElementById(ctxId).getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function createDonutChart(ctxId, labels, data) {
            const ctx = document.getElementById(ctxId).getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Stok Produk',
                        data: data,
                        backgroundColor: generateColors(data.length)
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
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

        // === 📈 Render All Charts ===

        // 1. Donut Chart - Stok Produk
        createDonutChart('productChart', productNames, productStocks);

        // 2. Bar Chart - Produk Masuk
        createBarChart('productInChart', inLabels, [{
            label: 'Produk Masuk',
            data: inQtys,
            backgroundColor: 'rgba(255, 206, 86, 0.7)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1
        }]);

        // 3. Bar Chart - Produk Keluar
        createBarChart('productOutChart', outLabels, [{
            label: 'Produk Keluar',
            data: outQtys,
            backgroundColor: 'rgba(255, 99, 132, 0.6)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]);

        // 4. Bar Chart - Penjualan Harian (by Produk)
        // dailyValues = array of dataset per produk
        dailyValues.forEach((d, i) => d.backgroundColor = generateColors(dailyValues.length)[i]);
        createBarChart('salesDayChart', dailyLabels, dailyValues);

        // 5. Bar Chart - Penjualan Mingguan (by Produk)
        weekValues.forEach((d, i) => d.backgroundColor = generateColors(weekValues.length)[i]);
        createBarChart('salesWeekChart', weekLabels, weekValues);

        // 6. Bar Chart - Penjualan Bulanan (by Produk)
        monthValues.forEach((d, i) => d.backgroundColor = generateColors(monthValues.length)[i]);
        createBarChart('sales6MonthsChart', monthLabels, monthValues);

        // 7. Bar Chart - Penjualan Tahunan (by Produk)
        yearValues.forEach((d, i) => d.backgroundColor = generateColors(yearValues.length)[i]);
        createBarChart('salesYearChart', yearLabels, yearValues);
    </script>
@endsection
