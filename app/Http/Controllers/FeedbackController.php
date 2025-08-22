<?php

namespace App\Http\Controllers;

use App\Models\Bap;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{

    public function create($bap_id)
    {
        $bap = Bap::with('feedbacks')->findOrFail($bap_id);

        if ($bap->feedbacks->count() >= 2) {
            return redirect()->route('bap.show', $bap_id)->with('error', 'Feedback sudah penuh!');
        }

        return view('feedback.create', compact('bap'));
    }

    public function store(Request $request)
    {
        $bap = Bap::with('feedbacks')->findOrFail($request->bap_id);

        if ($bap->feedbacks->count() >= 2) {
            return redirect()->route('bap.show', $request->bap_id)->with('error', 'Feedback sudah penuh!');
        }

        $request->validate([
            'bap_id' => 'required|exists:baps,id',
            'id_mahasiswa' => 'nullable',
            'nama_mahasiswa' => 'required|string|max:255',
            'nim' => 'required|string|max:50',
            'kelas' => 'required|string|max:50',
            'email' => 'required|email',
            'feedback' => 'required|string|max:1000',
        ]);

        Feedback::create($request->all());

        return redirect()->back()->with('success', 'Feedback berhasil dikirim!');
    }

    public function createMahasiswa($bap_id)
    {
        $bap = Bap::with('feedbacks')->findOrFail($bap_id);
        $mahasiswa = Auth::user(); // Ambil data mahasiswa yang sedang login

        // Cek apakah feedback sudah mencapai batas maksimal (2 mahasiswa)
        if ($bap->feedbacks->count() >= 2) {
            return redirect()->route('mahasiswa.bap.show', $bap_id)->with('error', 'Feedback sudah penuh!');
        }

        return view('mahasiswa.feedback.create', compact('bap', 'mahasiswa'));
    }


    public function storeMahasiswa(Request $request)
    {
        $bap = Bap::with('feedbacks')->findOrFail($request->bap_id);
        $mahasiswa = Auth::user(); // Ambil data mahasiswa yang sedang login

        // Cek apakah feedback sudah penuh
        if ($bap->feedbacks->count() >= 2) {
            return redirect()->route('mahasiswa.bap.show', $request->bap_id)->with('error', 'Feedback sudah penuh!');
        }

        // Validasi input
        $request->validate([
            'bap_id' => 'required|exists:baps,id',
            'feedback' => 'required|string|max:1000',
        ]);

        // Simpan feedback dengan data mahasiswa dari tabel users
        Feedback::create([
            'bap_id' => $request->bap_id,
            'id_mahasiswa' => $mahasiswa->id,
            'nama_mahasiswa' => $mahasiswa->name,
            'nim' => $mahasiswa->nim,
            'kelas' => $mahasiswa->class,
            'email' => $mahasiswa->email,
            'feedback' => $request->feedback,
        ]);

        return redirect()->route('mahasiswa.bap.show', $request->bap_id)->with('success', 'Feedback berhasil dikirim!');
    }
}