<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    // Display a listing of the resource
    public function index(Request $request)
    {
        $search = $request->query('search');
        if (!empty($search)) {
            $categories = Category::where('name', 'LIKE', '%' . $request->search . '%')->paginate(5)->onEachSide(2);
        } else {
            $categories = Category::orderBy('created_at', 'DESC')->paginate(5)->onEachSide(2);
        }
        return view('category.index', [
            'categories' => $categories,
            'search' => $search
        ]);
    }

    // Show the form for creating a new resource
    public function create()
    {
        return view('category.create');
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return redirect()->route('category.index')->with('success', 'Kategori Telah ditambah!');
    }

    // Display the specified resource
    public function show($id)
    {
        $category = Category::find($id);
        return view('category.show', compact('category'));
    }

    // Show the form for editing the specified resource
    public function edit($id)
    {
        $category = Category::find($id);
        return view('category.edit', compact('category'));
    }

    // Update the specified resource in storage
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $category = Category::find($id);
        $category->name = $request->name;
        $category->save();

        return redirect()->route('category.index')->with('success', 'Kategori Telah diupdate!');
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        $category = Category::findOrFail($id);  // Ensure the pic exists

        // Set pic_id in products to null
        Product::where('category_id', $id)->update(['category_id' => null]);

        // Delete the pic
        $category->delete();

        return redirect(route('category.index'))->with('success', 'Kategori Telah dihapus!.');
    }
}
