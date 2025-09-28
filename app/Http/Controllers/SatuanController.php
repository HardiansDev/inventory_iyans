<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    /**
     * Tampilkan semua data satuan.
     */
    public function index()
    {
        $satuans = Satuan::latest()->paginate(10);

        return view('satuan.index', compact('satuans'));
    }

    /**
     * Form tambah satuan.
     */
    public function create()
    {
        return view('satuan.create');
    }

    /**
     * Simpan data satuan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required|unique:satuans,nama_satuan',
            'keterangan' => 'nullable|string',
        ]);

        Satuan::create($request->only(['nama_satuan', 'keterangan']));

        return redirect()->route('satuan.index')
            ->with('success', 'Satuan berhasil ditambahkan');
    }

    /**
     * Form edit satuan.
     */
    public function edit(Satuan $satuan)
    {
        return view('satuan.edit', compact('satuan'));
    }

    /**
     * Update data satuan.
     */
    public function update(Request $request, Satuan $satuan)
    {
        $request->validate([
            'nama_satuan' => 'required|unique:satuans,nama_satuan,'.$satuan->id,
            'keterangan' => 'nullable|string',
        ]);

        $satuan->update($request->only(['nama_satuan', 'keterangan']));

        return redirect()->route('satuan.index')
            ->with('success', 'Satuan berhasil diperbarui');
    }

    /**
     * Hapus data satuan.
     */
    public function destroy(Satuan $satuan)
    {
        $satuan->delete();

        return redirect()->route('satuan.index')
            ->with('success', 'Satuan berhasil dihapus');
    }
}
