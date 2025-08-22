<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalKuliah;
use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\Semester;
use App\Models\Kelas;
// Tambahkan pada bagian atas file controller
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\JadwalImport;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = JadwalKuliah::with([
            'dosen.user',
            'semester',
            'kelas.prodi',
            'mataKuliah.prodi'
        ])->latest()->get();

        return view('admin.jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $dosens = Dosen::with('user')->get();
        $prodis = Prodi::all();
        $semesters = Semester::all();
        $kelas = Kelas::all();

        return view('admin.jadwal.create', compact('dosens', 'prodis', 'semesters', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required',
            'prodi_id' => 'required',
            'semester_id' => 'required',
            'kelas_id' => 'required',
            'mata_kuliah' => 'required|string|max:255',
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        JadwalKuliah::create($request->all());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jadwal = JadwalKuliah::findOrFail($id);
        $dosens = Dosen::with('user')->get();
        $prodis = Prodi::all();
        $semesters = Semester::all();
        $kelas = Kelas::all();

        return view('jadwal.edit', compact('jadwal', 'dosens', 'prodis', 'semesters', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalKuliah::findOrFail($id);

        $request->validate([
            'dosen_id' => 'required',
            'prodi_id' => 'required',
            'semester_id' => 'required',
            'kelas_id' => 'required',
            'mata_kuliah' => 'required|string|max:255',
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $jadwal->update($request->all());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jadwal = JadwalKuliah::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        Excel::import(new JadwalImport, $request->file('file'));

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diimport');
    }
}
