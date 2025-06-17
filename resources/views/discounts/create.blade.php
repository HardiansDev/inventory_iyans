@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Tambah Diskon</title>
@endsection

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-teal text-white">
                <h5 class="mb-0">
                    <i class="fas fa-percent me-1"></i> {{ isset($discount) ? 'Edit Diskon' : 'Tambah Diskon' }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ isset($discount) ? route('discounts.update', $discount->id) : route('discounts.store') }}"
                    method="POST">
                    @csrf
                    @if (isset($discount))
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Diskon</label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="{{ old('name', $discount->name ?? '') }}" required>
                        @error('name')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nilai" class="form-label">Nilai (%)</label>
                        <input type="number" id="nilai" name="nilai" class="form-control" step="0.01"
                            min="0" max="100" value="{{ old('nilai', $discount->nilai ?? '') }}">
                        @error('nilai')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('discounts.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Batal
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
