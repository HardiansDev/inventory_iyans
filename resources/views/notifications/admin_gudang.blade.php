@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID - Notifikasi</title>
@endsection

@section('content')
    <div class="container mx-auto mt-6 px-4">
        {{-- Breadcrumbs --}}
        <nav class="text-sm text-gray-600 dark:text-gray-400 mb-4">
            <a href="{{ url('/productin') }}" class="hover:underline">Produk Masuk</a> /
            <span class="font-semibold text-gray-800 dark:text-gray-200">Notifikasi</span>
        </nav>

        <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-gray-100">
            Notifikasi Permintaan Produk
        </h2>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700">
            <table class="min-w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase text-sm">
                        <th class="px-6 py-3 text-left">Produk</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Tanggal Update</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($notifs as $notif)
                        <tr onclick="window.location='{{ route('notifications.admin_gudang.show', $notif->id) }}'"
                            class="cursor-pointer transition
                            {{ $notif->is_read ? 'bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800' : 'bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700' }}">

                            <td class="px-6 py-4 font-medium text-gray-700 dark:text-gray-300">
                                {{ $notif->product->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($notif->status === 'disetujui')
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 dark:bg-green-800 text-green-700 dark:text-green-200">
                                        Disetujui
                                    </span>
                                @else
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 dark:bg-red-800 text-red-700 dark:text-red-200">
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                                {{ $notif->updated_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-6 text-gray-500 dark:text-gray-400">
                                Tidak ada feedback.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $notifs->links('pagination::tailwind') }}
        </div>
    </div>
@endsection
