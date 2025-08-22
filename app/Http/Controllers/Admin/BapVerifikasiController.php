<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bap;
use App\Helpers\GeoHelper;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;

class BapVerifikasiController extends Controller
{
    public function index()
    {
        // view tanpa load semua data; DataTables akan ambil via AJAX
        return view('admin.bap.index');
    }

    public function datatable(Request $request)
    {
        $q = Bap::with(['jadwal', 'dosen'])->select('bap.*');

        return DataTables::of($q)
            ->addIndexColumn()
            ->addColumn('hari', fn($b) => optional($b->jadwal)->hari ?? '-')
            ->addColumn('mata_kuliah', fn($b) => optional($b->jadwal)->nama_mk ?? '-')
            ->addColumn('dosen_nama', fn($b) => optional($b->dosen)->nama ?? '-')
            ->addColumn('waktu', fn($b) => optional($b->jadwal)->waktu ?? '-')
            ->addColumn('status', fn($b) => $b->status_verifikasi ?? 'belum')
            ->editColumn('created_at', fn($b) => optional($b->created_at)->format('Y-m-d H:i'))
            ->addColumn('aksi', function ($b) {
                $url = route('admin.bap.show', $b->id);
                return '<a href="' . $url . '" class="btn btn-sm btn-primary" title="Detail"><i class="fas fa-eye"></i> Detail</a>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show($id)
    {
        $bap = Bap::with('jadwal', 'dosen', 'bapMahasiswa.mahasiswa')->findOrFail($id);

        // Konversi lokasi mahasiswa
        foreach ($bap->bapMahasiswa as $bm) {
            if ($bm->lokasi_mahasiswa) {
                [$lat, $lon] = explode(',', $bm->lokasi_mahasiswa);
                $bm->lokasi_nama = GeoHelper::getCityFromCoordinates(trim($lat), trim($lon));
            } else {
                $bm->lokasi_nama = 'Tidak tersedia';
            }
        }

        // Konversi lokasi dosen
        if ($bap->lokasi_dosen) {
            [$latDosen, $lonDosen] = explode(',', $bap->lokasi_dosen);
            $bap->lokasi_dosen_nama = GeoHelper::getCityFromCoordinates(trim($latDosen), trim($lonDosen));
        } else {
            $bap->lokasi_dosen_nama = 'Tidak tersedia';
        }

        return view('admin.bap.show', compact('bap'));
    }


    public function verifikasi(Request $request, $id)
    {
        $bap = Bap::findOrFail($id);
        $bap->status_verifikasi = 'disetujui'; // ganti sesuai field di DB
        $bap->verifikasi_admin_id = auth()->id(); // simpan ID admin yg menyetujui
        $bap->save();

        return redirect()->route('admin.bap.index')->with('success', 'BAP berhasil diverifikasi.');
    }

    public function exportPdf($id)
    {
        $bap = Bap::with('jadwal', 'dosen', 'bapMahasiswa.mahasiswa')->findOrFail($id);

        // Lokasi Mahasiswa
        foreach ($bap->bapMahasiswa as $bm) {
            if ($bm->lokasi_mahasiswa) {
                [$lat, $lon] = explode(',', $bm->lokasi_mahasiswa);
                $bm->lokasi_nama = \App\Helpers\GeoHelper::getCityFromCoordinates(trim($lat), trim($lon));
            } else {
                $bm->lokasi_nama = 'Tidak tersedia';
            }
        }

        // Lokasi Dosen
        if ($bap->lokasi_dosen) {
            [$latDosen, $lonDosen] = explode(',', $bap->lokasi_dosen);
            $bap->lokasi_dosen_nama = \App\Helpers\GeoHelper::getCityFromCoordinates(trim($latDosen), trim($lonDosen));
        } else {
            $bap->lokasi_dosen_nama = 'Tidak tersedia';
        }

        $pdf = Pdf::loadView('admin.bap.pdf', compact('bap'))->setPaper('a4', 'portrait');
        return $pdf->stream('BAP-' . $bap->jadwal->nama_mk . '.pdf');
    }
}
