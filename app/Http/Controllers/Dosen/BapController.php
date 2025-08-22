<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bap;
use App\Models\JadwalKuliah;
use App\Models\Mahasiswa;
use App\Models\BapMahasiswa;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\GeoHelper; // Tambahkan di paling atas jika belum ada
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;


class BapController extends Controller
{
    public function index()
    {
        // View kosong, data diambil via DataTables
        return view('dosen.bap.index');
    }

    public function datatable(Request $request)
    {
        $dosenId = Auth::guard('dosen')->id();

        $q = Bap::with('jadwal')
            ->where('dosen_id', $dosenId)
            ->select('bap.*');

        return DataTables::of($q)
            ->addIndexColumn()
            ->addColumn('mata_kuliah', fn($b) => optional($b->jadwal)->nama_mk ?? '-')
            ->editColumn('tanggal', fn($b)   => $b->tanggal ? Carbon::parse($b->tanggal)->format('d M Y') : '-')
            ->addColumn('status_text', fn($b) => $b->status_verifikasi ?? '')
            ->addColumn('aksi', function ($b) {
                $show = route('dosen.bap.show', $b->id);
                return '<a href="' . $show . '" class="btn btn-sm btn-outline-primary">Lihat</a>';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create(Request $request)
    {
        $dosen = Auth::guard('dosen')->user();
        $jadwals = JadwalKuliah::where('nama_dosen', $dosen->nama)->get();
        $jadwal = null;

        if ($request->filled('jadwal_id')) {
            $jadwal = JadwalKuliah::find($request->jadwal_id);
        }
        $mahasiswaList = [];

        if ($jadwal) {
            $mahasiswaList = Mahasiswa::where('kelas', $jadwal->kelas)->get();
        }
        return view('dosen.bap.create', compact('jadwals', 'jadwal', 'mahasiswaList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_kuliah_id' => 'required|exists:jadwal_kuliah,id',
            'tanggal' => 'required|date',
            'materi' => 'required|string',
            'pertemuan_ke' => 'required|integer',
            'lokasi' => 'required|string',
            'jumlah_hadir' => 'required|integer|min:0',
            'jumlah_tidak_hadir' => 'required|integer|min:0',
            'pokok_bahasan' => 'nullable|string',
            'deskripsi_tugas' => 'nullable|string',
            'dokumentasi' => 'nullable|image|max:2048',
        ]);

        // Ambil data yang dibutuhkan
        $data = $request->only([
            'jadwal_kuliah_id',
            'tanggal',
            'materi',
            'pertemuan_ke',
            'jumlah_hadir',
            'jumlah_tidak_hadir',
            'pokok_bahasan',
            'deskripsi_tugas',
        ]);

        $data['dosen_id'] = Auth::guard('dosen')->id();
        $data['lokasi_dosen'] = $request->lokasi;
        $data['status_verifikasi'] = 'pending';

        // Proses dokumentasi (foto pembelajaran)
        if ($request->hasFile('dokumentasi')) {
            $file = $request->file('dokumentasi');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/dokumentasi'), $filename);
            $data['foto_pembelajaran'] = $filename;
        }

        // Simpan data BAP
        $bap = Bap::create($data);

        // Ambil mahasiswa berdasarkan kelas dari jadwal kuliah
        $jadwal = JadwalKuliah::findOrFail($data['jadwal_kuliah_id']);
        $mahasiswaList = Mahasiswa::where('kelas', $jadwal->kelas)->get();

        // Simpan absensi dari form
        if ($request->has('kehadiran')) {
            foreach ($request->kehadiran as $mhsId => $absen) {
                BapMahasiswa::create([
                    'bap_id' => $bap->id,
                    'mahasiswa_id' => $mhsId,
                    'hadir' => isset($absen['hadir']) ? 1 : 0,
                    'keterangan' => $absen['keterangan'] ?? null,
                ]);
            }
        }

        return redirect()->route('dosen.bap.index')->with('success', 'BAP berhasil disimpan.');
    }

    public function show($id)
    {
        $bap = Bap::with('jadwal', 'bapMahasiswa.mahasiswa')->findOrFail($id);

        // Tambahkan lokasi dosen dalam bentuk nama kota
        if ($bap->lokasi_dosen) {
            [$lat, $lon] = explode(',', $bap->lokasi_dosen);
            $bap->lokasi_dosen_nama = GeoHelper::getCityFromCoordinates(trim($lat), trim($lon));
        } else {
            $bap->lokasi_dosen_nama = 'Tidak tersedia';
        }

        return view('dosen.bap.show', compact('bap'));
    }

    public function exportPdf($id)
    {
        $bap = Bap::with(['jadwal', 'dosen', 'mahasiswa', 'bapMahasiswa'])->findOrFail($id);

        // Tambahkan lokasi dosen dalam bentuk nama kota
        if ($bap->lokasi_dosen) {
            [$lat, $lon] = explode(',', $bap->lokasi_dosen);
            $bap->lokasi_dosen_nama = GeoHelper::getCityFromCoordinates(trim($lat), trim($lon));
        } else {
            $bap->lokasi_dosen_nama = 'Tidak tersedia';
        }

        $pdf = Pdf::loadView('dosen.bap.pdf', compact('bap'))->setPaper('a4', 'portrait');
        return $pdf->stream('berita_acara_' . $bap->id . '.pdf');
    }
}
