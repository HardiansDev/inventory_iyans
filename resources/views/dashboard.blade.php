@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID</title>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="mb-6 rounded-xl bg-white dark:bg-gray-900 p-6 shadow-md transition-colors duration-300">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">

            <!-- Title -->
            <div class="flex flex-col gap-1">
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white leading-tight">
                    Dashboard
                </h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Selamat datang di sistem manajemen ERP Anda
                </p>
            </div>
        </div>
    </section>



    <!-- Main content -->
    <section class="content">
        <div class="mt-6 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 items-stretch">
            <!-- Card -->
            <div
                class="rounded-xl bg-gradient-to-r from-teal-400 to-teal-600 p-5 text-white shadow flex items-center gap-4 h-full">
                <i class="fas fa-wallet text-3xl opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">Rp {{ number_format($totalModal, 0, ',', '.') }}</div>
                    <div class="mt-1 text-sm">Total Modal</div>
                </div>
            </div>

            <div
                class="rounded-xl bg-gradient-to-r from-blue-400 to-blue-600 p-5 text-white shadow flex items-center gap-4 h-full">
                <i class="fas fa-boxes text-3xl opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">{{ $totalProduk }}</div>
                    <div class="mt-1 text-sm">Data Produk</div>
                </div>
            </div>

            <div
                class="rounded-xl bg-gradient-to-r from-emerald-400 to-emerald-600 p-5 text-white shadow flex items-center gap-4 h-full">
                <i class="fas fa-truck-loading text-3xl opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">{{ $produkMasuk }}</div>
                    <div class="mt-1 text-sm">Total Produk Masuk</div>
                </div>
            </div>

            <div
                class="rounded-xl bg-gradient-to-r from-rose-400 to-rose-600 p-5 text-white shadow flex items-center gap-4 h-full">
                <i class="fas fa-dolly text-3xl opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">{{ $produkKeluar }}</div>
                    <div class="mt-1 text-sm">Total Produk Keluar</div>
                </div>
            </div>

            <div
                class="rounded-xl bg-gradient-to-r from-green-400 to-green-600 p-5 text-white shadow flex items-center gap-4 h-full">
                <i class="fas fa-users text-3xl opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">{{ $totalUser }}</div>
                    <div class="mt-1 text-sm">Pengguna</div>
                </div>
            </div>

            <div
                class="rounded-xl bg-gradient-to-r from-indigo-400 to-indigo-600 p-5 text-white shadow flex items-center gap-4 h-full">
                <i class="fas fa-cash-register text-3xl opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}</div>
                    <div class="mt-1 text-sm">Pendapatan Hari Ini</div>
                </div>
            </div>

            <div
                class="rounded-xl bg-gradient-to-r from-emerald-400 to-emerald-600 p-5 text-white shadow flex items-center gap-4 h-full">
                <i class="fas fa-coins text-3xl opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">Rp {{ number_format($keuntunganHariIni, 0, ',', '.') }}</div>
                    <div class="mt-1 text-sm">Keuntungan Hari Ini</div>
                </div>
            </div>

            <div
                class="rounded-xl bg-gradient-to-r from-cyan-400 to-cyan-600 p-5 text-white shadow flex items-center gap-4 h-full">
                <i class="fas fa-receipt text-3xl opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">{{ $transaksiHariIni }}</div>
                    <div class="mt-1 text-sm">Transaksi Hari Ini</div>
                </div>
            </div>

            <div
                class="rounded-xl bg-gradient-to-r from-teal-400 to-teal-600 p-5 text-white shadow flex items-center gap-4 h-full">
                <i class="fas fa-user-check text-3xl opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">{{ $pegawaiAktif }}</div>
                    <div class="mt-1 text-sm">Pegawai Aktif</div>
                </div>
            </div>

            <div
                class="rounded-xl bg-gradient-to-r from-gray-400 to-gray-600 p-5 text-white shadow flex items-center gap-4 h-full">
                <i class="fas fa-user-slash text-3xl opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">{{ $pegawaiTidakAktif }}</div>
                    <div class="mt-1 text-sm">Pegawai Tidak Aktif</div>
                </div>
            </div>
        </div>


        <!-- Main Dashboard Row -->
        <div class="mt-6 mb-6 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">

            <!-- Judul -->
            <h2 class="text-xl lg:text-2xl font-semibold text-gray-800 dark:text-white">
                Data Statistik
            </h2>

            <!-- Tools: Date Range, Reset, Export -->
            <div class="flex flex-wrap items-center gap-3 lg:gap-4">

                <!-- Date Range Picker + Reset -->
                <div class="flex items-center gap-2">
                    <div id="date-range-picker" date-rangepicker class="flex items-center gap-2">

                        <!-- Start Date -->
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="datepicker-range-start" name="start" type="text"
                                class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 placeholder-gray-400 dark:placeholder-gray-400"
                                placeholder="Tanggal awal">
                        </div>

                        <span class="mx-1 text-gray-500 dark:text-gray-400 font-medium">-</span>

                        <!-- End Date -->
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="datepicker-range-end" name="end" type="text"
                                class="bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 placeholder-gray-400 dark:placeholder-gray-400"
                                placeholder="Tanggal akhir">
                        </div>
                    </div>

                    <!-- Reset Button -->
                    <button type="button" onclick="resetDateRange()"
                        class="inline-flex items-center text-sm px-4 py-2 rounded-lg bg-gray-500 hover:bg-gray-600 text-white font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400">
                        <i class="fas fa-redo-alt mr-2"></i> Reset
                    </button>
                </div>

                <!-- Export Dropdown -->
                <div class="relative">
                    <button id="dropdownButton" data-dropdown-toggle="dropdownExport"
                        class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-colors duration-200">
                        <i class="fas fa-file-export mr-2"></i> Export
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div id="dropdownExport"
                        class="z-10 hidden w-44 rounded-lg bg-white shadow dark:bg-gray-700 dark:divide-gray-600 absolute right-0 mt-2">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownButton">
                            <li>
                                <a href="#" onclick="exportToPDF(); return false;"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    Export PDF
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>


        <!-- GRAFIK TREN PENJUALAN & DONAT + TABEL TRANSAKSI HARI INI -->
        <div class="w-full mt-6 flex flex-col lg:flex-row gap-6">

            <!-- KIRI: Grafik Penjualan + Tabel Aktivitas -->
            <div class="w-full lg:w-2/3 flex flex-col gap-6">

                <!-- TABS PENJUALAN -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 transition-colors duration-200">
                    <h4 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Trend Penjualan</h4>

                    <!-- Tabs Navigation + Export -->
                    <div
                        class="mb-4 border-b border-gray-200 dark:border-gray-700 flex flex-col lg:flex-row lg:items-center justify-between gap-3 lg:gap-0">

                        <!-- Tabs -->
                        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center gap-2 lg:gap-0" id="chartTabs"
                            role="tablist">
                            <li>
                                <button
                                    class="inline-block p-3 border-b-2 rounded-t-lg active text-blue-600 border-blue-600"
                                    id="tab-day" data-tabs-target="#tab-content-day" type="button" role="tab"
                                    aria-controls="tab-content-day" aria-selected="true">
                                    Harian
                                </button>
                            </li>
                            <li>
                                <button class="inline-block p-3 border-b-2 rounded-t-lg text-gray-600 dark:text-gray-300"
                                    id="tab-week" data-tabs-target="#tab-content-week" type="button" role="tab"
                                    aria-controls="tab-content-week" aria-selected="false">
                                    Mingguan
                                </button>
                            </li>
                            <li>
                                <button class="inline-block p-3 border-b-2 rounded-t-lg text-gray-600 dark:text-gray-300"
                                    id="tab-month" data-tabs-target="#tab-content-month" type="button" role="tab"
                                    aria-controls="tab-content-month" aria-selected="false">
                                    Bulanan
                                </button>
                            </li>
                            <li>
                                <button class="inline-block p-3 border-b-2 rounded-t-lg text-gray-600 dark:text-gray-300"
                                    id="tab-year" data-tabs-target="#tab-content-year" type="button" role="tab"
                                    aria-controls="tab-content-year" aria-selected="false">
                                    Tahunan
                                </button>
                            </li>
                        </ul>

                        <!-- Export Buttons -->
                        <div class="flex gap-2 mt-3 lg:mt-0">
                            <button id="export-current"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition flex items-center gap-2 text-sm">
                                <i class="fa-solid fa-download text-base"></i>
                                <span>Export Harian</span>
                            </button>
                            <button id="export-all"
                                class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 transition flex items-center gap-2 text-sm">
                                <i class="fa-solid fa-download text-base"></i>
                                Export Semua
                            </button>
                        </div>
                    </div>

                    <!-- Tabs Content -->
                    <div id="chart-tabs-content">
                        <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm" id="tab-content-day">
                            <canvas id="chart-day" class="w-full h-80"></canvas>
                        </div>
                        <div class="hidden p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm" id="tab-content-week">
                            <canvas id="chart-week" class="w-full h-80"></canvas>
                        </div>
                        <div class="hidden p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm" id="tab-content-month">
                            <canvas id="chart-month" class="w-full h-80"></canvas>
                        </div>
                        <div class="hidden p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm" id="tab-content-year">
                            <canvas id="chart-year" class="w-full h-80"></canvas>
                        </div>
                    </div>
                </div>

                <!-- TABEL AKTIVITAS TRANSAKSI HARI INI -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 transition-colors duration-200">
                    <h4 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">
                        Aktivitas Transaksi Hari Ini
                    </h4>
                    <div class="overflow-x-auto rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm text-left">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-gray-700 dark:text-gray-200">Waktu</th>
                                    <th class="px-4 py-2 text-gray-700 dark:text-gray-200">Produk</th>
                                    <th class="px-4 py-2 text-gray-700 dark:text-gray-200">Qty</th>
                                    <th class="px-4 py-2 text-gray-700 dark:text-gray-200">Metode Pembayaran</th>
                                    <th class="px-4 py-2 text-right text-gray-700 dark:text-gray-200">Total</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse ($aktivitasHariIni as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                        <td class="px-4 py-2">
                                            {{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }}
                                        </td>
                                        <td class="px-4 py-2">{{ $item->product_name }}</td>
                                        <td class="px-4 py-2">{{ $item->qty }}</td>
                                        <td class="px-4 py-2">{{ $item->metode_pembayaran }}</td>
                                        <td class="px-4 py-2 text-right">
                                            Rp {{ number_format($item->total, 0, ',', '.') }}
                                            @if ($item->discount > 0)
                                                <br>
                                                <span
                                                    class="text-xs text-green-600 dark:text-green-400">(-{{ $item->discount }}%)</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-gray-500 dark:text-gray-400 py-4">
                                            Belum ada transaksi hari ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $aktivitasHariIni->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>

                <!-- Performa Kasir Hari Ini -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-5 transition-colors duration-200">
                    <h4 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Performa Kasir Hari Ini</h4>
                    <div class="overflow-x-auto rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm text-left">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 font-bold">Kasir</th>
                                    <th class="px-6 py-3 font-bold text-center">Melakukan Transaksi</th>
                                    <th class="px-6 py-3 font-bold text-right">Total Penjualan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($performaKasirHariIni as $kasir)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                        <td class="px-4 py-2">{{ $kasir->kasir }}</td>
                                        <td class="px-4 py-2 text-center">{{ $kasir->transaksi }}</td>
                                        <td class="px-4 py-2 text-right">Rp
                                            {{ number_format($kasir->total_penjualan, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-gray-500 dark:text-gray-400 py-4">
                                            Belum ada transaksi dari kasir hari ini
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- KANAN: Donut Chart -->
            <div class="w-full lg:w-1/3 flex flex-col gap-6">

                <!-- Produk Terjual -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 transition-colors duration-200">
                    <h4 class="text-center text-sm font-semibold mb-2 text-gray-800 dark:text-gray-100">Produk Terjual</h4>
                    <canvas id="donut-product-sold" class="w-full h-60"></canvas>
                </div>

                <!-- Produk Masuk -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 transition-colors duration-200">
                    <h4 class="text-center text-sm font-semibold mb-2 text-gray-800 dark:text-gray-100">Produk Masuk</h4>
                    <canvas id="donut-product-in" class="w-full h-60"></canvas>
                </div>

            </div>
        </div>




    </section>
@endsection

@push('scripts')
    <script>
        let chartDay, chartWeek, chartMonth, chartYear;

        function initChartDay() {
            const ctx = document.getElementById("chart-day").getContext("2d");
            if (chartDay) chartDay.destroy();

            chartDay = new Chart(ctx, {
                type: "line",
                data: {
                    labels: @json($dailyLabels),
                    datasets: [
                        @foreach ($dailyByProduct as $dataset)
                            {!! json_encode($dataset) !!},
                        @endforeach
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
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

        function initChartWeek() {
            const ctx = document.getElementById("chart-week").getContext("2d");
            if (chartWeek) chartWeek.destroy();

            chartWeek = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: @json($weekLabels),
                    datasets: [
                        @foreach ($weeklyByProduct as $dataset)
                            {!! json_encode($dataset) !!},
                        @endforeach
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
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

        function initChartMonth() {
            const ctx = document.getElementById("chart-month").getContext("2d");
            if (chartMonth) chartMonth.destroy();

            chartMonth = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: @json($monthLabels),
                    datasets: [
                        @foreach ($monthlyByProduct as $dataset)
                            {!! json_encode($dataset) !!},
                        @endforeach
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }

        function initChartYear() {
            const ctx = document.getElementById("chart-year").getContext("2d");
            if (chartYear) chartYear.destroy();

            chartYear = new Chart(ctx, {
                type: "line",
                data: {
                    labels: @json($yearLabels),
                    datasets: [
                        @foreach ($yearlyByProduct as $dataset)
                            {!! json_encode($dataset) !!},
                        @endforeach
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        },

                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // === Tabs Handling ===
        const tabButtons = document.querySelectorAll('[data-tabs-target]');
        const tabContents = document.querySelectorAll('#chart-tabs-content > div');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-tabs-target');

                tabButtons.forEach(btn => btn.classList.remove("text-blue-600", "border-blue-600",
                    "active"));
                button.classList.add("text-blue-600", "border-blue-600", "active");

                tabContents.forEach(content => {
                    content.classList.add('hidden');

                    if ("#" + content.id === targetId) {
                        content.classList.remove('hidden');

                        // Render chart sesuai tab yang aktif
                        switch (targetId) {
                            case '#tab-content-day':
                                initChartDay();
                                break;
                            case '#tab-content-week':
                                initChartWeek();
                                break;
                            case '#tab-content-month':
                                initChartMonth();
                                break;
                            case '#tab-content-year':
                                initChartYear();
                                break;
                        }
                    }
                });
            });
        });

        // Render chart default saat halaman dimuat
        window.addEventListener('DOMContentLoaded', () => {
            initChartDay();
        });

        // Resize otomatis saat window diubah
        window.addEventListener('resize', () => {
            chartDay?.resize();
            chartWeek?.resize();
            chartMonth?.resize();
            chartYear?.resize();
            donutSold?.resize();
            donutIn?.resize();
        });


        // Definisikan variabel chart global
        let donutSold;
        let donutIn;

        // Donut Chart Produk Keluar (Terjual)
        const ctxSold = document.getElementById('donut-product-sold');
        if (donutSold) donutSold.destroy(); // Destroy jika chart sudah ada
        donutSold = new Chart(ctxSold, {
            type: 'doughnut',
            data: {
                labels: @json($outLabels),
                datasets: [{
                    data: @json($outQtys),
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
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

        // Donut Chart Produk Masuk
        const ctxIn = document.getElementById('donut-product-in');
        if (donutIn) donutIn.destroy(); // Destroy jika chart sudah ada
        donutIn = new Chart(ctxIn, {
            type: 'doughnut',
            data: {
                labels: @json($inLabels),
                datasets: [{
                    data: @json($inQtys),
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
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


        function resetDateRange() {
            const startInput = document.getElementById('datepicker-range-start');
            const endInput = document.getElementById('datepicker-range-end');

            if (startInput) startInput.value = '';
            if (endInput) endInput.value = '';

            // Kalau pakai Flowbite datepicker, perlu trigger event manual biar efek visualnya ikut ke-reset
            startInput.dispatchEvent(new Event('change'));
            endInput.dispatchEvent(new Event('change'));
        }

        function exportToPDF() {
            // Ambil nilai tanggal dari input datepicker
            const start = document.getElementById('datepicker-range-start').value;
            const end = document.getElementById('datepicker-range-end').value;

            if (!start || !end) {
                alert('Harap pilih tanggal awal dan akhir terlebih dahulu!');
                return;
            }

            // Buat URL dengan query param untuk route PDF kamu
            const url = new URL('{{ route('report.penjualan.pdf') }}', window.location.origin);
            url.searchParams.append('start', start);
            url.searchParams.append('end', end);

            // Buka URL di tab baru supaya user bisa download atau lihat PDF
            window.open(url.toString(), '_blank');
        }
    </script>




    <script>
        const {
            jsPDF
        } = window.jspdf;
        const exportBtn = document.getElementById("export-current");

        // Fungsi render chart ke PDF
        function renderChartToPDF(pdf, canvasId, title, addNewPage = false) {
            const canvas = document.getElementById(canvasId);
            if (!canvas) return;

            if (addNewPage) pdf.addPage();

            const imgData = canvas.toDataURL("image/png", 1.0);
            const pdfWidth = pdf.internal.pageSize.getWidth() - 20;
            const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

            pdf.setFontSize(14);
            pdf.text(title, 14, 20);
            pdf.addImage(imgData, "PNG", 10, 30, pdfWidth, pdfHeight);
        }

        // Fungsi update label export sesuai tab aktif
        function updateExportButtonLabel() {
            const activeTab = document.querySelector("#chart-tabs-content > div:not(.hidden)");
            if (!activeTab) return;

            const tabName = activeTab.id.replace("tab-content-", ""); // day, week, month, year
            let label = "Export";

            switch (tabName) {
                case "day":
                    label = "Export Harian";
                    break;
                case "week":
                    label = "Export Mingguan";
                    break;
                case "month":
                    label = "Export Bulanan";
                    break;
                case "year":
                    label = "Export Tahunan";
                    break;
            }

            exportBtn.querySelector("span").textContent = label;
        }

        // Inisialisasi label saat load
        updateExportButtonLabel();

        // Handle klik tab
        document.querySelectorAll("#chartTabs button").forEach(tab => {
            tab.addEventListener("click", () => {
                // Toggle class aktif
                document.querySelectorAll("#chartTabs button").forEach(t => {
                    t.classList.remove("active", "text-blue-600", "border-blue-600");
                    t.classList.add("text-gray-600", "dark:text-gray-300");
                });
                tab.classList.add("active", "text-blue-600", "border-blue-600");
                tab.classList.remove("text-gray-600", "dark:text-gray-300");

                // Toggle konten tab
                document.querySelectorAll("#chart-tabs-content > div").forEach(c => c.classList.add(
                    "hidden"));
                document.querySelector(tab.dataset.tabsTarget).classList.remove("hidden");

                // Update export label
                setTimeout(updateExportButtonLabel, 50);
            });
        });

        // Export tab aktif
        exportBtn.addEventListener("click", () => {
            const activeTab = document.querySelector("#chart-tabs-content > div:not(.hidden)");
            if (!activeTab) return alert("Tidak ada tab aktif");

            const canvas = activeTab.querySelector("canvas");
            if (!canvas) return alert("Tidak ada grafik di tab ini");

            const pdf = new jsPDF("p", "mm", "a4");
            const tabName = activeTab.id.replace("tab-content-", "");
            let title = "Laporan ";

            switch (tabName) {
                case "day":
                    title += "Harian";
                    break;
                case "week":
                    title += "Mingguan";
                    break;
                case "month":
                    title += "Bulanan";
                    break;
                case "year":
                    title += "Tahunan";
                    break;
                default:
                    title += tabName;
            }

            renderChartToPDF(pdf, canvas.id, title);
            pdf.save("laporan-" + tabName + ".pdf");
        });

        // Export semua tab
        document.getElementById("export-all").addEventListener("click", () => {
            const pdf = new jsPDF("p", "mm", "a4");
            const charts = [{
                    id: "chart-day",
                    title: "Laporan Harian"
                },
                {
                    id: "chart-week",
                    title: "Laporan Mingguan"
                },
                {
                    id: "chart-month",
                    title: "Laporan Bulanan"
                },
                {
                    id: "chart-year",
                    title: "Laporan Tahunan"
                }
            ];

            charts.forEach((chart, index) => {
                renderChartToPDF(pdf, chart.id, chart.title, index > 0);
            });

            pdf.save("laporan-semua.pdf");
        });
    </script>
@endpush
