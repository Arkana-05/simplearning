@extends('layouts.app')
@section('title')
    <title>Edit Data Materi {{ $data->judul }} | Sistem Informasi E-learning</title>
@endsection
@section('header')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Materi</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="{{ url('/backend/dashboard') }}">
                <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="{{ url('/backend/materi') }}">Materi</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Edit Data</a>
            </li>
        </ul>
    </div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Form Edit Materi {{ $data->judul }}</div>
        </div>
        <form action="{{ Route('backend.materi.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div id="form-container">
                    <div class="row form-row">

                        <div class="col-4">
                            <div class="form-group">
                                <label for="judul">Judul Materi</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" placeholder="Masukkan Judul Materi" value="{{ old('judul', $data->judul) }}">
                                    @error('judul')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group row">
                            <label for="foto">File Materi </label>
                            <div class="col-sm-12">
                                <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" value="{{ old('file') }}">
                                <a href="{{ asset('img/materi/'.$data->file) }}" target="_blank">Lihat File</a>
                                @error('file')
                                    <div class="invalid invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                          </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="defaultSelect">Mata Kuliah</label>
                                <select class="form-select form-control @error('matkul_id') is-invalid @enderror" id="defaultSelect" value="{{ old('matkul_id') }}" name="matkul_id">
                                    <option value="">-- Pilih Mata Kuliah --</option>
                                    @foreach ($matkul as $p)
                                    <option value="{{ $p->id }}" {{ old('matkul_id', $data->matkul_id) == $p->id ? 'selected' : null }}>{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="desc">Deskripsi</label>
                                <div class="col-lg-12 mb-3">
                                    <textarea class="form-control @error('desc') is-invalid @enderror" placeholder="Deskripsi / Rangkuman Pertemuan ....." id="texteditor" name="desc">{{ old('desc', $data->desc) }}</textarea>
                                    @error('desc')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        
                    </div> 
                </div>
            </div>
            <div class="card-action">
            <button class="btn btn-success">Submit</button>
            <a href="{{ url('backend/materi') }}" class="btn btn-danger">Cancel</a>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#texteditor'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection