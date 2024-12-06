<?php

namespace App\Http\Controllers;

use App\Models\Pic;
use App\Models\Product;
use Illuminate\Http\Request;

class PicController extends Controller
{
    // Display a list of pics
    public function index(Request $request)
    {
        $search = $request->query('search');
        if (!empty($search)) {
            $pics = Pic::where('name', 'LIKE', '%' . $request->search . '%')->paginate(5)->onEachSide(2);
        } else {
            $pics = Pic::orderBy('created_at', 'DESC')->paginate(5)->onEachSide(2);
        }

        return view('pic.index')->with([
            'pics' => $pics,
            'search' => $search
        ]);
    }

    // Show the form to create a new pic
    public function create()
    {
        return view('pic.create');
    }

    // Store a newly created pic
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        Pic::create([
            'name' => $request->name
        ]);

        return redirect(route('pic.index'))->with('success', 'PIC successfully added.');
    }

    // Show the form to edit an existing pic
    public function edit($id)
    {
        $pic = Pic::findOrFail($id);  // Use findOrFail to handle errors
        return view('pic.edit', ['pic' => $pic]);
    }

    // Update the details of an existing pic
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $pic = Pic::findOrFail($id);
        $pic->name = $request->name;
        $pic->save();

        return redirect(route('pic.index'))->with('success', 'PIC successfully updated.');
    }

    // Delete a pic and handle relationships
    public function destroy($id)
    {
        $pic = Pic::findOrFail($id);  // Ensure the pic exists

        // Set pic_id in products to null
        Product::where('pic_id', $id)->update(['pic_id' => null]);

        // Delete the pic
        $pic->delete();

        return redirect(route('pic.index'))->with('success', 'PIC successfully deleted.');
    }
}
