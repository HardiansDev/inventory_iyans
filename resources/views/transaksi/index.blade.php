@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID - Riwayat Transaksi</title>
@endsection

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 px-6 py-8">
        <div class="max-w-7xl mx-auto">
            {{-- Header --}}
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">Riwayat Transaksi</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Lihat semua transaksi yang telah diproses
                        pembayaran.</p>
                </div>
            </div>

            {{-- Table Container --}}
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="transaksiTable" class="min-w-full border-collapse">
                        <thead class="bg-blue-600 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Nomor Transaksi</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Tanggal</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Produk</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Metode Pembayaran</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Total</th>
                                <th class="px-4 py-3 text-center text-sm font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($salesDetails as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200 font-medium">
                                        {{ $item->transaction_number }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                        {{ $item->date_order ? \Carbon\Carbon::parse($item->date_order)->format('d/m/Y H:i') : '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                                        {{ optional(optional($item->sales->productIn)->product)->name ?? '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="inline-flex items-center px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $item->metode_pembayaran === 'cash'
                                            ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100'
                                            : 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100' }}">
                                            {{ strtoupper($item->metode_pembayaran) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200 font-semibold">
                                        Rp {{ number_format($item->total, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <a href="{{ route('print.receipt', ['transaction_number' => $item->transaction_number]) }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm transition"
                                            target="_blank">
                                            <i class="fa fa-eye mr-1"></i> Lihat Struk
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-6 text-gray-500 dark:text-gray-400">
                                        Belum ada transaksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination placeholder (jika ingin ditambah nanti) --}}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#transaksiTable').DataTable({
                responsive: true,
                pageLength: 10,
                order: [
                    [1, 'desc']
                ],
                language: {
                    search: "🔍 Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    zeroRecords: "Tidak ditemukan data yang sesuai",
                    info: "Menampilkan _PAGE_ dari _PAGES_ halaman",
                    infoEmpty: "Tidak ada data tersedia",
                    infoFiltered: "(difilter dari total _MAX_ data)"
                },
                dom: '<"flex justify-between items-center mb-4"lf>t<"flex justify-between items-center mt-4"ip>',
            });
        });
    </script>
@endpush
