<?php

namespace App\Models;

use App\Models\Absen;
use App\Models\Tugas;
use App\Models\Jadwal;
use App\Models\Absendosen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pertemuan extends Model
{
    use HasFactory;
    protected $table = 'pertemuans';
    protected $guarded = [];

     public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function absen()
    {
        return $this->hasOne(Absendosen::class, 'pertemuan_id');
    }
    
    public function absenmh()
    {
        return $this->hasMany(Absen::class, 'pertemuan_id');
    }
    
    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'pertemuan_id');
    }
}
