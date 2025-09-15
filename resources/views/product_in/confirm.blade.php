@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID - Konfirmasi Permintaan Produk</title>
@endsection

@section('content')
    <div
        class="mx-auto max-w-2xl rounded-xl bg-white dark:bg-gray-800 p-8 shadow-lg ring-1 ring-gray-200 dark:ring-gray-700">
        <h2 class="mb-6 text-2xl font-semibold text-gray-800 dark:text-gray-100">
            Konfirmasi Permintaan Produk
        </h2>

        <div class="space-y-4 text-sm text-gray-700 dark:text-gray-300">
            <div class="flex justify-between border-b pb-2 border-gray-200 dark:border-gray-700">
                <span class="font-medium text-gray-600 dark:text-gray-400">Nama Produk</span>
                <span class="text-gray-900 dark:text-gray-100">{{ $permintaan->product->name }}</span>
            </div>

            <div class="flex justify-between border-b pb-2 border-gray-200 dark:border-gray-700">
                <span class="font-medium text-gray-600 dark:text-gray-400">Tanggal Permohonan</span>
                <span class="text-gray-900 dark:text-gray-100">{{ $permintaan->date }}</span>
            </div>

            <div class="flex justify-between border-b pb-2 border-gray-200 dark:border-gray-700">
                <span class="font-medium text-gray-600 dark:text-gray-400">Pemohon:</span>
                <span class="text-gray-900 dark:text-gray-100">{{ $permintaan->requester_name }}</span>
            </div>

            <div class="flex justify-between">
                <span class="font-medium text-gray-600 dark:text-gray-400">Jumlah Diajukan</span>
                <span class="text-gray-900 dark:text-gray-100">{{ $permintaan->qty }} pcs</span>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-4">
            <!-- Tolak -->
            <button type="button"
                class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 transition-all"
                onclick="document.getElementById('rejectModal').classList.remove('hidden')">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.536-11.536a1 1 0 00-1.414-1.414L10 7.586 7.879 5.465a1 1 0 10-1.414 1.414L8.586 9l-2.121 2.121a1 1 0 101.414 1.414L10 10.414l2.121 2.121a1 1 0 001.414-1.414L11.414 9l2.122-2.121z"
                        clip-rule="evenodd"></path>
                </svg>
                Tolak
            </button>

            <!-- Konfirmasi -->
            <form action="{{ route('product.approve', $permintaan->id) }}" method="POST">
                @csrf
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition-all">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-7.414 7.414a1 1 0 01-1.414 0L3.293 9.414a1 1 0 011.414-1.414L8 11.293l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Konfirmasi
                </button>
            </form>

        </div>
    </div>

    <!-- Modal Tolak -->
    <div id="rejectModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="w-full max-w-md rounded-lg bg-white dark:bg-gray-800 p-6 shadow-lg">
            <h3 class="mb-4 text-lg font-semibold text-gray-800 dark:text-gray-100">Catatan Penolakan</h3>
            <form action="{{ route('product.reject', $permintaan->id) }}" method="POST">
                @csrf
                <textarea name="catatan" rows="4"
                    class="w-full rounded border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-900 p-2 text-gray-800 dark:text-gray-200 focus:border-blue-500 focus:outline-none"
                    placeholder="Masukkan alasan penolakan..." required></textarea>

                <div class="mt-4 flex justify-end space-x-3">
                    <button type="button"
                        class="rounded border border-gray-300 dark:border-gray-600 px-4 py-2 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700"
                        onclick="document.getElementById('rejectModal').classList.add('hidden')">Batal</button>

                    <button type="submit" class="rounded bg-red-600 px-4 py-2 text-white hover:bg-red-700">Kirim</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openBtn = document.getElementById('openRejectModal');
            const cancelBtn = document.getElementById('cancelReject');
            const modal = document.getElementById('rejectModal');

            openBtn?.addEventListener('click', () => {
                modal.classList.remove('hidden');
            });

            cancelBtn?.addEventListener('click', () => {
                modal.classList.add('hidden');
            });

            window.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
@endsection
