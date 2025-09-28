<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::all();

        return view('positions.index', compact('positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'base_salary' => 'required|numeric|min:0',
        ]);

        Position::create($request->only('name', 'base_salary'));

        return redirect()->back()->with('success', 'Posisi berhasil ditambahkan.');
    }

    public function update(Request $request, Position $position)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'base_salary' => 'required|numeric|min:0',
        ]);

        $position->update($request->only('name', 'base_salary'));

        return redirect()->back()->with('success', 'Posisi berhasil diperbarui.');
    }

    public function destroy(Position $position)
    {
        $position->delete();

        return redirect()->back()->with('success', 'Posisi berhasil dihapus.');
    }
}
