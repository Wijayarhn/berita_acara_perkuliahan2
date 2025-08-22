<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Dosen;
use App\Models\Mahasiswa;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginAction(Request $request)
    {
        $credentials = $request->only('username', 'password');

        // ✅ Admin
        if (Auth::guard('admin')->attempt($credentials)) {
            session()->flash('success', 'Selamat datang ' . Auth::guard('admin')->user()->nama . ' di Dashboard!');
            return redirect()->route('admin.dashboard');
        }

        // ✅ Dosen
        if (Auth::guard('dosen')->attempt($credentials)) {
            session()->flash('success', 'Selamat datang ' . Auth::guard('dosen')->user()->nama . ' di Dashboard!');
            return redirect()->route('dosen.dashboard');
        }

        // ✅ Mahasiswa
        if (Auth::guard('mahasiswa')->attempt($credentials)) {
            session()->flash('success', 'Selamat datang ' . Auth::guard('mahasiswa')->user()->nama . ' di Dashboard!');
            return redirect()->route('mahasiswa.dashboard');
        }

        return back()->withErrors(['login' => 'Username atau password salah']);
    }


    public function logout()
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('dosen')->check()) {
            Auth::guard('dosen')->logout();
        } elseif (Auth::guard('mahasiswa')->check()) {
            Auth::guard('mahasiswa')->logout();
        }

        return redirect()->route('login');
    }

    // ✅ OPTIONAL: Manual Register (tidak wajib digunakan kalau input via admin)
    public function register()
    {
        return view('auth.register');
    }

    public function registerSave(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:admin,username|unique:dosen,username|unique:mahasiswa,username',
            'password' => 'required|min:6|confirmed',
            'nama' => 'required',
            'role' => 'required|in:admin,dosen,mahasiswa',
        ]);

        $data = [
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nama'     => $request->nama,
        ];

        switch ($request->role) {
            case 'admin':
                Admin::create($data);
                break;
            case 'dosen':
                Dosen::create($data + ['nidn' => $request->nidn]);
                break;
            case 'mahasiswa':
                Mahasiswa::create($data + [
                    'nim'   => $request->nim,
                    'kelas' => $request->kelas,
                ]);
                break;
        }

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat');
    }
}
