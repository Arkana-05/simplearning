<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Materi;
use App\Models\Matkul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Materi::latest()->get();
        return view('backend.admin.materi.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $matkul = Matkul::all();
        $kelas = Kelas::all();
        return view('backend.admin.materi.create', compact('kelas', 'matkul'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages=[
            'matkul_id.required' => 'Kolom Pertemuan harus diisi',
            'judul.required' => 'Judul Materi harus diisi',
            'desc.required' => 'Deskripsi Materi harus diisi',
            'matkul_id.required' => 'Mata Kuliah harus diisi',
            'file.required' => 'File materi harus diisi',
            'file.mimes' => 'Format gambar gunakan ekstensi pdf, zip atau rar',
            'file.max' => 'Ukuran file gambar Maksimal adalah 5000 KB',
        ];

        $request->validate([
            'matkul_id' => 'required',
            'judul' => 'required',
            'desc' => 'required',
            'file' => 'required|mimes:pdf,zip,rar|max:5000',
        ], $messages
        );
        
        $data = Materi::create([
            'file' => $request->file,
            'desc' => $request->desc,
            'judul' => $request->judul,
            'matkul_id' => $request->matkul_id,
            'kelas_id' => $request->kelas_id,
        ]);


        if ($request->hasFile('file')) {
            $fileName = $request->file('file')->hashName();
            $request->file('file')->move('img/materi/', $fileName);

            $data->file = $fileName;
            $data->save();
        }


        return redirect('/backend/materi')->with('success', 'Data Successfully Added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Matkul::with(['materi', 'jadwal.pertemuan'])->findOrFail($id);
        return view('backend.dosen.jadwal.materi-detail', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $matkul = Matkul::all();
        $kelas = Kelas::all();
        $data = Materi::find($id);
        return view('backend.admin.materi.edit', compact('data', 'kelas', 'matkul'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Materi::find($id);
         $messages=[
            'matkul_id.required' => 'Kolom Pertemuan harus diisi',
            'judul.required' => 'Judul Materi harus diisi',
            'desc.required' => 'Deskripsi Materi harus diisi',
            'matkul_id.required' => 'Mata Kuliah harus diisi',
            'file.mimes' => 'Format gambar gunakan ekstensi pdf, zip atau rar',
            'file.max' => 'Ukuran file gambar Maksimal adalah 5000 KB',
        ];

        $request->validate([
            'matkul_id' => 'required',
            'judul' => 'required',
            'desc' => 'required',
            'file' => 'mimes:pdf,zip,rar|max:5000',
        ], $messages
        );

        if ($request->hasFile('file')) {
            File::delete('img/materi/' . $data->file);

            $fileName = $request->file('file')->hashName();
            $request->file('file')->move('img/materi/', $fileName);

            $data->file = $fileName;
        }


        $data->desc = $request->desc;
        $data->matkul_id = $request->matkul_id;
        $data->judul = $request->judul;
        $data->kelas_id = $request->kelas_id;
        $data->save();
        return redirect('/backend/materi')->with('success','Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Materi::findOrFail($id);
        $data->delete();
        return redirect('/backend/materi')->with('success', 'Data Successfully Deleted!');
    }
}
