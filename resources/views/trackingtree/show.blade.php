@extends('layouts.master')

@section('content')
    <section class="mb-6 rounded-lg bg-white dark:bg-gray-900 p-6 shadow-sm">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Detail Tracking</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Progress persetujuan untuk produk <span
                class="font-semibold">{{ optional($productIn->product)->name ?? '-' }}</span>
        </p>

        <!-- Progress Roadmap -->
        <div class="mt-8">
            @include('trackingtree.partials.progress', ['status' => $productIn->status])
        </div>
    </section>
@endsection
