@extends('layouts.master')

@section('content')
    <div class="mx-auto max-w-xl rounded bg-white p-6 shadow">
        <h2 class="mb-4 text-xl font-semibold">Konfirmasi Permintaan Produk</h2>

        <div class="mb-4">
            <label class="block font-medium">Nama Produk:</label>
            <p>{{ $permintaan->product->name }}</p>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Tanggal Permohonan:</label>
            <p>{{ $permintaan->date }}</p>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Pemohon:</label>
            <p>{{ $permintaan->requester_name }}</p>
        </div>

        <div class="mb-4">
            <label class="block font-medium">Jumlah Diajukan:</label>
            <p>{{ $permintaan->qty }} pcs</p>
        </div>

        <div class="mt-6 flex justify-between">
            <form
                action="{{ route('product.approve', $permintaan->id) }}"
                method="POST"
            >
                @csrf
                <button
                    type="submit"
                    class="rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700"
                >
                    ✅ Konfirmasi
                </button>
            </form>

            <form
                action="{{ route('product.reject', $permintaan->id) }}"
                method="POST"
            >
                @csrf
                <button
                    type="submit"
                    class="rounded bg-red-600 px-4 py-2 text-white hover:bg-red-700"
                >
                    ❌ Tolak
                </button>
            </form>
        </div>
    </div>
@endsection
