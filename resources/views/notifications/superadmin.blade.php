@extends('layouts.master')
@section('title')
    <title>KASIRIN.ID - Detail Notifikasi</title>
@endsection

@section('content')
    <div class="container mx-auto mt-6">
        <h2 class="text-xl font-bold mb-4">Notifikasi Permintaan Produk</h2>
        <div class="overflow-x-auto rounded-lg shadow">
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700">
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Pemohon</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Produk</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-200">Tanggal</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700 dark:text-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                    @forelse($notifs as $notif)
                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                                {{ $notif->requester_name }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-200">
                                {{ $notif->product->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                {{ $notif->created_at->format('d-m-Y H:i') }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <a href="{{ route('product.confirmation', $notif->id) }}"
                                    class="inline-flex items-center gap-1 rounded-md bg-blue-600 px-3 py-1.5 text-sm font-medium text-white shadow hover:bg-blue-700 transition">
                                    <i class="fas fa-check-circle"></i>
                                    Konfirmasi
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                Tidak ada notifikasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection
