@extends('layouts.app')
@section('title')
    <title>Tugas {{ $data->nama }} | Sistem Informasi E-learning</title>
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
                <a href="{{ url('backend/jadwal-ds') }}">Jadwal </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Tugas {{ $data->nama }} </a>
            </li>
        </ul>
    </div>
@endsection
@section('content')
  <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">Tugas {{ $data->matkul->nama }}</h4>
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
                  <th style="width: 10%;">Mata Kuliah</th>
                  <th>Pertemuan</th>
                  <th style="width: 30%;">Deskripsi</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>File</th>
                  <th>Judul</th>
                  <th>Mata Kuliah</th>
                  <th>Pertemuan</th>
                  <th>Deskripsi</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody>
                @foreach ($data->tugas as $t)
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>
                          <a href="{{ asset('https://simplearning-j968.vercel.app/img/tugas/'.$t->file) }}" target="_blank">
                              <i class="fas fa-book"></i>
                          </a>
                      </td>
                      <td>{{ $t->judul ?? '-' }}</td>
                      <td>{{ $data->matkul->nama ?? '-' }}</td>
                      <td>{{ $t->pertemuan->nama ?? '-' }}</td>
                      <td>{!! $t->desc ?? '-' !!}</td>

                      <td>
                          <a href="{{ url('backend/tugas/'.$t->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Pengumpulan Tugas"> <i class="fas fa-tasks"></i>
                          </a>
                      </td>
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