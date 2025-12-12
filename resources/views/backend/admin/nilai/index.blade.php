@extends('layouts.app')
@section('title')
    <title>Nilai Mahasiswa | Sistem Informasi E-learning</title>
    <style>
      .avatar-group img {
          border: 2px solid #fff;
          margin-left: -10px;
          transition: 0.2s;
      }

      .avatar-group img:first-child {
          margin-left: 0;
      }

      .avatar-group img:hover {
          transform: scale(1.1);
          z-index: 10;
      }

      .modal-content {
          padding: 5px 0;
      }

    </style>
@endsection

@section('header')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Data Nilai</h3>
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
            <a href="#">Nilai</a>
        </li>
        </ul>
    </div>
@endsection

@section('content')
  <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">Data Nilai Mahasiswa</h4>
            <a class="btn btn-primary btn-round ms-auto" href="{{ route('backend.nilai.create') }}">
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
                  <th>Mahasiswa</th>
                  <th>Kelas</th>
                  <th>Mata Kuliah</th>
                  <th>Total</th>
                  <th style="width: 10%">Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Mahasiswa</th>
                  <th>Kelas</th>
                  <th>Mata Kuliah</th>
                  <th>Total</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody>
              @foreach ($data as $d)                
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $d->mhs->nama }}</td>
                  <td>{{ $d->mhs->kelas->nama }}</td>
                  <td>{{ $d->matkul->nama }}</td>
                  <td>{{ $d->total }}</td>
                  <td>
                    <div class="form-button-action">
                      <a href="{{ Route('backend.nilai.edit', $d->id) }}" type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"  style="padding: 10px">
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
                              <p>Are you sure for delete data nilai {{ $d->mhs->nama }}?</p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                              <form action="{{ Route('backend.nilai.destroy', $d->id) }}"
                                  method="post">
                                  @csrf
                                  @method('delete')
                                  <button class="btn btn-primary" type="submit">Yes, Sure</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="modal fade" id="detailBackdrop{{ $d->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content shadow-lg border-0 rounded-4">

                                {{-- HEADER --}}
                                <div class="bg-primary text-white p-4 rounded-top" style="background: linear-gradient(135deg, #1e3a8a, #2563eb); margin-top: -35px;">
                                    
                                </div>

                                {{-- BODY --}}
                                <div class="modal-body p-4">

                                    {{-- MAHASISWA INFO --}}
                                    <div class="d-flex align-items-center mb-4">
                                        <img src="{{ $d->mhs->foto ? asset('img/mahasiswa/profile/'.$d->mhs->foto) : asset('assets/img/person_circle_icon_159926.png') }}" 
                                            class="rounded-circle me-3" style="object-fit: cover; width: 65px; height: 65px;">
                                        <div>
                                            <h5 class="mb-0 fw-semibold">{{ $d->mhs->nama }}</h5>
                                            <small class="text-muted">{{ $d->mhs->prodi->nama }} | {{ $d->mhs->kelas->nama ?? '-' }}</small>
                                        </div>
                                    </div>

                                    {{-- MATA KULIAH --}}
                                    <div class="mb-3 p-3 rounded shadow-sm bg-light border-start border-4 border-info">
                                        <i class="fas fa-book-open text-info me-2"></i> Mata Kuliah
                                        <div class="fw-bold">{{ $d->matkul->nama ?? '-' }}</div>
                                    </div>

                                    {{-- NILAI --}}
                                    <div class="row g-3 mb-3 text-center">

                                        <div class="col-6 col-md-4">
                                            <div class="p-2 rounded shadow-sm bg-light border-start border-4 border-primary">
                                                <i class="fas fa-clipboard-list text-primary me-1"></i> Kehadiran
                                                <div class="fw-bold">{{ $d->kehadiran ?? 0 }}</div>
                                            </div>
                                        </div>

                                        <div class="col-6 col-md-4">
                                            <div class="p-2 rounded shadow-sm bg-light border-start border-4 border-success">
                                                <i class="fas fa-file-alt text-success me-1"></i> UTS
                                                <div class="fw-bold">{{ $d->uts ?? 0 }}</div>
                                            </div>
                                        </div>

                                        <div class="col-6 col-md-4">
                                            <div class="p-2 rounded shadow-sm bg-light border-start border-4 border-danger">
                                                <i class="fas fa-file-alt text-danger me-1"></i> UAS
                                                <div class="fw-bold">{{ $d->uas ?? 0 }}</div>
                                            </div>
                                        </div>

                                        <div class="col-6 col-md-4">
                                            <div class="p-2 rounded shadow-sm bg-light border-start border-4 border-warning">
                                                <i class="fas fa-list-ul text-warning me-1"></i> Tugas
                                                <div class="fw-bold">{{ $d->tugas ?? 0 }}</div>
                                            </div>
                                        </div>

                                        <div class="col-6 col-md-4">
                                            <div class="p-2 rounded shadow-sm bg-light border-start border-4 border-secondary">
                                                <i class="fas fa-project-diagram text-secondary me-1"></i> Project
                                                <div class="fw-bold">{{ $d->project ?? 0 }}</div>
                                            </div>
                                        </div>

                                        <div class="col-6 col-md-4">
                                            <div class="p-2 rounded shadow-sm bg-light border-start border-4 border-success">
                                                <i class="fas fa-star text-success me-1"></i> Total Nilai
                                                <div class="fw-bold">{{ $d->total ?? 0 }}</div>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- TANGGAL DIBUAT --}}
                                    <div class="text-end text-muted" style="font-size: 13px;">
                                        <i class="far fa-clock me-1"></i> {{ $d->created_at->format('d M, H:i') }}
                                    </div>

                                </div>

                                {{-- FOOTER --}}
                                <div class="modal-footer border-0 justify-content-end">
                                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i> Tutup
                                    </button>
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