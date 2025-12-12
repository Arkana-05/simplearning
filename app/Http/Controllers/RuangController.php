<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use Illuminate\Http\Request;

class RuangController extends Controller
{
    public function index()
    {
        $data = Ruang::latest()->get();
        return view('backend.admin.ruang.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin.ruang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages=[
            'nama.required' => 'Nama Ruang Kelas Harus Diisi',
            'nama.unique' => 'Nama Ruang Kelas Harus Unique',
        ];

        $request->validate([
            'nama' => 'required|unique:ruangs'
        ], $messages
        );

        Ruang::create($request->all());
        return redirect('/backend/ruang')->with('success', 'Data Successfully Added!');
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
        $data = Ruang::find($id);
        return view('backend.admin.ruang.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Ruang::find($id);
        $messages=[
            'nama.required' => 'Nama Ruang Kelas Harus Diisi',
        ];

        $request->validate([
            'nama' => 'required'
        ], $messages
        );
        $data->update($request->all());
        return redirect('/backend/ruang')->with('success', 'Data Berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dosen = Ruang::findOrFail($id);
        $dosen->delete();
        return redirect('/backend/ruang')->with('success', 'Data Successfully Deleted!');
    }
}
