<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $departments = Department::when($search, function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })->paginate(10);

        return view('department.index', compact('departments', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Department::create($request->only('name'));

        return redirect()->route('department.index')->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function update(Request $request, Department $department)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $department->update($request->only('name'));

        return redirect()->route('department.index')->with('success', 'Departemen berhasil diperbarui.');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('department.index')->with('success', 'Departemen berhasil dihapus.');
    }
}
