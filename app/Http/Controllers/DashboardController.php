<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absen;
use App\Models\Dosen;
use App\Models\Jadwal;
use App\Models\Matkul;
use App\Models\Mahasiswa;
use App\Models\Pertemuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $day = Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('dddd');

        if (Auth::user()->level == 'admin') {
            $dosen = Dosen::count();
            $mhs = Mahasiswa::count();
            $matkul = Matkul::count();
            $jadwal = Jadwal::count();

            $jadwal_terbaru = Jadwal::latest()->take(5)->get();
            $dosen_baru = Dosen::latest()->take(5)->get();

            $day = $day;
            $jadwal_hari_ini = Jadwal::where('hari', 'LIKE', $day)->get();
            return view('backend.dash', compact('dosen', 'mhs', 'matkul','jadwal', 'jadwal_terbaru', 'jadwal_hari_ini', 'day', 'dosen_baru'));
        }

        if (Auth::user()->level == 'dosen') {
            $dosenId = Auth::user()->dosen->id;

            $day = Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('dddd');

            // Card data
            $total_jadwal = Jadwal::where('dosen_id', $dosenId)->count();
            $total_matkul = Jadwal::where('dosen_id', $dosenId)->distinct('matkul_id')->count('matkul_id');
            $total_kelas = Jadwal::where('dosen_id', $dosenId)->distinct('kelas_id')->count('kelas_id');

            // Jadwal hari ini
            $jadwal_hari_ini = Jadwal::where('dosen_id', $dosenId)
                ->where('hari', $day)->get();

            // Jadwal terdekat
            $jadwal_terdekat = Jadwal::where('dosen_id', $dosenId)
                ->orderBy('hari')
                ->take(5)
                ->get();

            // Semua jadwal
            $jadwal_dosen = Jadwal::where('dosen_id', $dosenId)->get();

            return view('backend.dash', compact(
                'total_jadwal',
                'total_matkul',
                'total_kelas',
                'jadwal_hari_ini',
                'jadwal_terdekat',
                'jadwal_dosen'
            ));
        }


        $mhs = Auth::user()->mhs;
        $mhsId = $mhs->id;

        $day = Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('dddd');

        return view('backend.dash', [
            'total_matkul' => Jadwal::where('kelas_id', $mhs->kelas_id)->count(),
            'kehadiran' => Absen::where('mhs_id', $mhsId)->where('status', 'Hadir')->count(),
            'jadwal_hari_ini' => Jadwal::where('kelas_id', $mhs->kelas_id)->where('hari', $day)->get(),
            'jadwal_mhs' => Jadwal::where('kelas_id', $mhs->kelas_id)->get(),
        ]);
    }

    private function countByYear($model)
    {
        $result = [];
        foreach (range(date('Y') - 4, date('Y')) as $y) {
            $result[] = $model::whereYear('created_at', $y)->count();
        }
        return $result;
    }

}
