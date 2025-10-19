@extends('layouts.master')

@section('title')
    <title>Edit Pendidikan Pegawai</title>
@endsection

@section('content')
    <section
        class="mb-6 rounded-xl bg-white dark:bg-gray-800 p-6 shadow-lg border-t-4 border-yellow-500 dark:border-yellow-600">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100">Ubah Riwayat Pendidikan</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Mengubah detail pendidikan untuk: <span
                        class="font-semibold text-yellow-600 dark:text-yellow-400">{{ $education->employee->name ?? 'Pegawai Tidak Diketahui' }}</span>
                </p>
            </div>
            <a href="{{ route('education.index') }}"
                class="inline-flex items-center rounded-lg bg-gray-700 px-4 py-2 text-sm font-medium text-white transition hover:bg-gray-800 dark:bg-gray-600 dark:hover:bg-gray-500 shadow-md">
                <i class="fa fa-arrow-left mr-2"></i> Daftar Pendidikan
            </a>
        </div>
    </section>

    <div class="rounded-xl bg-white dark:bg-gray-800 p-8 shadow-lg">
        <form action="{{ route('education.update', $education->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <h2
                    class="text-xl font-bold text-gray-900 dark:text-gray-100 pb-2 border-b border-gray-200 dark:border-gray-700">
                    Informasi Sekolah/Kampus</h2>

                <div>
                    <label for="employee_id"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pegawai</label>
                    <select name="employee_id" id="employee_id" disabled {{-- FIX: Border tetap ada untuk elemen disabled --}}
                        class="mt-1 block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700/50 text-gray-600 dark:text-gray-400 cursor-not-allowed py-2 px-3">
                        <option value="{{ $education->employee->id ?? '' }}">
                            {{ $education->employee->name ?? 'Pegawai Tidak Diketahui' }}</option>
                    </select>
                    <input type="hidden" name="employee_id" value="{{ $education->employee_id }}">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="education_level"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenjang Pendidikan</label>
                        <select name="education_level" id="education_level" {{-- FIX: Menambahkan border yang jelas --}}
                            class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm shadow-sm text-gray-700 dark:text-gray-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('education_level') border-red-500 @enderror">
                            @foreach (['SD', 'SMP', 'SMA/SMK', 'D3', 'S1', 'S2', 'S3'] as $level)
                                <option value="{{ $level }}"
                                    {{ old('education_level', $education->education_level) == $level ? 'selected' : '' }}>
                                    {{ $level }}
                                </option>
                            @endforeach
                        </select>
                        @error('education_level')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="institution_name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Institusi</label>
                        <input type="text" name="institution_name" id="institution_name"
                            value="{{ old('institution_name', $education->institution_name) }}" {{-- FIX: Menambahkan border yang jelas --}}
                            class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm shadow-sm text-gray-700 dark:text-gray-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('institution_name') border-red-500 @enderror"
                            placeholder="Contoh: Universitas Indonesia">
                        @error('institution_name')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="space-y-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                <h2
                    class="text-xl font-bold text-gray-900 dark:text-gray-100 pb-2 border-b border-gray-200 dark:border-gray-700">
                    Detail Akademik</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="major" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jurusan
                            (Jika ada)</label>
                        <input type="text" name="major" id="major" value="{{ old('major', $education->major) }}"
                            {{-- FIX: Menambahkan border yang jelas --}}
                            class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm shadow-sm text-gray-700 dark:text-gray-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('major') border-red-500 @enderror"
                            placeholder="Contoh: Teknik Informatika">
                        @error('major')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="start_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun
                            Masuk</label>
                        <input type="number" name="start_year" id="start_year"
                            value="{{ old('start_year', $education->start_year) }}" {{-- FIX: Menambahkan border yang jelas --}}
                            class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm shadow-sm text-gray-700 dark:text-gray-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('start_year') border-red-500 @enderror"
                            placeholder="YYYY">
                        @error('start_year')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tahun
                            Lulus</label>
                        <input type="number" name="end_year" id="end_year"
                            value="{{ old('end_year', $education->end_year) }}" {{-- FIX: Menambahkan border yang jelas --}}
                            class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm shadow-sm text-gray-700 dark:text-gray-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('end_year') border-red-500 @enderror"
                            placeholder="YYYY">
                        @error('end_year')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="certificate_number"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Ijazah</label>
                        <input type="text" name="certificate_number" id="certificate_number"
                            value="{{ old('certificate_number', $education->certificate_number) }}" {{-- FIX: Menambahkan border yang jelas --}}
                            class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm shadow-sm text-gray-700 dark:text-gray-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('certificate_number') border-red-500 @enderror">
                        @error('certificate_number')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="gpa" class="block text-sm font-medium text-gray-700 dark:text-gray-300">IPK / Nilai
                            Rata-rata</label>
                        <input type="text" name="gpa" id="gpa" value="{{ old('gpa', $education->gpa) }}"
                            {{-- FIX: Menambahkan border yang jelas --}}
                            class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-3 py-2 text-sm shadow-sm text-gray-700 dark:text-gray-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('gpa') border-red-500 @enderror"
                            placeholder="Contoh: 3.50 atau 85.00">
                        @error('gpa')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-end">
                <button type="submit"
                    class="inline-flex items-center rounded-lg bg-yellow-500 px-6 py-2 text-base font-semibold text-white transition hover:bg-yellow-600 shadow-lg shadow-yellow-500/50">
                    <i class="fa fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
