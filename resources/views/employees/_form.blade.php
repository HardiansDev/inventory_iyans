<div class="row">
    <!-- NIP -->
    <div class="mb-3 col-md-6">
        <label for="employee_number">
            NIP <span class="text-danger">*</span>
            <i class="bi bi-info-circle text-primary ms-1" data-bs-toggle="tooltip" title="Masukkan NIP pegawai"></i>
        </label>
        <input type="text" name="employee_number" id="employee_number"
            class="form-control @error('employee_number') is-invalid @enderror"
            value="{{ old('employee_number', $employee->employee_number ?? '') }}" required>
        @error('employee_number')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Nama -->
    <div class="mb-3 col-md-6">
        <label for="name">
            Nama <span class="text-danger">*</span>
            <i class="bi bi-info-circle text-primary ms-1" data-bs-toggle="tooltip"
                title="Masukkan nama lengkap pegawai"></i>
        </label>
        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $employee->name ?? '') }}" required>
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Email -->
    <div class="mb-3 col-md-6">
        <label for="email">
            Email <span class="text-danger">*</span>
            <i class="bi bi-info-circle text-primary ms-1" data-bs-toggle="tooltip"
                title="Masukkan email aktif pegawai"></i>
        </label>
        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $employee->email ?? '') }}">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- No HP -->
    <div class="mb-3 col-md-6">
        <label for="phone">
            No. HP <span class="text-danger">*</span>
            <i class="bi bi-info-circle text-primary ms-1" data-bs-toggle="tooltip"
                title="Masukkan nomor HP pegawai"></i>
        </label>
        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
            value="{{ old('phone', $employee->phone ?? '') }}">
        @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Jenis Kelamin -->
    <div class="mb-3 col-md-6">
        <label for="gender">
            Jenis Kelamin <span class="text-danger">*</span>
            <i class="bi bi-info-circle text-primary ms-1" data-bs-toggle="tooltip"
                title="Pilih jenis kelamin pegawai"></i>
        </label>
        <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror" required>
            <option value="">-- Pilih Jenis Kelamin --</option>
            <option value="L" {{ old('gender', $employee->gender ?? '') == 'L' ? 'selected' : '' }}>Laki-laki
            </option>
            <option value="P" {{ old('gender', $employee->gender ?? '') == 'P' ? 'selected' : '' }}>Perempuan
            </option>
        </select>
        @error('gender')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Tanggal Lahir -->
    <div class="mb-3 col-md-6">
        <label for="birth_date">
            Tanggal Lahir <span class="text-danger">*</span>
            <i class="bi bi-info-circle text-primary ms-1" data-bs-toggle="tooltip"
                title="Masukkan tanggal lahir pegawai"></i>
        </label>
        <input type="date" name="birth_date" id="birth_date"
            class="form-control @error('birth_date') is-invalid @enderror"
            value="{{ old('birth_date', $employee->birth_date ?? '') }}">
        @error('birth_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Alamat -->
    <div class="mb-3 col-md-12">
        <label for="address">
            Alamat <span class="text-danger">*</span>
            <i class="bi bi-info-circle text-primary ms-1" data-bs-toggle="tooltip" title="Masukkan alamat pegawai"></i>
        </label>
        <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address', $employee->address ?? '') }}</textarea>
        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Foto -->
    <div class="mb-3 col-md-6">
        <label for="photo">
            Foto <span class="text-danger">*</span>
            <i class="bi bi-info-circle text-primary ms-1" data-bs-toggle="tooltip" title="Upload foto pegawai"></i>
        </label>
        <input type="file" name="photo" id="photo" class="form-control @error('photo') is-invalid @enderror">
        @error('photo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        @if (isset($employee) && $employee->photo)
            <small class="text-muted">Foto saat ini: {{ $employee->photo }}</small><br>
            <img src="{{ asset('storage/fotoproduct/pegawai/' . $employee->photo) }}" class="img-thumbnail mt-1"
                style="max-height: 150px;">
        @endif
    </div>

    <!-- Departemen -->
    <div class="mb-3 col-md-6">
        <label for="department_id">
            Departemen <span class="text-danger">*</span>
            <i class="bi bi-info-circle text-primary ms-1" data-bs-toggle="tooltip"
                title="Pilih departemen pegawai"></i>
        </label>
        <select name="department_id" id="department_id"
            class="form-control @error('department_id') is-invalid @enderror" required>
            <option value="">-- Pilih Departemen --</option>
            @foreach ($departments as $d)
                <option value="{{ $d->id }}"
                    {{ old('department_id', $employee->department_id ?? '') == $d->id ? 'selected' : '' }}>
                    {{ $d->name }}
                </option>
            @endforeach
        </select>
        @error('department_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Posisi -->
    <div class="mb-3 col-md-6">
        <label for="position_id">
            Posisi <span class="text-danger">*</span>
            <i class="bi bi-info-circle text-primary ms-1" data-bs-toggle="tooltip" title="Pilih posisi pegawai"></i>
        </label>
        <select name="position_id" id="position_id" class="form-control @error('position_id') is-invalid @enderror"
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
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Status -->
    <div class="mb-3 col-md-6">
        <label for="status_id">
            Status <span class="text-danger">*</span>
            <i class="bi bi-info-circle text-primary ms-1" data-bs-toggle="tooltip"
                title="Pilih status kepegawaian"></i>
        </label>
        <select name="status_id" id="status_id" class="form-control @error('status_id') is-invalid @enderror"
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
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Tanggal Masuk -->
    <div class="mb-3 col-md-6">
        <label for="date_joined">
            Tanggal Masuk <span class="text-danger">*</span>
            <i class="bi bi-info-circle text-primary ms-1" data-bs-toggle="tooltip"
                title="Masukkan tanggal mulai kerja"></i>
        </label>
        <input type="date" name="date_joined" id="date_joined"
            class="form-control @error('date_joined') is-invalid @enderror"
            value="{{ old('date_joined', $employee->date_joined ?? '') }}" required>
        @error('date_joined')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Status Aktif -->
    <div class="mb-3 col-md-6">
        <label for="is_active">
            Status Aktif <span class="text-danger">*</span>
            <i class="bi bi-info-circle text-primary ms-1" data-bs-toggle="tooltip"
                title="Pilih apakah pegawai masih aktif"></i>
        </label>
        <select name="is_active" id="is_active" class="form-control @error('is_active') is-invalid @enderror"
            required>
            <option value="">-- Pilih --</option>
            <option value="1" {{ old('is_active', $employee->is_active ?? '') == '1' ? 'selected' : '' }}>Aktif
            </option>
            <option value="0" {{ old('is_active', $employee->is_active ?? '') == '0' ? 'selected' : '' }}>
                Nonaktif</option>
        </select>
        @error('is_active')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
