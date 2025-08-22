<?php

namespace App\Http\Controllers;

use App\Models\BeritaAcara as Bap;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
  /**
   * Menampilkan daftar BAP aktif yang perlu ditandatangani mahasiswa
   */
  public function aktif()
  {
    $mahasiswaId = Auth::id();

    $bapAktif = Bap::where('mahasiswa_id', $mahasiswaId)
      ->whereNull('ttd_mahasiswa')
      ->latest()
      ->get();

    return view('mahasiswa.bap.aktif', compact('bapAktif'));
  }

  /**
   * Proses tanda tangan BAP oleh mahasiswa
   */
  public function ttd($id)
  {
    $bap = Bap::where('id', $id)
      ->where('mahasiswa_id', Auth::id())
      ->firstOrFail();

    $bap->ttd_mahasiswa = now();
    $bap->save();

    return redirect()->route('mahasiswa.bap.aktif')
      ->with('success', 'BAP berhasil ditandatangani.');
  }

  /**
   * Menampilkan riwayat tanda tangan BAP
   */
  public function riwayat()
  {
    $riwayat = Bap::where('mahasiswa_id', Auth::id())
      ->whereNotNull('ttd_mahasiswa')
      ->latest()
      ->get();

    return view('mahasiswa.bap.riwayat', compact('riwayat'));
  }
}
