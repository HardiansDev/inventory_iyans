<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Position;
use App\Models\EmploymentStatus;
use Illuminate\Http\Request;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class EmployeeController extends Controller
{

    public function downloadQrCode($id)
    {
        $employee = Employee::findOrFail($id);

        $writer = new PngWriter();
        $qrCode = QrCode::create($employee->id);

        $result = $writer->write($qrCode);

        $filename = 'qr_pegawai_' . $employee->id . '.png';
        $path = 'public/qrcodes/' . $filename;

        // Simpan ke storage
        Storage::put($path, $result->getString());

        // Kembalikan response file untuk download
        return response()->download(storage_path('app/' . $path));
    }

    public function index()
    {
        $employees = Employee::with(['department', 'position', 'status'])->paginate(10);
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $departments = Department::all();
        $positions = Position::all();
        $statuses = EmploymentStatus::all();
        return view('employees.create', compact('departments', 'positions', 'statuses'));
    }

    public function store(Request $request)
    {
        $messages = [
            'employee_number.required' => 'NIP wajib diisi.',
            'employee_number.unique' => 'NIP sudah digunakan.',
            'name.required' => 'Nama wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'phone.numeric' => 'Nomor HP harus berupa angka.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin harus L atau P.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'photo.image' => 'File foto harus berupa gambar.',
            'photo.mimes' => 'Foto harus berformat jpeg, png, atau jpg.',
            'photo.max' => 'Ukuran foto maksimal 2MB.',
            'department_id.required' => 'Departemen wajib dipilih.',
            'position_id.required' => 'Posisi wajib dipilih.',
            'status_id.required' => 'Status wajib dipilih.',
            'date_joined.required' => 'Tanggal masuk wajib diisi.',
            'date_joined.date' => 'Format tanggal masuk tidak valid.',
            'is_active.required' => 'Status aktif wajib dipilih.',
            'is_active.boolean' => 'Status aktif tidak valid.',
        ];

        $validated = $request->validate([
            'employee_number' => 'required|unique:employees',
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable|numeric',
            'gender' => 'required|in:L,P',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'department_id' => 'required',
            'position_id' => 'required',
            'status_id' => 'required',
            'date_joined' => 'required|date',
            'is_active' => 'required|boolean',
        ], $messages);

        if ($request->hasFile('photo')) {
            $uploadedFileUrl = Cloudinary::upload($request->file('photo')->getRealPath())->getSecurePath();
            $validated['photo'] = $uploadedFileUrl;
        }

        Employee::create($validated);


        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }


    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $positions = Position::all();
        $statuses = EmploymentStatus::all();
        return view('employees.edit', compact('employee', 'departments', 'positions', 'statuses'));
    }

    public function update(Request $request, Employee $employee)
    {
        $messages = [
            'employee_number.required' => 'NIP wajib diisi.',
            'employee_number.unique' => 'NIP sudah digunakan.',
            'name.required' => 'Nama wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'phone.numeric' => 'Nomor HP harus berupa angka.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'gender.in' => 'Jenis kelamin harus L atau P.',
            'birth_date.date' => 'Format tanggal lahir tidak valid.',
            'photo.image' => 'File foto harus berupa gambar.',
            'photo.mimes' => 'Foto harus berformat jpeg, png, atau jpg.',
            'photo.max' => 'Ukuran foto maksimal 2MB.',
            'department_id.required' => 'Departemen wajib dipilih.',
            'position_id.required' => 'Posisi wajib dipilih.',
            'status_id.required' => 'Status wajib dipilih.',
            'date_joined.required' => 'Tanggal masuk wajib diisi.',
            'date_joined.date' => 'Format tanggal masuk tidak valid.',
            'is_active.required' => 'Status aktif wajib dipilih.',
            'is_active.boolean' => 'Status aktif tidak valid.',
        ];

        $validated = $request->validate([
            'employee_number' => 'required|unique:employees,employee_number,' . $employee->id,
            'name' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable|numeric',
            'gender' => 'required|in:L,P',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'department_id' => 'required',
            'position_id' => 'required',
            'status_id' => 'required',
            'date_joined' => 'required|date',
            'is_active' => 'required|boolean',
        ], $messages);

        if ($request->hasFile('photo')) {
            if ($employee->photo) {
                $publicId = $this->extractCloudinaryPublicId($employee->photo);
                Cloudinary::destroy($publicId);
            }

            $uploadedFileUrl = Cloudinary::upload($request->file('photo')->getRealPath())->getSecurePath();
            $validated['photo'] = $uploadedFileUrl;
        }

        $employee->update($validated);


        return redirect()->route('employees.index')->with('success', 'Data pegawai diperbarui.');
    }



    public function show($id)
    {
        $employee = Employee::with(['department', 'position', 'status'])->findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    public function destroy(Employee $employee)
    {
        // Hapus foto jika ada
        if ($employee->photo && Storage::disk('public')->exists('photos/' . $employee->photo)) {
            Storage::disk('public')->delete('photos/' . $employee->photo);
        }

        $employee->delete();

        return back()->with('success', 'Pegawai dihapus.');
    }


    private function extractCloudinaryPublicId($url)
    {
        $path = parse_url($url, PHP_URL_PATH);
        $filename = pathinfo($path, PATHINFO_FILENAME);
        return $filename;
    }
}
