@extends('layouts.app')
@section('title')
    <title>Tambah Data Pengumpulan Tugas | Sistem Informasi E-learning</title>
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
                <a href="{{ url('backend/jadwalmh') }}">Jadwal</a>
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
          <div class="card-title">Form Pengumpulan Tugas</div>
        </div>
        <form action="{{ url('backend/tugas-sub') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div id="form-container">
                    <div class="row form-row">

                        <div class="col-6">
                            <div class="form-group row">
                            <label for="file">File Tugas </label>
                            <div class="col-sm-12">
                                <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" value="{{ old('file') }}">
                                @error('file')
                                    <div class="invalid invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                          </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group row">
                            <label for="link">Link </label>
                            <div class="col-sm-12">
                                <input type="text" name="link" id="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" placeholder="Link pengumpulan tugas ..">
                                @error('link')
                                    <div class="invalid invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                          </div>
                        </div>
                        
                        <input type="hidden" name="tugas_id" value="{{ $tugas_id }}">
                        <input type="hidden" name="mhs_id" value="{{ Auth::user()->mhs->id }}">

                    </div> 
                </div>
            </div>
            <div class="card-action">
                <button class="btn btn-success">Submit</button>
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