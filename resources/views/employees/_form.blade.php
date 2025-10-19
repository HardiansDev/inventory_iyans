<div class="space-y-8">

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-6 border-l-4 border-blue-600 pl-3">
            Data Personal
        </h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="space-y-1">
                <label for="employee_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    NIP <span class="text-red-500">*</span>
                </label>
                <input type="text" name="employee_number" id="employee_number"
                    value="{{ old('employee_number', $employee->employee_number ?? '') }}"
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                    dark:bg-gray-700 dark:text-gray-100 px-4 py-2.5 shadow-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition duration-150 ease-in-out
                    @error('employee_number') border-red-500 ring-red-500/50 @enderror"
                    required />
                @error('employee_number')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-1">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $employee->name ?? '') }}"
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                    dark:bg-gray-700 dark:text-gray-100 px-4 py-2.5 shadow-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition duration-150 ease-in-out
                    @error('name') border-red-500 ring-red-500/50 @enderror"
                    required />
                @error('name')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" name="email" id="email" value="{{ old('email', $employee->email ?? '') }}"
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                    dark:bg-gray-700 dark:text-gray-100 px-4 py-2.5 shadow-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition duration-150 ease-in-out
                    @error('email') border-red-500 ring-red-500/50 @enderror" />
                @error('email')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-1">
                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    No. HP <span class="text-red-500">*</span>
                </label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $employee->phone ?? '') }}"
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                    dark:bg-gray-700 dark:text-gray-100 px-4 py-2.5 shadow-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition duration-150 ease-in-out
                    @error('phone') border-red-500 ring-red-500/50 @enderror" />
                @error('phone')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1 md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    TTL (Tempat, Tanggal Lahir) <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="space-y-1">
                        <input id="birth_place" name="birth_place" type="text"
                            value="{{ old('birth_place', $employee?->birth_place) }}" placeholder="Contoh: Jakarta"
                            class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                            dark:bg-gray-700 dark:text-gray-100 px-4 py-2.5 shadow-sm
                            focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50
                            @error('birth_place') border-red-500 ring-red-500/50 @enderror" />
                        @error('birth_place')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

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
                            placeholder="DD/MM/YYYY"
                            class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                            dark:bg-gray-700 dark:text-gray-100 ps-10 p-2.5 shadow-sm
                            focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50
                            @error('birth_date') border-red-500 ring-red-500/50 @enderror" />
                        @error('birth_date')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative">
                        <input id="age" name="age" type="text" readonly
                            value="{{ $employee?->birth_date ? \Carbon\Carbon::parse($employee->birth_date)->age : '' }}"
                            placeholder="Umur"
                            class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                            dark:bg-gray-700/50 dark:text-gray-400 p-2.5 shadow-sm text-center
                            cursor-not-allowed" />
                        <span
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-500 dark:text-gray-400 select-none">Thn</span>
                    </div>
                </div>
            </div>

            <div class="space-y-1">
                <label for="gender" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Jenis Kelamin <span class="text-red-500">*</span>
                </label>
                <select name="gender" id="gender"
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                    dark:bg-gray-700 dark:text-gray-100 px-4 py-2.5 shadow-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition duration-150 ease-in-out
                    @error('gender') border-red-500 ring-red-500/50 @enderror"
                    required>
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="L" {{ old('gender', $employee->gender ?? '') == 'L' ? 'selected' : '' }}>
                        Laki-laki</option>
                    <option value="P" {{ old('gender', $employee->gender ?? '') == 'P' ? 'selected' : '' }}>
                        Perempuan</option>
                </select>
                @error('gender')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1 row-span-2">
                <label for="photo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Foto
                    Pegawai</label>
                <input type="file" name="photo" id="photo"
                    class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4
                    file:rounded-lg file:border-0 file:text-sm file:font-semibold
                    file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 dark:file:bg-blue-900/50 dark:file:text-blue-200 dark:hover:file:bg-blue-900">
                @error('photo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                @if (isset($employee) && $employee->photo)
                    <div class="mt-3">
                        <p class="text-xs text-gray-500 dark:text-gray-400">Foto saat ini:</p>
                        <img src="{{ $employee->photo }}" alt="Foto Pegawai"
                            class="mt-1 max-h-40 rounded-lg border border-gray-200 dark:border-gray-700 shadow-md object-cover">
                    </div>
                @endif
            </div>

            <div class="space-y-1 md:col-span-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label for="address_ktp" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Alamat KTP <span class="text-red-500">*</span>
                        </label>
                        <textarea name="address_ktp" id="address_ktp" rows="3"
                            class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                            dark:bg-gray-700 dark:text-gray-100 px-4 py-2.5 shadow-sm
                            focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition duration-150 ease-in-out
                            @error('address_ktp') border-red-500 ring-red-500/50 @enderror">{{ old('address_ktp', $employee->address_ktp ?? '') }}</textarea>
                        @error('address_ktp')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-1">
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Alamat Domisili <span class="text-red-500">*</span>
                        </label>
                        <textarea name="address" id="address" rows="3"
                            class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                            dark:bg-gray-700 dark:text-gray-100 px-4 py-2.5 shadow-sm
                            focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition duration-150 ease-in-out
                            @error('address') border-red-500 ring-red-500/50 @enderror">{{ old('address', $employee->address ?? '') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-6 border-l-4 border-blue-600 pl-3">
            Data Pekerjaan
        </h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="space-y-1">
                <label for="department_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Departemen <span class="text-red-500">*</span>
                </label>
                <select name="department_id" id="department_id"
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                    dark:bg-gray-700 dark:text-gray-100 px-4 py-2.5 shadow-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition duration-150 ease-in-out
                    @error('department_id') border-red-500 ring-red-500/50 @enderror"
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
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-1">
                <label for="position_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Posisi <span class="text-red-500">*</span>
                </label>
                <select name="position_id" id="position_id"
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                    dark:bg-gray-700 dark:text-gray-100 px-4 py-2.5 shadow-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition duration-150 ease-in-out
                    @error('position_id') border-red-500 ring-red-500/50 @enderror"
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
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1">
                <label for="status_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Status Kepegawaian <span class="text-red-500">*</span>
                </label>
                <select name="status_id" id="status_id"
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                    dark:bg-gray-700 dark:text-gray-100 px-4 py-2.5 shadow-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition duration-150 ease-in-out
                    @error('status_id') border-red-500 ring-red-500/50 @enderror"
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
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="space-y-1">
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
                        placeholder="Pilih tanggal" required
                        class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                        dark:bg-gray-700 dark:text-gray-100 ps-10 p-2.5 shadow-sm
                        focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50
                        @error('date_joined') border-red-500 ring-red-500/50 @enderror">
                </div>
                @error('date_joined')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1">
                <label for="is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Status Aktif <span class="text-red-500">*</span>
                </label>
                <select name="is_active" id="is_active"
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                    dark:bg-gray-700 dark:text-gray-100 px-4 py-2.5 shadow-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition duration-150 ease-in-out
                    @error('is_active') border-red-500 ring-red-500/50 @enderror"
                    required>
                    <option value="">-- Pilih --</option>
                    <option value="1"
                        {{ old('is_active', $employee->is_active ?? '') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0"
                        {{ old('is_active', $employee->is_active ?? '') == '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>
                @error('is_active')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-6 border-l-4 border-blue-600 pl-3">
            Data Lain-lain & Kontak Darurat
        </h4>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="space-y-1">
                <label for="religion" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Agama <span class="text-red-500">*</span>
                </label>
                <select name="religion" id="religion"
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                    dark:bg-gray-700 dark:text-gray-100 px-4 py-2.5 shadow-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition duration-150 ease-in-out">
                    <option value="">-- Pilih Agama --</option>
                    @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu', 'Lainnya'] as $religion)
                        <option value="{{ $religion }}"
                            {{ old('religion', $employee->religion ?? '') == $religion ? 'selected' : '' }}>
                            {{ $religion }}
                        </option>
                    @endforeach
                </select>
                @error('religion')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1">
                <label for="marital_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Status Pernikahan <span class="text-red-500">*</span>
                </label>
                <select name="marital_status" id="marital_status"
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                    dark:bg-gray-700 dark:text-gray-100 px-4 py-2.5 shadow-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition duration-150 ease-in-out">
                    <option value="">-- Pilih Status --</option>
                    @foreach (['Belum Menikah', 'Menikah', 'Cerai'] as $status)
                        <option value="{{ $status }}"
                            {{ old('marital_status', $employee->marital_status ?? '') == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                @error('marital_status')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1">
                <label for="nationals" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Kewarganegaraan <span class="text-red-500">*</span>
                </label>
                <select name="nationals" id="nationals"
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                    dark:bg-gray-700 dark:text-gray-100 px-4 py-2.5 shadow-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition duration-150 ease-in-out">
                    <option value="">-- Pilih --</option>
                    <option value="WNI"
                        {{ old('nationals', $employee->nationals ?? '') == 'WNI' ? 'selected' : '' }}>WNI</option>
                    <option value="WNA"
                        {{ old('nationals', $employee->nationals ?? '') == 'WNA' ? 'selected' : '' }}>WNA</option>
                </select>
                @error('nationals')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <h5
            class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4 pt-4 border-t border-gray-200 dark:border-gray-700">
            Kontak Darurat
        </h5>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="space-y-1">
                <label for="emergency_contact_name"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Nama
                </label>
                <input type="text" name="emergency_contact_name" id="emergency_contact_name"
                    value="{{ old('emergency_contact_name', $employee->emergency_contact_name ?? '') }}"
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                    dark:bg-gray-700 dark:text-gray-100 px-4 py-2.5 shadow-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition duration-150 ease-in-out">
            </div>

            <div class="space-y-1">
                <label for="emergency_contact_relation"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Hubungan
                </label>
                <input type="text" name="emergency_contact_relation" id="emergency_contact_relation"
                    value="{{ old('emergency_contact_relation', $employee->emergency_contact_relation ?? '') }}"
                    placeholder="Contoh: Istri, Ayah"
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                    dark:bg-gray-700 dark:text-gray-100 px-4 py-2.5 shadow-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition duration-150 ease-in-out">
            </div>

            <div class="space-y-1">
                <label for="emergency_contact_phone"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Nomor Telepon
                </label>
                <input type="text" name="emergency_contact_phone" id="emergency_contact_phone"
                    value="{{ old('emergency_contact_phone', $employee->emergency_contact_phone ?? '') }}"
                    placeholder="Contoh: 08123456789"
                    class="block w-full rounded-lg border border-gray-300 dark:border-gray-600
                    dark:bg-gray-700 dark:text-gray-100 px-4 py-2.5 shadow-sm
                    focus:border-blue-500 focus:ring-2 focus:ring-blue-500/50 transition duration-150 ease-in-out">
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const birthInput = document.getElementById('birth_date');
            const ageInput = document.getElementById('age');
            let lastValue = birthInput.value;

            // Parse tanggal dari string ke object Date dengan heuristik format
            function parseDateSmart(dateStr) {
                if (!dateStr) return null;

                dateStr = dateStr.trim();
                // support common separators
                const sep = dateStr.includes('/') ? '/' : (dateStr.includes('-') ? '-' : null);

                // If contains no sep but looks like YYYYMMDD (rare), try fallback
                if (!sep) {
                    // try ISO-like yyyy-mm-dd already covered; if no sep, bail
                    return null;
                }

                const parts = dateStr.split(sep).map(p => p.trim());
                if (parts.length !== 3) return null;

                // If first part is 4 digits => treat as yyyy-mm-dd
                if (parts[0].length === 4) {
                    const y = Number(parts[0]),
                        m = Number(parts[1]),
                        d = Number(parts[2]);
                    if (!isNaN(y) && !isNaN(m) && !isNaN(d)) return new Date(y, m - 1, d);
                    return null;
                }

                // Now we have ambiguity between dd/mm/yyyy and mm/dd/yyyy
                // Convert all to numbers
                const nums = parts.map(Number);
                if (nums.some(isNaN)) return null;

                const [a, b, c] = nums; // a and b are day/month in some order, c is year

                // If year is at the end and is 4-digit, good
                const year = (c < 1000) ? (c + (c > 50 ? 1900 : 2000)) : c; // fallback for 2-digit years

                // Heuristic:
                // - if a > 12 then a must be day (dd/mm)
                // - else if b > 12 then b must be day => format mm/dd
                // - else default to dd/mm (common in your blade: format('d/m/Y'))
                if (a > 12 && a <= 31) {
                    // dd/mm/yyyy
                    return new Date(year, b - 1, a);
                } else if (b > 12 && b <= 31) {
                    // mm/dd/yyyy (so b is day)
                    return new Date(year, a - 1, b);
                } else {
                    // ambiguous: choose dd/mm as default (since server side uses d/m/Y)
                    return new Date(year, b - 1, a);
                }
            }

            function calculateAgeFromDate(dateObj) {
                if (!dateObj || !(dateObj instanceof Date) || isNaN(dateObj)) return '';
                const today = new Date();
                let age = today.getFullYear() - dateObj.getFullYear();
                const m = today.getMonth() - dateObj.getMonth();
                if (m < 0 || (m === 0 && today.getDate() < dateObj.getDate())) {
                    age--;
                }
                return age >= 0 ? age : '';
            }

            function updateAge() {
                const parsed = parseDateSmart(birthInput.value);
                const umur = parsed ? calculateAgeFromDate(parsed) : '';
                ageInput.value = umur;
            }

            // run on load
            updateAge();

            // run on manual input changes
            birthInput.addEventListener('input', updateAge);

            // polling to detect libraries that set .value property without firing events (Flowbite, flatpickr in some configs)
            setInterval(() => {
                if (birthInput.value !== lastValue) {
                    lastValue = birthInput.value;
                    updateAge();
                }
            }, 300);
        });
    </script>
@endpush
