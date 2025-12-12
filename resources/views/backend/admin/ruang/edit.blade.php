@extends('layouts.app')
@section('title')
    <title>Edit Data Ruang {{ $data->nama }} | Sistem Informasi E-learning</title>
@endsection
@section('header')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Ruang</h3>
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
                <a href="{{ url('/backend/ruang') }}">Ruang</a>
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
          <div class="card-title">Form Edit Data Ruang Kelas {{ $data->nama }}</div>
        </div>
        <form action="{{ Route('backend.ruang.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div id="form-container">
                    <div class="row form-row">

                        <div class="col-12">
                            <div class="form-group">
                                <label for="nama">Nama Ruang Kelas </label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Masukkan Nama Ruang Kelas " value="{{ old('nama', $data->nama) }}">
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
            <a href="{{ url('backend/ruang') }}" class="btn btn-danger">Cancel</a>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
