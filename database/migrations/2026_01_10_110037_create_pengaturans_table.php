<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id('pengaturan_id');
            $table->string('nama_pesantren', 150);
            $table->string('logo', 200)->nullable();
            $table->text('alamat');
            $table->string('telepon', 15);
            $table->string('email', 100);
            $table->string('website', 100)->nullable();
            $table->string('no_rekening', 30)->nullable();
            $table->string('atas_nama', 100)->nullable();
            $table->string('nama_bank', 50)->nullable();
            $table->integer('jumlah_santri')->default(0);
            $table->integer('jumlah_guru')->default(0);
            $table->integer('jumlah_alumni')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
    }
};
