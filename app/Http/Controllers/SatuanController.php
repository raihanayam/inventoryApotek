<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SatuanController extends Controller
{
    public function index()
    {
        $satuans = Satuan::paginate(7);
        return view('pages.satuan.index', compact('satuans'));
    }

    public function create()
    {
        return view('pages.satuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:satuans,name',
        ], [
            'name.required' => 'Nama Satuan Wajib diisi',
            'name.unique'   => 'Nama Satuan sudah ada!',
        ]);

        Satuan::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect('/satuans')->with('success', 'Satuan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $satuan = Satuan::findOrFail($id);

        return view('pages.satuan.edit', compact('satuan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:satuans,name,' . $id,
        ], [
            'name.required' => 'Nama Satuan Wajib diisi',
            'name.unique'   => 'Nama Satuan sudah ada!',
        ]);

        $satuan = Satuan::findOrFail($id);
        $satuan->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect('/satuans')->with('success', 'Satuan berhasil diperbarui');
    }

    public function delete($id)
    {
        Satuan::findOrFail($id)->delete();

        return redirect('/satuans')->with('success', 'Satuan berhasil dihapus');
    }
}
