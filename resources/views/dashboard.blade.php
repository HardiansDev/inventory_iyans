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
                <!-- Customer Graph -->
                {{-- <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Customer Growth</h3>
                    </div>
                    <div class="box-body">
                        <canvas id="customerGrowthChart" height="300"></canvas>
                    </div>
                </div> --}}

                <!-- Sales Graph per Week -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Penjualan per Minggu</h3>
                    </div>
                    <div class="box-body">
                        <canvas id="salesWeekChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Sales Graph per 6 Months -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Penjualan per Bulan</h3>
                    </div>
                    <div class="box-body">
                        <canvas id="sales6MonthsChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Sales Graph per Year -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Penjualan per Tahun</h3>
                    </div>
                    <div class="box-body">
                        <canvas id="salesYearChart" height="300"></canvas>
                    </div>
                </div>
            </section>
            <!-- /.Left col -->

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

    <script>
        const productNames = @json($productNames ?? []);
        const productStocks = @json($productStocks ?? []);
        const inLabels = @json($inLabels ?? []);
        const inQtys = @json($inQtys ?? []);
        const outLabels = @json($outLabels ?? []);
        const outQtys = @json($outQtys ?? []);
    </script>

    <script>
        // Product Chart
        var ctx5 = document.getElementById('productChart').getContext('2d');
        new Chart(ctx5, {
            type: 'bar',
            data: {
                labels: productNames,
                datasets: [{
                    label: 'Stok Produk',
                    data: productStocks,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Produk Masuk Chart
        var ctx6 = document.getElementById('productInChart').getContext('2d');
        new Chart(ctx6, {
            type: 'line',
            data: {
                labels: inLabels,
                datasets: [{
                    label: 'Produk Masuk',
                    data: inQtys,
                    backgroundColor: 'rgba(255, 206, 86, 0.5)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Produk Keluar Chart
        var ctx7 = document.getElementById('productOutChart').getContext('2d');
        new Chart(ctx7, {
            type: 'bar',
            data: {
                labels: outLabels,
                datasets: [{
                    label: 'Produk Keluar',
                    data: outQtys,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endsection
