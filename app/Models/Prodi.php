<?php

namespace App\Models;

use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prodi extends Model
{
    use HasFactory;
    protected $table = 'prodi';
    protected $guarded = [];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'prodi_id');
    }

    public function mhs()
    {
        return $this->hasMany(Mahasiswa::class, 'prodi_id');
    }
}
