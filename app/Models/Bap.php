<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bap extends Model
{
    protected $table = 'bap';
    protected $fillable = [
        'jadwal_kuliah_id',
        'tanggal',
        'dosen_id',
        'pertemuan_ke',
        'jumlah_hadir',
        'jumlah_tidak_hadir',
        'materi',
        'pokok_bahasan',
        'deskripsi_tugas',
        'lokasi_dosen',
        'foto_pembelajaran',
        'status_verifikasi',
        'verifikasi_admin_id',
        'catatan_verifikasi'
    ];

    public function jadwalKuliah()
    {
        return $this->belongsTo(JadwalKuliah::class, 'jadwal_kuliah_id');
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function bapMahasiswa()
    {
        return $this->hasMany(BapMahasiswa::class);
    }

    public function verifikasiAdmin()
    {
        return $this->belongsTo(Admin::class, 'verifikasi_admin_id');
    }
    public function jadwal()
    {
        return $this->belongsTo(\App\Models\JadwalKuliah::class, 'jadwal_kuliah_id');
    }


    public function mahasiswa()
    {
        return $this->belongsToMany(Mahasiswa::class, 'bap_mahasiswa', 'bap_id', 'mahasiswa_id');
    }
}
