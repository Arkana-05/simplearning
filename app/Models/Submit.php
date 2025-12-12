<?php

namespace App\Models;

use App\Models\Tugas;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Submit extends Model
{
    use HasFactory;
    protected $table = 'submits';
    protected $guarded = [];

    public function mhs()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }
}
