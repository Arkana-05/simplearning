@extends('layouts.app')
@section('title')
    <title>Tambah Data Mata Kuliah | Sistem Informasi E-learning</title>
@endsection
@section('header')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Mata Kuliah</h3>
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
                <a href="{{ url('/backend/matkul') }}">Mata Kuliah</a>
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
          <div class="card-title">Form Tambah Data Mata Kuliah</div>
        </div>
        <form action="{{ url('backend/matkul') }}" method="POST" enctype="multipart/form-data">
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
                                <label for="kode">Kode Mata Kuliah</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('kode') is-invalid @enderror" name="kode" placeholder="Masukkan Kode Mata Kuliah" value="{{ old('kode') }}">
                                    @error('kode')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="nama">Nama Mata Kuliah</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Masukkan Nama Mata Kuliah" value="{{ old('nama') }}">
                                    @error('nama')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="sks">SKS</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('sks') is-invalid @enderror" name="sks" placeholder="Masukkan SKS Mata Kuliah" value="{{ old('sks') }}">
                                    @error('sks')
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
            <a href="{{ url('backend/matkul') }}" class="btn btn-danger">Cancel</a>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection