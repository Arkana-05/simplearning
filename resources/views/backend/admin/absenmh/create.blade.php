@extends('layouts.app')
@section('title')
    <title>Tambah Data Absensi Mahasiswa | Sistem Informasi E-learning</title>
@endsection
@section('header')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Absensi</h3>
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
                <a href="{{ url('/backend/absen') }}">Absensi</a>
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
          <div class="card-title">Form Tambah Data Absensi</div>
        </div>
        <form action="{{ url('backend/absen') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div id="form-container">
                    <div class="row form-row">

                        <div class="col-6">
                            <div class="form-group">
                                <label for="defaultSelect">Pertemuan Ke</label>
                                <select class="form-select form-control @error('pertemuan_id') is-invalid @enderror" id="defaultSelect" value="{{ old('pertemuan_id') }}" name="pertemuan_id">
                                    <option value="">-- Pilih Pertemuan ke --</option>
                                    @foreach ($pertemuan as $p)
                                    <option value="{{ $p->id }}" {{ old('pertemuan_id') == $p->id ? 'selected' : null }}>{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="defaultSelect" class="form-label d-block">Status</label>
                                <div class="selectgroup selectgroup-secondary selectgroup-pills">
                                    <input type="hidden" name="status" value="Tidak Hadir">
                                    {{--  <a class="btn btn-outline-secondary me-2" style="border-radius: 150px" ><i class="fas fa-battery-empty"></i></a>
                                    <a class="btn btn-outline-primary me-2" style="border-radius: 150px" ><i class="fas fa-battery-half"></i></a>
                                    <a class="btn btn-outline-success me-2" style="border-radius: 150px" ><i class="fas fa-battery-full"></i></a>  --}}
                                    <a class="btn btn-outline-secondary me-2" style="border-radius: 150px" ><i class="fas fa-exclamation-circle"></i> Tidak Hadir</a>
                                    <a class="btn btn-outline-primary me-2" style="border-radius: 150px" ><i class="fas fa-check-circle"></i> Hadir</a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-6">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="hidden" class="form-control" name="mhs_id" value="{{ Auth::user()->dosen->id }}">
                                </div>
                            </div>
                        </div>
                        
                    </div> 
                </div>
            </div>
            <div class="card-action">
                <button class="btn btn-success">Submit</button>
                <a href="{{ url('backend/absen') }}" class="btn btn-danger">Cancel</a>
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
    <script>
        $(document).ready(function() {
            $('#file').on('change', function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#gambar-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files[0]);
            });
        });
    </script>
@endsection