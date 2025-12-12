<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_mulai');
            $table->string('hari');
            $table->string('jam_s');
            $table->string('jam_e');
            $table->integer('semester')->null();
            $table->bigInteger('ruang_id')->unsigned();
            $table->foreign('ruang_id')->references('id')->on('ruangs')->onDelete('cascade');
            $table->bigInteger('kelas_id')->unsigned();
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->bigInteger('matkul_id')->unsigned();
            $table->foreign('matkul_id')->references('id')->on('matkul')->onDelete('cascade');
            $table->bigInteger('dosen_id')->unsigned();
            $table->foreign('dosen_id')->references('id')->on('dosen')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
