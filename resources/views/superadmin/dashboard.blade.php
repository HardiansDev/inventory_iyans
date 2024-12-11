@extends('layouts.master')
@section('title')
    <title>Aplikasi Inventory | Dashboard</title>
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
                        <h3>0</h3>
                        <p>Data Product</p>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-navy">
                    <div class="inner">
                        <h3>0</h3>
                        <p>Data Customer</p>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-orange">
                    <div class="inner">
                        <h3>0</h3>
                        <p>Product In</p>
                    </div>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>0</h3>
                        <p>Product Out</p>
                    </div>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">
                <!-- Customer Graph -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Customer Growth</h3>
                    </div>
                    <div class="box-body">
                        <canvas id="customerGrowthChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Sales Graph per Week -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Sales per Week</h3>
                    </div>
                    <div class="box-body">
                        <canvas id="salesWeekChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Sales Graph per 6 Months -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Sales per 6 Months</h3>
                    </div>
                    <div class="box-body">
                        <canvas id="sales6MonthsChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Sales Graph per Year -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Sales per Year</h3>
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
                        <h3 class="box-title">Product Data</h3>
                    </div>
                    <div class="box-body">
                        <canvas id="productChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Product In Graph -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Product In</h3>
                    </div>
                    <div class="box-body">
                        <canvas id="productInChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Product Out Graph -->
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Product Out</h3>
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
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data for Customer Growth (Example)
        var customerGrowthData = {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Customer Growth',
                data: [12, 19, 3, 5, 2, 3, 15, 20, 25, 30, 35, 40],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        // Customer Growth Chart
        var ctx = document.getElementById('customerGrowthChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: customerGrowthData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Sales per Week Chart
        var salesWeekData = {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Sales per Week',
                data: [20, 30, 15, 25],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        };

        var ctx2 = document.getElementById('salesWeekChart').getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: salesWeekData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Sales per 6 Months Chart
        var sales6MonthsData = {
            labels: ['Jan-Jun', 'Jul-Dec'],
            datasets: [{
                label: 'Sales per 6 Months',
                data: [150, 300],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        var ctx3 = document.getElementById('sales6MonthsChart').getContext('2d');
        new Chart(ctx3, {
            type: 'line',
            data: sales6MonthsData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Sales per Year Chart
        var salesYearData = {
            labels: ['2021', '2022', '2023'],
            datasets: [{
                label: 'Sales per Year',
                data: [1000, 2000, 3000],
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        };

        var ctx4 = document.getElementById('salesYearChart').getContext('2d');
        new Chart(ctx4, {
            type: 'bar',
            data: salesYearData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Product Data Chart
        var productData = {
            labels: ['Product A', 'Product B', 'Product C'],
            datasets: [{
                label: 'Products',
                data: [10, 20, 30],
                backgroundColor: 'rgba(255, 159, 64, 0.2)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        };

        var ctx5 = document.getElementById('productChart').getContext('2d');
        new Chart(ctx5, {
            type: 'pie',
            data: productData
        });

        // Product In Chart
        var productInData = {
            labels: ['Jan', 'Feb', 'Mar'],
            datasets: [{
                label: 'Product In',
                data: [10, 20, 30],
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }]
        };

        var ctx6 = document.getElementById('productInChart').getContext('2d');
        new Chart(ctx6, {
            type: 'line',
            data: productInData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Product Out Chart
        var productOutData = {
            labels: ['Jan', 'Feb', 'Mar'],
            datasets: [{
                label: 'Product Out',
                data: [5, 15, 10],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        };

        var ctx7 = document.getElementById('productOutChart').getContext('2d');
        new Chart(ctx7, {
            type: 'bar',
            data: productOutData,
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
