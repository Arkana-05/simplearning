<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Matkul;
use App\Models\Submit;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class NilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Nilai::latest()->get();
        return view('backend.admin.nilai.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $matkul = Matkul::all();
        $mhs = Mahasiswa::all();
        return view('backend.admin.nilai.create', compact('matkul', 'mhs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'kehadiran.required' => 'Nilai Kehadiran Harus Diisi',
            'tugas.required' => 'Nilai Tugas Harus Diisi',
            'matkul_id.required' => 'Mata Kuliah Harus Diisi',
            'mhs_id.required' => 'Nama Mahasiswa Harus Diisi',
            'mhs_id.unique' => 'Mahasiswa ini sudah memiliki nilai untuk mata kuliah ini',
        ];

        $request->validate([
            'kehadiran' => 'required',
            'tugas' => 'required',
            'matkul_id' => 'required',
            'mhs_id' => [
                'required',
                Rule::unique('nilai')->where(fn($query) => $query->where('matkul_id', $request->matkul_id)),
            ],
        ], $messages);

        Nilai::create($request->all());
        return redirect('/backend/nilai')->with('success', 'Data Successfully Added!');
    }

    /**
     * Display the specified resource.
     */
    
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
        $matkul = Matkul::all();
        $mhs = Mahasiswa::all();
        $data = Nilai::find($id);
        return view('backend.admin.nilai.edit', compact('data', 'matkul', 'mhs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Nilai::find($id);
        $messages = [
            'kehadiran.required' => 'Nilai Kehadiran Harus Diisi',
            'tugas.required' => 'Nilai Tugas Harus Diisi',
            'matkul_id.required' => 'Mata Kuliah Harus Diisi',
            'mhs_id.required' => 'Nama Mahasiswa Harus Diisi',
            'mhs_id.unique' => 'Mahasiswa ini sudah memiliki nilai untuk mata kuliah ini',
        ];

        $request->validate([
            'kehadiran' => 'required',
            'tugas' => 'required',
            'matkul_id' => 'required',
            'mhs_id' => 'required',
        ], $messages);

        $data->update($request->all());
        return redirect('/backend/nilai')->with('success', 'Data Berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Nilai::findOrFail($id);
        $data->delete();
        return redirect('/backend/nilai')->with('success', 'Data Successfully Deleted!');
    }
}
