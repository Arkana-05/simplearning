<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Ruang;
use App\Models\Jadwal;
use App\Models\Matkul;
use App\Models\Pertemuan;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Jadwal::latest()->get();
        return view('backend.admin.jadwal.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::all();
        $matkul = Matkul::all();
        $ruang = Ruang::all();
        $dosen = Dosen::all();
        return view('backend.admin.jadwal.create', compact('kelas', 'matkul', 'dosen', 'ruang'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages=[
            'hari.required' => 'Jadwal Hari Harus Diisi',
            'kelas_id.required' => 'Nama Kelas Harus Diisi',
            'matkul_id.required' => 'Mata Kuliah Harus Diisi',
            'ruang_id.required' => 'Ruang Kelas Harus Diisi',
            'dosen_id.required' => 'Dosen Pengampu Harus Diisi',
            'jam_s.required' => 'Jam Mulai kelas Harus Diisi',
            'jam_e.required' => 'Jam Slesai kelas Harus Diisi',
            'tanggal_mulai.required' => 'Tanggal Mulai Harus Diisi',
        ];

        $request->validate([
            'hari' => 'required',
            'jam_s' => 'required',
            'jam_e' => 'required',
            'kelas_id' => 'required',
            'ruang_id' => 'required',
            'matkul_id' => 'required',
            'dosen_id' => 'required',
            'tanggal_mulai' => 'required|date',
        ], $messages
        );

        $jadwal = Jadwal::create($request->all());

        $tanggal = Carbon::parse($request->tanggal_mulai)->startOfDay();

        for ($i = 1; $i <= 15; $i++) {

            Pertemuan::create([
                'jadwal_id' => $jadwal->id,
                'nama' => $i,
                'tanggal_mulai' => $tanggal->toDateString(),
                'status' => 'Belum Mulai',
            ]);

            $tanggal->addDays(7);
        }
        return redirect('/backend/jadwal')->with('success', 'Data Successfully Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kelas = Kelas::all();
        $matkul = Matkul::all();
        $dosen = Dosen::all();
        $ruang = Ruang::all();
        $data = Jadwal::find($id);
        return view('backend.admin.jadwal.edit', compact('data', 'kelas', 'matkul', 'dosen', 'ruang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Jadwal::find($id);
        $messages=[
            'hari.required' => 'Jadwal Hari Harus Diisi',
            'kelas_id.required' => 'Nama Kelas Harus Diisi',
            'matkul_id.required' => 'Mata Kuliah Harus Diisi',
            'ruang_id.required' => 'Ruang Kelas Harus Diisi',
            'dosen_id.required' => 'Dosen Pengampu Harus Diisi',
            'jam_s.required' => 'Jam Mulai kelas Harus Diisi',
            'jam_e.required' => 'Jam Slesai kelas Harus Diisi',
            'tanggal_mulai.required' => 'Tanggal Mulai Harus Diisi',
        ];

        $request->validate([
            'hari' => 'required',
            'jam_s' => 'required',
            'jam_e' => 'required',
            'kelas_id' => 'required',
            'ruang_id' => 'required',
            'matkul_id' => 'required',
            'dosen_id' => 'required',
            'tanggal_mulai' => 'required|date',
        ], $messages
        );

        $tanggalMulaiBerubah = $data->tanggal_mulai != $request->tanggal_mulai;
        $data->update($request->all());

        if ($tanggalMulaiBerubah) {

            $tanggal = Carbon::parse($request->tanggal_mulai)->startOfDay();

            $pertemuans = Pertemuan::where('jadwal_id', $data->id)
            ->orderByRaw('CAST(nama AS UNSIGNED)')
            ->get();

            foreach ($pertemuans as $pt) {

                $pt->update([
                    'tanggal_mulai' => $tanggal->format('Y-m-d'),
                ]);

                $tanggal->addDays(7);
            }
        }
        return redirect('/backend/jadwal')->with('success', 'Data Berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Jadwal::findOrFail($id);
        $data->delete();
        return redirect('/backend/jadwal')->with('success', 'Data Successfully Deleted!');
    }
}
