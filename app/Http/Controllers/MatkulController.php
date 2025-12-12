<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Matkul;
use Illuminate\Http\Request;

class MatkulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Matkul::latest()->get();
        return view('backend.admin.matkul.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prodi = Prodi::all();
        return view('backend.admin.matkul.create', compact('prodi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages=[
            'nama.required' => 'Nama Matkul Harus Diisi',
            'nama.unique' => 'Nama Matkul Harus Unique',
            'kode.required' => 'Kode Matkul Harus Diisi',
            'kode.unique' => 'Kode Matkul Harus Unique',
            'prodi_id.required' => 'Nama Prodi Harus Diisi',
            'sks.required' => 'SKS Matkul Harus Diisi',
        ];

        $request->validate([
            'kode' => 'required|unique:matkul',
            'nama' => 'required|unique:matkul',
            'prodi_id' => 'required',
            'sks' => 'required'
        ], $messages
        );

        Matkul::create($request->all());
        return redirect('/backend/matkul')->with('success', 'Data Successfully Added!');
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
        $prodi = Prodi::all();
        $data = Matkul::find($id);
        return view('backend.admin.matkul.edit', compact('data', 'prodi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Matkul::find($id);
        $messages=[
            'nama.required' => 'Nama Matkul Harus Diisi',
            'kode.required' => 'Kode Matkul Harus Diisi',
            'prodi_id.required' => 'Nama Prodi Harus Diisi',
            'sks.required' => 'SKS Matkul Harus Diisi',
        ];

        $request->validate([
            'kode' => 'required',
            'nama' => 'required',
            'prodi_id' => 'required',
            'sks' => 'required'
        ], $messages
        );
        $data->update($request->all());
        return redirect('/backend/matkul')->with('success', 'Data Berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Matkul::findOrFail($id);
        $data->delete();
        return redirect('/backend/matkul')->with('success', 'Data Successfully Deleted!');
    }
}
