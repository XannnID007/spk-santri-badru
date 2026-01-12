<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil', function (Blueprint $table) {
            $table->id('profil_id');
            $table->unsignedBigInteger('pengguna_id');
            $table->foreign('pengguna_id')->references('pengguna_id')->on('pengguna')->onDelete('cascade');
            $table->string('nik', 16)->unique();
            $table->string('nama_lengkap', 100);
            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat_lengkap');
            $table->string('provinsi', 50);
            $table->string('kota', 50);
            $table->string('kecamatan', 50);
            $table->string('kelurahan', 50);
            $table->string('kode_pos', 5);
            $table->string('nama_ayah', 100);
            $table->string('nama_ibu', 100);
            $table->string('pekerjaan_ayah', 50);
            $table->string('pekerjaan_ibu', 50);
            $table->integer('penghasilan_ortu');
            $table->string('foto', 200)->nullable();
            $table->boolean('is_lengkap')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil');
    }
};
