@extends('layouts.app')
@section('title')
    <title>Tambah Data Dosen | Sistem Informasi E-learning</title>
@endsection
@section('header')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Menu</h3>
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
                <a href="{{ url('/backend/dosen') }}">Dosen</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Create Data</a>
            </li>
        </ul>
    </div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Form Tambah Data Dosen</div>
        </div>
        <form action="{{ url('backend/dosen') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div id="form-container">
                    <div class="row form-row">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="nid">NID</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('nid') is-invalid @enderror" name="nid" placeholder="Masukkan NID" value="{{ old('nid') }}">
                                    @error('nid')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="kode_dosen">Kode Dosen</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('kode_dosen') is-invalid @enderror" name="kode_dosen" placeholder="Masukkan Kode Dosen" value="{{ old('kode_dosen') }}">
                                    @error('kode_dosen')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="nama">Nama Dosen</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Masukkan Nama Dosen" value="{{ old('nama') }}">
                                    @error('nama')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">Email Dosen</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Masukkan Email Dosen" value="{{ old('email') }}">
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
                            <label for="foto">Foto Dosen </label>
                            <div class="col-sm-12">
                                <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" value="{{ old('foto') }}">
                                <img src="" width="100px" class="mt-2" alt="foto" id="gambar-preview">
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
            <a href="{{ url('backend/dosen') }}" class="btn btn-danger">Cancel</a>
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