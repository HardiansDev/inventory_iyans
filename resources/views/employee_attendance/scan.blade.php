@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Scan QR Absensi</title>
@endsection

@section('content')
    <!-- Header -->
    <section class="mb-6 rounded-md bg-gray-100 py-4 dark:bg-gray-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-900 dark:text-white">Scan QR Absensi</h1>
                <nav class="text-sm text-gray-500 dark:text-gray-300">
                    <ol class="flex items-center space-x-1">
                        <li>
                            <a
                                href="{{ route('dashboard') }}"
                                class="text-blue-600 hover:underline"
                            >Dashboard</a>
                        </li>
                        <li>/</li>
                        <li class="text-gray-700 dark:text-gray-200">Scan Absensi</li>
                    </ol>
                </nav>
            </div>
        </div>
    </section>

    <!-- QR Scanner & Upload -->
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-lg bg-white p-6 text-center shadow dark:bg-gray-900">
            <div
                id="qr-reader"
                class="mx-auto"
                style="width:100%; max-width:500px; min-height:300px;"
            ></div>
            <p class="mt-4 text-sm text-gray-500">Arahkan kamera ke QR Code untuk melakukan absensi.</p>

            <div class="my-6 border-t border-gray-200 dark:border-gray-700"></div>

            <h2 class="mb-2 text-lg font-medium text-gray-800 dark:text-gray-200">Atau Upload Gambar QR</h2>
            <form
                action="{{ route('employee-attendance.processUpload') }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-4"
            >
                @csrf
                <input
                    type="file"
                    name="qr_image"
                    accept="image/*"
                    required
                    class="block w-full cursor-pointer text-sm text-gray-700 file:mr-4 file:rounded file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-blue-700 hover:file:bg-blue-100 dark:text-gray-200"
                />

                <button
                    type="submit"
                    class="inline-flex items-center rounded bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="mr-2 h-4 w-4"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                    >
                        <path
                            d="M4 3a1 1 0 00-1 1v12a1 1 0 001 1h5a1 1 0 001-1V8h4v8a1 1 0 001 1h5a1 1 0 001-1V4a1 1 0 00-1-1H4z"
                        />
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
        const officeLatitude = -6.2
        const officeLongitude = 106.816666
        const maxDistance = 0.2

        function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
            const R = 6371
            const dLat = ((lat2 - lat1) * Math.PI) / 180
            const dLon = ((lon2 - lon1) * Math.PI) / 180
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos((lat1 * Math.PI) / 180) *
                Math.cos((lat2 * Math.PI) / 180) *
                Math.sin(dLon / 2) *
                Math.sin(dLon / 2)
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a))
            return R * c
        }

        function onScanSuccess(decodedText, decodedResult) {
            html5QrCode.stop().then(() => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const userLat = position.coords.latitude
                            const userLon = position.coords.longitude
                            const distance = getDistanceFromLatLonInKm(
                                userLat, userLon, officeLatitude, officeLongitude
                            )

                            if (distance > maxDistance) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Diluar Jangkauan',
                                    text: `Kamu berada di luar jangkauan kantor! (${(distance * 1000).toFixed(1)} meter)`,
                                }).then(() => location.reload())
                                return
                            }

                            const type =
                                document.querySelector('input[name="type"]:checked')?.value || 'check_in'

                            fetch('{{ route('employee-attendance.qrStore') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    },
                                    body: JSON.stringify({
                                        employee_id: decodedText,
                                        latitude: userLat,
                                        longitude: userLon,
                                        type: type,
                                    }),
                                })
                                .then(res => res.ok ? res.json() : res.json().then(err => Promise.reject(err)))
                                .then(data => {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: data.message || 'Absen berhasil!',
                                    }).then(() => location.reload())
                                })
                                .catch(err => {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal Absen',
                                        text: err.message || 'Terjadi kesalahan',
                                    }).then(() => location.reload())
                                })
                        },
                        error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Lokasi Error',
                                text: 'Gagal mendapatkan lokasi: ' + error.message,
                            }).then(() => location.reload())
                        }
                    )
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Geolocation Tidak Didukung',
                        text: 'Browser tidak mendukung Geolocation.',
                    }).then(() => location.reload())
                }
            })
        }

        const html5QrCode = new Html5Qrcode('qr-reader')
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
                })
            })
    </script>
@endpush
