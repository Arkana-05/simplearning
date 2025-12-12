@extends('layouts.app')
@section('title')
    <title>Edit Data Jadwal Mata Kuliah {{ $data->nama }} | Sistem Informasi E-learning</title>
@endsection
@section('header')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Jadwal</h3>
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
                <a href="{{ url('/backend/jadwal') }}">Jadwal</a>
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
        <form action="{{ Route('backend.jadwal.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div id="form-container">
                    <div class="row form-row">

                         <div class="col-4">
                            <div class="form-group">
                                <label for="defaultSelect">Mata Kuliah</label>
                                <select class="form-select form-control @error('matkul_id') is-invalid @enderror" id="defaultSelect" value="{{ old('matkul_id') }}" name="matkul_id">
                                    <option value="">-- Pilih Nama Prodi --</option>
                                    @foreach ($matkul as $p)
                                    <option value="{{ $p->id }}" {{ old('matkul_id', $data->matkul_id) == $p->id ? 'selected' : null }}>{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                         <div class="col-4">
                            <div class="form-group">
                                <label for="defaultSelect">Kelas</label>
                                <select class="form-select form-control @error('kelas_id') is-invalid @enderror" id="defaultSelect" value="{{ old('kelas_id') }}" name="kelas_id">
                                    <option value="">-- Pilih Nama Prodi --</option>
                                    @foreach ($kelas as $p)
                                    <option value="{{ $p->id }}" {{ old('kelas_id', $data->kelas_id) == $p->id ? 'selected' : null }}>{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="defaultSelect">Dosen Pengampu</label>
                                <select class="form-select form-control @error('dosen_id') is-invalid @enderror" id="defaultSelect" value="{{ old('dosen_id') }}" name="dosen_id">
                                    <option value="">-- Pilih Nama Dosen --</option>
                                    @foreach ($dosen as $p)
                                    <option value="{{ $p->id }}" {{ old('dosen_id', $data->dosen_id) == $p->id ? 'selected' : null }}>{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="defaultSelect">Jadwal Hari</label>
                                <select class="form-select form-control @error('hari') is-invalid @enderror" id="defaultSelect" value="{{ old('hari', $data->hari) }}" name="hari">
                                    <option value="Senin" {{ old('hari', $data->hari) == 'Senin' ? 'selected' : '' }}>Senin</option>
                                    <option value="Selasa" {{ old('hari', $data->hari) == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                                    <option value="Rabu" {{ old('hari', $data->hari) == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                                    <option value="Kamis" {{ old('hari', $data->hari) == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                                    <option value="Jumat" {{ old('hari', $data->hari) == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="defaultSelect">Ruang</label>
                                <select class="form-select form-control @error('ruang_id') is-invalid @enderror" id="defaultSelect" value="{{ old('ruang_id') }}" name="ruang_id">
                                    <option value="">-- Pilih Ruang Kelas --</option>
                                    @foreach ($ruang as $p)
                                    <option value="{{ $p->id }}" {{ old('ruang_id', $data->ruang_id) == $p->id ? 'selected' : null }}>{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="tanggal_mulai">Tanggal Mulai Kelas</label>
                                <div class="input-group mb-3">
                                    <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" name="tanggal_mulai" placeholder="Masukkan Tanggal Mulai Kelas" value="{{ old('tanggal_mulai', $data->tanggal_mulai) }}">
                                    @error('tanggal_mulai')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-4">
                            <div class="form-group">
                                <label for="jam_s">Jam Mulai</label>
                                <div class="input-group mb-3">
                                    <input type="time" class="form-control @error('jam_s') is-invalid @enderror" name="jam_s" placeholder="Masukkan jam_s Dosen" value="{{ old('jam_s', $data->jam_s) }}">
                                    @error('jam_s')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="jam_e">Jam Slesai</label>
                                <div class="input-group mb-3">
                                    <input type="time" class="form-control @error('jam_e') is-invalid @enderror" name="jam_e" placeholder="Masukkan jam_e" value="{{ old('jam_e', $data->jam_e) }}">
                                    @error('jam_e')
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
            <a href="{{ url('backend/jadwal') }}" class="btn btn-danger">Cancel</a>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
