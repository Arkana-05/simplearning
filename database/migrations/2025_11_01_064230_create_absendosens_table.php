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
        Schema::create('absendosens', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->text('desc')->nullable();
            $table->enum('status', ['Hadir', 'Tidak Hadir'])->default('Tidak Hadir');
            $table->bigInteger('jadwal_id')->unsigned();
            $table->foreign('jadwal_id')->references('id')->on('jadwals')->onDelete('cascade');
            $table->bigInteger('pertemuan_id')->unsigned();
            $table->foreign('pertemuan_id')->references('id')->on('pertemuans')->onDelete('cascade');
            $table->bigInteger('dosen_id')->unsigned()->nullable();
            $table->foreign('dosen_id')->references('id')->on('dosen')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absendosens');
    }
};
