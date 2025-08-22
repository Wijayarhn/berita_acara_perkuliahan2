<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bap;
use App\Models\BapMahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class BapController extends Controller
{
    /**
     * Menampilkan daftar BAP yang aktif dan belum ditandatangani oleh mahasiswa.
     */
    public function index()
    {
        // View kosong; data akan diambil via DataTables
        return view('mahasiswa.bap.index');
    }

    public function datatable(Request $request)
    {
        $mahasiswaId = Auth::guard('mahasiswa')->id();

        $q = Bap::query()
            ->whereHas('bapMahasiswa', function ($sub) use ($mahasiswaId) {
                $sub->where('mahasiswa_id', $mahasiswaId)
                    ->whereNull('lokasi_mahasiswa'); // belum tanda tangan
            })
            ->with('jadwal') // ambil nama_mk
            ->select('bap.*')
            ->latest('tanggal');

        return DataTables::of($q)
            ->addIndexColumn()
            ->addColumn('mata_kuliah', fn($b) => optional($b->jadwal)->nama_mk ?? '-')
            ->editColumn('tanggal', fn($b) => $b->tanggal ? Carbon::parse($b->tanggal)->format('d M Y') : '-')
            ->addColumn('aksi', function ($b) {
                $show = route('mahasiswa.bap.show', $b->id);
                $ttd  = route('mahasiswa.bap.form_ttd', $b->id); // ✅ pakai route GET form
                return <<<HTML
<div class="btn-group btn-group-sm" role="group">
  <a href="{$show}" class="btn btn-primary">Lihat</a>
  <a href="{$ttd}"  class="btn btn-success">TTD</a>
</div>
HTML;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    /**
     * Menampilkan detail BAP untuk mahasiswa.
     */
    public function show($id)
    {
        $mahasiswaId = Auth::guard('mahasiswa')->id();

        // Pastikan BAP memang terhubung dengan mahasiswa tersebut
        $bap = Bap::whereHas('bapMahasiswa', function ($query) use ($mahasiswaId) {
            $query->where('mahasiswa_id', $mahasiswaId);
        })->with(['jadwal', 'bapMahasiswa'])->findOrFail($id);

        return view('mahasiswa.bap.show', compact('bap'));
    }

    public function formTtd($id)
    {
        $mahasiswaId = Auth::guard('mahasiswa')->id();

        // Pastikan BAP memang terhubung dengan mahasiswa tersebut
        $bap = Bap::whereHas('bapMahasiswa', function ($query) use ($mahasiswaId) {
            $query->where('mahasiswa_id', $mahasiswaId);
        })->with('jadwal')->findOrFail($id);

        return view('mahasiswa.bap.ttd', compact('bap'));
    }


    /**
     * Proses mahasiswa tanda tangan BAP dengan menyimpan lokasi.
     */
    public function ttd(Request $request, $id)
    {
        $mahasiswaId = Auth::guard('mahasiswa')->id();

        $request->validate([
            'lokasi_mahasiswa' => 'required|string|max:255',
            'ttd_mahasiswa' => 'required|string',
        ]);

        // Cek apakah sudah ada 2 mahasiswa yang memberikan ttd pada BAP ini
        $jumlahSudahTtd = BapMahasiswa::where('bap_id', $id)
            ->whereNotNull('ttd_mahasiswa')
            ->count();

        if ($jumlahSudahTtd >= 2) {
            return redirect()->back()->with('error', 'Batas maksimal mahasiswa yang memberikan TTD telah tercapai.');
        }

        $bapMahasiswa = BapMahasiswa::where('bap_id', $id)
            ->where('mahasiswa_id', $mahasiswaId)
            ->firstOrFail();

        // Cegah mahasiswa memberikan ttd lebih dari sekali
        if ($bapMahasiswa->ttd_mahasiswa) {
            return redirect()->back()->with('error', 'Anda sudah memberikan TTD untuk BAP ini.');
        }

        $bapMahasiswa->update([
            'lokasi_mahasiswa' => $request->lokasi_mahasiswa,
            'ttd_mahasiswa' => $request->ttd_mahasiswa,
        ]);

        return redirect()->route('mahasiswa.bap.index')->with('success', 'Berhasil tanda tangan BAP.');
    }


    public function riwayat()
    {
        // View kosong; data diambil via DataTables
        return view('mahasiswa.bap.riwayat');
    }

    public function datatableRiwayat(Request $request)
    {
        $mahasiswaId = Auth::guard('mahasiswa')->id();

        $q = \App\Models\BapMahasiswa::query()
            ->where('mahasiswa_id', $mahasiswaId)
            ->whereNotNull('lokasi_mahasiswa') // sudah TTD
            ->with(['bap.jadwal'])             // untuk nama mk & tanggal
            ->select('bap_mahasiswa.*')
            ->latest('id');                    // urutan terbaru

        return DataTables::of($q)
            ->addIndexColumn()
            ->addColumn('mata_kuliah', function ($r) {
                return optional(optional($r->bap)->jadwal)->nama_mk ?? '-';
            })
            ->addColumn('tanggal', function ($r) {
                $tgl = optional($r->bap)->tanggal;
                return $tgl ? Carbon::parse($tgl)->format('d M Y') : '-';
            })
            ->addColumn('status_text', function ($r) {
                $s = optional($r->bap)->status_verifikasi;
                return $s ? ucfirst($s) : 'Ditandatangani';
            })
            ->addColumn('aksi', function ($r) {
                $showUrl = route('mahasiswa.bap.show', $r->bap_id);
                return '<a href="' . $showUrl . '" class="btn btn-sm btn-info">
                  <i class="fas fa-eye"></i> Show
                </a>';
            })
            ->rawColumns(['aksi']) // biar button tidak di-escape
            ->make(true);
    }

    public function exportPdf($id)
    {
        $bap = Bap::with(['jadwal', 'dosen', 'mahasiswa', 'bapMahasiswa'])->findOrFail($id);

        $pdf = Pdf::loadView('dosen.bap.pdf', compact('bap'))->setPaper('a4', 'portrait');
        return $pdf->stream('berita_acara_' . $bap->id . '.pdf');
    }
}
