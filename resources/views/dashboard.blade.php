@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID</title>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="p-6 mb-6 transition-colors duration-300 bg-white shadow-md rounded-xl dark:bg-gray-900">
        <div class="flex flex-col items-start justify-between gap-4 mx-auto max-w-7xl sm:flex-row sm:items-center">
            <!-- Title -->
            <div class="flex flex-col gap-1">
                <h1 class="text-3xl font-extrabold leading-tight text-gray-900 dark:text-white">
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
        <div class="grid items-stretch grid-cols-2 gap-6 mt-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <!-- Card -->
            <div
                class="flex items-center h-full gap-4 p-5 text-white shadow rounded-xl bg-gradient-to-r from-teal-400 to-teal-600">
                <i class="text-3xl fas fa-wallet opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">
                        Rp {{ number_format($totalModal, 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-sm">Total Modal</div>
                </div>
            </div>

            <div
                class="flex items-center h-full gap-4 p-5 text-white shadow rounded-xl bg-gradient-to-r from-blue-400 to-blue-600">
                <i class="text-3xl fas fa-boxes opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">{{ $totalProduk }}</div>
                    <div class="mt-1 text-sm">Data Produk</div>
                </div>
            </div>

            <div
                class="flex items-center h-full gap-4 p-5 text-white shadow rounded-xl bg-gradient-to-r from-emerald-400 to-emerald-600">
                <i class="text-3xl fas fa-truck-loading opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">{{ $produkMasuk }}</div>
                    <div class="mt-1 text-sm">Total Produk Masuk</div>
                </div>
            </div>

            <div
                class="flex items-center h-full gap-4 p-5 text-white shadow rounded-xl bg-gradient-to-r from-rose-400 to-rose-600">
                <i class="text-3xl fas fa-dolly opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">{{ $produkKeluar }}</div>
                    <div class="mt-1 text-sm">Total Produk Keluar</div>
                </div>
            </div>

            <div
                class="flex items-center h-full gap-4 p-5 text-white shadow rounded-xl bg-gradient-to-r from-green-400 to-green-600">
                <i class="text-3xl fas fa-users opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">{{ $totalUser }}</div>
                    <div class="mt-1 text-sm">Pengguna</div>
                </div>
            </div>

            <div
                class="flex items-center h-full gap-4 p-5 text-white shadow rounded-xl bg-gradient-to-r from-indigo-400 to-indigo-600">
                <i class="text-3xl fas fa-cash-register opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">
                        Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-sm">Pendapatan Hari Ini</div>
                </div>
            </div>

            <div
                class="flex items-center h-full gap-4 p-5 text-white shadow rounded-xl bg-gradient-to-r from-emerald-400 to-emerald-600">
                <i class="text-3xl fas fa-coins opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">
                        Rp {{ number_format($keuntunganHariIni, 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-sm">Keuntungan Hari Ini</div>
                </div>
            </div>

            <div
                class="flex items-center h-full gap-4 p-5 text-white shadow rounded-xl bg-gradient-to-r from-cyan-400 to-cyan-600">
                <i class="text-3xl fas fa-receipt opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">{{ $transaksiHariIni }}</div>
                    <div class="mt-1 text-sm">Transaksi Hari Ini</div>
                </div>
            </div>

            <div
                class="flex items-center h-full gap-4 p-5 text-white shadow rounded-xl bg-gradient-to-r from-teal-400 to-teal-600">
                <i class="text-3xl fas fa-user-check opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">{{ $pegawaiAktif }}</div>
                    <div class="mt-1 text-sm">Pegawai Aktif</div>
                </div>
            </div>

            <div
                class="flex items-center h-full gap-4 p-5 text-white shadow rounded-xl bg-gradient-to-r from-gray-400 to-gray-600">
                <i class="text-3xl fas fa-user-slash opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">{{ $pegawaiTidakAktif }}</div>
                    <div class="mt-1 text-sm">Pegawai Tidak Aktif</div>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Row -->
        <div class="flex flex-col items-start justify-between gap-4 mt-6 mb-6 lg:flex-row lg:items-center">
            <!-- Judul -->
            <h2 class="text-xl font-semibold text-gray-800 lg:text-2xl dark:text-white">
                Data Statistik
            </h2>

            <!-- Tools: Date Range, Reset, Export -->
            <div class="flex flex-wrap items-center gap-3 lg:gap-4">
                <!-- Date Range Picker + Reset -->
                <div class="flex items-center gap-2">
                    <div id="date-range-picker" date-rangepicker class="flex items-center gap-2">
                        <!-- Start Date -->
                        <div class="relative">
                            <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="datepicker-range-start" name="start" type="text"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                placeholder="Tanggal awal" />
                        </div>

                        <span class="mx-1 font-medium text-gray-500 dark:text-gray-400">-</span>

                        <!-- End Date -->
                        <div class="relative">
                            <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="datepicker-range-end" name="end" type="text"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                placeholder="Tanggal akhir" />
                        </div>
                    </div>

                    <!-- Reset Button -->
                    <button type="button" onclick="resetDateRange()"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-gray-500 rounded-lg hover:bg-gray-600 focus:ring-2 focus:ring-gray-400 focus:outline-none">
                        <i class="mr-2 fas fa-redo-alt"></i>
                        Reset
                    </button>
                </div>

                <!-- Export Dropdown -->
                <div class="relative">
                    <button id="dropdownButton" data-dropdown-toggle="dropdownExport"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-colors duration-200 bg-indigo-600 rounded-lg shadow hover:bg-indigo-700 focus:ring-2 focus:ring-blue-300 focus:outline-none">
                        <i class="mr-2 fas fa-file-export"></i>
                        Export
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div id="dropdownExport"
                        class="absolute right-0 z-10 hidden mt-2 bg-white rounded-lg shadow w-44 dark:divide-gray-600 dark:bg-gray-700">
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
        <div class="flex flex-col w-full gap-6 mt-6 lg:flex-row">
            <!-- KIRI: Grafik Penjualan + Tabel Aktivitas -->
            <div class="flex flex-col w-full gap-6 lg:w-2/3">
                <!-- TABS PENJUALAN -->
                <div class="p-5 transition-colors duration-200 bg-white shadow rounded-xl dark:bg-gray-800">
                    <h4 class="mb-4 text-lg font-semibold text-gray-800 dark:text-gray-100">
                        Trend Penjualan
                    </h4>

                    <!-- Tabs Navigation + Export -->
                    <div
                        class="flex flex-wrap items-center justify-between gap-3 mb-4 border-b border-gray-200 dark:border-gray-700">
                        <!-- Tabs -->
                        <ul class="flex flex-wrap gap-2 text-sm font-medium text-center" id="chartTabs" role="tablist">
                            <li>
                                <button
                                    class="inline-block p-3 text-blue-600 border-b-2 border-transparent border-blue-600 rounded-t-lg active hover:text-blue-600 dark:hover:text-blue-400"
                                    id="tab-day" data-tab="daily" data-tabs-target="#tab-content-day" type="button"
                                    role="tab" aria-controls="tab-content-day" aria-selected="true">
                                    Harian
                                </button>
                            </li>
                            <li>
                                <button
                                    class="inline-block p-3 text-gray-700 border-b-2 border-transparent rounded-t-lg hover:text-blue-600 dark:text-white dark:hover:text-blue-400"
                                    id="tab-week" data-tab="weekly" data-tabs-target="#tab-content-week" type="button"
                                    role="tab" aria-controls="tab-content-week" aria-selected="false">
                                    Mingguan
                                </button>
                            </li>
                            <li>
                                <button
                                    class="inline-block p-3 text-gray-700 border-b-2 border-transparent rounded-t-lg hover:text-blue-600 dark:text-white dark:hover:text-blue-400"
                                    id="tab-month" data-tab="monthly" data-tabs-target="#tab-content-month"
                                    type="button" role="tab" aria-controls="tab-content-month"
                                    aria-selected="false">
                                    Bulanan
                                </button>
                            </li>
                            <li>
                                <button
                                    class="inline-block p-3 text-gray-700 border-b-2 border-transparent rounded-t-lg hover:text-blue-600 dark:text-white dark:hover:text-blue-400"
                                    id="tab-year" data-tab="yearly" data-tabs-target="#tab-content-year" type="button"
                                    role="tab" aria-controls="tab-content-year" aria-selected="false">
                                    Tahunan
                                </button>
                            </li>
                        </ul>

                        <!-- Export Buttons -->
                        <div class="flex-shrink-0">
                            <!-- Export Dropdown -->
                            <div x-data="{ open: false }" class="relative inline-block text-left">
                                <!-- Trigger button -->
                                <button @click="open = !open"
                                    class="flex items-center gap-2 rounded-md bg-blue-600 px-3 py-1.5 text-xs text-white shadow transition hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                                    <i class="text-sm fa-solid fa-download"></i>
                                    <span>Export</span>
                                    <i class="fa-solid fa-caret-down text-[10px]"></i>
                                </button>

                                <!-- Dropdown menu -->
                                <div x-show="open" @click.outside="open = false"
                                    class="absolute right-0 z-20 mt-2 bg-white divide-y divide-gray-100 rounded-md shadow w-44 dark:bg-gray-700"
                                    x-transition>
                                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                                        <!-- Export Harian (Label dinamis) -->
                                        <li>
                                            <button id="export-current"
                                                class="flex items-center w-full gap-3 px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                <i class="w-5 text-base text-blue-500 fa-solid fa-file-pdf"></i>
                                                <span id="export-current-label">Export Harian</span>
                                            </button>
                                        </li>

                                        <!-- Export Semua -->
                                        <li>
                                            <button id="export-all"
                                                class="flex items-center w-full gap-3 px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                <i class="w-5 text-base text-green-600 fa-solid fa-file-pdf"></i>
                                                <span>Export Semua</span>
                                            </button>
                                        </li>

                                        <!-- Export Excel -->
                                        <li>
                                            <a id="export-excel-btn" href="#"
                                                class="flex items-center w-full gap-3 px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                <i class="w-5 text-base text-yellow-500 fa-solid fa-file-excel"></i>
                                                <span>Export Excel</span>
                                            </a>
                                        </li>

                                        <!-- Export CSV -->
                                        <li>
                                            <button onclick="exportToCSV()"
                                                class="flex items-center w-full gap-3 px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                                <i class="w-5 text-base text-orange-500 fa-solid fa-file-csv"></i>
                                                <span>Export CSV</span>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs Content -->
                    <div id="chart-tabs-content">
                        <div class="p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800" id="tab-content-day">
                            <div id="chart-day" class="w-full h-80"></div>
                        </div>
                        <div class="hidden p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800" id="tab-content-week">
                            <div id="chart-week" class="w-full h-80"></div>
                        </div>
                        <div class="hidden p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800" id="tab-content-month">
                            <div id="chart-month" class="w-full h-80"></div>
                        </div>
                        <div class="hidden p-4 bg-white rounded-lg shadow-sm dark:bg-gray-800" id="tab-content-year">
                            <div id="chart-year" class="w-full h-80"></div>
                        </div>
                    </div>

                    <input type="hidden" id="daily-totals" value='@json($dailyTotals)' />
                    <input type="hidden" id="weekly-totals" value='@json($weeklyTotals)' />
                    <input type="hidden" id="monthly-totals" value='@json($monthlyTotals)' />
                    <input type="hidden" id="yearly-totals" value='@json($yearlyTotals)' />
                </div>

                <!-- TABEL AKTIVITAS TRANSAKSI HARI INI -->
                <div class="p-5 transition-colors duration-200 bg-white shadow rounded-xl dark:bg-gray-800">
                    <h4 class="mb-4 text-lg font-semibold text-gray-800 dark:text-gray-100">
                        Aktivitas Transaksi Hari Ini
                    </h4>
                    <div class="overflow-x-auto rounded-lg">
                        <table class="min-w-full text-sm text-left divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-4 py-2 text-gray-700 dark:text-gray-200">
                                        Waktu
                                    </th>
                                    <th class="px-4 py-2 text-gray-700 dark:text-gray-200">
                                        Produk
                                    </th>
                                    <th class="px-4 py-2 text-gray-700 dark:text-gray-200">Qty</th>
                                    <th class="px-4 py-2 text-gray-700 dark:text-gray-200">
                                        Metode Pembayaran
                                    </th>
                                    <th class="px-4 py-2 text-right text-gray-700 dark:text-gray-200">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse ($aktivitasHariIni as $item)
                                    <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                        <td class="px-4 py-2">
                                            {{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }}
                                        </td>
                                        <td class="px-4 py-2">{{ $item->product_name }}</td>
                                        <td class="px-4 py-2">{{ $item->qty }}</td>
                                        <td class="px-4 py-2">{{ $item->metode_pembayaran }}</td>
                                        <td class="px-4 py-2 text-right">
                                            Rp {{ number_format($item->total, 0, ',', '.') }}
                                            @if ($item->discount > 0)
                                                <br />
                                                <span class="text-xs text-green-600 dark:text-green-400">
                                                    (-{{ $item->discount }}%)
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-4 text-center text-gray-500 dark:text-gray-400">
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
                <div class="p-5 transition-colors duration-200 bg-white shadow rounded-xl dark:bg-gray-800">
                    <h4 class="mb-4 text-lg font-semibold text-gray-800 dark:text-gray-100">
                        Performa Kasir Hari Ini
                    </h4>
                    <div class="overflow-x-auto rounded-lg">
                        <table class="min-w-full text-sm text-left divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 font-bold">Kasir</th>
                                    <th class="px-6 py-3 font-bold text-center">
                                        Melakukan Transaksi
                                    </th>
                                    <th class="px-6 py-3 font-bold text-right">Total Penjualan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($performaKasirHariIni as $kasir)
                                    <tr class="transition hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-4 py-2">{{ $kasir->kasir }}</td>
                                        <td class="px-4 py-2 text-center">
                                            {{ $kasir->transaksi }}
                                        </td>
                                        <td class="px-4 py-2 text-right">
                                            Rp
                                            {{ number_format($kasir->total_penjualan, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="py-4 text-center text-gray-500 dark:text-gray-400">
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
            <div class="flex flex-col w-full gap-6 lg:w-1/3">
                <!-- Produk Terjual -->
                <div class="p-4 transition-colors duration-200 bg-white shadow rounded-xl dark:bg-gray-800">
                    <h4 class="mb-2 text-sm font-semibold text-center text-gray-800 dark:text-gray-100">
                        Produk Terjual
                    </h4>
                    <canvas id="donut-product-sold" class="w-full h-60"></canvas>
                </div>

                <!-- Produk Masuk -->
                <div class="p-4 transition-colors duration-200 bg-white shadow rounded-xl dark:bg-gray-800">
                    <h4 class="mb-2 text-sm font-semibold text-center text-gray-800 dark:text-gray-100">
                        Produk Masuk
                    </h4>
                    <canvas id="donut-product-in" class="w-full h-60"></canvas>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        let chartDay, chartWeek, chartMonth, chartYear;
        let donutSold, donutIn;

        function reRenderChart(updateFn, containerId) {
            const container = document.getElementById(containerId);

            if (!container) {
                return;
            }

            setTimeout(() => {
                updateFn();
            }, 500);
        }

        function getThemeColor(lightColor, darkColor) {
            const isDarkMode = document.documentElement.classList.contains('dark');
            return isDarkMode ? darkColor : lightColor;
        }

        function initChartDay() {
            const dailyLabels = @json($dailyLabels);
            const dailyByProductData = [
                @foreach ($dailyByProduct as $dataset)
                    {
                        name: {!! json_encode($dataset['label']) !!},
                        data: {!! json_encode($dataset['data']) !!}
                    },
                @endforeach
            ];

            if (chartDay) {
                chartDay.destroy();
            }


            const labelColorLight = '#374151';
            const labelColorDark = '#E5E7EB';
            const axisColorLight = '#D1D5DB';
            const axisColorDark = '#4B5563';

            const options = {
                series: dailyByProductData,
                chart: {

                    id: 'chart-day',
                    type: 'line',
                    height: 350,
                    animations: {

                    },
                    toolbar: {
                        show: true,
                        tools: {
                            download: true,
                            selection: false,
                            zoom: false,
                            zoomin: false,
                            zoomout: false,
                            pan: false,
                            reset: false,
                        }
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                tooltip: {

                    theme: getThemeColor('light', 'dark'),

                    style: {
                        fontSize: '13px',
                        fontFamily: 'inherit',
                    }
                },

                grid: {
                    borderColor: getThemeColor(axisColorLight, axisColorDark),

                },
                xaxis: {

                    categories: dailyLabels,
                    labels: {
                        style: {
                            colors: getThemeColor(labelColorLight, labelColorDark),
                            fontSize: '12px',
                            fontFamily: 'inherit',
                            fontWeight: 400,
                        }
                    },
                    axisBorder: {
                        show: true,
                        color: getThemeColor(axisColorLight, axisColorDark),
                    },
                    axisTicks: {
                        show: true,
                        color: getThemeColor(axisColorLight, axisColorDark),
                    }
                },
                yaxis: {

                    min: 0,
                    labels: {
                        formatter: function(val) {
                            return val.toFixed(0);
                        },
                        style: {
                            colors: getThemeColor(labelColorLight, labelColorDark),
                            fontSize: '12px',
                            fontFamily: 'inherit',
                            fontWeight: 400
                        }
                    }
                },
                legend: {

                    position: 'top',
                    horizontalAlign: 'center',
                    labels: {
                        colors: getThemeColor(labelColorLight, labelColorDark),
                    }
                }
            };

            chartDay = new ApexCharts(document.querySelector("#chart-day"), options);
            chartDay.render();
        }

        function initChartWeek() {

            const weekLabels = @json($weekLabels);

            const weeklyByProductData = [
                @foreach ($weeklyByProduct as $dataset)
                    {
                        name: {!! json_encode($dataset['label']) !!},
                        data: {!! json_encode($dataset['data']) !!}
                    },
                @endforeach
            ];

            if (chartWeek) {
                chartWeek.destroy();
            }


            const labelColorLight = '#374151';
            const labelColorDark = '#E5E7EB';
            const axisColorLight = '#D1D5DB';
            const axisColorDark = '#4B5563';

            const options = {

                series: weeklyByProductData,
                chart: {

                    id: 'chart-week',
                    type: 'bar',
                    height: 350,

                    animations: {
                        enabled: false
                    },

                    toolbar: {
                        show: true,
                        tools: {
                            download: true,
                            selection: false,
                            zoom: false,
                            zoomin: false,
                            zoomout: false,
                            pan: false,
                            reset: false,
                        }
                    }
                },


                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },


                dataLabels: {
                    enabled: false
                },


                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },


                title: {
                    text: '',
                    align: 'left'
                },


                theme: {
                    mode: getThemeColor('light', 'dark'),
                },

                tooltip: {
                    theme: getThemeColor('light', 'dark'),
                    style: {
                        fontSize: '13px',
                        fontFamily: 'inherit',
                    },
                    y: {
                        formatter: function(val) {
                            return val.toFixed(0)
                        }
                    }
                },

                grid: {
                    borderColor: getThemeColor(axisColorLight, axisColorDark),
                },
                xaxis: {

                    categories: weekLabels,
                    labels: {
                        style: {
                            colors: getThemeColor(labelColorLight, labelColorDark),
                            fontSize: '12px',
                            fontFamily: 'inherit',
                            fontWeight: 400,
                        }
                    },
                    axisBorder: {
                        show: true,
                        color: getThemeColor(axisColorLight, axisColorDark),
                    },
                    axisTicks: {
                        show: true,
                        color: getThemeColor(axisColorLight, axisColorDark),
                    }
                },
                yaxis: {
                    min: 0,
                    labels: {
                        formatter: function(val) {
                            return val.toFixed(0);
                        },
                        style: {
                            colors: getThemeColor(labelColorLight, labelColorDark),
                            fontSize: '12px',
                            fontFamily: 'inherit',
                            fontWeight: 400
                        }
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'center',
                    labels: {
                        colors: getThemeColor(labelColorLight, labelColorDark),
                    }
                }
            };

            chartWeek = new ApexCharts(document.querySelector("#chart-week"), options);
            chartWeek.render();
        }

        function initChartMonth() {
            const monthLabels = @json($monthLabels);
            const monthlyByProductData = [
                @foreach ($monthlyByProduct as $dataset)
                    {
                        name: {!! json_encode($dataset['label']) !!},
                        data: {!! json_encode($dataset['data']) !!}
                    },
                @endforeach
            ];

            if (chartMonth) {
                chartMonth.destroy();
            }

            const labelColorLight = '#374151';
            const labelColorDark = '#E5E7EB';
            const axisColorLight = '#D1D5DB';
            const axisColorDark = '#4B5563';

            const options = {
                series: monthlyByProductData,
                chart: {
                    id: 'chart-month',
                    type: 'bar',
                    height: 350,
                    toolbar: {
                        show: true,
                        tools: {
                            download: true,
                            selection: false,
                            zoom: false,
                            zoomin: false,
                            zoomout: false,
                            pan: false,
                            reset: false,
                        }
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                title: {
                    text: '',
                    align: 'left'
                },


                theme: {
                    mode: getThemeColor('light', 'dark'),
                },


                tooltip: {
                    theme: getThemeColor('light', 'dark'),
                    style: {
                        fontSize: '13px',
                        fontFamily: 'inherit',
                    },
                    y: {
                        formatter: function(val) {
                            return val.toFixed(0)
                        }
                    }
                },

                grid: {
                    borderColor: getThemeColor(axisColorLight, axisColorDark),

                },
                xaxis: {

                    categories: monthLabels,
                    labels: {
                        style: {
                            colors: getThemeColor(labelColorLight, labelColorDark),
                            fontSize: '12px',
                            fontFamily: 'inherit',
                            fontWeight: 400,
                        }
                    },
                    axisBorder: {
                        show: true,
                        color: getThemeColor(axisColorLight, axisColorDark),
                    },
                    axisTicks: {
                        show: true,
                        color: getThemeColor(axisColorLight, axisColorDark),
                    }
                },
                yaxis: {
                    min: 0,
                    labels: {
                        formatter: function(val) {
                            return val.toFixed(0);
                        },
                        style: {
                            colors: getThemeColor(labelColorLight, labelColorDark),
                            fontSize: '12px',
                            fontFamily: 'inherit',
                            fontWeight: 400
                        }
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'center',
                    labels: {
                        colors: getThemeColor(labelColorLight, labelColorDark),
                    }
                }
            };


            chartMonth = new ApexCharts(document.querySelector("#chart-month"), options);
            chartMonth.render();
        }

        function initChartYear() {

            const yearLabels = @json($yearLabels);


            const yearlyByProductData = [
                @foreach ($yearlyByProduct as $dataset)
                    {
                        name: {!! json_encode($dataset['label']) !!},
                        data: {!! json_encode($dataset['data']) !!}
                    },
                @endforeach
            ];

            if (chartYear) {
                chartYear.destroy();
            }


            const labelColorLight = '#374151';
            const labelColorDark = '#E5E7EB';
            const axisColorLight = '#D1D5DB';
            const axisColorDark = '#4B5563';

            const options = {
                series: yearlyByProductData,
                chart: {
                    id: 'chart-year',
                    type: 'bar',
                    height: 350,

                    animations: {
                        enabled: false
                    },

                    toolbar: {
                        show: true,
                        tools: {
                            download: true,
                            selection: false,
                            zoom: false,
                            zoomin: false,
                            zoomout: false,
                            pan: false,
                            reset: false,
                        }
                    }
                },


                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },

                dataLabels: {
                    enabled: false
                },


                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },

                title: {
                    text: '',
                    align: 'left'
                },

                theme: {
                    mode: getThemeColor('light', 'dark'),
                },

                tooltip: {
                    theme: getThemeColor('light', 'dark'),
                    style: {
                        fontSize: '13px',
                        fontFamily: 'inherit',
                    },
                    y: {
                        formatter: function(val) {
                            return val.toFixed(0)
                        }
                    }
                },

                grid: {
                    borderColor: getThemeColor(axisColorLight, axisColorDark),
                },
                xaxis: {
                    categories: yearLabels,
                    labels: {
                        style: {
                            colors: getThemeColor(labelColorLight, labelColorDark),
                            fontSize: '12px',
                            fontFamily: 'inherit',
                            fontWeight: 400,
                        }
                    },
                    axisBorder: {
                        show: true,
                        color: getThemeColor(axisColorLight, axisColorDark),
                    },
                    axisTicks: {
                        show: true,
                        color: getThemeColor(axisColorLight, axisColorDark),
                    }
                },
                yaxis: {
                    min: 0,
                    labels: {
                        formatter: function(val) {
                            return val.toFixed(0);
                        },
                        style: {
                            colors: getThemeColor(labelColorLight, labelColorDark),
                            fontSize: '12px',
                            fontFamily: 'inherit',
                            fontWeight: 400
                        }
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'center',
                    labels: {
                        colors: getThemeColor(labelColorLight, labelColorDark),
                    }
                }
            };

            chartYear = new ApexCharts(document.querySelector("#chart-year"), options);
            chartYear.render();
        }



        // ===================== Tabs Handling =====================
        const tabButtons = document.querySelectorAll('[data-tabs-target]');
        const tabContents = document.querySelectorAll('#chart-tabs-content > div');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-tabs-target');

                tabButtons.forEach(btn => {
                    btn.classList.remove("text-blue-600", "border-blue-600", "active");
                    btn.classList.add("text-gray-700", "dark:text-white");
                });

                button.classList.add("text-blue-600", "border-blue-600", "active");
                button.classList.remove("text-gray-700", "dark:text-white");

                tabContents.forEach(content => {
                    content.classList.add('hidden');
                    if ("#" + content.id === targetId) {
                        content.classList.remove('hidden');

                        switch (targetId) {
                            case '#tab-content-day':
                                reRenderChart(initChartDay, 'chart-day');
                                break;
                            case '#tab-content-week':
                                reRenderChart(initChartWeek, 'chart-week');
                                break;
                            case '#tab-content-month':
                                reRenderChart(initChartMonth, 'chart-month');
                                break;
                            case '#tab-content-year':
                                reRenderChart(initChartYear, 'chart-year');
                                break;
                        }
                    }
                });
            });
        });

        // ===================== Default Load =====================
        window.addEventListener('DOMContentLoaded', () => {
            reRenderChart(initChartDay, 'chart-day');
        });

        // ===================== Donut Charts =====================
        const ctxSold = document.getElementById('donut-product-sold');
        if (donutSold) donutSold.destroy();
        donutSold = new Chart(ctxSold, {
            type: 'pie',
            data: {
                labels: @json($outLabels),
                datasets: [{
                    data: @json($outQtys),
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6']
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

        const ctxIn = document.getElementById('donut-product-in');
        if (donutIn) donutIn.destroy();
        donutIn = new Chart(ctxIn, {
            type: 'doughnut',
            data: {
                labels: @json($inLabels),
                datasets: [{
                    data: @json($inQtys),
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6']
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

        // ===================== Data from Controller =====================
        const dailyData = @json(collect($dailyLabels)->map(function ($label, $i) use ($dailyValues) {
                return ['tanggal' => $label, 'total' => $dailyValues[$i] ?? 0];
            }));
        const weekData = @json(collect($weekLabels)->map(function ($label, $i) use ($weekValues) {
                return ['minggu' => $label, 'total' => collect($weekValues)->pluck('data')->sum(fn($arr) => $arr[$i] ?? 0)];
            }));
        const monthData = @json(collect($monthLabels)->map(function ($label, $i) use ($monthValues) {
                return ['bulan' => $label, 'total' => collect($monthValues)->pluck('data')->sum(fn($arr) => $arr[$i] ?? 0)];
            }));
        const yearData = @json(collect($yearLabels)->map(function ($label, $i) use ($yearValues) {
                return ['tahun' => $label, 'total' => collect($yearValues)->pluck('data')->sum(fn($arr) => $arr[$i] ?? 0)];
            }));


        function resetDateRange() {
            const startInput = document.getElementById('datepicker-range-start');
            const endInput = document.getElementById('datepicker-range-end');

            if (startInput) startInput.value = '';
            if (endInput) endInput.value = '';

            startInput.dispatchEvent(new Event('change'));
            endInput.dispatchEvent(new Event('change'));
        }

        function exportToPDF() {
            const start = document.getElementById('datepicker-range-start').value;
            const end = document.getElementById('datepicker-range-end').value;

            if (!start || !end) {
                alert('Harap pilih tanggal awal dan akhir terlebih dahulu!');
                return;
            }

            const url = new URL('{{ route('report.penjualan.pdf') }}', window.location.origin);
            url.searchParams.append('start', start);
            url.searchParams.append('end', end);

            window.open(url.toString(), '_blank');
        }
    </script>

    <script>
        const {
            jsPDF
        } = window.jspdf
        const exportCurrentBtn = document.getElementById('export-current')
        const exportAllBtn = document.getElementById('export-all')

        async function renderChartToPDF(pdf, chartInstance, title, tableData = null, addNewPage = false) {
            if (!chartInstance) return

            if (addNewPage) pdf.addPage()

            const imgObj = await chartInstance.dataURI({
                width: 1000,
                type: 'image/png',
                quality: 1
            })

            if (!imgObj || !imgObj.imgURI) {
                console.error("Gagal mendapatkan Data URI dari grafik.")
                return
            }

            const imgData = imgObj.imgURI

            const pdfWidth = pdf.internal.pageSize.getWidth() - 20
            const originalChartWidth = 1000
            const fallbackHeight = 350

            const chartGlobals = chartInstance.w.globals
            const originalChartHeight = chartGlobals.chartHeight > 0 ? chartGlobals.chartHeight : fallbackHeight

            let pdfHeight = (originalChartHeight * pdfWidth) / originalChartWidth
            if (pdfHeight <= 0) {
                pdfHeight = (fallbackHeight * pdfWidth) / originalChartWidth
            }

            pdf.setFontSize(14)
            pdf.text(title, 14, 20)
            pdf.addImage(imgData, 'PNG', 10, 30, pdfWidth, pdfHeight)

            if (tableData && tableData.rows.length > 0) {
                const tableStart = pdfHeight + 50

                if (tableStart > pdf.internal.pageSize.getHeight() - 50) {
                    pdf.addPage()
                    pdf.autoTable({
                        head: [tableData.headers],
                        body: tableData.rows,
                        startY: 20,
                        styles: {
                            fontSize: 10
                        },
                        headStyles: {
                            fillColor: [41, 128, 185]
                        },
                    })
                } else {
                    pdf.autoTable({
                        head: [tableData.headers],
                        body: tableData.rows,
                        startY: tableStart,
                        styles: {
                            fontSize: 10
                        },
                        headStyles: {
                            fillColor: [41, 128, 185]
                        },
                    })
                }
            }
        }



        exportCurrentBtn.addEventListener('click', async () => {
            const activeTab = document.querySelector('#chart-tabs-content > div:not(.hidden)')
            if (!activeTab) return alert('Tidak ada tab aktif')

            const tabName = activeTab.id.replace('tab-content-', '')

            let initFn
            let title = 'Laporan '
            let tableData = null

            switch (tabName) {
                case 'day':
                    initFn = initChartDay
                    title += 'Harian'
                    const dailyTotals = JSON.parse(document.getElementById('daily-totals').value)
                    tableData = {
                        headers: ['Tanggal', 'Produk', 'Total'],
                        rows: dailyTotals.map((d) => [d.tanggal, d.product, Number(d.total).toLocaleString(
                            'id-ID')])
                    }
                    break
                case 'week':
                    initFn = initChartWeek
                    title += 'Mingguan'
                    const weeklyTotals = JSON.parse(document.getElementById('weekly-totals').value)
                    tableData = {
                        headers: ['Minggu', 'Produk', 'Total'],
                        rows: weeklyTotals.map((d) => [d.week, d.product, Number(d.total).toLocaleString(
                            'id-ID')])
                    }
                    break
                case 'month':
                    initFn = initChartMonth
                    title += 'Bulanan'
                    const monthlyTotals = JSON.parse(document.getElementById('monthly-totals').value)
                    tableData = {
                        headers: ['Bulan', 'Produk', 'Total'],
                        rows: monthlyTotals.map((d) => [d.month, d.product, Number(d.total).toLocaleString(
                            'id-ID')])
                    }
                    break
                case 'year':
                    initFn = initChartYear
                    title += 'Tahunan'
                    const yearlyTotals = JSON.parse(document.getElementById('yearly-totals').value)
                    tableData = {
                        headers: ['Tahun', 'Produk', 'Total'],
                        rows: yearlyTotals.map((d) => [d.year, d.product, Number(d.total).toLocaleString(
                            'id-ID')])
                    }
                    break
                default:
                    return alert('Tab tidak dikenali.')
            }

            initFn()

            await new Promise(resolve => setTimeout(resolve, 700))

            let currentChartInstance


            switch (tabName) {
                case 'day':
                    currentChartInstance = chartDay
                    break
                case 'week':
                    currentChartInstance = chartWeek
                    break
                case 'month':
                    currentChartInstance = chartMonth
                    break
                case 'year':
                    currentChartInstance = chartYear
                    break
            }

            if (!currentChartInstance) {
                return alert(
                    'Instance chart gagal diinisialisasi setelah render ulang. Coba muat ulang halaman atau tingkatkan delay.'
                )
            }

            const pdf = new jsPDF('p', 'mm', 'a4')

            await renderChartToPDF(pdf, currentChartInstance, title, tableData)

            pdf.save('laporan-' + tabName + '.pdf')
        })

        function updateExportButtonLabel() {
            const activeTab = document.querySelector('#chart-tabs-content > div:not(.hidden)')
            if (!activeTab) return

            const tabName = activeTab.id.replace('tab-content-', '')
            let label = 'Export Harian'

            switch (tabName) {
                case 'day':
                    label = 'Export Harian'
                    break
                case 'week':
                    label = 'Export Mingguan'
                    break
                case 'month':
                    label = 'Export Bulanan'
                    break
                case 'year':
                    label = 'Export Tahunan'
                    break
            }

            document.getElementById('export-current-label').textContent = label
        }

        updateExportButtonLabel()

        document.querySelectorAll('#chartTabs button').forEach((tab) => {
            tab.addEventListener('click', () => {
                setTimeout(updateExportButtonLabel, 50)
            })
        })

        exportAllBtn.addEventListener('click', async () => {
            const pdf = new jsPDF('p', 'mm', 'a4');


            const chartContainers = document.querySelectorAll('#chart-tabs-content > div');

            const containersToRestore = [];
            chartContainers.forEach(container => {
                if (container.classList.contains('hidden')) {
                    containersToRestore.push(container);
                    container.classList.remove('hidden');

                    const chartId = container.id.replace('tab-content-', 'chart-');
                    let currentChart;

                    if (chartId === 'chart-day' && chartDay) currentChart = chartDay;
                    else if (chartId === 'chart-week' && chartWeek) currentChart = chartWeek;
                    else if (chartId === 'chart-month' && chartMonth) currentChart = chartMonth;
                    else if (chartId === 'chart-year' && chartYear) currentChart = chartYear;

                    if (currentChart) {
                        currentChart.update();
                    }
                }
            });

            initChartDay();
            initChartWeek();
            initChartMonth();
            initChartYear();

            await new Promise(resolve => setTimeout(resolve, 1500));

            const getChartData = (id, defaultKey) => {
                const el = document.getElementById(id);
                const dataValue = el ? el.value : '[]';

                try {
                    const data = JSON.parse(dataValue);
                    return data.map(d => ({
                        key: d[defaultKey] || '',
                        product: d.product || '',
                        total: Number(d.total || 0).toLocaleString('id-ID')
                    }));
                } catch (e) {
                    console.error(`Gagal parsing data untuk ID: ${id}. Error: ${e}`);
                    return [];
                }
            };

            const dailyData = getChartData('daily-totals', 'tanggal');
            const weekData = getChartData('weekly-totals', 'week');
            const monthData = getChartData('monthly-totals', 'month');
            const yearData = getChartData('yearly-totals', 'year');


            try {
                const chartsToExport = [{
                        instance: chartDay,
                        title: 'Laporan Harian',
                        data: {
                            headers: ['Tanggal', 'Produk', 'Total'],
                            rows: dailyData.map((d) => [d.key, d.product, d.total]),
                        }
                    },
                    {
                        instance: chartWeek,
                        title: 'Laporan Mingguan',
                        data: {
                            headers: ['Minggu', 'Produk', 'Total'],
                            rows: weekData.map((d) => [d.key, d.product, d.total]),
                        }
                    },
                    {
                        instance: chartMonth,
                        title: 'Laporan Bulanan',
                        data: {
                            headers: ['Bulan', 'Produk', 'Total'],
                            rows: monthData.map((d) => [d.key, d.product, d.total]),
                        }
                    },
                    {
                        instance: chartYear,
                        title: 'Laporan Tahunan',
                        data: {
                            headers: ['Tahun', 'Produk', 'Total'],
                            rows: yearData.map((d) => [d.key, d.product, d.total]),
                        }
                    },
                ];

                for (let i = 0; i < chartsToExport.length; i++) {
                    const chart = chartsToExport[i];

                    if (!chart.instance) {
                        console.warn(`Melewati ${chart.title}: Instance chart belum dibuat.`);
                        continue;
                    }

                    await renderChartToPDF(pdf, chart.instance, chart.title, chart.data, i > 0);
                }

                pdf.save('laporan-semua.pdf');

            } catch (e) {
                console.error("Gagal melakukan ekspor PDF saat rendering chart atau tabel:", e);
                alert("Gagal melakukan ekspor semua laporan. Periksa log konsol.");
            } finally {
                containersToRestore.forEach(container => {
                    container.classList.add('hidden');
                });
            }
        });
    </script>

    <script>
        window.exportDataSets = {
            daily: @json($dailyTotals),
            weekly: @json($weeklyTotals),
            monthly: @json($monthlyTotals),
            yearly: @json($yearlyTotals),
        }

        function getActiveDataset() {
            const activeTab = document.querySelector('button[data-tab].active')
            const active = activeTab ? activeTab.dataset.tab : 'daily'
            return window.exportDataSets[active] || []
        }

        function exportToExcel() {
            const data = getActiveDataset()
            if (!data || data.length === 0) {
                alert('Tidak ada data untuk diexport.')
                return
            }

            const worksheet = XLSX.utils.json_to_sheet(data)

            const colWidths = Object.keys(data[0]).map((key) => ({
                wch: Math.max(
                    key.length,
                    ...data.map((row) => (row[key] ? row[key].toString().length : 0)),
                ),
            }))
            worksheet['!cols'] = colWidths

            const workbook = XLSX.utils.book_new()
            XLSX.utils.book_append_sheet(workbook, worksheet, 'Data')

            XLSX.writeFile(workbook, `laporan-${Date.now()}.xlsx`)
        }

        // Export ke CSV
        function exportToCSV() {
            const data = getActiveDataset()
            if (!data || data.length === 0) {
                alert('Tidak ada data untuk diexport.')
                return
            }

            let csvContent = 'data:text/csv;charset=utf-8,'
            const headers = Object.keys(data[0]).join(',') + '\n'
            csvContent += headers

            data.forEach((row) => {
                const values = Object.values(row)
                    .map((v) => `"${v}"`)
                    .join(',')
                csvContent += values + '\n'
            })

            const encodedUri = encodeURI(csvContent)
            const link = document.createElement('a')
            link.setAttribute('href', encodedUri)
            link.setAttribute('download', `laporan-${Date.now()}.csv`)
            document.body.appendChild(link)
            link.click()
            document.body.removeChild(link)
        }


        function updateExcelExportLink() {
            const activeTab = document.querySelector('button[data-tab].active')
            const type = activeTab ? activeTab.dataset.tab : 'daily'
            const btn = document.getElementById('export-excel-btn')
            btn.setAttribute('href', `/report/export-excel?type=${type}`)
        }

        updateExcelExportLink()

        document.querySelectorAll('button[data-tab]').forEach((tab) => {
            tab.addEventListener('click', () => {
                setTimeout(updateExcelExportLink, 100)
            })
        })
    </script>
@endpush
