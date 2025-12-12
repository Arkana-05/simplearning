@extends('layouts.app')
@section('title')
    <title>Edit Data Pengumpulan Tugas {{ $data->judul }} | Sistem Informasi E-learning</title>
@endsection
@section('header')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Pengumpulan Tugas</h3>
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
                <a href="{{ url('/backend/jadwalmh') }}">Jadwal</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="{{ url('/backend/tugas-submit/'.$data->mhs_id) }}">Tugas</a>
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
          <div class="card-title">Form Edit Tugas {{ $data->judul }}</div>
        </div>
        <form action="{{ Route('backend.tugas-sub.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div id="form-container">
                    <div class="row form-row">

                        <div class="col-6">
                            <div class="form-group row">
                            <label for="foto">File Tugas </label>
                            <div class="col-sm-12">
                                <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" value="{{ old('file') }}">
                                <a href="{{ asset('https://simplearning-j968.vercel.app/img/tugas/submit/'.$data->file) }}" target="_blank">Lihat File</a>
                                @error('file')
                                    <div class="invalid invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                          </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="link">Link Tugas</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('link') is-invalid @enderror" name="link" placeholder="Masukkan Link Pengumpulan Tugas" value="{{ old('link', $data->link) }}">
                                    @error('link')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="tugas_id" value="{{ $data->tugas_id }}">
                        <input type="hidden" name="mhs_id" value="{{ $data->mhs_id }}">
                        
                    </div> 
                </div>
            </div>
            <div class="card-action">
            <button class="btn btn-success">Submit</button>
            <a href="{{ url('backend/tugas-submit/'.$data->mhs_id) }}" class="btn btn-danger">Back</a>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
@section('script')
    @if(Session::has('success'))
      <script>
          swal({
              icon: 'success',
              title: 'Successfully',
              text: '{{ session('success') }}',
          })
      </script>
    @endif
@endsection