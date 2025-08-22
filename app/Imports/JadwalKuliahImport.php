<?php

namespace App\Imports;

use App\Models\JadwalKuliah;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JadwalKuliahImport implements ToModel, WithHeadingRow
{
    public function headingRow(): int
    {
        return 5; // baris ke-4 berisi kolom: KODE MK, MATA KULIAH, ...
    }

    public function model(array $row)
    {
        // Pisahkan fakultas dan prodi dari kolom 'prodi'
        $fakultas = null;
        $prodi = null;

        if (isset($row['prodi'])) {
            $parts = explode('/', $row['prodi']);
            $fakultas = $parts[0] ?? null;
            $prodi = $parts[1] ?? null;
        }

        return new JadwalKuliah([
            'kode_mk'          => $row['kode_mk'] ?? null,
            'nama_mk'          => $row['mata_kuliah'] ?? null,
            'sks'              => $row['sks'] ?? null,
            'nama_dosen'       => $row['dosen'] ?? null,
            'kelas'            => $row['kelas'] ?? null,
            'jumlah_mhs'       => $row['mhs'] ?? null,
            'hari'             => $row['hari'] ?? null,
            'waktu'            => trim($row['waktu']) ?? null,
            'ruang'            => $row['ruang'] ?? null,
            'kelompok'         => $row['kelompok'] ?? null,
            'fakultas'         => $fakultas,
            'prodi'            => $prodi,
            'tahun_ajaran'     => '2024/2025',
            'semester'         => 'Genap',
        ]);
    }
}
