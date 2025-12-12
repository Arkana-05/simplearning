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
            @if(Auth::user()->level == 'mhs')
            <a class="btn btn-primary btn-round ms-auto" href="{{ url('backend/tugas-submit/'.$data->id) }}">
              <i class="fas fa-clipboard-list"></i>
              Data Nilai Tugas 
            </a>
            @endif
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="add-row" class="display table table-striped table-hover" >
              <thead>
                <tr>
                  <th>No</th>
                  <th>Instruksi</th>
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
                  <th>Instruksi</th>
                  <th>Judul</th>
                  <th>Mata Kuliah</th>
                  <th>Pertemuan</th>
                  <th>Deskripsi</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody>
                @foreach ($data->tugas as $t)
                  @php
                    $mySubmit = $t->submit->where('mhs_id', optional($mhs)->id)->first();
                  @endphp
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>
                        @if(Auth::user()->level == 'dosen')
                          <a href="{{ asset('img/tugas/'.$t->file) }}" target="_blank">
                              <i class="fas fa-book">File Tugas</i>
                          </a>
                        @elseif(Auth::user()->level == 'mhs')
                          <a href="{{ asset('img/tugas/'.$t->file) }}" target="_blank">
                              <i class="fas fa-book"> Tugas</i>
                          </a>
                        @endif
                      </td>
                      <td>{{ $t->judul ?? '-' }}</td>
                      <td>{{ $data->matkul->nama ?? '-' }}</td>
                      <td>{{ $t->pertemuan->nama ?? '-' }}</td>
                      <td>{!! $t->desc ?? '-' !!}</td>

                      <td>
                        <div class="form-button-action">
                          @if(Auth::user()->level == 'dosen')
                            <a href="{{ url('backend/tugas/'.$t->id) }}" class="btn btn-link btn-primary btn-lg" data-bs-toggle="tooltip" title="Pengumpulan Tugas"> <i class="fas fa-tasks"></i>
                            </a>
                          @endif
                          @if(auth()->user()->level == 'mhs')
                            @if($mySubmit)
                              <a href="{{ url('backend/tugas-sub/'.$mySubmit->id.'/edit') }}" class="btn btn-link btn-primary btn-lg">
                                <i class="fa fa-edit"></i>
                              </a>
                            @else
                              <a href="{{ url('backend/tugas-sub/create?tugas_id='.$t->id) }}" class="btn btn-link btn-primary btn-lg">
                                <i class="fas fa-cloud-upload-alt"></i>
                              </a>
                            @endif
                          @endif
                        </div>
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