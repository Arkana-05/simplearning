@extends('layouts.app')
@section('title')
    <title>Tambah Data Tugas | Sistem Informasi E-learning</title>
@endsection
@section('header')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Tugas</h3>
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
                <a href="{{ url('/backend/tugas') }}">Tugas</a>
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
          <div class="card-title">Form Tambah Data Tugas</div>
        </div>
        <form action="{{ url('backend/tugas') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div id="form-container">
                    <div class="row form-row">

                        <div class="col-4">
                            <div class="form-group">
                                <label class="fw-semibold" for="judul">Judul Tugas</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" placeholder="Masukkan Judul Tugas" value="{{ old('judul') }}">
                                    @error('judul')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group row">
                            <label class="fw-semibold" for="file">File Tugas </label>
                            <div class="col-sm-12">
                                <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" value="{{ old('file') }}">
                                @error('file')
                                    <div class="invalid invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                          </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label class="fw-semibold">Jadwal</label>
                                <select class="form-select form-control @error('jadwal_id') is-invalid @enderror" name="jadwal_id">
                                    <option value="">-- Pilih Jadwal --</option>
                                    @foreach ($jadwal as $j)
                                        <option value="{{ $j->id }}" {{ old('jadwal_id') == $j->id ? 'selected' : '' }}>
                                            {{ $j->matkul->nama }} - {{ $j->kelas->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jadwal_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>


                        <div class="col-4">
                            <div class="form-group">
                                <label class="fw-semibold" for="defaultSelect">Pertemuan Ke</label>
                                <select class="form-select form-control @error('pertemuan_id') is-invalid @enderror" id="defaultSelect" value="{{ old('pertemuan_id') }}" name="pertemuan_id">
                                    <option value="">-- Pilih Pertemuan Ke --</option>
                                    @foreach ($pertemuan as $p)
                                    <option value="{{ $p->id }}" {{ old('pertemuan_id') == $p->id ? 'selected' : null }}>{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label class="fw-semibold" for="mulai">Jam Mulai </label>
                                <div class="input-group mb-3">
                                    <input type="datetime-local" class="form-control @error('mulai') is-invalid @enderror" name="mulai" placeholder="Masukkan Jam Mulai Pengumpulan" value="{{ old('mulai') }}">
                                    @error('mulai')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="fw-semibold" for="deadline">Deadline</label>
                                <div class="input-group mb-3">
                                    <input type="datetime-local" class="form-control @error('deadline') is-invalid @enderror" name="deadline" placeholder="Masukkan Jadwal Jam Slesai Kelas" value="{{ old('deadline') }}">
                                    @error('deadline')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="fw-semibold" for="desc">Deskripsi</label>
                                <div class="col-lg-12 mb-3">
                                    <textarea class="form-control @error('desc') is-invalid @enderror" placeholder="Deskripsi / Rangkuman Isi tugas ....." id="texteditor" name="desc">{{ old('desc') }}</textarea>
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
                <a href="{{ url('backend/tugas') }}" class="btn btn-danger">Cancel</a>
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