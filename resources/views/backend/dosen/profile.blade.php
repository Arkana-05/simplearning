@extends('layouts.app')
@section('title')
    <title>Profile Dosen {{ $data->nama }} | Sistem Informasi E-learning</title>
@endsection
@section('header')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Profile</h3>
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
                <a href="#">Profile</a>
            </li>
        </ul>
    </div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Form Edit Profile Dosen {{ $data->nama }}</div>
        </div>
        <form action="{{ route('backend.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div id="form-container">
                    <div class="row form-row">
                        @if(Auth::user()->level == 'dosen')
                        <div class="col-4">
                            <div class="form-group">
                                <label for="nid">NID</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('nid') is-invalid @enderror" name="nid" placeholder="Masukkan NID" value="{{ old('nid', $data->nid) }}" readonly>
                                    @error('nid')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="kode_dosen">Kode Dosen</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('kode_dosen') is-invalid @enderror" name="kode_dosen" placeholder="Masukkan Kode Dosen" value="{{ old('kode_dosen', $data->kode_dosen) }}" readonly>
                                    @error('kode_dosen')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="email">Email Dosen</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Masukkan Email Dosen" value="{{ old('email', $data->email) }}" readonly>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label for="nama">Nama Dosen</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Masukkan Nama Dosen" value="{{ old('nama', $data->nama) }}">
                                    @error('nama')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" name="password" class="form-control">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group row">
                            <label for="foto">Foto Dosen </label>
                            <div class="col-sm-12">
                                <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" value="{{ old('foto') }}">
                                <img src="{{ asset('https://simplearning-j968.vercel.app/img/dosen/profile/'.$data->foto) }}" width="100px" class="mt-2" alt="foto" id="gambar-preview">
                                @error('foto')
                                    <div class="invalid invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>
                          </div>
                        </div>
                        @elseif(Auth::user()->level == 'mhs')
                        <div class="col-3">
                            <div class="form-group">
                                <label for="nim">NIM</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('nim') is-invalid @enderror" name="nim" placeholder="Masukkan NIM" value="{{ old('nim', $data->nim) }}" readonly>
                                    @error('nim')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="email">Email Mahasiswa</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Masukkan Email Dosen" value="{{ old('email', $data->email) }}" readonly>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="prodi_id">Prodi</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('prodi_id') is-invalid @enderror" name="prodi_id" value="{{ old('prodi_id', $data->prodi->nama) }}" readonly>
                                    @error('prodi_id')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="kelas_id">Kelas</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('kelas_id') is-invalid @enderror" name="kelas_id" value="{{ old('kelas_id', $data->kelas->nama) }}" readonly>
                                    @error('kelas_id')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="nama">Nama Mahasiswa</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" name="nama" placeholder="Masukkan Nama Dosen" value="{{ old('nama', $data->nama) }}">
                                    @error('nama')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" name="password" class="form-control">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
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
                        @endif
                        
                        
                        
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