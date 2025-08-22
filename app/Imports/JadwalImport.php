<?php

namespace App\Imports;

use App\Models\JadwalKuliah;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\Prodi;
use App\Models\Fakultas;
use App\Models\Semester;
use App\Models\Kelas;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;

class JadwalImport implements ToModel
{
  public function model(array $row)
  {
    if ($row[0] === "NO" || empty($row[1])) return null; // Skip header

    // 💡 Split kolom prodi: "FILKOM/Ilmu Komputer"
    [$fakultasNama, $prodiNama] = explode('/', $row[11]);

    // ✅ Insert fakultas & prodi jika belum ada
    $fakultas = Fakultas::firstOrCreate(['nama_fakultas' => trim($fakultasNama)]);
    $prodi = Prodi::firstOrCreate([
      'nama_prodi' => trim($prodiNama),
      'fakultas_id' => $fakultas->id,
    ]);

    // ✅ Cek atau insert mata kuliah
    $mataKuliah = MataKuliah::firstOrCreate(
      ['kode_mk' => $row[1]],
      [
        'nama' => $row[2],
        'sks' => $row[3],
        'prodi_id' => $prodi->id,
      ]
    );

    // ✅ Cek dosen berdasarkan nama user
    $dosen = Dosen::whereHas('user', function ($q) use ($row) {
      $q->where('name', 'like', '%' . $row[4] . '%');
    })->first();

    // ✅ Cek atau insert kelas
    $kelas = Kelas::firstOrCreate([
      'nama_kelas' => $row[5],
      'prodi_id' => $prodi->id,
    ]);

    // ✅ Ambil semester aktif
    $semester = Semester::where('tahun_akademik', '2024-2025')->where('jenis', 'genap')->first();
    $semesterId = $semester?->id;

    // ✅ Parsing jam
    $jam_mulai = null;
    $jam_selesai = null;
    if (!empty($row[8]) && Str::contains($row[8], ' - ')) {
      [$jam_mulai, $jam_selesai] = explode(' - ', $row[8]);
    }

    return new JadwalKuliah([
      'mata_kuliah_id' => $mataKuliah->id,
      'dosen_id' => optional($dosen)->id,
      'kelas_id' => $kelas->id,
      'hari' => $row[7],
      'jam_mulai' => $jam_mulai,
      'jam_selesai' => $jam_selesai,
      'ruangan' => $row[9],
      'kelompok' => $row[10] ?? null,
      'semester_id' => $semesterId,
    ]);
  }
}
