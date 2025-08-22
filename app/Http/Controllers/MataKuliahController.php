<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index()
    {
        $mataKuliahs = MataKuliah::all();
        return view('matakuliah.index', compact('mataKuliahs'));
    }

    public function create()
    {
        return view('matakuliah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mk' => 'required|unique:mata_kuliahs',
            'nama_mk' => 'required',
            'sks' => 'required|integer',
        ]);

        MataKuliah::create($request->all());

        return redirect()->route('matakuliah.index')->with('success', 'Mata Kuliah berhasil ditambahkan.');
    }

    public function show($id)
    {
        $matakuliah = MataKuliah::findOrFail($id);  // Ganti nama variabel di controller
        return view('matakuliah.show', compact('matakuliah'));  // Kirim variabel dengan nama 'matakuliah'
    }


    public function edit($id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);
        return view('matakuliah.edit', compact('mataKuliah'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_mk' => 'required|unique:mata_kuliahs,kode_mk,' . $id,
            'nama_mk' => 'required',
            'sks' => 'required|integer',
        ]);

        $mataKuliah = MataKuliah::findOrFail($id);
        $mataKuliah->update($request->all());

        return redirect()->route('matakuliah.index')->with('success', 'Mata Kuliah berhasil diperbarui.');
    }

    public function destroy(MataKuliah $matakuliah)
    {
        $matakuliah->delete();
        return redirect()->route('matakuliah.index')->with('success', 'Mata Kuliah berhasil dihapus.');
    }
}
