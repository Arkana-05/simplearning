@extends('layouts.app')
@section('title')
    <title>Absensi Dosen | Sistem Informasi E-learning</title>
@endsection

@section('header')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Data Absensi Dosen</h3>
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
            <a href="#">Absensi</a>
        </li>
        </ul>
    </div>
@endsection

@section('content')
  <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">Data Absensi Dosen</h4>
            <a class="btn btn-primary btn-round ms-auto" href="{{ route('backend.absends.create') }}">
              <i class="fa fa-plus-circle"></i>
              Add 
            </a>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="add-row" class="display table table-striped table-hover" >
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Pertemuan</th>
                  <th>Status</th>
                  <th style="width: 10%">Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Pertemuan</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody>
              @foreach ($data as $d)                
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $d->dosen->nama }}</td>
                  <td>{{ $d->pertemuan->nama }}</td>
                  <td>{{ $d->status }}</td>
                  <td>
                    <div class="form-button-action">
                      <a href="{{ Route('backend.absends.edit', $d->id) }}" type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"  style="padding: 10px">
                        <i class="fa fa-edit"></i>
                      </a>

                      <button type="button" class="btn btn-link btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $d->id }}" value="{{ $d->id }}" style="padding: 10px">
                        <i class="fa fa-times"></i>
                      </button>

                      <button type="button" class="btn btn-link btn-danger" data-bs-toggle="modal" data-bs-target="#detailBackdrop{{ $d->id }}" value="{{ $d->id }}" style="padding: 10px">
                        <i class="fa fa-eye"></i>
                      </button>

                      <div class="modal fade" id="staticBackdrop{{ $d->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Data </h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <p>Are you sure for delete data absen {{ $d->dosen->nama }}?</p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <form action="{{ Route('backend.absends.destroy', $d->id) }}"
                                  method="post">
                                  @csrf
                                  @method('delete')
                                  <button class="btn btn-primary" type="submit">Delete</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="modal fade" id="detailBackdrop{{ $d->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Absensi Dosen </h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <form action="">
                                <div class="row">
                                    <!-- field lama -->

                                    <div class="col-12 mt-2 row">
                                      <div class="col-6">
                                        <img src="{{ asset('img/dosen/absenfile/'.$d->file) }}" style="width: 100%;" alt="">
                                        <center>
                                          <label><i class="fas fa-calendar-alt me-2 mt-2"></i><strong>{{ $d->created_at->format('d F Y') }}</strong></label>
                                        </center>
                                      </div>
                                      <div class="col-6 cardss">
                                        <label><i class="fas fa-user me-2 mb-2"></i><strong> {{ $d->dosen->nama }} </strong></label>
                                         @if ($d->status == 'Tidak Hadir')
                                          <span class="badge rounded-pill text-bg-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Status akan berubah saat 15 menit terakhir">Tidak Hadir</span> <br>
                                        @else
                                          <span class="badge rounded-pill text-bg-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Status akan berubah saat 15 menit terakhir">Hadir</span> <br>
                                        @endif
                                        <label><i class="fas fa-tag me-2 mb-2"></i><strong>{{ $d->pertemuan->jadwal->matkul->nama }} - {{ $d->pertemuan->nama }}</strong></label><br>
                                        <label><i class="fas fa-clipboard-list me-2"></i><strong>Deskripsi / Ringkasan</strong>{!! $d->desc !!}</label>
                                        <style>
                                          .cardss p{
                                            font-size : 11px;                                         
                                          }
                                        </style>

                                      </div>
                                    </div>
                                    
                                </div>
                            </form>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>

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