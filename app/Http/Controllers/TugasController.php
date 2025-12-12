<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Tugas;
use App\Models\Jadwal;
use App\Models\Submit;
use App\Models\Pertemuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Tugas::latest()->get();
        return view('backend.admin.tugas.index', compact('data'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pertemuan = Pertemuan::all();
        $jadwal = Jadwal::all();
        return view('backend.admin.tugas.create', compact('jadwal', 'pertemuan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages=[
            'judul.required' => 'Judul Tugas harus diisi',
            'desc.required' => 'Deskripsi Tugas harus diisi',
            'jadwal_id.required' => 'Jadwal Kelas harus diisi',
            'pertemuan_id.required' => 'Pertemuan harus diisi',
            'deadline.required' => 'Deadline harus diisi',
            'mulai.required' => 'Mulai pengumpulan tugas harus diisi',
            'file.required' => 'File Tugas harus diisi',
            'file.mimes' => 'Format gunakan ekstensi pdf, docx atau xlsx',
            'file.max' => 'Ukuran file gambar Maksimal adalah 5000 KB',
        ];

        $request->validate([
            'jadwal_id' => 'required',
            'pertemuan_id' => 'required',
            'judul' => 'required',
            'desc' => 'required',
            'mulai' => 'required',
            'deadline' => 'required',
            'file' => 'required|mimes:pdf,xlsx,docx|max:5000',
        ], $messages
        );
        
        $data = Tugas::create([
            'file' => $request->file,
            'desc' => $request->desc,
            'judul' => $request->judul,
            'pertemuan_id' => $request->pertemuan_id,
            'jadwal_id' => $request->jadwal_id,
            'mulai' => $request->mulai,
            'deadline' => $request->deadline,
        ]);


        if ($request->hasFile('file')) {
            $fileName = $request->file('file')->hashName();
            $request->file('file')->move('img/tugas/', $fileName);

            $data->file = $fileName;
            $data->save();
        }


        return redirect('/backend/tugas')->with('success', 'Data Successfully Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Tugas::with([ 'pertemuan.jadwal.kelas.mhs', 'pertemuan.jadwal.matkul', 'submit.mhs'
        ])->findOrFail($id);

        $submit = $data->jadwal->kelas->mhs->count();
        $done = $data->submit->where('status', 'Slesai')->count() ?? 0;
        $late = $data->submit->where('status', 'Telat')->count() ?? 0;
        $blm = $submit - ($done + $late);

        return view('backend.admin.tugas.detail', compact('data', 'blm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pertemuan = Pertemuan::all();
        $jadwal = Jadwal::all();
        $data = Tugas::find($id);
        return view('backend.admin.tugas.edit', compact('data', 'jadwal', 'pertemuan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Tugas::find($id);

         $messages=[
            'judul.required' => 'Judul Tugas harus diisi',
            'desc.required' => 'Deskripsi Tugas harus diisi',
            'jadwal_id.required' => 'Kelas harus diisi',
            'pertemuan_id.required' => 'Pertemuan harus diisi',
            'deadline.required' => 'Deadline harus diisi',
            'mulai.required' => 'Mulai pengumpulan tugas harus diisi',
            'file.mimes' => 'Format gunakan ekstensi pdf, docx atau xlsx',
            'file.max' => 'Ukuran file gambar Maksimal adalah 5000 KB',
        ];

        $request->validate([
            'jadwal_id' => 'required',
            'pertemuan_id' => 'required',
            'judul' => 'required',
            'desc' => 'required',
            'mulai' => 'required',
            'deadline' => 'required',
            'file' => 'mimes:pdf,xlsx,docx|max:5000',
        ], $messages
        );

        if ($request->hasFile('file')) {
            File::delete('img/tugas/' . $data->file);

            $fileName = $request->file('file')->hashName();
            $request->file('file')->move('img/tugas/', $fileName);

            $data->file = $fileName;
        }


        $data->desc = $request->desc;
        $data->pertemuan_id = $request->pertemuan_id;
        $data->judul = $request->judul;
        $data->jadwal_id = $request->jadwal_id;
        $data->save();
        return redirect('/backend/tugas')->with('success','Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Tugas::findOrFail($id);
        $data->delete();
        return redirect('/backend/tugas')->with('success', 'Data Successfully Deleted!');
    }
}
