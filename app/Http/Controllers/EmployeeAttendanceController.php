<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeAttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('employee')->latest()->get();
        return view('employee_attendance.index', compact('attendances'));
    }

    public function scanQR()
    {
        return view('employee_attendance.scan');
    }

    public function processUpload(Request $request)
    {
        $request->validate([
            'qr_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->file('qr_image')->store('temp');
        $fullPath = storage_path('app/' . $imagePath);

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
                return back()->with('success', 'Absen masuk berhasil untuk ' . $attendance->employee->name . ' (NIP: ' . $attendance->employee->employee_number . ')');
            }

            if (!$attendance->check_out) {
                $attendance->check_out = now()->format('H:i:s');
                $attendance->save();
                $attendance->load('employee'); // <<=== Tambahkan baris ini
                return back()->with('success', 'Absen pulang berhasil untuk ' . $attendance->employee->name . ' (NIP: ' . $attendance->employee->employee_number . ')');
            }


            return back()->with('error', 'Anda sudah absen masuk dan pulang hari ini.');
        } else {
            return back()->with('error', 'QR Code tidak terbaca. Pastikan gambar jelas dan format benar.');
        }
    }




    public function qrStore(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'latitude'    => 'required|numeric',
            'longitude'   => 'required|numeric',
            'type'        => 'required|in:check_in,check_out',
        ]);

        // Lokasi kantor
        $officeLat = -6.200000; // Ganti sesuai lokasi kantor kamu
        $officeLng = 106.816666;

        $distance = $this->calculateDistance($officeLat, $officeLng, $request->latitude, $request->longitude);

        if ($distance > 0.2) { // km
            return response()->json(['message' => 'Anda berada di luar radius 200 meter dari kantor.'], 403);
        }

        $attendance = Attendance::firstOrCreate([
            'employee_id' => $request->employee_id,
            'date'        => now()->toDateString(),
        ]);

        if ($request->type == 'check_in') {
            if ($attendance->check_in) {
                return response()->json(['message' => 'Anda sudah absen masuk.'], 409);
            }
            $attendance->check_in = now()->format('H:i:s');
        } else { // check_out
            if ($attendance->check_out) {
                return response()->json(['message' => 'Anda sudah absen pulang.'], 409);
            }
            $attendance->check_out = now()->format('H:i:s');
        }

        $attendance->latitude = $request->latitude;
        $attendance->longitude = $request->longitude;
        $attendance->save();

        return response()->json(['message' => 'Absen berhasil!', 'data' => $attendance]);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c; // km
    }
}
