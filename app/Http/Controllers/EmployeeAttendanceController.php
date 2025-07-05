<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeAttendanceController extends Controller
{
    public function index()
    {
        return view('employee_attendance.index');
    }

    public function create()
    {
        return view('employee_attendance.create');
    }

    public function store(Request $request)
    {
        // Simpan absensi ke DB
    }

    public function show($id)
    {
        return view('employee_attendance.show', compact('id'));
    }

    public function edit($id)
    {
        return view('employee_attendance.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Update absensi
    }

    public function destroy($id)
    {
        // Hapus absensi
    }
}
