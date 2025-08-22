<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\JadwalKuliah;
use Yajra\DataTables\Facades\DataTables;

class MahasiswaJadwalController extends Controller
{
    // Menampilkan daftar jadwal kuliah mahasiswa sesuai kelasnya
    public function index()
    {
        return view('mahasiswa.jadwal.index');
    }

    // Endpoint DataTables
    public function datatable(Request $request)
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        $q = JadwalKuliah::query()
            ->where('kelas', $mahasiswa->kelas)
            ->select('id', 'nama_mk', 'hari', 'waktu', 'ruang')
            ->orderBy('hari')
            ->orderBy('waktu');

        return DataTables::of($q)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $url = route('mahasiswa.jadwal.show', $row->id);
                return '<a href="' . $url . '" class="btn btn-info btn-sm">Detail</a>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Menampilkan detail jadwal kuliah tertentu
    public function show($id)
    {
        $jadwal = JadwalKuliah::findOrFail($id);

        return view('mahasiswa.jadwal.show', compact('jadwal'));
    }
}
