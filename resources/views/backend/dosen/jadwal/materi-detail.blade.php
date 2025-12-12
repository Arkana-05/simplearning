@extends('layouts.app')
@section('title')
    <title>Materi {{ $data->nama }} | Sistem Informasi E-learning</title>
     <style>
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.12);
            transition: all 0.3s;
        }
        .row .card.shadow-sm{
            margin-bottom: 10px;
        }

    </style>
@endsection
@section('header')
    <div class="page-header">
        <h3 class="fw-bold">Jadwal Perkuliahan </h3>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ url('/backend/dashboard') }}">
                <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                @if(Auth::user()->level == 'dosen')
                <a href="{{ url('backend/jadwal-ds') }}">Jadwal </a>
                @elseif(Auth::user()->level == 'mhs')
                <a href="{{ url('backend/jadwalmh') }}">Jadwal </a>
                @endif
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ $data->nama }} </a>
            </li>
        </ul>
    </div>
@endsection
@section('content')
  <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">Materi {{ $data->nama }}</h4>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="add-row" class="display table table-striped table-hover" >
              <thead>
                <tr>
                  <th>No</th>
                  <th>File</th>
                  <th>Judul</th>
                  <th>Mata Kuliah</th>
                  <th style="width: 30%">Deskripsi</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>File</th>
                  <th>Judul</th>
                  <th>Mata Kuliah</th>
                  <th>Deskripsi</th>
                </tr>
              </tfoot>
              <tbody>
              @foreach ($data->materi as $d)                
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td><a href="{{ asset('https://simplearning-j968.vercel.app/img/materi/'.$d->file) }}" target="_blank"><i class="fas fa-book"></i> {{ $d->matkul->kode }}</a></td>
                  <td>{{ $d->judul }}</td>
                  <td>{{ $d->matkul->nama }}</td>
                  <td>{!! $d->desc !!}</td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
  </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
        
        // Add Row
        $("#add-row").DataTable({});

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