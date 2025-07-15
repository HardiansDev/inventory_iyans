@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Diskon</title>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center bg-teal text-white">
                <h5 class="mb-0">Manajemen Diskon</h5>
                <a href="{{ route('discounts.create') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-plus me-1"></i> Tambah Diskon
                </a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Diskon</th>
                                <th>Nilai (%)</th>
                                <th class="text-center" style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($discounts as $discount)
                                <tr>
                                    <td>{{ $discount->name }}</td>
                                    <td>{{ $discount->nilai ?? '-' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('discounts.edit', $discount->id) }}"
                                            class="btn btn-sm btn-warning me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('discounts.destroy', $discount->id) }}" method="POST"
                                            style="display:inline-block;"
                                            onsubmit="return confirm('Yakin ingin menghapus diskon ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Belum ada data diskon.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
