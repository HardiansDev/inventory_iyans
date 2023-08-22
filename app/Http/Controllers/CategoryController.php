<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    function index(Request $request)
    {
        $search = $request->query('search');
        if (!empty($search)) {
            $categories = Category::where('name', 'LIKE', '%' . $request->search . '%')->paginate(5)->onEachSide('2');
        } else {
            $categories = Category::orderBy('created_at', 'DESC')->paginate(5)->onEachSide('2');
        }
        return view('category.index')->with([
            'categories' => $categories,
            'search' => $search
        ]);
    }

    function simpan(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        Category::create([
            'name' => $request->name
        ]);
        return redirect(route('category.index'))->with('success', 'Asik Category Berhasil Ditambahkan');
    }

    function edit($id)
    {
        $categories = Category::find($id);
        return view('category.edit', ['categories' => $categories]);
    }

    function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $categories = Category::find($id);
        $categories->name = $request->name;
        $categories->save();

        return redirect(route('category.index'))->with('success', 'Asik Category Berhasil Di Ubah');
    }

    function delete($id)
    {
        $categories = Category::find($id);

        if ($categories->produtcs->count() > 0){
            // gagal delete

            return redirect(route('category.index'))->with('error', 'gagal menghapus kategori karena kategori ini digunakan!!');
        }

        $categories->delete();
        return redirect(route('category.index'))->with('success', 'Asik Category Berhasil Di apus');
    }
}
