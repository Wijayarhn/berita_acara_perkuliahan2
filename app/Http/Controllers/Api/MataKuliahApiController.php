<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahApiController extends Controller
{
    public function index()
    {
        $mataKuliahs = MataKuliah::all();
        return response()->json($mataKuliahs);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mk' => 'required|unique:mata_kuliahs',
            'nama_mk' => 'required|string|max:255',
            'sks' => 'required|integer|min:1',
        ]);

        $mataKuliah = MataKuliah::create($request->all());

        return response()->json([
            'message' => 'Mata Kuliah berhasil ditambahkan.',
            'data' => $mataKuliah
        ], 201);
    }

    public function show($id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);
        return response()->json($mataKuliah);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_mk' => 'required|unique:mata_kuliahs,kode_mk,' . $id,
            'nama_mk' => 'required|string|max:255',
            'sks' => 'required|integer|min:1',
        ]);

        $mataKuliah = MataKuliah::findOrFail($id);
        $mataKuliah->update($request->all());

        return response()->json([
            'message' => 'Mata Kuliah berhasil diperbarui.',
            'data' => $mataKuliah
        ]);
    }

    public function destroy($id)
    {
        $mataKuliah = MataKuliah::findOrFail($id);
        $mataKuliah->delete();

        return response()->json(['message' => 'Mata Kuliah berhasil dihapus.']);
    }
}
