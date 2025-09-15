@extends('layouts.master')

@section('content')
    <div class="container mx-auto mt-6">
        <h2 class="text-xl font-bold mb-4">Notifikasi Permintaan Produk</h2>
        <table class="table-auto w-full border">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2">Requester</th>
                    <th class="px-4 py-2">Produk</th>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notifs as $notif)
                    <tr>
                        <td class="border px-4 py-2">{{ $notif->requester_name }}</td>
                        <td class="border px-4 py-2">{{ $notif->product->name ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $notif->created_at->format('d-m-Y H:i') }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('product.confirmation', $notif->id) }}" class="text-blue-600">Konfirmasi</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-2">Tidak ada notifikasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{-- <div class="mt-4">
            {{ $notifs->links() }}
        </div> --}}
    </div>
@endsection
