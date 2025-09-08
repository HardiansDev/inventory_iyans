@section('title')
    <title>Tracking Tree Detail - Inventory Iyans</title>
@endsection

<nav class="flex mb-6 text-sm text-gray-600 dark:text-gray-300" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li>
            <div class="flex items-center">
                <svg class="w-4 h-4 mx-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M7.05 9.293a1 1 0 000 1.414L11.293 15a1 1 0 101.414-1.414L9.464 10l3.243-3.586A1 1 0 0011.293 5L7.05 9.293z">
                    </path>
                </svg>
                <a href="{{ route('trackingtree.index') }}"
                    class="ml-1 text-gray-600 hover:text-blue-600 dark:hover:text-blue-400 md:ml-2">
                    Tracking Tree
                </a>
            </div>
        </li>
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="w-4 h-4 mx-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M7.05 9.293a1 1 0 000 1.414L11.293 15a1 1 0 101.414-1.414L9.464 10l3.243-3.586A1 1 0 0011.293 5L7.05 9.293z">
                    </path>
                </svg>
                <span class="ml-1 text-gray-500 dark:text-gray-400 md:ml-2">Detail</span>
            </div>
        </li>
    </ol>
</nav>
<!-- Progress Roadmap -->
<div class="mt-8">
    <ol class="flex items-center justify-between w-full text-sm font-medium text-gray-500 dark:text-gray-400">
        <!-- Step 1: Menunggu -->
        <li
            class="flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-300 after:border-4 dark:after:border-gray-600">
            <span
                class="flex items-center {{ $status === 'menunggu' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">
                <span
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border {{ $status === 'menunggu' ? 'border-blue-600 bg-blue-100 dark:border-blue-400 dark:bg-blue-900' : 'border-gray-400 bg-gray-200 dark:border-gray-600 dark:bg-gray-700' }}">
                    1
                </span>
                <span class="ml-2">Proses</span>
            </span>
        </li>

        <!-- Step 2: Disetujui -->
        <li
            class="flex w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-300 after:border-4 dark:after:border-gray-600">
            <span
                class="flex items-center {{ $status === 'disetujui' ? 'text-green-600 dark:text-green-400' : 'text-gray-500 dark:text-gray-400' }}">
                <span
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border {{ $status === 'disetujui' ? 'border-green-600 bg-green-100 dark:border-green-400 dark:bg-green-900' : 'border-gray-400 bg-gray-200 dark:border-gray-600 dark:bg-gray-700' }}">
                    2
                </span>
                <span class="ml-2">Disetujui</span>
            </span>
        </li>

        <!-- Step 3: Ditolak -->
        <li class="flex items-center">
            <span
                class="flex items-center {{ $status === 'ditolak' ? 'text-red-600 dark:text-red-400' : 'text-gray-500 dark:text-gray-400' }}">
                <span
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border {{ $status === 'ditolak' ? 'border-red-600 bg-red-100 dark:border-red-400 dark:bg-red-900' : 'border-gray-400 bg-gray-200 dark:border-gray-600 dark:bg-gray-700' }}">
                    3
                </span>
                <span class="ml-2">Ditolak</span>
            </span>
        </li>
    </ol>
</div>

<!-- Keterangan Status -->
<div class="mt-6 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
    @if ($status === 'menunggu')
        <p class="text-yellow-600 dark:text-yellow-400">⏳ Produk masih menunggu persetujuan.</p>
    @elseif ($status === 'disetujui')
        <p class="text-green-600 dark:text-green-400">✅ Produk sudah disetujui dan bisa dijual.</p>
    @elseif ($status === 'ditolak')
        <p class="text-red-600 dark:text-red-400">❌ Produk ditolak. Silakan periksa kembali data produk.</p>
    @else
        <p class="text-gray-600 dark:text-gray-300">🚧 Status produk belum diketahui.</p>
    @endif
</div>
