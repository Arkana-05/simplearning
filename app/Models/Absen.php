<?php

namespace App\Models;

use App\Models\Jadwal;
use App\Models\Mahasiswa;
use App\Models\Pertemuan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absen extends Model
{
    use HasFactory;
    protected $table = 'absenmahasiswa';
    protected $guarded = [];

    public function mhs()
    {
        return $this->belongsTo(Mahasiswa::class, 'mhs_id');
    }

    public function pertemuan()
    {
        return $this->belongsTo(Pertemuan::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }
}
