<?php

namespace App\Models;

use App\Models\Jadwal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ruang extends Model
{
    use HasFactory;
    protected $table = 'ruangs';
    protected $guarded = [];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'ruang_id');
    }
}
