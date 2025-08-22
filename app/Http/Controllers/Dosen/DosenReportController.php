<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalKuliah;
use Illuminate\Http\Request;
use App\Models\Bap;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class DosenReportController extends Controller
{
    public function index()
    {
        // View kosong, data diambil via DataTables
        return view('dosen.reports.index');
    }

    public function datatableIndex(Request $request)
    {
        $dosen = Auth::guard('dosen')->user();

        $q = JadwalKuliah::query()
            ->where('nama_dosen', $dosen->nama)
            // JANGAN select total_pertemuan kalau kolomnya gak ada
            ->select('id', 'nama_mk', 'hari', 'waktu', 'kelas')
            // relasi yang benar: baps (jamak)
            ->withCount('baps');

        return DataTables::of($q)
            ->addIndexColumn()
            ->addColumn('total_pertemuan_fix', function ($j) {
                return $j->total_pertemuan ?? 16; // fallback 16
            })
            ->addColumn('persentase', function ($j) {
                $total = $j->total_pertemuan ?? 16;
                $done  = $j->baps_count ?? 0;
                return $total > 0 ? round(($done / $total) * 100, 1) : 0;
            })
            ->addColumn('aksi', function ($j) {
                $url = route('dosen.reports.show', $j->id);
                return '<a href="' . $url . '" class="btn btn-sm btn-primary">📄 Lihat BAP</a>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show($jadwalId)
    {
        $jadwal = JadwalKuliah::findOrFail($jadwalId);
        // View kosong; detail tabel diambil via DataTables
        return view('dosen.reports.show', compact('jadwal'));
    }

    public function datatableShow($jadwalId)
    {
        $jadwal = JadwalKuliah::findOrFail($jadwalId);

        $q = Bap::query()
            ->with('jadwal')
            ->where('jadwal_kuliah_id', $jadwal->id)
            ->withCount([
                // alias counts
                'bapMahasiswa as total_mhs'     => fn($q) => $q,
                'bapMahasiswa as hadir_count'   => fn($q) => $q->where('hadir', 1),        // pakai 1 biar eksplisit
                'bapMahasiswa as ttd_mhs_count' => fn($q) => $q->whereNotNull('ttd_mahasiswa'),
            ])
            ->select('bap.*')
            ->orderBy('pertemuan_ke');

        return DataTables::of($q)
            ->addIndexColumn()

            // ✅ pastikan key-key ada di payload
            ->addColumn('hadir_count',   fn($b) => (int) ($b->hadir_count   ?? 0))
            ->addColumn('total_mhs',     fn($b) => (int) ($b->total_mhs     ?? 0))
            ->addColumn('ttd_mhs_count', fn($b) => (int) ($b->ttd_mhs_count ?? 0))

            ->editColumn('tanggal', fn($b) => $b->tanggal ? \Carbon\Carbon::parse($b->tanggal)->format('d-m-Y') : '-')
            ->addColumn('kelas', fn($b) => optional($b->jadwal)->kelas ?? '-')
            ->addColumn('ttd_dosen', fn($b) => $b->foto_pembelajaran ? '✔️' : '❌')
            ->addColumn('ttd_mhs', fn($b) => ($b->ttd_mhs_count ?? 0) . '/' . ($b->total_mhs ?? 0))
            ->addColumn('status_teks', function ($b) {
                $okDosen = !empty($b->foto_pembelajaran);
                $okMhs   = ($b->ttd_mhs_count ?? 0) == ($b->total_mhs ?? 0) && ($b->total_mhs ?? 0) > 0;
                return ($okDosen && $okMhs) ? 'Lengkap' : 'Belum Lengkap';
            })
            ->make(true);
    }


    public function exportPdf($jadwalId)
    {
        $jadwal = JadwalKuliah::findOrFail($jadwalId);
        $baps = Bap::where('jadwal_kuliah_id', $jadwal->id)->orderBy('pertemuan_ke')->get();

        $pdf = Pdf::loadView('dosen.reports.pdf', compact('jadwal', 'baps'))->setPaper('a4', 'portrait');
        return $pdf->stream('laporan_bap_' . $jadwal->kode_mk . '.pdf');
    }
}
