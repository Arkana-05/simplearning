<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Prodi;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Kelas::latest()->get();
        return view('backend.admin.kelas.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prodi = Prodi::all();
        return view('backend.admin.kelas.create', compact('prodi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages=[
            'nama.required' => 'Nama Kelas Harus Diisi',
            'nama.unique' => 'Nama Kelas Harus Unique',
            'prodi_id.required' => 'Nama Prodi Harus Diisi',
        ];

        $request->validate([
            'nama' => 'required|unique:kelas',
            'prodi_id' => 'required'
        ], $messages
        );

        Kelas::create($request->all());
        return redirect('/backend/kelas')->with('success', 'Data Successfully Added!');
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
        $data = Kelas::find($id);
        return view('backend.admin.kelas.edit', compact('data', 'prodi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Kelas::find($id);
        $messages=[
            'nama.required' => 'Nama Kelas Harus Diisi',
            'prodi_id.required' => 'Nama Prodi Harus Diisi',
        ];

        $request->validate([
            'nama' => 'required',
            'prodi_id' => 'required'
        ], $messages
        );
        $data->update($request->all());
        return redirect('/backend/kelas')->with('success', 'Data Berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Kelas::findOrFail($id);
        $data->delete();
        return redirect('/backend/kelas')->with('success', 'Data Successfully Deleted!');
    }
}
