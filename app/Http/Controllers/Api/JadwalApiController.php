<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class JadwalApiController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::with('mataKuliah')->get();
        return response()->json($jadwals);
    }

    public function store(Request $request)
    {
        $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'ruangan' => 'required|string',
            'kelas' => 'required|string',
        ]);

        $jadwal = Jadwal::create($request->all());

        return response()->json([
            'message' => 'Jadwal berhasil ditambahkan.',
            'data' => $jadwal
        ], 201);
    }

    public function show($id)
    {
        $jadwal = Jadwal::with('mataKuliah')->findOrFail($id);
        return response()->json($jadwal);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'ruangan' => 'required|string',
            'kelas' => 'required|string',
        ]);

        $jadwal = Jadwal::findOrFail($id);
        $jadwal->update($request->all());

        return response()->json([
            'message' => 'Jadwal berhasil diperbarui.',
            'data' => $jadwal
        ]);
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);
        $jadwal->delete();

        return response()->json(['message' => 'Jadwal berhasil dihapus.']);
    }
}
