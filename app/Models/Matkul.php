<?php

namespace App\Models;

use App\Models\Prodi;
use App\Models\Jadwal;
use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matkul extends Model
{
    use HasFactory;
    protected $table = 'matkul';
    protected $guarded = [];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function materi()
    {
        return $this->hasMany(Materi::class, 'matkul_id');
    }
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'matkul_id');
    }

}
