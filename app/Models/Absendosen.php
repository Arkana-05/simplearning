<?php

namespace App\Models;

use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Pertemuan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Absendosen extends Model
{
    use HasFactory;
    protected $table = 'absendosens';
    protected $guarded = [];
    
    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
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
