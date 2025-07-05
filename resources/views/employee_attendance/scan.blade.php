@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Scan QR Absensi</title>
@endsection

@section('content')
    <section class="content-header py-4 bg-light rounded mb-4">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h1 class="text-dark mb-0">Scan QR Absensi</h1>
                </div>
                <div class="col-auto">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Scan Absensi</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <div id="qr-reader" style="width:100%; max-width:500px; margin:auto; min-height: 300px;"></div>
                <p class="mt-3 text-muted">Arahkan kamera ke QR Code untuk melakukan absensi</p>

                <hr class="my-4">

                <h5>Atau Upload QR dari File</h5>
                <form action="{{ route('employee-attendance.processUpload') }}" method="POST" enctype="multipart/form-data"
                    class="mb-3">
                    @csrf
                    <input type="file" name="qr_image" accept="image/*" class="form-control mb-2" required>
                    <button type="submit" class="btn btn-primary btn-sm">Upload QR Code</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <script>
        const officeLatitude = -6.200000; // Koordinat kantor
        const officeLongitude = 106.816666;
        const maxDistance = 0.2; // 200 meter

        function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
            const R = 6371;
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return R * c;
        }

        function onScanSuccess(decodedText, decodedResult) {
            html5QrCode.stop().then(() => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const userLat = position.coords.latitude;
                        const userLon = position.coords.longitude;
                        const distance = getDistanceFromLatLonInKm(userLat, userLon, officeLatitude,
                            officeLongitude);

                        if (distance > maxDistance) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Diluar Jangkauan',
                                text: `Kamu berada di luar jangkauan kantor! (${(distance * 1000).toFixed(1)} meter)`
                            }).then(() => location.reload());
                            return;
                        }

                        const type = document.querySelector('input[name="type"]:checked')?.value ||
                            'check_in';

                        fetch("{{ route('employee-attendance.qrStore') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    employee_id: decodedText,
                                    latitude: userLat,
                                    longitude: userLon,
                                    type: type
                                })
                            })
                            .then(res => {
                                if (!res.ok) return res.json().then(e => Promise.reject(e));
                                return res.json();
                            })
                            .then(data => {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: data.message || 'Absen berhasil!'
                                }).then(() => location.reload());
                            })
                            .catch(err => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal Absen',
                                    text: err.message || 'Terjadi kesalahan'
                                }).then(() => location.reload());
                            });

                    }, function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Lokasi Error',
                            text: "Gagal mendapatkan lokasi: " + error.message
                        }).then(() => location.reload());
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Geolocation Tidak Didukung',
                        text: "Browser tidak mendukung Geolocation."
                    }).then(() => location.reload());
                }
            });
        }

        const html5QrCode = new Html5Qrcode("qr-reader");

        html5QrCode.start({
            facingMode: "environment"
        }, {
            fps: 10,
            qrbox: 250
        }, onScanSuccess).catch(err => {
            Swal.fire({
                icon: 'error',
                title: 'Kamera Gagal Dibuka',
                text: err
            });
        });
    </script>
@endpush
