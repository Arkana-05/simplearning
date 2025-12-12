<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Absen;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Ruang;
use App\Models\Tugas;
use App\Models\Matkul;
use App\Models\Pertemuan;
use App\Models\Absendosen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jadwal extends Model
{
    use HasFactory;
    protected $table = 'jadwals';
    protected $guarded = [];

    public function matkul()
    {
        return $this->belongsTo(Matkul::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function ruang()
    {
        return $this->belongsTo(Ruang::class);
    }

    public function pertemuan()
    {
        return $this->hasMany(Pertemuan::class, 'jadwal_id');
    }

    public function absendosen()
    {
        return $this->hasMany(Absendosen::class, 'jadwal_id');
    }

    public function absenmh()
    {   
        return $this->hasMany(Absen::class, 'jadwal_id');
    }
    
    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'jadwal_id');
    }

}
