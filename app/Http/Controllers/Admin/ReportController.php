<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\Bap;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    // 📊 Laporan daftar dosen dengan jumlah BAP
    public function indexDosen()
    {
        return view('admin.reports.dosen.index');
    }

    // 🔄 Endpoint DataTables
    public function datatableDosen(Request $request)
    {
        $q = Dosen::select('id', 'nama')->withCount('bap');

        return DataTables::of($q)
            ->addIndexColumn() // DT_RowIndex
            ->addColumn('aksi', function ($row) {
                $show = route('admin.reports.dosen.show', $row->id);
                return '<a href="' . $show . '" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Detail</a>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // 📄 Detail BAP per dosen
    public function showDosen($id)
    {
        $dosen = Dosen::findOrFail($id);

        // Ambil BAP grup berdasarkan mata kuliah (jadwal_id)
        $groupedBap = $dosen->bap()
            ->with('jadwal')
            ->get()
            ->groupBy(fn($bap) => $bap->jadwal->nama_mk ?? 'Tidak Diketahui');

        return view('admin.reports.dosen.show', compact('dosen', 'groupedBap'));
    }


    public function datatableDosenDetail($id)
    {
        $dosen = Dosen::findOrFail($id);

        // Ambil semua BAP dosen ini + MK, lalu kelompokkan per MK
        $rows = $dosen->bap()->with('jadwal')->get()
            ->groupBy(function ($b) {
                return $b->jadwal->nama_mk ?? 'Tidak Diketahui';
            })
            ->map(function ($baps, $mk) {
                $total     = $baps->count();
                $disetujui = $baps->where('status_verifikasi', 'disetujui')->count();
                $belum     = $total - $disetujui;
                return [
                    'mata_kuliah' => $mk,
                    'total'       => $total,
                    'disetujui'   => $disetujui,
                    'belum'       => $belum,
                ];
            })
            ->values(); // -> collection of arrays

        return DataTables::of($rows)
            ->addIndexColumn() // DT_RowIndex
            ->make(true);
    }
}
