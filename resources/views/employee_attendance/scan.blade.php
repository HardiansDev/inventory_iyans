@extends('layouts.master')

@section('title')
    <title>KASIRIN.ID - Scan QR Absensi</title>
@endsection

@section('content')
    <!-- Header -->
    <section class="mb-6 rounded-lg bg-white p-6 shadow-sm">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
            <!-- Title -->
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Scan QR Absensi</h1>
                <p class="mt-1 text-sm text-gray-500">Gunakan QR Code untuk melakukan absensi masuk atau pulang</p>
            </div>

            <!-- Optional Back Button -->
            <a href="{{ route('employee-attendance.index') }}"
                class="inline-flex items-center rounded-md bg-gray-500 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-600 transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </section>



    <!-- QR Scanner & Upload -->
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-lg bg-white p-6 text-center shadow dark:bg-gray-900">
            <div id="qr-reader" class="mx-auto" style="width:100%; max-width:500px; min-height:300px;"></div>
            <input type="hidden" id="absenType" value="{{ request('type') ?? 'check_in' }}">

            <p class="mt-4 text-sm text-gray-500">Arahkan kamera ke QR Code untuk melakukan absensi.</p>

            <div class="my-6 border-t border-gray-200 dark:border-gray-700"></div>

            <h2 class="mb-2 text-lg font-medium text-gray-800 dark:text-gray-200">Atau Upload Gambar QR</h2>
            <form action="{{ route('employee-attendance.processUpload') }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                <input type="file" name="qr_image" accept="image/*" required
                    class="block w-full cursor-pointer text-sm text-gray-700 file:mr-4 file:rounded file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100 dark:text-gray-200" />

                <button type="submit"
                    class="inline-flex items-center rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path
                            d="M4 3a1 1 0 00-1 1v12a1 1 0 001 1h5a1 1 0 001-1V8h4v8a1 1 0 001 1h5a1 1 0 001-1V4a1 1 0 00-1-1H4z" />
                    </svg>
                    Upload QR Code
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            html5QrCode.stop().then(() => {
                const type = document.getElementById('absenType').value; // Ambil dari hidden input

                fetch('{{ route('employee-attendance.qrStore') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({
                            employee_id: decodedText,
                            latitude: 0,
                            longitude: 0,
                            type: type,
                        }),
                    })
                    .then(async res => {
                        const data = await res.json();
                        if (!res.ok) throw data;

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message || 'Absen berhasil!',
                        }).then(() => location.href = '{{ route('employee-attendance.index') }}');
                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Absen',
                            text: err.message || 'Terjadi kesalahan',
                        }).then(() => location.reload());
                    });
            });
        }


        const html5QrCode = new Html5Qrcode('qr-reader');
        html5QrCode
            .start({
                facingMode: 'environment'
            }, {
                fps: 10,
                qrbox: 250
            }, onScanSuccess)
            .catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Kamera Gagal Dibuka',
                    text: err,
                });
            });
    </script>
@endpush
