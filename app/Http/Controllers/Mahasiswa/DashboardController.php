<?php
// app/Http/Controllers/Mahasiswa/DashboardController.php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $mahasiswa = auth()->guard('mahasiswa')->user();

        $baps = $mahasiswa->baps ?? collect();

        $totalBap       = $baps->count();
        $sudahTtd       = $baps->where('ttd_mahasiswa', true)->count();
        $belumTtd       = $baps->where('ttd_mahasiswa', false)->count();
        $bapHariIni     = $baps->where('tanggal', now()->toDateString())->count();

        return view('mahasiswa.dashboard', compact(
            'totalBap',
            'sudahTtd',
            'belumTtd',
            'bapHariIni'
        ));
    }
}
