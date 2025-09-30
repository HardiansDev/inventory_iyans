@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID</title>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section
        class="mb-6 rounded-xl bg-white p-6 shadow-md transition-colors duration-300 dark:bg-gray-900"
    >
        <div
            class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center"
        >
            <!-- Title -->
            <div class="flex flex-col gap-1">
                <h1 class="text-3xl leading-tight font-extrabold text-gray-900 dark:text-white">
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
        <div
            class="mt-6 grid grid-cols-2 items-stretch gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
        >
            <!-- Card -->
            <div
                class="flex h-full items-center gap-4 rounded-xl bg-gradient-to-r from-teal-400 to-teal-600 p-5 text-white shadow"
            >
                <i class="fas fa-wallet text-3xl opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">
                        Rp {{ number_format($totalModal, 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-sm">Total Modal</div>
                </div>
            </div>

            <div
                class="flex h-full items-center gap-4 rounded-xl bg-gradient-to-r from-blue-400 to-blue-600 p-5 text-white shadow"
            >
                <i class="fas fa-boxes text-3xl opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">{{ $totalProduk }}</div>
                    <div class="mt-1 text-sm">Data Produk</div>
                </div>
            </div>

            <div
                class="flex h-full items-center gap-4 rounded-xl bg-gradient-to-r from-emerald-400 to-emerald-600 p-5 text-white shadow"
            >
                <i class="fas fa-truck-loading text-3xl opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">{{ $produkMasuk }}</div>
                    <div class="mt-1 text-sm">Total Produk Masuk</div>
                </div>
            </div>

            <div
                class="flex h-full items-center gap-4 rounded-xl bg-gradient-to-r from-rose-400 to-rose-600 p-5 text-white shadow"
            >
                <i class="fas fa-dolly text-3xl opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">{{ $produkKeluar }}</div>
                    <div class="mt-1 text-sm">Total Produk Keluar</div>
                </div>
            </div>

            <div
                class="flex h-full items-center gap-4 rounded-xl bg-gradient-to-r from-green-400 to-green-600 p-5 text-white shadow"
            >
                <i class="fas fa-users text-3xl opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">{{ $totalUser }}</div>
                    <div class="mt-1 text-sm">Pengguna</div>
                </div>
            </div>

            <div
                class="flex h-full items-center gap-4 rounded-xl bg-gradient-to-r from-indigo-400 to-indigo-600 p-5 text-white shadow"
            >
                <i class="fas fa-cash-register text-3xl opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">
                        Rp {{ number_format($penjualanHariIni, 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-sm">Pendapatan Hari Ini</div>
                </div>
            </div>

            <div
                class="flex h-full items-center gap-4 rounded-xl bg-gradient-to-r from-emerald-400 to-emerald-600 p-5 text-white shadow"
            >
                <i class="fas fa-coins text-3xl opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">
                        Rp {{ number_format($keuntunganHariIni, 0, ',', '.') }}
                    </div>
                    <div class="mt-1 text-sm">Keuntungan Hari Ini</div>
                </div>
            </div>

            <div
                class="flex h-full items-center gap-4 rounded-xl bg-gradient-to-r from-cyan-400 to-cyan-600 p-5 text-white shadow"
            >
                <i class="fas fa-receipt text-3xl opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">{{ $transaksiHariIni }}</div>
                    <div class="mt-1 text-sm">Transaksi Hari Ini</div>
                </div>
            </div>

            <div
                class="flex h-full items-center gap-4 rounded-xl bg-gradient-to-r from-teal-400 to-teal-600 p-5 text-white shadow"
            >
                <i class="fas fa-user-check text-3xl opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">{{ $pegawaiAktif }}</div>
                    <div class="mt-1 text-sm">Pegawai Aktif</div>
                </div>
            </div>

            <div
                class="flex h-full items-center gap-4 rounded-xl bg-gradient-to-r from-gray-400 to-gray-600 p-5 text-white shadow"
            >
                <i class="fas fa-user-slash text-3xl opacity-80"></i>
                <div>
                    <div class="text-2xl font-bold">{{ $pegawaiTidakAktif }}</div>
                    <div class="mt-1 text-sm">Pegawai Tidak Aktif</div>
                </div>
            </div>
        </div>

        <!-- Main Dashboard Row -->
        <div
            class="mt-6 mb-6 flex flex-col items-start justify-between gap-4 lg:flex-row lg:items-center"
        >
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
                            <div
                                class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3"
                            >
                                <svg
                                    class="h-4 w-4 text-gray-500 dark:text-gray-400"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"
                                    />
                                </svg>
                            </div>
                            <input
                                id="datepicker-range-start"
                                name="start"
                                type="text"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                placeholder="Tanggal awal"
                            />
                        </div>

                        <span class="mx-1 font-medium text-gray-500 dark:text-gray-400">-</span>

                        <!-- End Date -->
                        <div class="relative">
                            <div
                                class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3"
                            >
                                <svg
                                    class="h-4 w-4 text-gray-500 dark:text-gray-400"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"
                                    />
                                </svg>
                            </div>
                            <input
                                id="datepicker-range-end"
                                name="end"
                                type="text"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 ps-10 text-sm text-gray-900 placeholder-gray-400 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400"
                                placeholder="Tanggal akhir"
                            />
                        </div>
                    </div>

                    <!-- Reset Button -->
                    <button
                        type="button"
                        onclick="resetDateRange()"
                        class="inline-flex items-center rounded-lg bg-gray-500 px-4 py-2 text-sm font-medium text-white transition-colors duration-200 hover:bg-gray-600 focus:ring-2 focus:ring-gray-400 focus:outline-none"
                    >
                        <i class="fas fa-redo-alt mr-2"></i>
                        Reset
                    </button>
                </div>

                <!-- Export Dropdown -->
                <div class="relative">
                    <button
                        id="dropdownButton"
                        data-dropdown-toggle="dropdownExport"
                        class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow transition-colors duration-200 hover:bg-indigo-700 focus:ring-2 focus:ring-blue-300 focus:outline-none"
                    >
                        <i class="fas fa-file-export mr-2"></i>
                        Export
                        <svg
                            class="ml-2 h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7"
                            ></path>
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div
                        id="dropdownExport"
                        class="absolute right-0 z-10 mt-2 hidden w-44 rounded-lg bg-white shadow dark:divide-gray-600 dark:bg-gray-700"
                    >
                        <ul
                            class="py-2 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="dropdownButton"
                        >
                            <li>
                                <a
                                    href="#"
                                    onclick="exportToPDF(); return false;"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                >
                                    Export PDF
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- GRAFIK TREN PENJUALAN & DONAT + TABEL TRANSAKSI HARI INI -->
        <div class="mt-6 flex w-full flex-col gap-6 lg:flex-row">
            <!-- KIRI: Grafik Penjualan + Tabel Aktivitas -->
            <div class="flex w-full flex-col gap-6 lg:w-2/3">
                <!-- TABS PENJUALAN -->
                <div
                    class="rounded-xl bg-white p-5 shadow transition-colors duration-200 dark:bg-gray-800"
                >
                    <h4 class="mb-4 text-lg font-semibold text-gray-800 dark:text-gray-100">
                        Trend Penjualan
                    </h4>

                    <!-- Tabs Navigation + Export -->
                    <div
                        class="mb-4 flex flex-wrap items-center justify-between gap-3 border-b border-gray-200 dark:border-gray-700"
                    >
                        <!-- Tabs -->
                        <ul
                            class="flex flex-wrap gap-2 text-center text-sm font-medium"
                            id="chartTabs"
                            role="tablist"
                        >
                            <li>
                                <button
                                    class="active inline-block rounded-t-lg border-b-2 border-blue-600 border-transparent p-3 text-blue-600 hover:text-blue-600 dark:hover:text-blue-400"
                                    id="tab-day"
                                    data-tab="daily"
                                    data-tabs-target="#tab-content-day"
                                    type="button"
                                    role="tab"
                                    aria-controls="tab-content-day"
                                    aria-selected="true"
                                >
                                    Harian
                                </button>
                            </li>
                            <li>
                                <button
                                    class="inline-block rounded-t-lg border-b-2 border-transparent p-3 text-gray-700 hover:text-blue-600 dark:text-white dark:hover:text-blue-400"
                                    id="tab-week"
                                    data-tab="weekly"
                                    data-tabs-target="#tab-content-week"
                                    type="button"
                                    role="tab"
                                    aria-controls="tab-content-week"
                                    aria-selected="false"
                                >
                                    Mingguan
                                </button>
                            </li>
                            <li>
                                <button
                                    class="inline-block rounded-t-lg border-b-2 border-transparent p-3 text-gray-700 hover:text-blue-600 dark:text-white dark:hover:text-blue-400"
                                    id="tab-month"
                                    data-tab="monthly"
                                    data-tabs-target="#tab-content-month"
                                    type="button"
                                    role="tab"
                                    aria-controls="tab-content-month"
                                    aria-selected="false"
                                >
                                    Bulanan
                                </button>
                            </li>
                            <li>
                                <button
                                    class="inline-block rounded-t-lg border-b-2 border-transparent p-3 text-gray-700 hover:text-blue-600 dark:text-white dark:hover:text-blue-400"
                                    id="tab-year"
                                    data-tab="yearly"
                                    data-tabs-target="#tab-content-year"
                                    type="button"
                                    role="tab"
                                    aria-controls="tab-content-year"
                                    aria-selected="false"
                                >
                                    Tahunan
                                </button>
                            </li>
                        </ul>

                        <!-- Export Buttons -->
                        <div class="flex-shrink-0">
                            <!-- Export Dropdown -->
                            <div
                                x-data="{ open: false }"
                                class="relative inline-block text-left"
                            >
                                <!-- Trigger button -->
                                <button
                                    @click="open = !open"
                                    class="flex items-center gap-2 rounded-md bg-blue-600 px-3 py-1.5 text-xs text-white shadow transition hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600"
                                >
                                    <i class="fa-solid fa-download text-sm"></i>
                                    <span>Export</span>
                                    <i class="fa-solid fa-caret-down text-[10px]"></i>
                                </button>

                                <!-- Dropdown menu -->
                                <div
                                    x-show="open"
                                    @click.outside="open = false"
                                    class="absolute right-0 z-20 mt-2 w-44 divide-y divide-gray-100 rounded-md bg-white shadow dark:bg-gray-700"
                                    x-transition
                                >
                                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                                        <!-- Export Harian (Label dinamis) -->
                                        <li>
                                            <button
                                                id="export-current"
                                                class="flex w-full items-center gap-3 px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            >
                                                <i
                                                    class="fa-solid fa-file-pdf w-5 text-base text-blue-500"
                                                ></i>
                                                <span id="export-current-label">Export Harian</span>
                                            </button>
                                        </li>

                                        <!-- Export Semua -->
                                        <li>
                                            <button
                                                id="export-all"
                                                class="flex w-full items-center gap-3 px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            >
                                                <i
                                                    class="fa-solid fa-file-pdf w-5 text-base text-green-600"
                                                ></i>
                                                <span>Export Semua</span>
                                            </button>
                                        </li>

                                        <!-- Export Excel -->
                                        <li>
                                            <a
                                                id="export-excel-btn"
                                                href="#"
                                                class="flex w-full items-center gap-3 px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            >
                                                <i
                                                    class="fa-solid fa-file-excel w-5 text-base text-yellow-500"
                                                ></i>
                                                <span>Export Excel</span>
                                            </a>
                                        </li>

                                        <!-- Export CSV -->
                                        <li>
                                            <button
                                                onclick="exportToCSV()"
                                                class="flex w-full items-center gap-3 px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                            >
                                                <i
                                                    class="fa-solid fa-file-csv w-5 text-base text-orange-500"
                                                ></i>
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
                        <div
                            class="rounded-lg bg-white p-4 shadow-sm dark:bg-gray-800"
                            id="tab-content-day"
                        >
                            <canvas id="chart-day" class="h-80 w-full"></canvas>
                        </div>
                        <div
                            class="hidden rounded-lg bg-white p-4 shadow-sm dark:bg-gray-800"
                            id="tab-content-week"
                        >
                            <canvas id="chart-week" class="h-80 w-full"></canvas>
                        </div>
                        <div
                            class="hidden rounded-lg bg-white p-4 shadow-sm dark:bg-gray-800"
                            id="tab-content-month"
                        >
                            <canvas id="chart-month" class="h-80 w-full"></canvas>
                        </div>
                        <div
                            class="hidden rounded-lg bg-white p-4 shadow-sm dark:bg-gray-800"
                            id="tab-content-year"
                        >
                            <canvas id="chart-year" class="h-80 w-full"></canvas>
                        </div>
                    </div>

                    <input type="hidden" id="daily-totals" value="@json($dailyTotals)" />
                    <input type="hidden" id="weekly-totals" value="@json($weeklyTotals)" />
                    <input type="hidden" id="monthly-totals" value="@json($monthlyTotals)" />
                    <input type="hidden" id="yearly-totals" value="@json($yearlyTotals)" />
                </div>

                <!-- TABEL AKTIVITAS TRANSAKSI HARI INI -->
                <div
                    class="rounded-xl bg-white p-5 shadow transition-colors duration-200 dark:bg-gray-800"
                >
                    <h4 class="mb-4 text-lg font-semibold text-gray-800 dark:text-gray-100">
                        Aktivitas Transaksi Hari Ini
                    </h4>
                    <div class="overflow-x-auto rounded-lg">
                        <table
                            class="min-w-full divide-y divide-gray-200 text-left text-sm dark:divide-gray-700"
                        >
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
                                    <th
                                        class="px-4 py-2 text-right text-gray-700 dark:text-gray-200"
                                    >
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                @forelse ($aktivitasHariIni as $item)
                                    <tr
                                        class="transition hover:bg-gray-50 dark:hover:bg-gray-700/50"
                                    >
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
                                                <span
                                                    class="text-xs text-green-600 dark:text-green-400"
                                                >
                                                    (-{{ $item->discount }}%)
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td
                                            colspan="5"
                                            class="py-4 text-center text-gray-500 dark:text-gray-400"
                                        >
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
                <div
                    class="rounded-xl bg-white p-5 shadow transition-colors duration-200 dark:bg-gray-800"
                >
                    <h4 class="mb-4 text-lg font-semibold text-gray-800 dark:text-gray-100">
                        Performa Kasir Hari Ini
                    </h4>
                    <div class="overflow-x-auto rounded-lg">
                        <table
                            class="min-w-full divide-y divide-gray-200 text-left text-sm dark:divide-gray-700"
                        >
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 font-bold">Kasir</th>
                                    <th class="px-6 py-3 text-center font-bold">
                                        Melakukan Transaksi
                                    </th>
                                    <th class="px-6 py-3 text-right font-bold">Total Penjualan</th>
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
                                        <td
                                            colspan="3"
                                            class="py-4 text-center text-gray-500 dark:text-gray-400"
                                        >
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
            <div class="flex w-full flex-col gap-6 lg:w-1/3">
                <!-- Produk Terjual -->
                <div
                    class="rounded-xl bg-white p-4 shadow transition-colors duration-200 dark:bg-gray-800"
                >
                    <h4
                        class="mb-2 text-center text-sm font-semibold text-gray-800 dark:text-gray-100"
                    >
                        Produk Terjual
                    </h4>
                    <canvas id="donut-product-sold" class="h-60 w-full"></canvas>
                </div>

                <!-- Produk Masuk -->
                <div
                    class="rounded-xl bg-white p-4 shadow transition-colors duration-200 dark:bg-gray-800"
                >
                    <h4
                        class="mb-2 text-center text-sm font-semibold text-gray-800 dark:text-gray-100"
                    >
                        Produk Masuk
                    </h4>
                    <canvas id="donut-product-in" class="h-60 w-full"></canvas>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // ===================== Charts =====================
        let chartDay, chartWeek, chartMonth, chartYear;
        let donutSold, donutIn;

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

        // ===================== Tabs Handling =====================
        const tabButtons = document.querySelectorAll('[data-tabs-target]');
        const tabContents = document.querySelectorAll('#chart-tabs-content > div');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-tabs-target');

                tabButtons.forEach(btn => {
                    // Reset semua tombol → non-aktif
                    btn.classList.remove("text-blue-600", "border-blue-600", "active");
                    btn.classList.add("text-gray-700", "dark:text-white");
                });

                // Tombol yang diklik → aktif
                button.classList.add("text-blue-600", "border-blue-600", "active");
                button.classList.remove("text-gray-700", "dark:text-white");

                // Konten tab
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                    if ("#" + content.id === targetId) {
                        content.classList.remove('hidden');
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


        // Render default → aktif tab "Harian"
        window.addEventListener('DOMContentLoaded', () => {
            initChartDay();
        });


        window.addEventListener('resize', () => {
            chartDay?.resize();
            chartWeek?.resize();
            chartMonth?.resize();
            chartYear?.resize();
            donutSold?.resize();
            donutIn?.resize();
        });

        // ===================== Donut Charts =====================
        const ctxSold = document.getElementById('donut-product-sold');
        if (donutSold) donutSold.destroy();
        donutSold = new Chart(ctxSold, {
            type: 'doughnut',
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
        const { jsPDF } = window.jspdf
        const exportCurrentBtn = document.getElementById('export-current')
        const exportAllBtn = document.getElementById('export-all')

        function renderChartToPDF(pdf, canvasId, title, tableData = null, addNewPage = false) {
            const canvas = document.getElementById(canvasId)
            if (!canvas) return
            if (addNewPage) pdf.addPage()

            const imgData = canvas.toDataURL('image/png', 1.0)
            const pdfWidth = pdf.internal.pageSize.getWidth() - 20
            const pdfHeight = (canvas.height * pdfWidth) / canvas.width

            pdf.setFontSize(14)
            pdf.text(title, 14, 20)
            pdf.addImage(imgData, 'PNG', 10, 30, pdfWidth, pdfHeight)

            if (tableData && tableData.rows.length > 0) {
                pdf.autoTable({
                    head: [tableData.headers],
                    body: tableData.rows,
                    startY: pdfHeight + 50,
                    styles: {
                        fontSize: 10,
                    },
                    headStyles: {
                        fillColor: [41, 128, 185],
                    },
                })
            }
        }

        // Export sesuai tab aktif
        exportCurrentBtn.addEventListener('click', () => {
            const activeTab = document.querySelector('#chart-tabs-content > div:not(.hidden)')
            if (!activeTab) return alert('Tidak ada tab aktif')
            const canvas = activeTab.querySelector('canvas')
            if (!canvas) return alert('Tidak ada grafik di tab ini')

            const pdf = new jsPDF('p', 'mm', 'a4')
            const tabName = activeTab.id.replace('tab-content-', '')
            let title = 'Laporan '
            let tableData = null

            switch (tabName) {
                case 'day':
                    title += 'Harian'
                    const dailyTotals = JSON.parse(document.getElementById('daily-totals').value)
                    tableData = {
                        headers: ['Tanggal', 'Produk', 'Total'],
                        rows: dailyTotals.map((d) => [
                            d.tanggal,
                            d.product,
                            Number(d.total).toLocaleString('id-ID'),
                        ]),
                    }
                    break
                case 'week':
                    title += 'Mingguan'
                    const weeklyTotals = JSON.parse(document.getElementById('weekly-totals').value)
                    tableData = {
                        headers: ['Periode', 'Produk', 'Total'],
                        rows: weeklyTotals.map((d) => [
                            d.week,
                            d.product,
                            Number(d.total).toLocaleString('id-ID'),
                        ]),
                    }
                    break
                case 'month':
                    title += 'Bulanan'
                    const monthlyTotals = JSON.parse(
                        document.getElementById('monthly-totals').value,
                    )
                    tableData = {
                        headers: ['Bulan', 'Produk', 'Total'],
                        rows: monthlyTotals.map((d) => [
                            d.month,
                            d.product,
                            Number(d.total).toLocaleString('id-ID'),
                        ]),
                    }
                    break
                case 'year':
                    title += 'Tahunan'
                    const yearlyTotals = JSON.parse(document.getElementById('yearly-totals').value)
                    tableData = {
                        headers: ['Tahun', 'Produk', 'Total'],
                        rows: yearlyTotals.map((d) => [
                            d.year,
                            d.product,
                            Number(d.total).toLocaleString('id-ID'),
                        ]),
                    }
                    break
            }

            renderChartToPDF(pdf, canvas.id, title, tableData)
            pdf.save('laporan-' + tabName + '.pdf')
        })

        function updateExportButtonLabel() {
            const activeTab = document.querySelector('#chart-tabs-content > div:not(.hidden)')
            if (!activeTab) return

            const tabName = activeTab.id.replace('tab-content-', '')
            let label = 'Export Harian' // default

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

        // pertama kali load
        updateExportButtonLabel()

        // setiap kali ganti tab
        document.querySelectorAll('#chartTabs button').forEach((tab) => {
            tab.addEventListener('click', () => {
                setTimeout(updateExportButtonLabel, 50)
            })
        })

        // Export semua
        exportAllBtn.addEventListener('click', () => {
            const pdf = new jsPDF('p', 'mm', 'a4')

            const dailyData = JSON.parse(document.getElementById('daily-totals').value)
            const weekData = JSON.parse(document.getElementById('weekly-totals').value)
            const monthData = JSON.parse(document.getElementById('monthly-totals').value)
            const yearData = JSON.parse(document.getElementById('yearly-totals').value)

            const charts = [
                {
                    id: 'chart-day',
                    title: 'Laporan Harian',
                    data: {
                        headers: ['Tanggal', 'Produk', 'Total'],
                        rows: dailyData.map((d) => [
                            d.tanggal,
                            d.product,
                            Number(d.total).toLocaleString('id-ID'),
                        ]),
                    },
                },
                {
                    id: 'chart-week',
                    title: 'Laporan Mingguan',
                    data: {
                        headers: ['Minggu', 'Produk', 'Total'],
                        rows: weekData.map((d) => [
                            d.week,
                            d.product,
                            Number(d.total).toLocaleString('id-ID'),
                        ]),
                    },
                },
                {
                    id: 'chart-month',
                    title: 'Laporan Bulanan',
                    data: {
                        headers: ['Bulan', 'Produk', 'Total'],
                        rows: monthData.map((d) => [
                            d.month,
                            d.product,
                            Number(d.total).toLocaleString('id-ID'),
                        ]),
                    },
                },
                {
                    id: 'chart-year',
                    title: 'Laporan Tahunan',
                    data: {
                        headers: ['Tahun', 'Produk', 'Total'],
                        rows: yearData.map((d) => [
                            d.year,
                            d.product,
                            Number(d.total).toLocaleString('id-ID'),
                        ]),
                    },
                },
            ]

            charts.forEach((chart, index) => {
                renderChartToPDF(pdf, chart.id, chart.title, chart.data, index > 0)
            })

            pdf.save('laporan-semua.pdf')
        })
    </script>

    <script>
        // Dataset dari controller
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

        // Export ke Excel (JS / XLSX, hanya data)
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

        // ===============================
        // Update tombol Export Excel + Chart
        // ===============================
        function updateExcelExportLink() {
            const activeTab = document.querySelector('button[data-tab].active')
            const type = activeTab ? activeTab.dataset.tab : 'daily'
            const btn = document.getElementById('export-excel-btn')
            btn.setAttribute('href', `/report/export-excel?type=${type}`)
        }

        // Panggil saat pertama kali halaman load
        updateExcelExportLink()

        // Update setiap kali tab berganti
        document.querySelectorAll('button[data-tab]').forEach((tab) => {
            tab.addEventListener('click', () => {
                setTimeout(updateExcelExportLink, 100) // delay kecil supaya class 'active' sudah berubah
            })
        })
    </script>
@endpush
