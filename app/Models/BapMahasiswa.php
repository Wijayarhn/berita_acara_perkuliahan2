<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BapMahasiswa extends Model
{
    protected $table = 'bap_mahasiswa';
    protected $fillable = ['bap_id', 'mahasiswa_id', 'hadir', 'keterangan', 'lokasi_mahasiswa', 'ttd_mahasiswa'];

    public function bap()
    {
        return $this->belongsTo(Bap::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }
}