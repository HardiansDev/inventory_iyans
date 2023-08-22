<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pic;

class PicController extends Controller
{
    function index(Request $request)
    {
        $search = $request->query('search');
        if (!empty($search)) {
            $pics = Pic::where('name', 'LIKE', '%' . $request->search . '%')->paginate(5)->onEachSide('2');
        } else {
            $pics = Pic::orderBy('created_at', 'DESC')->paginate(5)->onEachSide('2');
        }
        return view('pic.index')->with([
            'pics' => $pics,
            'search' => $search
        ]);
    }

    function simpan(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        Pic::create([
            'name' => $request->name
        ]);
        return redirect(route('pic.index'))->with('success', 'Asik Pic Berhasil Ditambahkan');
    }

    function edit($id)
    {
        $pics = Pic::find($id);
        return view('pic.edit', ['pics' => $pics]);
    }

    function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $pics = Pic::find($id);
        $pics->name = $request->name;
        $pics->save();

        return redirect(route('pic.index'))->with('success', 'Asik Pic Berhasil Di Ubah');
    }

    function delete($id)
    {
        $pics = Pic::find($id);

        // check jika pic dengan $id di gunakan di model product
        if ($pics->produtcs->count() > 0){
            // gagal delete

            return redirect(route('category.index'))->with('error', 'gagal menghapus PIC karena PIC ini digunakan!!');
        }

        $pics->delete();
        return redirect(route('pic.index'))->with('success', 'Asik Pic Berhasil Di apus');
    }
}
