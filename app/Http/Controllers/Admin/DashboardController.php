<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\JadwalKuliah;
use App\Models\Bap;

class DashboardController extends Controller
{
    public function index()
    {
        $dosenCount     = Dosen::count();
        $mahasiswaCount = Mahasiswa::count();
        $jadwalCount    = JadwalKuliah::count();
        $bapCount       = Bap::count();

        return view('admin.dashboard', compact('dosenCount', 'mahasiswaCount', 'jadwalCount', 'bapCount'));
    }
}
