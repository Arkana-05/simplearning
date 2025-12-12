@extends('layouts.app')
@section('title')
    <title>Pengumpulan Tugas {{ $data->judul }} | Sistem Informasi E-learning</title>
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
                <a href="#">Tugas {{ $data->judul }} </a>
            </li>
        </ul>
    </div>
@endsection
@section('content')
  <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">Data Nilai Tugas {{ $data->matkul->nama ?? '-' }}</h4>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="add-row" class="display table table-striped table-hover" >
              <thead>
                <tr>
                  <th>No</th>
                  <th>Judul</th>
                  <th>Mata Kuliah</th>
                  <th>Pertemuan</th>
                  <th>Link / File</th>
                  <th>Status</th>
                  <th>Nilai</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Judul</th>
                  <th>Mata Kuliah</th>
                  <th>Pertemuan</th>
                  <th>Link / File</th>
                  <th>Status</th>
                  <th>Nilai</th>
                </tr>
              </tfoot>
              <tbody>
                @foreach ($data->tugas as $tugas)
                  @foreach ($tugas->submit as $s)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $s->tugas->judul ?? '-' }}</td>
                      <td>{{ $s->tugas->jadwal->matkul->nama ?? '-' }}</td>
                      <td>{{ $s->tugas->pertemuan->nama ?? '-' }}</td>
                      <td>
                          @if ($s->link) 
                              <a href="{{ $s->link }}" target="_blank">Buka Link</a>
                          @elseif ($s->file)
                              <a href="{{ asset('img/tugas/submit/'.$s->file) }}" target="_blank">Download File</a>
                          @else
                              <span class="text-danger">Tidak ada file/link</span>
                          @endif
                      </td>
                      @if($s->status == 'Telat')
                        <td><span class="badge badge-danger mb-1" style="border-radius: 50px;">{{ $s->status }}</span></td>
                      @else
                        <td><span class="badge badge-success mb-1" style="border-radius: 50px;">{{ $s->status }}</span></td>
                      @endif
                      <td>{{ $s->nilai }}</td>
                      {{--  <td>
                          <div class="form-button-action">
                              <a href="{{ Route('backend.tugas-sub.edit', $s->id) }}" type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"  style="padding: 10px">
                                  <i class="fa fa-edit"></i>
                              </a>
                          </div>
                      </td>  --}}
                    </tr>
                  @endforeach
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