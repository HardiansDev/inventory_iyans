<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
        $query = Discount::query();

        if ($request->has('search') && $request->search !== null) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        $discounts = $query->latest()->get(); // atau paginate jika kamu gunakan pagination

        return view('discounts.index', compact('discounts'));
    }

    public function create()
    {
        return view('discounts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nilai' => 'nullable|numeric|min:0|max:100',
        ]);

        Discount::create($validated);

        return redirect()->route('discounts.index')->with('success', 'Diskon berhasil ditambahkan.');
    }

    public function edit(Discount $discount)
    {
        return view('discounts.edit', compact('discount'));
    }

    public function update(Request $request, Discount $discount)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nilai' => 'nullable|numeric|min:0|max:100',
        ]);

        $discount->update($validated);

        return redirect()->route('discounts.index')->with('success', 'Diskon berhasil diperbarui.');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();

        return redirect()->route('discounts.index')->with('success', 'Diskon berhasil dihapus.');
    }
}
