<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;


class SupplierController extends Controller
{
    function index(Request $request)
    {
        $search = $request->query('search');
        if (!empty($search)) {
            $suppliers = Supplier::where('name', 'LIKE', '%' . $request->search . '%')->paginate(5)->onEachSide('2');
        } else {
            $suppliers = Supplier::orderBy('created_at', 'DESC')->paginate(5)->onEachSide('2');
        }
        return view('supplier.index')->with([
            'suppliers' => $suppliers,
            'search' => $search
        ]);
    }


    function simpan(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required'
        ]);

        Supplier::create([
            'name' => $request->name,
            'address' => $request->address
        ]);
        return redirect(route('supplier.index'))->with('success', 'Asik Supplier Berhasil Ditambahkan');
    }

    function edit($id)
    {
        $suppliers = Supplier::find($id);
        return view('supplier.edit', ['suppliers' => $suppliers]);
    }

    function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'address' => 'required'
        ]);
        $suppliers = Supplier::find($id);
        $suppliers->name = $request->name;
        $suppliers->address = $request->address;
        $suppliers->save();

        return redirect(route('supplier.index'))->with('success', 'Asik Supplier Berhasil Di Ubah');
    }

    function delete($id)
    {
        $suppliers = Supplier::find($id);
        $suppliers->delete();
        return redirect(route('supplier.index'))->with('success', 'Asik suppliers Berhasil Di apus');
    }
}
