<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeritaAcaraTtdMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berita_acara_ttd_mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('berita_acara_id')->constrained('berita_acara')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            $table->enum('peran', ['ttd1', 'ttd2']);
            $table->string('lokasi_mahasiswa'); // lokasi ttd wajib
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('berita_acara_ttd_mahasiswa');
    }
}
