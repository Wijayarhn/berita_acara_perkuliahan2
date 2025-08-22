<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bap;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BapApiController extends Controller
{
    public function index()
    {
        $baps = Bap::with('jadwal.mataKuliah')->get();
        return response()->json($baps);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id',
            'tanggal' => 'required|date',
            'materi' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $bap = Bap::create([
            'jadwal_id' => $request->jadwal_id,
            'tanggal' => $request->tanggal,
            'materi' => $request->materi,
            'keterangan' => $request->keterangan,
            'created_by' => Auth::id(),
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'BAP berhasil ditambahkan.', 'data' => $bap], 201);
    }

    public function show($id)
    {
        $bap = Bap::with('jadwal.mataKuliah')->findOrFail($id);
        return response()->json($bap);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id',
            'tanggal' => 'required|date',
            'materi' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $bap = Bap::findOrFail($id);
        $bap->update($request->all());

        return response()->json(['message' => 'BAP berhasil diperbarui.', 'data' => $bap]);
    }

    public function destroy($id)
    {
        $bap = Bap::findOrFail($id);
        $bap->delete();

        return response()->json(['message' => 'BAP berhasil dihapus.']);
    }

    public function pending()
    {
        $baps = Bap::with('jadwal.mataKuliah')->where('status', 'pending')->get();
        return response()->json($baps);
    }

    public function approve($id)
    {
        $bap = Bap::findOrFail($id);
        $bap->update(['status' => 'approved']);

        return response()->json(['message' => 'BAP telah disetujui.']);
    }

    public function reject($id)
    {
        $bap = Bap::findOrFail($id);
        $bap->update(['status' => 'rejected']);

        return response()->json(['message' => 'BAP telah ditolak.']);
    }

    public function approved()
    {
        $baps = Bap::with('jadwal.mataKuliah')->where('status', 'approved')->get();
        return response()->json($baps);
    }

    public function mahasiswaBaps()
    {
        $mahasiswa = Auth::user();

        $jadwalMahasiswa = Jadwal::where('kelas', $mahasiswa->class)->pluck('id');

        $baps = Bap::with('jadwal.mataKuliah')
            ->whereIn('jadwal_id', $jadwalMahasiswa)
            ->get();

        return response()->json($baps);
    }

    public function mahasiswaShow($id)
    {
        $bap = Bap::with(['jadwal.mataKuliah', 'feedbacks'])->findOrFail($id);
        $mahasiswa = Auth::user();

        return response()->json(['bap' => $bap, 'mahasiswa' => $mahasiswa]);
    }
}
