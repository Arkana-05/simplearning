<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    
    
    public function index()
    {
        $data = Prodi::latest()->get();
        return view('backend.admin.prodi.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin.prodi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages=[
            'nama.required' => 'Nama Prodi Harus Diisi',
            'nama.unique' => 'Nama Prodi Harus Unique',
        ];

        $request->validate([
            'nama' => 'required|unique:prodi'
        ], $messages
        );

        Prodi::create($request->all());
        return redirect('/backend/prodi')->with('success', 'Data Successfully Added!');
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
        $data = Prodi::find($id);
        return view('backend.admin.prodi.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Prodi::find($id);
        $messages=[
            'nama.required' => 'Nama Prodi Harus Diisi',
        ];

        $request->validate([
            'nama' => 'required'
        ], $messages
        );
        $data->update($request->all());
        return redirect('/backend/prodi')->with('success', 'Data Berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dosen = Prodi::findOrFail($id);
        $dosen->delete();
        return redirect('/backend/prodi')->with('success', 'Data Successfully Deleted!');
    }
}
