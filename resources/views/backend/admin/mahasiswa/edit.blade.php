@extends('layouts.app')
@section('title')
    <title>Edit Data Mahasiswa {{ $data->nama }} | Sistem Informasi E-learning</title>
@endsection
@section('header')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Mahasiswa</h3>
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
                <a href="{{ url('/backend/mahasiswa') }}">Mahasiswa</a>
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
          <div class="card-title">Form Edit Data {{ $data->nama }}</div>
        </div>
        <form action="{{ Route('backend.mahasiswa.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div id="form-container">
                    <div class="row form-row">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="nim">NIM</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('nim') is-invalid @enderror" name="nim" placeholder="Masukkan NIM" value="{{ old('nim', $data->nim) }}">
                                    @error('nim')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="nama">Nama </label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Masukkan Nama " value="{{ old('nama', $data->nama) }}">
                                    @error('nama')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-6">
                            <div class="form-group">
                                <label for="defaultSelect">Kelas</label>
                                <select class="form-select form-control @error('kelas_id') is-invalid @enderror" id="defaultSelect" value="{{ old('kelas_id') }}" name="kelas_id">
                                    <option value="">-- Pilih Kelas --</option>
                                    @foreach ($kelas as $p)
                                    <option value="{{ $p->id }}" {{ old('kelas_id', $data->kelas_id) == $p->id ? 'selected' : null }}>{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                                @error('kelas_id')
                                    <div class="invalid invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">Email Mahasiswa</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Masukkan Email Mahasiswa" value="{{ old('email', $data->email) }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group row">
                            <label for="foto">Foto Mahasiswa </label>
                            <div class="col-sm-12">
                                <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" value="{{ old('foto') }}">
                                <img src="{{ asset('https://simplearning-j968.vercel.app/img/mahasiswa/profile/'.$data->foto) }}" width="100px" class="mt-2" alt="foto" id="gambar-preview">
                                @error('foto')
                                    <div class="invalid invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                          </div>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="card-action">
            <button class="btn btn-success">Submit</button>
            <a href="{{ url('backend/mahasiswa') }}" class="btn btn-danger">Cancel</a>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#foto').on('change', function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#gambar-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            });
        });
    </script>
@endsection