<?php

namespace App\Models;

use App\Models\Prodi;
use App\Models\Materi;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $guarded = [];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function mhs()
    {
        return $this->hasMany(Mahasiswa::class, 'kelas_id');
    }

    public function materi()
    {
        return $this->hasMany(Materi::class, 'kelas_id');
    }
}
