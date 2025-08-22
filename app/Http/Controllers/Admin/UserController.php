<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Admin;

class UserController extends Controller
{
    // app/Http/Controllers/Admin/UserController.php
    public function index(Request $request)
    {
        $type = $request->get('type', 'admin'); // default: admin

        [$title, $columns, $rows] = match ($type) {
            'dosen' => [
                'Dosen',
                ['nama' => 'Nama', 'nidn' => 'NIDN'],
                \App\Models\Dosen::select('id', 'nama', 'nidn')->paginate(10),
            ],
            'mahasiswa' => [
                'Mahasiswa',
                ['nama' => 'Nama', 'nim' => 'NIM', 'kelas' => 'Kelas'],
                \App\Models\Mahasiswa::select('id', 'nama', 'nim', 'kelas')->paginate(10),
            ],
            default => [
                'Admin',
                ['nama' => 'Nama'],
                \App\Models\Admin::select('id', 'nama')->paginate(10),
            ],
        };

        return view('admin.user.index', compact('type', 'title', 'columns', 'rows'));
    }


    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $role = $request->input('role');

        // Validasi dinamis per role
        $rules = [
            'role' => 'required|in:admin,dosen,mahasiswa',
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:100|unique:' . $role . ',username',
            'password' => 'required|string|min:6|confirmed',
        ];

        if ($role === 'dosen') {
            $rules['nidn'] = 'required|string|max:50|unique:dosen,nidn';
        }

        if ($role === 'mahasiswa') {
            $rules['nim']   = 'required|string|max:50|unique:mahasiswa,nim';
            $rules['kelas'] = 'required|string|max:50';
        }

        $validated = $request->validate($rules);

        // Data dasar yang selalu ada
        $payload = [
            'nama'     => $validated['nama'],
            'username' => $validated['username'],
            'password' => bcrypt($validated['password']),
        ];

        // Buat model sesuai role + field khususnya
        switch ($role) {
            case 'admin':
                $model = new Admin($payload);
                break;

            case 'dosen':
                $payload['nidn'] = $validated['nidn'];
                $model = new Dosen($payload);
                break;

            case 'mahasiswa':
                $payload['nim']   = $validated['nim'];
                $payload['kelas'] = $validated['kelas'];
                $model = new Mahasiswa($payload);
                break;
        }

        $model->save();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
    }


    public function show($tipe, $id)
    {
        $user = $this->findUser($tipe, $id);
        return view('admin.user.show', compact('user', 'tipe'));
    }

    public function edit($tipe, $id)
    {
        $user = $this->findUser($tipe, $id);
        return view('admin.user.edit', compact('user', 'tipe'));
    }

    public function update(Request $request, $tipe, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user = $this->findUser($tipe, $id);
        $user->nama = $request->nama;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($tipe, $id)
    {
        $user = $this->findUser($tipe, $id);
        $user->delete();

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus.');
    }

    /**
     * Helper untuk mencari user berdasarkan tipe dan ID
     */
    private function findUser($tipe, $id)
    {
        return match ($tipe) {
            'admin' => Admin::findOrFail($id),
            'dosen' => Dosen::findOrFail($id),
            'mahasiswa' => Mahasiswa::findOrFail($id),
            default => abort(404),
        };
    }
}
