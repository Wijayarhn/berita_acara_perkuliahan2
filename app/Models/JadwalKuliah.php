<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalKuliah extends Model
{
    protected $table = 'jadwal_kuliah';
    protected $fillable = [
        'kode_mk',
        'nama_mk',
        'sks',
        'nama_dosen',
        'kelas',
        'jumlah_mhs',
        'hari',
        'waktu',
        'ruang',
        'kelompok',
        'fakultas',
        'prodi',
        'tahun_ajaran',
        'semester',
    ];

    public function baps()
    {
        return $this->hasMany(Bap::class, 'jadwal_kuliah_id');
    }

    public function mahasiswa()
    {
        return Mahasiswa::where('kelas', $this->kelas)->get();
    }
}