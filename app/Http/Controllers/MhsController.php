<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MhsController extends Controller
{
    public function index()
    {   
        $mahasiswa = Mahasiswa::latest()->get();
        return view('backend.admin.mahasiswa.index', compact('mahasiswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('backend.admin.mahasiswa.create', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages=[
            'nim.required' => 'NIM harus diisi',
            'nama.required' => 'Nama harus diisi',
            'nim.unique' => 'NIM harus unique',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email harus unique',
            'kelas.required' => 'KelasMahasiswa  harus diisi',
            'foto.image' => 'Format gambar gunakan ekstensi jpeg, jpg atau png',
            'foto.max' => 'Ukuran file gambar Maksimal adalah 2000 KB',
        ];

        $request->validate([
            'nim' => 'required|unique:mahasiswa',
            'email' => 'required|unique:mahasiswa',
            'nama' => 'required',
            'kelas_id' => 'required',
            'file' => 'image|mimes:jpeg,jpg,png|max:2000',
        ], $messages
        );
        
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->email),
            'level' => 'mhs',
        ]);

        $data = Mahasiswa::create([
            'foto' => $request->foto,
            'nama' => $request->nama,
            'nim' => $request->nim,
            'email' => $request->email,
            'semester' => 3,
            'prodi_id' => $request->prodi_id,
            'kelas_id' => $request->kelas_id,
            'user_id' => $user->id,
        ]);


        if ($request->hasFile('foto')) {
            $imageName = $request->file('foto')->hashName();
            $request->file('foto')->move('img/mahasiswa/profile/', $imageName);
            $data->foto = $imageName;  
            $data->save();
        }
        return redirect('/backend/mahasiswa')->with('success', 'Data Successfully Added!');
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
        $kelas = Kelas::all();
        $data = Mahasiswa::find($id);
        return view('backend.admin.mahasiswa.edit', compact('data', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Mahasiswa::find($id);
        $messages=[
            'nim.required' => 'NIM harus diisi',
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'kelas.required' => 'Kelas Mahasiswa  harus diisi',
            'foto.image' => 'Format gambar gunakan ekstensi jpeg, jpg atau png',
            'foto.max' => 'Ukuran file gambar Maksimal adalah 2000 KB',
        ];

        $request->validate([
            'nim' => 'required',
            'email' => 'required',
            'nama' => 'required',
            'kelas_id' => 'required',
            'file' => 'image|mimes:jpeg,jpg,png|max:2000',
        ], $messages
        );

        if ($request->hasFile('foto')) {

            // hapus foto lama
            File::delete('img/mahasiswa/profile/' . $data->foto);

            // upload foto baru
            $imageName = $request->file('foto')->hashName();
            $request->file('foto')->move('img/mahasiswa/profile/', $imageName);
            $data->foto = $imageName;
        }
        $data->nama = $request->nama;
        $data->nim = $request->nim;
        $data->semester = 3;
        $data->email = $request->email;
        $data->kelas_id = $request->kelas_id;
        $data->user_id = $request->user_id;
        $data->save();

        User::where('id', $data->user_id)->update([
            'email' => $request->email,
            'password' => bcrypt($request->email)
        ]);
        return redirect('/backend/mahasiswa')->with('success','Data Berhasil Di Update');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->user()->delete();
        $mahasiswa->delete();
        return redirect('/backend/mahasiswa')->with('success', 'Data Successfully Deleted!');
    }
}
