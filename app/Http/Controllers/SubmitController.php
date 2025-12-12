<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Submit;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SubmitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Submit::latest()->get();
        return view('backend.admin.submit.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $tugas_id = $request->tugas_id;

        $mhs = Mahasiswa::all();
        $tugas = Tugas::all();
        return view('backend.admin.submit.create', compact('tugas', 'mhs', 'tugas_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages=[
            'file.mimes' => 'Format gambar gunakan ekstensi pdf,doc,docx,ppt,pptx,zip',
            'file.max' => 'Ukuran file gambar Maksimal adalah 5000 KB',
            'required_without' => 'Isi salah satu: File atau Link.',
        ];

        $request->validate([
            'file' => 'mimes:pdf,doc,docx,ppt,pptx,zip|max:5000|required_without:link',
            'link' => 'required_without:file',
        ], $messages
        );
        
        $tugas = Tugas::findOrFail($request->tugas_id);

        // === CEK STATUS BERDASARKAN WAKTU ===
        $now = now();

        if ($now->gt($tugas->deadline)) {
            $status = "Telat";
        } else if ($now->between($tugas->mulai, $tugas->deadline)) {
            $status = "Slesai";
        } else {
            $status = ""; // kondisi kalau sebelum mulai
        }

        // === SIMPAN DATA ===
        $data = Submit::create([
            'file' => $request->file,
            'link' => $request->link,
            'nilai' => 0,
            'mhs_id' => $request->mhs_id,
            'tugas_id' => $request->tugas_id,
            'status' => $status,
        ]);


        if ($request->hasFile('file')) {
            $fileName = $request->file('file')->hashName();
            $request->file('file')->move('img/tugas/submit/', $fileName);

            $data->file = $fileName;
            $data->save();
        }

        // dd($request->all());

        return redirect()->back()->with('success', 'Data Successfully Added!');
    }

    /**
     * Display the specified resource.
     */
    public function nilaistore(Request $request, $id)
    {
         $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        $submit = Submit::findOrFail($id);

        $submit->nilai = $request->nilai;
        $submit->updated_at = now();
        $submit->save();

        return back()->with('success', 'Nilai berhasil diperbarui!');
    }
    
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mhs = Mahasiswa::all();
        $tugas = Tugas::all();
        $data = Submit::find($id);
        return view('backend.admin.submit.edit', compact('data', 'tugas', 'mhs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = Submit::findOrFail($id);

        $messages = [
            'file.mimes' => 'Format file gunakan pdf, doc, docx, ppt, pptx atau zip',
            'file.max' => 'Ukuran file maksimal 5000 KB',
            'required_without' => 'Isi salah satu: File atau Link.',
        ];

        $request->validate([
            'file' => 'mimes:pdf,doc,docx,ppt,pptx,zip|max:5000|required_without:link',
            'link' => 'required_without:file',
        ], $messages);

        // === HANDLE FILE JIKA DIUPLOAD ULANG ===
        if ($request->hasFile('file')) {

            // Hapus file lama jika ada
            if ($data->file) {
                File::delete('img/tugas/submit/' . $data->file);
            }

            $fileName = $request->file('file')->hashName();
            $request->file('file')->move('img/tugas/submit/', $fileName);

        }

        // === AMBIL DATA TUGAS UNTUK CEK STATUS WAKTU ===
        $tugas = Tugas::findOrFail($request->tugas_id);
        $now = now();

        if ($now->gt($tugas->deadline)) {
            $status = "Telat";
        } elseif ($now->between($tugas->mulai, $tugas->deadline)) {
            $status = "Slesai"; // typo "Slesai" aku betulin
        } 

        // dd($request->all());
        // === SIMPAN DATA ===
        $data->mhs_id  = $request->mhs_id;
        $data->tugas_id = $request->tugas_id;
        $data->nilai = 0;
        $data->status = $status;
        $data->save();

        return redirect()->back()->with('success', 'Data berhasil diupdate');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Submit::findOrFail($id);
        $data->delete();
        return redirect('/backend/tugas-sub')->with('success', 'Data Successfully Deleted!');
    }
}
