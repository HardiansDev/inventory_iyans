<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class EmployeeAttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('employee')->latest()->get();

        return view('employee_attendance.index', compact('attendances'));
    }

    public function scanQR(Request $request)
    {
        $type = $request->query('type', 'check_in');

        return view('employee_attendance.scan', compact('type'));
    }

    public function processUpload(Request $request)
    {
        $request->validate([
            'qr_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->file('qr_image')->store('temp');
        $fullPath = storage_path('app/'.$imagePath);

        $qrcode = new \Zxing\QrReader($fullPath);
        $text = $qrcode->text();

        if ($text) {
            $employeeId = (int) $text;

            $employee = Employee::find($employeeId);
            if (!$employee) {
                return back()->with('error', 'Pegawai tidak ditemukan.');
            }

            $attendance = Attendance::firstOrCreate([
                'employee_id' => $employeeId,
                'date' => now()->toDateString(),
            ]);

            if (!$attendance->check_in) {
                $attendance->check_in = now()->format('H:i:s');
                $attendance->save();
                $attendance->load('employee'); // <<=== Tambahkan baris ini

                return back()->with('success', 'Absen masuk berhasil untuk '.$attendance->employee->name.' (NIP: '.$attendance->employee->employee_number.')');
            }

            if (!$attendance->check_out) {
                $attendance->check_out = now()->format('H:i:s');
                $attendance->save();
                $attendance->load('employee'); // <<=== Tambahkan baris ini

                return back()->with('success', 'Absen pulang berhasil untuk '.$attendance->employee->name.' (NIP: '.$attendance->employee->employee_number.')');
            }

            return back()->with('error', 'Anda sudah absen masuk dan pulang hari ini.');
        } else {
            return back()->with('error', 'QR Code tidak terbaca. Pastikan gambar jelas dan format benar.');
        }
    }

    public function processQRCode(Request $request)
    {
        $employeeId = (int) $request->qrcode;
        $employee = Employee::find($employeeId);
        if (!$employee) {
            return response()->json(['message' => 'Pegawai tidak ditemukan.'], 404);
        }

        $attendance = Attendance::firstOrCreate([
            'employee_id' => $employeeId,
            'date' => now()->toDateString(),
        ]);

        if (!$attendance->check_in) {
            $attendance->check_in = now()->format('H:i:s');
            $attendance->save();

            return response()->json(['message' => 'Absen masuk berhasil']);
        }

        if (!$attendance->check_out) {
            $attendance->check_out = now()->format('H:i:s');
            $attendance->save();

            return response()->json(['message' => 'Absen pulang berhasil']);
        }

        return response()->json(['message' => 'Anda sudah absen masuk & pulang hari ini.']);
    }

    public function qrStore(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|integer|exists:employees,id',
            'type' => 'required|in:check_in,check_out',
        ]);

        $employeeId = $request->employee_id;
        $type = $request->type;

        $employee = Employee::find($employeeId);
        if (!$employee) {
            return response()->json(['message' => 'Pegawai tidak ditemukan.'], 404);
        }

        $attendance = Attendance::firstOrCreate([
            'employee_id' => $employeeId,
            'date' => now()->toDateString(),
        ]);

        if ($type === 'check_in') {
            if ($attendance->check_in) {
                return response()->json(['message' => 'Anda sudah absen masuk hari ini.'], 422);
            }
            $attendance->check_in = now()->format('H:i:s');
            $attendance->save();

            return response()->json(['message' => 'Absen masuk berhasil.']);
        }

        if ($type === 'check_out') {
            if ($attendance->check_out) {
                return response()->json(['message' => 'Anda sudah absen pulang hari ini.'], 422);
            }
            $attendance->check_out = now()->format('H:i:s');
            $attendance->save();

            return response()->json(['message' => 'Absen pulang berhasil.']);
        }

        return response()->json(['message' => 'Tipe absen tidak valid.'], 400);
    }

    public function exportPdf()
    {
        $attendances = Attendance::with('employee')->get();
        $pdf = Pdf::loadView('employee_attendance.export-pdf', compact('attendances'));

        return $pdf->download('absensi_pegawai.pdf');
    }
}
