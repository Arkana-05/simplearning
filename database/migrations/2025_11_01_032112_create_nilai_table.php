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
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->string('project')->nullable();
            $table->string('kehadiran')->nullable();
            $table->string('tugas')->nullable();
            $table->string('uas')->nullable();
            $table->string('uts')->nullable();
            $table->string('total')->nullable();
            $table->bigInteger('matkul_id')->unsigned();
            $table->foreign('matkul_id')->references('id')->on('matkul')->onDelete('cascade');
            $table->bigInteger('mhs_id')->unsigned();
            $table->foreign('mhs_id')->references('id')->on('mahasiswa')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
