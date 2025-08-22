<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mahasiswa extends Authenticatable
{
    protected $table = 'mahasiswa';
    protected $fillable = ['username', 'password', 'nama', 'nim', 'kelas'];

    public function bapMahasiswa()
    {
        return $this->hasMany(BapMahasiswa::class, 'mahasiswa_id');
    }

    // app/Models/Mahasiswa.php
    public function baps()
    {
        return $this->belongsToMany(Bap::class, 'bap_mahasiswa', 'mahasiswa_id', 'bap_id')
            ->withPivot('ttd_mahasiswa') // jika kamu simpan tanda tangan di pivot
            ->withTimestamps();
    }
}
