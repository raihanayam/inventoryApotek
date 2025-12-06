<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

    public function create() {
        return view('pages.satuan.create');
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            "name" => "required|unique:satuans,name",
        ], [
            "name.required" => "Nama Satuan Wajib diisi",
            "name.unique" => "Nama Satuan sudah ada!"
        ]);

        $satuan = new Satuan();
        $satuan->name = $request->input('name');
        $satuan->slug = Str::slug($request->input('name'));
        $satuan->save();

        return redirect('/satuans');
    }

    public function edit($id) {
        $satuan = Satuan::find($id);

        return view('pages.satuan.edit', compact('Satuan'));
    }

    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            "name" => "required|unique:satuans,name",
        ], [
            "name.required" => "Nama Satuan Wajib diisi",
            "name.unique" => "Nama Satuan sudah ada!"
        ]);

        $satuan = Satuan::find($id);
        $satuan->name = $request->input('name');
        $satuan->slug = Str::slug($request->input('name'));
        $satuan->save();

        return redirect('/satuans');
    }

    public function delete($id) {
        Satuan::where('id', $id)->delete();

        return redirect('/satuans');
    }
}
