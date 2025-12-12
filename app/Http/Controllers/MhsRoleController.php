<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absen;
use App\Models\Tugas;
use App\Models\Jadwal;
use App\Models\Mahasiswa;
use App\Models\Pertemuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MhsRoleController extends Controller
{
    private function isNowInJadwal($jadwal)
    {
        // Ambil waktu saat ini
        $now = \Carbon\Carbon::now();

        // Cocokkan hari (jadwal->hari dalam bahasa Indonesia)
        $hariSekarang = strtolower($now->locale('id')->dayName);
        $hariJadwal = strtolower($jadwal->hari);

        if ($hariSekarang !== $hariJadwal) {
            return false;
        }

        // Cocokkan jam masuk & keluar
        $jamSekarang = $now->format('H:i');

        return $jamSekarang >= $jadwal->jam_s && $jamSekarang <= $jadwal->jam_e;
    }


    public function jadwal()
    {
        $mhs = Auth::user()->mhs;
        $kelas = $mhs->kelas;
        $jadwal = Jadwal::where('kelas_id', $kelas->id)->get();

        $hariSekarang = strtolower(Carbon::now()->locale('id')->isoFormat('dddd'));

        return view('backend.mhs.jadwal.index', compact('jadwal', 'hariSekarang'));
    }

    
    public function detail_jadwal(String $id)
    {
        $mhsId = auth()->user()->mhs->id;

        $data = Jadwal::with(['matkul', 'dosen', 'ruang'])->findOrFail($id);

        $activePertemuan = $data->pertemuan
            ->sortBy('tanggal_mulai')
            ->first(fn($p) => $p->status !== 'Selesai');

        if (!$activePertemuan) {
            return view('backend.mhs.jadwal.detail', [
                'data' => $data,
                'activePertemuan' => null,
                'bolehMulai' => false
            ]);
        }
        // Ambil hanya pertemuan yang sudah diabsen oleh mahasiswa ini
        $absenMhs = Absen::with('pertemuan')
            ->where('mhs_id', $mhsId)
            ->where('jadwal_id', $id)
            ->get();

        return view('backend.mhs.jadwal.detail', compact('data', 'absenMhs', 'activePertemuan'));
    }

    public function update_status(Request $request, String $id)
    {
        $data = Absen::create([
            'status' => $request->status,
            'pertemuan_id' => $request->pertemuan_id,
            'mhs_id' => $request->mhs_id,
            'jadwal_id' => $request->jadwal_id,
        ]);
        // dd($request->all());
        return redirect()->back()->with('success', 'Successfully!');
    }

    public function tugas_sub(Request $request, String $id)
    {
        $data = Jadwal::with(['tugas.submit'])->findOrFail($id);
        return view('backend.mhs.jadwal.tugas-sub', compact('data'));
    }
}
