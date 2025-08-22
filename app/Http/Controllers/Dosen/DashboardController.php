<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalKuliah;
use App\Models\Bap;

class DashboardController extends Controller
{
    public function index()
    {
        $dosen = auth()->guard('dosen')->user();

        // Query berdasarkan nama dosen
        $jadwals = JadwalKuliah::where('nama_dosen', $dosen->nama)->get();

        $jumlahJadwal = $jadwals->count();

        // Ambil BAP berdasarkan dosen_id
        $jumlahBap = Bap::where('dosen_id', $dosen->id)->count();

        // Hitung jadwal yang belum ada BAP
        $jadwalIdsWithBap = Bap::where('dosen_id', $dosen->id)->pluck('jadwal_kuliah_id')->toArray();
        $belumBuatBap = $jadwals->whereNotIn('id', $jadwalIdsWithBap)->count();

        // Hari ini (pakai format hari lokal)
        $hariIni = now()->isoFormat('dddd'); // contoh: Senin, Selasa, dst
        $jadwalHariIni = $jadwals->where('hari', $hariIni)->count();

        return view('dosen.dashboard', compact(
            'jumlahJadwal',
            'jumlahBap',
            'belumBuatBap',
            'jadwalHariIni'
        ));
    }
}
