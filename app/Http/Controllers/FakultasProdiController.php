<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fakultas;
use App\Models\Prodi;
use Illuminate\Support\Facades\Validator;

class FakultasProdiController extends Controller
{
  /**
   * Menampilkan daftar Fakultas dan Prodi
   */
  public function index()
  {
    $prodis = Prodi::all();
    return view('admin.fakultas_prodi.index', compact('prodis'));
  }

  /**
   * Menyimpan Fakultas & Prodi baru
   */
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'fakultas' => 'required|string|max:100',
      'prodi' => 'required|string|max:100',
    ]);

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    // Cek apakah fakultas sudah ada
    $fakultas = Fakultas::firstOrCreate(['nama' => $request->fakultas]);

    // Tambahkan prodi baru yang terhubung ke fakultas
    $fakultas->prodi()->create([
      'nama' => $request->prodi
    ]);

    return redirect()->route('admin.fakultas_prodi.index')->with('success', 'Prodi berhasil ditambahkan.');
  }
}
