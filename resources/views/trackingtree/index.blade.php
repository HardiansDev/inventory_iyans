@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID - Tracking</title>
@endsection

@section('content')
    <section class="mb-6 rounded-lg bg-white dark:bg-gray-900 p-6 shadow-sm">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Tracking Tree</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Lihat status persetujuan produk masuk.</p>

        <div class="mt-6 overflow-x-auto">
            <div class="overflow-hidden rounded-xl shadow-md border border-gray-200 dark:border-gray-700">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 text-left">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Produk</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                            <th class="px-4 py-3 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($productsIn as $item)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                <!-- Produk -->
                                <td class="px-4 py-3 text-gray-700 dark:text-gray-300">
                                    {{ optional($item->product)->name ?? '-' }}
                                </td>

                                <!-- Status -->
                                <td class="px-4 py-3">
                                    @if ($item->status === 'menunggu')
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-yellow-100 dark:bg-yellow-900 px-3 py-1 text-xs font-medium text-yellow-700 dark:text-yellow-300">
                                            <i class="fas fa-hourglass-half"></i> Menunggu
                                        </span>
                                    @elseif ($item->status === 'disetujui')
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-green-100 dark:bg-green-900 px-3 py-1 text-xs font-medium text-green-700 dark:text-green-300">
                                            <i class="fas fa-check-circle"></i> Disetujui
                                        </span>
                                    @elseif ($item->status === 'ditolak')
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-red-100 dark:bg-red-900 px-3 py-1 text-xs font-medium text-red-700 dark:text-red-300">
                                            <i class="fas fa-times-circle"></i> Ditolak
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full bg-gray-100 dark:bg-gray-700 px-3 py-1 text-xs font-medium text-gray-600 dark:text-gray-300">
                                            <i class="fas fa-question-circle"></i> Tidak Diketahui
                                        </span>
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td class="px-4 py-3">
                                    <a href="{{ route('trackingtree.show', $item->id) }}"
                                        class="inline-flex items-center gap-1 rounded-lg bg-blue-600 px-3 py-1 text-white text-xs font-medium hover:bg-blue-700 transition">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
