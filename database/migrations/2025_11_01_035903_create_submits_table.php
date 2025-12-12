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
        Schema::create('submits', function (Blueprint $table) {
            $table->id();
            $table->string('file')->nullable();
            $table->string('link')->nullable();
            $table->string('nilai')->default(0);
            $table->enum('status', ['Telat', 'Slesai'])->nullable();
            $table->bigInteger('tugas_id')->unsigned()->nullable();
            $table->foreign('tugas_id')->references('id')->on('tugas')->onDelete('cascade');
            $table->bigInteger('mhs_id')->unsigned()->nullable();
            $table->foreign('mhs_id')->references('id')->on('mahasiswa')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submits');
    }
};
