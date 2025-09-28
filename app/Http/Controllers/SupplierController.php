<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    // Display a listing of the resource
    public function index(Request $request)
    {
        $search = $request->query('search');
        if (!empty($search)) {
            $suppliers = Supplier::where('name', 'LIKE', '%'.$search.'%')
                ->orWhere('name_prod', 'LIKE', '%'.$search.'%')
                ->paginate(5)
                ->onEachSide(2);
        } else {
            $suppliers = Supplier::orderBy('created_at', 'DESC')
                ->paginate(5)
                ->onEachSide(2);
        }

        return view('supplier.index', compact('suppliers', 'search'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        return view('supplier.create');
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'name_prod' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
            'telp' => 'required|string|max:20',
            'email_sup' => 'nullable|email|max:255',
        ]);

        Supplier::create([
            'name' => $request->name,
            'name_prod' => $request->name_prod,
            'address' => $request->address,
            'telp' => $request->telp,
            'email_sup' => $request->email_sup,
        ]);

        return redirect(route('supplier.index'))->with('success', 'Supplier ditambah!');
    }

    // Display the specified resource
    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);

        return view('supplier.show', compact('supplier'));
    }

    // Show the form for editing the specified resource
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);

        return view('supplier.edit', compact('supplier'));
    }

    // Update the specified resource in storage
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'name_prod' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
            'telp' => 'required|string|max:20',
            'email_sup' => 'nullable|email|max:255',
        ]);

        $supplier = Supplier::findOrFail($id);
        $supplier->name = $request->name;
        $supplier->name_prod = $request->name_prod;
        $supplier->address = $request->address;
        $supplier->telp = $request->telp;
        $supplier->email_sup = $request->email_sup;
        $supplier->save();

        return redirect(route('supplier.index'))->with('success', 'Supplier Telah diupdate!');
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);  // Ensure the pic exists

        // Set pic_id in products to null
        BahanBaku::where('supplier_id', $id)->update(['supplier_id' => null]);

        // Delete the pic
        $supplier->delete();

        return redirect(route('supplier.index'))->with('success', 'Supplier Telah dihapus!.');
    }
}
