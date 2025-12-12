<?php

namespace App\Models;

use App\Models\Matkul;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nilai extends Model
{
    use HasFactory;
    protected $table = 'nilai';
    protected $guarded = [];

    public function mhs()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function matkul()
    {
        return $this->belongsTo(Matkul::class);
    }
}
