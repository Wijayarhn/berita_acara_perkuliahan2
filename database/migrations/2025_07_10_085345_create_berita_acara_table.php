<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeritaAcaraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berita_acara', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_kuliah_id')->constrained('jadwal_kuliah')->onDelete('cascade');

            $table->date('tanggal_perkuliahan');
            $table->integer('jumlah_mahasiswa');
            $table->integer('jumlah_hadir');
            $table->integer('jumlah_tidak_hadir');
            $table->text('materi');
            $table->text('pokok_bahasan');
            $table->text('deskripsi_tugas')->nullable();
            $table->string('ttd_dosen')->nullable(); // upload foto opsional
            $table->string('lokasi_dosen'); // wajib
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // dosen
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
        Schema::dropIfExists('berita_acara');
    }
}
