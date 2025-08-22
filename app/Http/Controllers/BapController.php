<?php

namespace App\Http\Controllers;

use App\Models\BeritaAcara as Bap;

use App\Models\JadwalKuliah as jadwal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BapController extends Controller
{
    // ========== ADMIN ==========
    public function index()
    {
        $baps = Bap::latest()->get();
        return view('admin.bap.index', compact('baps'));
    }

    public function show($id)
    {
        $bap = Bap::with(['jadwal', 'dosen', 'mahasiswa'])->findOrFail($id);
        return view('admin.bap.show', compact('bap'));
    }

    public function approve($id)
    {
        $bap = Bap::findOrFail($id);
        $bap->status = 'disetujui';
        $bap->save();

        return back()->with('success', 'BAP telah disetujui.');
    }

    public function reject($id)
    {
        $bap = Bap::findOrFail($id);
        $bap->status = 'ditolak';
        $bap->save();

        return back()->with('success', 'BAP telah ditolak.');
    }

    // ========== DOSEN ==========
    public function create($jadwal_id)
    {
        $jadwal = Jadwal::findOrFail($jadwal_id);
        return view('dosen.bap.create', compact('jadwal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal,id',
            'materi' => 'required|string',
            'pertemuan_ke' => 'required|numeric',
        ]);

        Bap::create([
            'jadwal_id' => $request->jadwal_id,
            'dosen_id' => Auth::id(),
            'materi' => $request->materi,
            'pertemuan_ke' => $request->pertemuan_ke,
            'status' => 'menunggu',
        ]);

        return redirect()->route('dosen.bap.index')->with('success', 'BAP berhasil disimpan.');
    }

    public function kehadiran($id)
    {
        $bap = Bap::with('jadwal.mahasiswa')->findOrFail($id);
        return view('dosen.bap.kehadiran', compact('bap'));
    }

    // ========== MAHASISWA ==========
    public function aktif()
    {
        $bap = Bap::whereHas('jadwal.mahasiswa', function ($query) {
            $query->where('mahasiswa_id', Auth::id());
        })->where('status', 'menunggu')->latest()->first();

        return view('mahasiswa.bap.aktif', compact('bap'));
    }

    public function ttd($id)
    {
        $bap = Bap::findOrFail($id);
        $bap->mahasiswa_id = Auth::id();
        $bap->status = 'ditandatangani';
        $bap->save();

        return back()->with('success', 'BAP berhasil ditandatangani.');
    }

    public function riwayat()
    {
        $baps = Bap::where('mahasiswa_id', Auth::id())->latest()->get();
        return view('mahasiswa.bap.riwayat', compact('baps'));
    }
}
