<?php

namespace App\Models;

use App\Models\Kelas;
use App\Models\Jadwal;
use App\Models\Pertemuan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tugas extends Model
{
    use HasFactory;
    protected $table = 'tugas';
    protected $guarded = [];

    public function pertemuan()
    {
        return $this->belongsTo(Pertemuan::class);
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }
    public function submit()
    {
        return $this->hasMany(Submit::class);
    }
}
