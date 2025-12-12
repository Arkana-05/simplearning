<?php

namespace App\Models;

use App\Models\User;
use App\Models\Absen;
use App\Models\Kelas;
use App\Models\Prodi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'mahasiswa';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function absenmh()
    {
        return $this->hasMany(Absen::class, 'mhs_id');
    }

    public function submit()
    {
        return $this->hasMany(Submit::class, 'mhs_id');
    }
}
