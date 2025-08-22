<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\User;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DosenController extends Controller
{
  public function index()
  {
    $dosen = Dosen::with('user', 'prodi')->latest()->get();
    return view('admin.dosen.index', compact('dosen'));
  }

  public function create()
  {
    $prodi = Prodi::all();
    return view('admin.dosen.create', compact('prodi'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'username' => 'required|string|unique:users,username',
      'password' => 'required|string|min:6',
      'nidn' => 'required|string|unique:dosen,nidn',
      'gelar' => 'nullable|string|max:50',
      'prodi_id' => 'required|exists:prodis,id',
    ]);

    $user = User::create([
      'name' => $request->name,
      'username' => $request->username,
      'password' => Hash::make($request->password),
      'role' => 'dosen',
    ]);

    Dosen::create([
      'user_id' => $user->id,
      'nidn' => $request->nidn,
      'gelar' => $request->gelar,
      'prodi_id' => $request->prodi_id,
    ]);

    return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil ditambahkan.');
  }

  public function edit($id)
  {
    $dosen = Dosen::with('user')->findOrFail($id);
    $prodi = Prodi::all();
    return view('admin.dosen.edit', compact('dosen', 'prodi'));
  }

  public function update(Request $request, $id)
  {
    $dosen = Dosen::with('user')->findOrFail($id);

    $request->validate([
      'name' => 'required|string|max:255',
      'username' => 'required|string|unique:users,username,' . $dosen->user->id,
      'nidn' => 'required|string|unique:dosen,nidn,' . $dosen->id,
      'gelar' => 'nullable|string|max:50',
      'prodi_id' => 'required|exists:prodis,id',
    ]);

    $dosen->user->update([
      'name' => $request->name,
      'username' => $request->username,
    ]);

    if ($request->filled('password')) {
      $dosen->user->update([
        'password' => Hash::make($request->password),
      ]);
    }

    $dosen->update([
      'nidn' => $request->nidn,
      'gelar' => $request->gelar,
      'prodi_id' => $request->prodi_id,
    ]);

    return redirect()->route('admin.dosen.index')->with('success', 'Data dosen berhasil diperbarui.');
  }

  public function destroy($id)
  {
    $dosen = Dosen::findOrFail($id);
    $user = $dosen->user;
    $dosen->delete();
    $user->delete();

    return redirect()->route('admin.dosen.index')->with('success', 'Dosen berhasil dihapus.');
  }
}
