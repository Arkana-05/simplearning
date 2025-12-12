<?php

namespace App\Models;

use App\Models\Kelas;
use App\Models\Matkul;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Materi extends Model
{
    use HasFactory;
    protected $table = 'materi';
    protected $guarded = [];

    public function matkul()
    {
        return $this->belongsTo(Matkul::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
}
