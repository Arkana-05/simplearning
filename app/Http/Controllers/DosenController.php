<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $dosen = Dosen::latest()->get();
        return view('backend.admin.dosen.index', compact('dosen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.admin.dosen.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages=[
            'nid.required' => 'NID harus diisi',
            'nid.unique' => 'NID harus unique',
            'kode_dosen.required' => 'Kode Dosen harus diisi',
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'foto.image' => 'Format gambar gunakan ekstensi jpeg, jpg atau png',
            'foto.max' => 'Ukuran file gambar Maksimal adalah 2000 KB',
        ];

        $request->validate([
            'nid' => 'required|unique:dosen',
            'kode_dosen' => 'required|unique:dosen',
            'email' => 'required|unique:dosen',
            'nama' => 'required',
            'file' => 'image|mimes:jpeg,jpg,png|max:2000',
        ], $messages
        );
        
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->email),
            'level' => 'dosen',
        ]);

        $data = Dosen::create([
            'foto' => $request->foto,
            'nama' => $request->nama,
            'nid' => $request->nid,
            'kode_dosen' => $request->kode_dosen,
            'email' => $request->email,
            'user_id' => $user->id,
        ]);

        if ($request->hasFile('foto')) {
            $imageName = $request->file('foto')->hashName();
            $request->file('foto')->move('img/dosen/profile/', $imageName);
            $data->foto = $imageName;  
            $data->save();
        }

        return redirect('/backend/dosen')->with('success', 'Data Successfully Added!');
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
        $data = Dosen::find($id);
        return view('backend.admin.dosen.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Dosen::find($id);
        $messages=[
            'nid.required' => 'NID harus diisi',
            'kode_dosen.required' => 'Kode Dosen harus diisi',
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'foto.image' => 'Format gambar gunakan ekstensi jpeg, jpg atau png',
            'foto.max' => 'Ukuran file gambar Maksimal adalah 2000 KB',
        ];

        $request->validate([
            'nid' => 'required',
            'kode_dosen' => 'required',
            'email' => 'required',
            'nama' => 'required',
            'file' => 'image|mimes:jpeg,jpg,png|max:2000',
        ], $messages
        );

        if ($request->hasFile('foto')) {

            // hapus foto lama
            File::delete('img/dosen/profile/' . $data->foto);

            // upload foto baru
            $imageName = $request->file('foto')->hashName();
            $request->file('foto')->move('img/dosen/profile/', $imageName);
            $data->foto = $imageName;
        }


        $data->nama = $request->nama;
        $data->nid = $request->nid;
        $data->kode_dosen = $request->kode_dosen;
        $data->email = $request->email;
        $data->save();

        User::where('id', $data->user_id)->update([
            'email' => $request->email,
            'password' => bcrypt($request->email)
        ]);
        return redirect('/backend/dosen')->with('success','Data Berhasil Di Update');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dosen = Dosen::findOrFail($id);
        $dosen->user()->delete();
        $dosen->delete();
        return redirect('/backend/dosen')->with('success', 'Data Successfully Deleted!');
    }
}
