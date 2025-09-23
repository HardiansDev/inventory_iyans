<div class="grid grid-cols-1 gap-4 md:grid-cols-2">
    <!-- NIP -->
    <div>
        <label for="employee_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            NIP <span class="text-red-500">*</span>
        </label>
        <input type="text" name="employee_number" id="employee_number"
            value="{{ old('employee_number', $employee->employee_number ?? '') }}"
            class="@error('employee_number') border-red-500 @enderror mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-blue-500"
            required />
        @error('employee_number')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Nama -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Nama <span class="text-red-500">*</span>
        </label>
        <input type="text" name="name" id="name" value="{{ old('name', $employee->name ?? '') }}"
            class="@error('name') border-red-500 @enderror mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-blue-500"
            required />
        @error('name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Email <span class="text-red-500">*</span>
        </label>
        <input type="email" name="email" id="email" value="{{ old('email', $employee->email ?? '') }}"
            class="@error('email') border-red-500 @enderror mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-blue-500" />
        @error('email')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- No HP -->
    <div>
        <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            No. HP <span class="text-red-500">*</span>
        </label>
        <input type="text" name="phone" id="phone" value="{{ old('phone', $employee->phone ?? '') }}"
            class="@error('phone') border-red-500 @enderror mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-blue-500" />
        @error('phone')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Jenis Kelamin -->
    <div>
        <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Jenis Kelamin <span class="text-red-500">*</span>
        </label>
        <select name="gender" id="gender"
            class="@error('gender') border-red-500 @enderror mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-blue-500"
            required>
            <option value="">-- Pilih Jenis Kelamin --</option>
            <option value="L" {{ old('gender', $employee->gender ?? '') == 'L' ? 'selected' : '' }}>Laki-laki
            </option>
            <option value="P" {{ old('gender', $employee->gender ?? '') == 'P' ? 'selected' : '' }}>Perempuan
            </option>
        </select>
        @error('gender')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Tanggal Lahir -->
    <div>
        <label for="birth_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Tanggal Lahir <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                </svg>
            </div>
            <input id="birth_date" name="birth_date" type="text" datepicker datepicker-autoselect-today
                value="{{ old('birth_date', $employee?->birth_date ? \Carbon\Carbon::parse($employee->birth_date)->format('d/m/Y') : '') }}"
                class="bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 @error('birth_date') border-red-500 @enderror" />
        </div>
        @error('birth_date')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Alamat -->
    <div class="md:col-span-2">
        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Alamat <span class="text-red-500">*</span>
        </label>
        <textarea name="address" id="address" rows="3"
            class="@error('address') border-red-500 @enderror mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-blue-500">{{ old('address', $employee->address ?? '') }}</textarea>
        @error('address')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Foto -->
    <div class="mb-4">
        <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto Pegawai</label>
        <input type="file" name="photo" id="photo"
            class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4
            file:rounded-md file:border-0 file:text-sm file:font-semibold
            file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-gray-700 dark:file:text-gray-200 dark:hover:file:bg-gray-600">
        @error('photo')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror

        @if (isset($employee) && $employee->photo)
            <div class="mt-2">
                <p class="text-xs text-gray-500 dark:text-gray-400">Foto saat ini:</p>
                <img src="{{ $employee->photo }}" alt="Foto Pegawai"
                    class="mt-1 max-h-40 rounded-md border border-gray-200 dark:border-gray-700">
            </div>
        @endif
    </div>

    <!-- Departemen -->
    <div>
        <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Departemen <span class="text-red-500">*</span>
        </label>
        <select name="department_id" id="department_id"
            class="@error('department_id') border-red-500 @enderror mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-blue-500"
            required>
            <option value="">-- Pilih Departemen --</option>
            @foreach ($departments as $d)
                <option value="{{ $d->id }}"
                    {{ old('department_id', $employee->department_id ?? '') == $d->id ? 'selected' : '' }}>
                    {{ $d->name }}
                </option>
            @endforeach
        </select>
        @error('department_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Posisi -->
    <div>
        <label for="position_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Posisi <span class="text-red-500">*</span>
        </label>
        <select name="position_id" id="position_id"
            class="@error('position_id') border-red-500 @enderror mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-blue-500"
            required>
            <option value="">-- Pilih Posisi --</option>
            @foreach ($positions as $p)
                <option value="{{ $p->id }}"
                    {{ old('position_id', $employee->position_id ?? '') == $p->id ? 'selected' : '' }}>
                    {{ $p->name }}
                </option>
            @endforeach
        </select>
        @error('position_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Status -->
    <div>
        <label for="status_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Status <span class="text-red-500">*</span>
        </label>
        <select name="status_id" id="status_id"
            class="@error('status_id') border-red-500 @enderror mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-blue-500"
            required>
            <option value="">-- Pilih Status --</option>
            @foreach ($statuses as $s)
                <option value="{{ $s->id }}"
                    {{ old('status_id', $employee->status_id ?? '') == $s->id ? 'selected' : '' }}>
                    {{ $s->name }}
                </option>
            @endforeach
        </select>
        @error('status_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Tanggal Masuk -->
    <div>
        <label for="date_joined" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Tanggal Masuk <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                </svg>
            </div>
            <input id="date_joined" name="date_joined" type="text" datepicker datepicker-autoselect-today
                value="{{ old('date_joined', $employee?->date_joined ? \Carbon\Carbon::parse($employee->date_joined)->format('d/m/Y') : '') }}"
                class="bg-gray-50 dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 @error('date_joined') border-red-500 @enderror"
                placeholder="Pilih tanggal" required>
        </div>
        @error('date_joined')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Status Aktif -->
    <div>
        <label for="is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
            Status Aktif <span class="text-red-500">*</span>
        </label>
        <select name="is_active" id="is_active"
            class="@error('is_active') border-red-500 @enderror mt-1 block w-full rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 px-3 py-2 focus:border-blue-500 focus:outline-none focus:ring-blue-500"
            required>
            <option value="">-- Pilih --</option>
            <option value="1" {{ old('is_active', $employee->is_active ?? '') == '1' ? 'selected' : '' }}>Aktif
            </option>
            <option value="0" {{ old('is_active', $employee->is_active ?? '') == '0' ? 'selected' : '' }}>
                Nonaktif</option>
        </select>
        @error('is_active')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
