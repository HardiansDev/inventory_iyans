@extends('layouts.master')

@section('title')
    <title>Tracking Tree - Inventory Iyans</title>
@endsection

@section('content')
    <section class="mb-6 rounded-lg bg-white dark:bg-gray-900 p-6 shadow-sm">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Tracking Tree</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Lihat status persetujuan produk masuk.</p>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>

                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Produk</th>
                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Status</th>
                        <th class="px-4 py-2 text-left text-gray-600 dark:text-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($productsIn as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">

                            <td class="px-4 py-2 text-gray-700 dark:text-gray-300">
                                {{ optional($item->product)->name ?? '-' }}</td>
                            <td class="px-4 py-2">
                                @if ($item->status === 'menunggu')
                                    <span
                                        class="rounded bg-yellow-100 dark:bg-yellow-900 px-2 py-1 text-xs text-yellow-700 dark:text-yellow-300">Menunggu</span>
                                @elseif ($item->status === 'disetujui')
                                    <span
                                        class="rounded bg-green-100 dark:bg-green-900 px-2 py-1 text-xs text-green-700 dark:text-green-300">Disetujui</span>
                                @elseif ($item->status === 'ditolak')
                                    <span
                                        class="rounded bg-red-100 dark:bg-red-900 px-2 py-1 text-xs text-red-700 dark:text-red-300">Ditolak</span>
                                @else
                                    <span
                                        class="rounded bg-gray-100 dark:bg-gray-700 px-2 py-1 text-xs text-gray-600 dark:text-gray-300">Tidak
                                        Diketahui</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('trackingtree.show', $item->id) }}"
                                    class="rounded bg-blue-600 px-3 py-1 text-white text-xs hover:bg-blue-700">
                                    Lihat
                                </a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection
