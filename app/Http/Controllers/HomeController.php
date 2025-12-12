<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $dosenId = Auth::user()->dosen->id;
        $jadwal = \App\Models\Jadwal::with(['matkul', 'kelas.mhs', 'pertemuan'])
                ->where('dosen_id', $dosenId)
                ->get()
                ->map(function ($j) {

        $totalPertemuan = 14;
        $poin = 0;

        foreach ($j->pertemuan as $p) {
            if ($p->status == 'Selesai') {
                $poin += 1;
            } elseif ($p->status == 'Mulai') {
                $poin += 0.5;
            } else {
                $poin += 0; // Belum Mulai
            }
        }

        $progress = $totalPertemuan > 0 ? ($poin / $totalPertemuan) * 100 : 0;

        // status warna
        if ($progress == 100) {
            $status = ['COMPLETED', '#33c363'];
        } elseif ($progress == 0) {
            $status = ['NOT STARTED', '#e9a834'];
        } else {
            $status = ['IN PROGRESS', '#3e7bfa'];
        }


        // masukkan data tambahan ke object jadwal
        $j->progress = $progress;
        $j->progress_text = number_format($progress, 0);
        $j->status_info = $status;
        $j->mahasiswaList = $j->kelas->mhs ?? collect();
        $j->limitShow = 3;

        return $j;
    });

    return view('backend.dosen.mhs.index', compact('jadwal'));
    }
}
