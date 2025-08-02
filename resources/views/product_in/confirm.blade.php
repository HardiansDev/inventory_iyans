@extends('layouts.master')

@section('content')
    <div class="mx-auto max-w-2xl rounded-xl bg-white p-8 shadow-lg ring-1 ring-gray-200">
        <h2 class="mb-6 text-2xl font-semibold text-gray-800">Konfirmasi Permintaan Produk</h2>

        <div class="space-y-4 text-sm text-gray-700">
            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">Nama Produk:</span>
                <span class="text-gray-900">{{ $permintaan->product->name }}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">Tanggal Permohonan:</span>
                <span class="text-gray-900">{{ $permintaan->date }}</span>
            </div>

            <div class="flex justify-between border-b pb-2">
                <span class="font-medium text-gray-600">Pemohon:</span>
                <span class="text-gray-900">{{ $permintaan->requester_name }}</span>
            </div>

            <div class="flex justify-between">
                <span class="font-medium text-gray-600">Jumlah Diajukan:</span>
                <span class="text-gray-900">{{ $permintaan->qty }} pcs</span>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-4">
            <button type="button"
                class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 transition-all"
                onclick="document.getElementById('rejectModal').classList.remove('hidden')">
                ❌ Tolak
            </button>


            <!-- Langsung Approve -->
            <form action="{{ route('product.approve', $permintaan->id) }}" method="POST">
                @csrf
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700 transition-all">
                    ✅ Konfirmasi
                </button>
            </form>
        </div>
    </div>

    <!-- Modal Tolak -->
    <div id="rejectModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-lg">
            <h3 class="mb-4 text-lg font-semibold text-gray-800">Catatan Penolakan</h3>
            <form action="{{ route('product.reject', $permintaan->id) }}" method="POST">
                @csrf
                <textarea name="catatan" rows="4"
                    class="w-full rounded border border-gray-300 p-2 focus:border-blue-500 focus:outline-none"
                    placeholder="Masukkan alasan penolakan..." required></textarea>

                <div class="mt-4 flex justify-end space-x-3">
                    <button type="button" class="rounded border px-4 py-2 text-gray-600 hover:bg-gray-100"
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
