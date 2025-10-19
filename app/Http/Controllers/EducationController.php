<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Employee;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Education::with('employee')->latest()->paginate(10);
        return view('education.index', compact('educations'));
    }

    public function create()
    {
        $employees = Employee::orderBy('name')->get();
        return view('education.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'education_level' => 'required|string',
            'institution_name' => 'required|string',
            'major' => 'nullable|string',
            'start_year' => 'nullable|digits:4',
            'end_year' => 'nullable|digits:4',
            'certificate_number' => 'nullable|string',
            'gpa' => 'nullable|numeric|between:0,4',
        ]);

        Education::create($request->all());

        return redirect()->route('education.index')->with('success', 'Data pendidikan berhasil ditambahkan.');
    }

    public function edit(Education $education)
    {
        $employees = Employee::orderBy('name')->get();
        return view('education.edit', compact('education', 'employees'));
    }

    public function update(Request $request, Education $education)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'education_level' => 'required|string',
            'institution_name' => 'required|string',
            'major' => 'nullable|string',
            'start_year' => 'nullable|digits:4',
            'end_year' => 'nullable|digits:4',
            'certificate_number' => 'nullable|string',
            'gpa' => 'nullable|numeric|between:0,4',
        ]);

        $education->update($request->all());

        return redirect()->route('education.index')->with('success', 'Data pendidikan berhasil diperbarui.');
    }

    public function show(Education $education)
    {    
        return view('education.show', compact('education'));
    }

    public function destroy(Education $education)
    {
        $education->delete();
        return redirect()->route('education.index')->with('success', 'Data pendidikan berhasil dihapus.');
    }
}
