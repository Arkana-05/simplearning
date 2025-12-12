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
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('desc');
            $table->string('file');
            $table->dateTime('mulai');
            $table->dateTime('deadline');
            $table->bigInteger('jadwal_id')->unsigned()->nullable();
            $table->foreign('jadwal_id')->references('id')->on('jadwals')->onDelete('cascade');
            $table->bigInteger('pertemuan_id')->unsigned()->nullable();
            $table->foreign('pertemuan_id')->references('id')->on('pertemuans')->onDelete('cascade');
            $table->bigInteger('kelas_id')->unsigned()->nullable();
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
