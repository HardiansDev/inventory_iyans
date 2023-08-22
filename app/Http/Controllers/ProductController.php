<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Pic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ProductController extends Controller
{
    function index(Request $request)
    {
        $search = $request->query('search');
        if (!empty($search)) {
            $products = Product::where('name', 'LIKE', '%' . $request->search . '%');
        } else {
            $products = Product::orderBy('created_at', 'DESC');
        }
        $datacategory = Category::all();
        return view('product.index')->with([
            'products' => $products->get(),
            'datacategory' => $datacategory

        ]);
        $products = Product::all();
        return view('product.index', compact('products'));
    }

    function tambah()
    {
        $datacategory = Category::all();
        $datasupplier = Supplier::all();
        $datapic = Pic::all();
        return view('product.tambah_product', compact('datacategory', 'datasupplier', 'datapic'));
    }

    function simpan(Request $request)
    {
        $validator = $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'photo' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'qty' => 'required',
            'stock' => 'required',
            'quality' => 'required',
            'purchase' => 'required',
            'billnum' => 'required',
            'supplier_id' => 'required',
            'pic_id' => 'required',
        ]);


        $products = Product::create($validator);
        // dd($products);
        if ($request->hasFile('photo')) {
            $request->file('photo')->move('fotoproduct/', $request->file('photo')->getClientOriginalName());
            $products->photo = $request->file('photo')->getClientOriginalName();
            $products->save();
        }
        return redirect('/product')->with('success', 'Asik Product Berhasil Ditambahkan');
    }

    function detail($id)
    {
        $products = Product::find($id);
        $datacategory = Category::find($id);
        $datasupplier = Supplier::find($id);
        $datapic = Pic::find($id);
        return view('product.detail_product', compact('products', 'datacategory', 'datasupplier', 'datapic'));
    }

    function edit($id)
    {
        $products = Product::find($id);
        $datacategory = Category::all();
        $datasupplier = Supplier::all();
        $datapic = Pic::all();
        return view('product.edit_product', compact('products', 'datacategory', 'datasupplier', 'datapic'));
    }

    function update($id, Request $request)
    {
        // dd($request->all());
        $validator =  $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'qty' => 'required',
            'stock' => 'required',
            'quality' => 'required',
            'purchase' => 'required',
            'billnum' => 'required',
            'supplier_id' => 'required',
            'pic_id' => 'required',
        ]);
        $products = Product::find($id);
        $products->name = $request->name;
        $products->code = $request->code;
        $products->category_id = $request->category_id;
        $products->price = $request->price;
        $products->qty = $request->qty;
        $products->stock = $request->stock;
        $products->quality = $request->quality;
        $products->purchase = $request->purchase;
        $products->billnum = $request->billnum;
        $products->supplier_id = $request->supplier_id;
        $products->pic_id = $request->pic_id;
        if ($request->hasFile('photo')) {
            $request->file('photo')->move('fotoproduct/', $request->file('photo')->getClientOriginalName());
            $products->photo = $request->file('photo')->getClientOriginalName();
        }
        $products->save();

        return redirect('/product')->with('success', 'Asik Product Berhasil Di Ubah');
    }

    function delete($id)
    {
        $products = Product::find($id);
        $products->delete();
        return redirect('/product')->with('success', 'Asik Product Berhasil Di apus');
    }

    function export(Request $request)
    {
        dd($request->all());
    }
}
