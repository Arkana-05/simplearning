<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Dosen;
use App\Models\Pertemuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Absen::latest()->get();
        return view('backend.admin.absenmh.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pertemuan = Pertemuan::all();
        $dosen = Dosen::all();
        return view('backend.admin.absenmh.create', compact('dosen', 'pertemuan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages=[
            'pertemuan_id.required' => 'Kolom Pertemuan harus diisi',
        ];

        $request->validate([
            'pertemuan_id' => 'required',
        ], $messages
        );
        
        $data = Absen::create([
            'pertemuan_id' => $request->pertemuan_id,
            'mhs_id' => $request->mhs_id,
        ]);

        return redirect('/backend/absen')->with('success', 'Data Successfully Added!');
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
        $pertemuan = Pertemuan::all();
        $dosen = Dosen::all();
        $data = Absen::find($id);
        return view('backend.admin.absenmh.edit', compact('data', 'dosen', 'pertemuan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Absen::find($id);
         $messages=[
            'pertemuan_id.required' => 'Kolom Pertemuan harus diisi',
        ];

        $request->validate([
            'pertemuan_id' => 'required',
        ], $messages
        );
        $data->update($request->all());
        return redirect('/backend/absen')->with('success','Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Absen::findOrFail($id);
        $data->delete();
        return redirect('/backend/absen')->with('success', 'Data Successfully Deleted!');
    }
}
