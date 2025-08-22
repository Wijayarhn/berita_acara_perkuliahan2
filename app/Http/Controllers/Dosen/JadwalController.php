<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalKuliah;
use App\Models\Mahasiswa;
use Yajra\DataTables\Facades\DataTables;

class JadwalController extends Controller
{
    public function index()
    {
        // View kosong, data diambil via AJAX datatable
        return view('dosen.jadwal.index');
    }

    public function datatable(Request $request)
    {
        $dosen = Auth::guard('dosen')->user();

        $q = JadwalKuliah::where('nama_dosen', $dosen->nama)
            ->select('id', 'kode_mk', 'nama_mk', 'kelas', 'hari', 'waktu', 'ruang');

        return DataTables::of($q)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $url = route('dosen.jadwal.show', $row->id);
                return '<a href="' . $url . '" class="btn btn-sm btn-primary">Lihat</a>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }
    public function create($jadwal_id)
    {
        $jadwal = JadwalKuliah::findOrFail($jadwal_id);
        return view('dosen.bap.create', compact('jadwal'));
    }

    public function show($id)
    {
        $jadwal = JadwalKuliah::findOrFail($id);
        $mahasiswa = Mahasiswa::where('kelas', $jadwal->kelas)->get();

        return view('dosen.jadwal.show', compact('jadwal', 'mahasiswa'));
    }
}
