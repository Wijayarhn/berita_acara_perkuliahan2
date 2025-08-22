<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Authenticatable
{
    protected $table = 'dosen';
    protected $fillable = ['username', 'password', 'nama', 'nidn'];

    public function bap()
    {
        return $this->hasMany(Bap::class, 'dosen_id');
    }

    public function jadwals()
    {
        return $this->hasMany(JadwalKuliah::class, 'dosen_id');
    }

    // Relasi ke BAP
    public function baps()
    {
        return $this->hasMany(Bap::class, 'dosen_id');
    }
}