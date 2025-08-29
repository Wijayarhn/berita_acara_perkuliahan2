<?php

namespace App\Imports;

use App\Models\JadwalKuliah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Session;

class JadwalKuliahImport implements ToModel, WithHeadingRow
{
    public function headingRow(): int
    {
        return 5; // baris ke-5 adalah header
    }

    public function model(array $row)
    {
        $fakultas = null;
        $prodi = null;

        if (isset($row['prodi'])) {
            $parts = explode('/', $row['prodi']);
            $fakultas = $parts[0] ?? null;
            $prodi = $parts[1] ?? null;
        }

        $tahunAjaran = '2024/2025';
        $semester    = 'Genap';

        // 🔎 Cek apakah sudah ada data duplikat
        $exists = JadwalKuliah::where('kode_mk', $row['kode_mk'] ?? null)
            ->where('nama_dosen', $row['dosen'] ?? null)
            ->where('tahun_ajaran', $tahunAjaran)
            ->where('semester', $semester)
            ->exists();

        if ($exists) {
            // Simpan pesan error ke session (biar bisa ditampilkan di controller)
            Session::push('import_errors', "Data Kode MK {$row['kode_mk']} dengan Dosen {$row['dosen']} sudah ada di database. Tidak disimpan.");
            return null; // jangan buat record baru
        }

        return new JadwalKuliah([
            'kode_mk'      => $row['kode_mk'] ?? null,
            'nama_mk'      => $row['mata_kuliah'] ?? null,
            'sks'          => $row['sks'] ?? null,
            'nama_dosen'   => $row['dosen'] ?? null,
            'kelas'        => $row['kelas'] ?? null,
            'jumlah_mhs'   => $row['mhs'] ?? null,
            'hari'         => $row['hari'] ?? null,
            'waktu'        => trim($row['waktu']) ?? null,
            'ruang'        => $row['ruang'] ?? null,
            'kelompok'     => $row['kelompok'] ?? null,
            'fakultas'     => $fakultas,
            'prodi'        => $prodi,
            'tahun_ajaran' => $tahunAjaran,
            'semester'     => $semester,
        ]);
    }
}
