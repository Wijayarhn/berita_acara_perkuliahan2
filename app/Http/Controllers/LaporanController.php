<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BeritaAcara; // Asumsikan model BAP bernama BeritaAcara

class LaporanController extends Controller
{
  public function index(Request $request)
  {
    // Filter opsional berdasarkan tanggal, dosen, atau prodi
    $query = BeritaAcara::query();

    if ($request->has('tanggal_mulai') && $request->has('tanggal_selesai')) {
      $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
    }

    if ($request->has('dosen_id')) {
      $query->where('dosen_id', $request->dosen_id);
    }

    if ($request->has('prodi_id')) {
      $query->where('prodi_id', $request->prodi_id);
    }

    $baps = $query->latest()->get();

    return view('admin.laporan.bap', compact('baps'));
  }
}
