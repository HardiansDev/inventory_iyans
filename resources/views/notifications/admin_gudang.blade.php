@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Notifikasi Admin Gudang</title>
@endsection

@section('content')
    <div class="container mx-auto mt-6 px-4">
        {{-- Breadcrumbs --}}
        <nav class="text-sm text-gray-600 mb-4">
            <a href="{{ url('/productin') }}" class="hover:underline">Produk Masuk</a> /
            <span class="font-semibold">Notifikasi</span>
        </nav>

        <h2 class="text-2xl font-bold mb-6 text-gray-800">Notifikasi Permintaan Produk</h2>

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full border-collapse">
                <thead>
                    <tr class="bg-white text-gray-700 uppercase text-sm">
                        <th class="px-6 py-3 text-left">Produk</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Tanggal Update</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($notifs as $notif)
                        <tr onclick="window.location='{{ route('notifications.admin_gudang.show', $notif->id) }}'"
                            class="cursor-pointer transition
                {{ $notif->is_read ? 'bg-gray-100 hover:bg-gray-200' : 'bg-white hover:bg-gray-50' }}">

                            <td class="px-6 py-4 font-medium text-gray-500">
                                {{ $notif->product->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($notif->status === 'disetujui')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                        Disetujui
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $notif->updated_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-6 text-gray-500">
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
