<?php

namespace App\Http\Controllers;

use App\Models\EmploymentStatus;
use Illuminate\Http\Request;

class EmploymentStatusController extends Controller
{
    public function index()
    {
        $statuses = EmploymentStatus::withCount('employees')->get();

        return view('employment_status.index', compact('statuses'));
    }

    public function create()
    {
        return view('employment_status.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        EmploymentStatus::create($request->only('name'));

        return redirect()->route('employment_status.index')->with('success', 'Status Pegawai Berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $status = EmploymentStatus::findOrFail($id);

        return view('employment_status.edit', compact('status'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $status = EmploymentStatus::findOrFail($id);
        $status->update($request->only('name'));

        return redirect()->route('employment_status.index')->with('success', 'Status Pegawai Berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $status = EmploymentStatus::findOrFail($id);
        $status->delete();

        return redirect()->route('employment_status.index')->with('success', 'Status Pegawai Berhasil dihapus!');
    }
}
