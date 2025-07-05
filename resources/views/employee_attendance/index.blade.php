@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Absensi Pegawai</title>
@endsection

@section('content')
    <!-- Header Section -->
    <section class="content-header py-4 bg-light rounded mb-4">
        <div class="container-fluid">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h1 class="text-dark mb-0">Absensi Pegawai</h1>
                </div>
                <div class="col-auto">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none">
                                <i class="fa fa-dashboard"></i> Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Absensi Pegawai</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="container-fluid">
        <div class="card shadow-sm">
            <div class="card-body">
                {{-- <a href="{{ route('employee-attendance.qr', $item->employee->id) }}" class="btn btn-sm btn-info">QR</a> --}}

                <a href="{{ route('employee-attendance.scan') }}" class="btn btn-primary btn-sm mb-3">
                    <i class="fa fa-qrcode"></i> Scan QR Absen
                </a>

                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Pegawai</th>
                                <th>NIP</th>
                                <th>Tanggal</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Status</th>
                                {{-- <th>Catatan</th> --}}
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendances as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->employee->name }}</td>
                                    <td>{{ $item->employee->employee_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                                    <td>{{ $item->check_in ?? '-' }}</td>
                                    <td>{{ $item->check_out ?? '-' }}</td>
                                    <td>
                                        @if ($item->check_in && !$item->check_out)
                                            Hadir
                                        @elseif ($item->check_in && $item->check_out)
                                            Sudah Pulang
                                        @else
                                            Belum Absen
                                        @endif
                                    </td>

                                    {{-- <td>{{ $item->note ?? '-' }}</td> --}}
                                    <td>
                                        @if (!$item->check_out)
                                            <a href="{{ route('employee-attendance.scan') }}"
                                                class="btn btn-success btn-sm">
                                                Absen Pulang
                                            </a>
                                        @else
                                            <span class="badge bg-success"></span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination jika tidak pakai datatables --}}
                {{-- {{ $attendances->links() }} --}}
            </div>
        </div>
    </div>
@endsection
