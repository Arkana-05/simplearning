<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Pertemuan;
use App\Models\Absendosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AbsendsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Absendosen::latest()->get();
        return view('backend.admin.absends.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pertemuan = Pertemuan::all();
        $dosen = Dosen::all();
        return view('backend.admin.absends.create', compact('dosen', 'pertemuan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages=[
            'pertemuan_id.required' => 'Kolom Pertemuan harus diisi',
            'file.image' => 'Format gambar gunakan ekstensi jpeg, jpg atau png',
            'file.max' => 'Ukuran file gambar Maksimal adalah 2000 KB',
        ];

        $request->validate([
            'pertemuan_id' => 'required',
            'file' => 'image|mimes:jpeg,jpg,png|max:2000',
        ], $messages
        );
        
        $data = Absendosen::create([
            'file' => $request->file,
            'desc' => $request->desc,
            'status' => $request->status,
            'pertemuan_id' => $request->pertemuan_id,
            'dosen_id' => $request->dosen_id,
        ]);


        // if($request->hasFile('file')){
        //     $request->file('file')->move('img/dosen/absenfile/', $request->file('file')->getclientOriginalName());
        //     $data->file = $request->file('file')->getclientOriginalName();
        //     $data->save();
        // }

        if ($request->hasFile('file')) {
            $imageName = $request->file('file')->hashName();
            $request->file('file')->move('img/dosen/absenfile/', $imageName);
            $data->file = $imageName;
            $data->save();
        }

        return redirect('/backend/absends')->with('success', 'Data Successfully Added!');
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
        $data = Absendosen::find($id);
        return view('backend.admin.absends.edit', compact('data', 'dosen', 'pertemuan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Absendosen::find($id);
        $messages=[
            'pertemuan_id.required' => 'Kolom Pertemuan harus diisi',
            'file.image' => 'Format gambar gunakan ekstensi jpeg, jpg atau png',
            'file.max' => 'Ukuran file gambar Maksimal adalah 2000 KB',
        ];

        $request->validate([
            'pertemuan_id' => 'required',
            'file' => 'image|mimes:jpeg,jpg,png|max:2000',
        ], $messages
        );

        if ($request->hasFile('file')) {

            // hapus file lama
            File::delete('img/dosen/absenfile/' . $data->file);

            // upload file baru
            $imageName = $request->file('file')->hashName();
            $request->file('file')->move('img/dosen/absenfile/', $imageName);

            $data->file = $imageName;
        }

        $data->desc = $request->desc;
        $data->pertemuan_id = $request->pertemuan_id;
        $data->status = $request->status;
        $data->dosen_id = $request->dosen_id;
        $data->save();
        return redirect('/backend/absends')->with('success','Data Berhasil Di Update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Absendosen::findOrFail($id);
        $data->delete();
        return redirect('/backend/absends')->with('success', 'Data Successfully Deleted!');
    }
}
