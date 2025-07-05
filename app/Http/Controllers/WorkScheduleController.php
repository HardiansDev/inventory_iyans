<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WorkScheduleController extends Controller
{
    public function index()
    {
        return view('work_schedules.index');
    }

    public function create()
    {
        return view('work_schedules.create');
    }

    public function store(Request $request)
    {
        // Simpan jadwal kerja ke DB
    }

    public function show($id)
    {
        return view('work_schedules.show', compact('id'));
    }

    public function edit($id)
    {
        return view('work_schedules.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Update jadwal kerja
    }

    public function destroy($id)
    {
        // Hapus jadwal kerja
    }
}
