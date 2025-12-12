@extends('layouts.app')
@section('title')
    <title>Tambah Data Kelas | Sistem Informasi E-learning</title>
@endsection
@section('header')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Kelas</h3>
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
                <a href="{{ url('/backend/kelas') }}">Kelas</a>
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
          <div class="card-title">Form Tambah Data Kelas</div>
        </div>
        <form action="{{ url('backend/kelas') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div id="form-container">
                    <div class="row form-row">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="defaultSelect">Prodi</label>
                                <select class="form-select form-control @error('prodi_id') is-invalid @enderror" id="defaultSelect" value="{{ old('prodi_id') }}" name="prodi_id">
                                    <option value="">-- Pilih Nama Prodi --</option>
                                    @foreach ($prodi as $p)
                                    <option value="{{ $p->id }}" {{ old('prodi_id') == $p->id ? 'selected' : null }}>{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="nama">Nama Kelas</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Masukkan Nama Kelas" value="{{ old('nama') }}">
                                    @error('nama')
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
            <a href="{{ url('backend/kelas') }}" class="btn btn-danger">Cancel</a>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection