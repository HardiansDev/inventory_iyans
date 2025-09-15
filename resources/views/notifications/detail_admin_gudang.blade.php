@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID - Detail Feedback Notifikasi</title>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-6 border-b pb-3">
                📩 Detail Feedback Notifikasi
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Produk</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ $notif->product->name ?? '-' }}
                    </p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Jumlah</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ $notif->qty }}
                    </p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Requester</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ $notif->requester_name }}
                    </p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Penerima</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        {{ $notif->recipient ?? '-' }}
                    </p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Status</p>
                    @if ($notif->status === 'disetujui')
                        <p class="text-lg font-semibold text-green-600">✔ Telah Disetujui</p>
                    @elseif ($notif->status === 'ditolak')
                        <p class="text-lg font-semibold text-red-600">✖ Ditolak</p>
                    @else
                        <p class="text-lg font-semibold text-gray-600">{{ ucfirst($notif->status) }}</p>
                    @endif
                </div>

                @if (!empty($notif->catatan))
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg md:col-span-2">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Keterangan</p>
                        <p class="text-base text-gray-900 dark:text-gray-200">
                            {{ $notif->catatan }}
                        </p>
                    </div>
                @endif

                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg md:col-span-2">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Diperbarui pada</p>
                    <p class="text-base font-medium text-gray-900 dark:text-gray-200">
                        {{ $notif->updated_at->format('d M Y, H:i') }}
                    </p>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('notifications.admin_gudang') }}"
                    class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-lg shadow transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
