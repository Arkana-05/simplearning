<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absen;
use App\Models\Kelas;
use App\Models\Jadwal;
use App\Models\Materi;
use App\Models\Matkul;
use App\Models\Mahasiswa;
use App\Models\Pertemuan;
use App\Models\Absendosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DosenRoleController extends Controller
{
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

    return view('backend.dosen.ajar.index', compact('jadwal'));
    }

    public function detail(String $id)
    {
        $data = Matkul::findOrFail($id);
        return view('backend.dosen.ajar.detail', compact('data'));
    }

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
        $jadwal = Jadwal::where('dosen_id', Auth::user()->dosen->id)->get();
        // foreach ($jadwal as $j) {
        //     $j->canAccess = $this->isNowInJadwal($j); 
        // }
        $hariSekarang = strtolower(Carbon::now()->locale('id')->isoFormat('dddd'));
        // $hariJadwal = strtolower($jadwal->hari);
        
        return view('backend.dosen.jadwal.index', compact('jadwal', 'hariSekarang'));
    }

    
    public function detail_jadwal(String $id)
    {
        $dsId = auth()->user()->dosen->id ?? null;

        $data = Jadwal::with(['pertemuan', 'absendosen' => fn($q) => $q->where('dosen_id', $dsId), 'matkul', 'kelas.mhs', 'ruang'
                        ])->findOrFail($id);

        $activePertemuan = $data->pertemuan
            ->sortBy('tanggal_mulai')
            ->first(fn($p) => $p->status !== 'Selesai');

        if (!$activePertemuan) {
            return view('backend.dosen.jadwal.detail', [
                'data' => $data,
                'activePertemuan' => null,
                'bolehMulai' => false
            ]);
        }

        $now = Carbon::now('Asia/Jakarta');
        $waktuSelesai = Carbon::parse($activePertemuan->tanggal_mulai . ' ' . $data->jam_e);

        $absenDosen = Absendosen::where('dosen_id', $dsId)
            ->where('jadwal_id', $data->id)
            ->where('pertemuan_id', $activePertemuan->id)
            ->first();

        if ($now->greaterThan($waktuSelesai) && !$absenDosen) {

            Absendosen::create([
                'file' => '',
                'dosen_id' => $dsId,
                'jadwal_id' => $data->id,
                'pertemuan_id' => $activePertemuan->id,
                'status' => 'Tidak Hadir',
            ]);
            
            foreach ($data->kelas->mhs as $mhs) {
                $sudahAbsen = Absen::where('jadwal_id', $data->id)
                    ->where('pertemuan_id', $activePertemuan->id)
                    ->where('mhs_id', $mhs->id)
                    ->exists();

                if (!$sudahAbsen) {
                    Absen::create([
                        'status' => 'Tidak Hadir',
                        'jadwal_id' => $data->id,
                        'pertemuan_id' => $activePertemuan->id,
                        'mhs_id' => $mhs->id,
                    ]);
                }
            }
        }

        if ($now->greaterThan($waktuSelesai) && $activePertemuan->status !== 'Selesai') {

            $activePertemuan->update([
                'status' => 'Selesai'
            ]);
        }

        $today = Carbon::today('Asia/Jakarta')->toDateString();
        $pertemuanDate = Carbon::parse($activePertemuan->tanggal_mulai)->toDateString();

        $bolehMulai = ($pertemuanDate === $today);
        $jadwalSudahSelesai = $now->greaterThan($waktuSelesai);

        return view('backend.dosen.jadwal.detail', compact('data', 'activePertemuan', 'bolehMulai', 'jadwalSudahSelesai'));
    }

    public function absen_ds($jadwal_id, $pertemuan_id)
    {
        $data = Jadwal::with(['pertemuan.absen.dosen', 'pertemuan.absenmh.mhs', 'matkul', 'kelas.mhs', 'ruang'])
            ->findOrFail($jadwal_id);

        $pertemuanDenganAbsen = $data->pertemuan->filter(fn($p) => $p->absen !== null);
        $pertemuanBelumMulai = $data->pertemuan->where('status','Belum Mulai')->first();
        $activePertemuan = $data->pertemuan->find($pertemuan_id);

        $totalMhs = $data->kelas->mhs->count();
        $hadir = $activePertemuan?->absenmh?->where('status', 'Hadir')->count() ?? 0;
        $alfa = $activePertemuan?->absenmh?->where('status', 'Tidak Hadir')->count() ?? 0;
        $belumAbsen = $totalMhs - ($hadir + $alfa);
        // dd($activePertemuan);
        return view('backend.dosen.jadwal.absen', compact('data', 'pertemuanDenganAbsen', 'pertemuanBelumMulai', 'activePertemuan', 'hadir', 'alfa', 'totalMhs', 'belumAbsen'));
    }


    public function submit_absends(Request $request)
    {
        // dd($request->all());
        $messages=[
            'pertemuan_id.required' => 'Kolom Pertemuan harus diisi',
            'file.required' => 'File bukti pertemuan harus diisi',
            'file.image' => 'Format gambar gunakan ekstensi jpeg, jpg atau png',
            'file.max' => 'Ukuran file gambar Maksimal adalah 2000 KB',
        ];

        $request->validate([
            'pertemuan_id' => 'required',
            'file' => 'required|image|mimes:jpeg,jpg,png|max:2000',
        ], $messages
        );
        
        $data = Absendosen::create([
            'file' => $request->file,
            'desc' => $request->desc,
            'status' => $request->status,
            'pertemuan_id' => $request->pertemuan_id,
            'dosen_id' => $request->dosen_id,
            'jadwal_id' => $request->jadwal_id,
        ]);
        
        if ($request->hasFile('file')) {
            $imageName = $request->file('file')->hashName();
            $request->file('file')->move('img/dosen/absenfile/', $imageName);
            $data->file = $imageName;
            $data->save();
        }

        // dd($request->all());
        return redirect()->back()->with('success', 'Data Successfully Added!');
    }

    public function update_status(Request $request, String $id)
    {
        $data = Pertemuan::find($id);
        $data->status = $request->status;
        $data->save();

        if ($request->status == 'Selesai') {

            $jadwal = Jadwal::find($request->jadwal_id);
            $mahasiswas = Mahasiswa::where('kelas_id', $jadwal->kelas_id)->get();

            foreach ($mahasiswas as $mhs) {

                $absen = Absen::where('pertemuan_id', $data->id)
                        ->where('mhs_id', $mhs->id)
                        ->first();

                if (!$absen) {
                    Absen::create([
                        'pertemuan_id' => $data->id,
                        'jadwal_id'    => $data->jadwal_id,
                        'mhs_id'       => $mhs->id,
                        'status'       => 'Tidak Hadir',
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Successfully!');
    }

    
    public function tugas(string $id)
    {
        $data = Jadwal::with(['pertemuan', 'matkul', 'tugas.submit.mhs'])->findOrFail($id);
        $mhs = Mahasiswa::where('user_id', auth()->id())->first();
        return view('backend.dosen.jadwal.tugas-detail', compact('data', 'mhs'));
    }

}
