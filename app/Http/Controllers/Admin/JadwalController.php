<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Models\JadwalKuliah;
use App\Models\Dosen;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel; // <- penting!
use App\Imports\JadwalKuliahImport;


class JadwalController extends Controller
{
    public function index()
    {
        return view('admin.jadwal.index'); // tanpa paginate, data diambil via AJAX
    }

    public function datatable(Request $request)
    {
        $q = \App\Models\JadwalKuliah::select('id', 'kode_mk', 'nama_mk', 'nama_dosen', 'kelas', 'hari', 'waktu');

        return DataTables::of($q)
            ->addIndexColumn()
            ->addColumn('aksi', function ($row) {
                $show = route('admin.jadwal.show', $row->id);
                $edit = route('admin.jadwal.edit', $row->id);
                $del  = route('admin.jadwal.destroy', $row->id);
                $csrf = csrf_field();
                $method = method_field('DELETE');
                return <<<HTML
<div class="d-flex gap-1 justify-content-center">
  <a href="{$show}" class="btn btn-info btn-sm" title="Detail"><i class="fas fa-eye"></i></a>
  <a href="{$edit}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
  <form action="{$del}" method="POST" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?');" style="display:inline-block">
    {$csrf}{$method}
    <button class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash-alt"></i></button>
  </form>
</div>
HTML;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $dosens = Dosen::all(); // ambil semua dosen
        return view('admin.jadwal.create', compact('dosens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mk' => 'required|string|max:20',
            'nama_mk' => 'required|string|max:100',
            'sks' => 'required|integer|min:1',
            'nama_dosen' => 'required|string|max:100',
            'kelas' => 'required|string|max:10',
            'jumlah_mhs' => 'required|integer|min:1',
            'hari' => 'required|string|max:20',
            'waktu' => 'required|string|max:50',
            'ruang' => 'required|string|max:20',
            'kelompok' => 'nullable|string|max:20',
            'fakultas' => 'required|string|max:100',
            'prodi' => 'required|string|max:100',
            'tahun_ajaran' => 'required|string|max:20',
            'semester' => 'required|string|max:10',
        ]);

        JadwalKuliah::create($request->all());

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal = JadwalKuliah::findOrFail($id);
        $dosens = Dosen::all(); // atau sesuaikan dengan sumber datanya
        return view('admin.jadwal.edit', compact('jadwal', 'dosens'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_mk' => 'required',
            'nama_mk' => 'required',
            'sks' => 'required|integer',
            'nama_dosen' => 'required',
            'kelas' => 'required',
            'jumlah_mhs' => 'required|integer',
            'hari' => 'required',
            'waktu' => 'required',
            'ruang' => 'required',
            'kelompok' => 'nullable',
            'fakultas' => 'required',
            'prodi' => 'required',
            'tahun_ajaran' => 'required',
            'semester' => 'required',
        ]);

        $jadwal = JadwalKuliah::findOrFail($id);
        $jadwal->update($request->all());

        return redirect()->route('admin.jadwal.index')->with('success', 'Data jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalKuliah::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal.index')->with('success', 'Data jadwal berhasil dihapus.');
    }

    public function show($id)
    {
        $jadwal = JadwalKuliah::findOrFail($id);
        $mahasiswa = \App\Models\Mahasiswa::where('kelas', $jadwal->kelas)->get();

        return view('admin.jadwal.show', compact('jadwal', 'mahasiswa'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:20480',
        ], [
            'file.required' => 'File Excel wajib diunggah.',
            'file.mimes'    => 'Format harus xlsx, xls, atau csv.',
        ]);

        try {
            Excel::import(new JadwalKuliahImport, $request->file('file'));

            // ambil error duplikat dari session
            $errors = session()->pull('import_errors', []);

            if (!empty($errors)) {
                return redirect()
                    ->route('admin.jadwal.import.form') // balik ke form upload
                    ->with('error', implode('<br>', $errors));
            }


            return redirect()
                ->route('admin.jadwal.index')
                ->with('success', 'Import jadwal berhasil.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }
}
