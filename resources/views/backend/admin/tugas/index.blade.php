@extends('layouts.app')
@section('title')
    <title>Tugas | Sistem Informasi E-learning</title>
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
        <h3 class="fw-bold mb-3">Data Tugas</h3>
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
            <a href="#">Tugas</a>
        </li>
        </ul>
    </div>
@endsection

@section('content')
  <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">Data Tugas</h4>
            <a class="btn btn-primary btn-round ms-auto" href="{{ route('backend.tugas.create') }}">
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
                  <th>File</th>
                  <th>Judul</th>
                  <th>Mata Kuliah</th>
                  <th>Kelas</th>
                  <th style="width: 10%">Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>File</th>
                  <th>Judul</th>
                  <th>Mata Kuliah</th>
                  <th>Kelas</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody>
              @foreach ($data as $d)                
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td><a href="{{ asset('img/tugas/'.$d->file) }}" target="_blank">Download File</a></td>
                  <td>{{ $d->judul }}</td>
                  <td>{{ $d->jadwal->matkul->nama }}</td>
                  <td>{{ $d->jadwal->kelas->nama }}</td>
                  <td>
                    <div class="form-button-action">
                      <a href="{{ Route('backend.tugas.edit', $d->id) }}" type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"  style="padding: 10px">
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
                              <p>Are you sure for delete data tugas {{ $d->judul }}?</p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                              <form action="{{ Route('backend.tugas.destroy', $d->id) }}"
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
                            <div class="modal-content shadow border-0 rounded-4" style="overflow:hidden;">

                                {{-- HEADER --}}
                                <div class="p-4 text-white" style="background: linear-gradient(135deg, #1e3a8a, #2563eb); margin-top: -10px">
                                    <h5 class="fw-bold mb-1">
                                        <i class="fas fa-book-open me-2"></i>{{ $d->judul }}
                                    </h5>
                                    <small class="opacity-75">Detail Informasi Tugas</small>
                                </div>

                                {{-- BODY --}}
                                <div class="modal-body p-4">

                                    {{-- GRID --}}
                                    <div class="row g-3">

                                        {{-- MATA KULIAH --}}
                                        <div class="col-md-6">
                                            <div class="p-3 rounded shadow-sm bg-light"
                                                style="border-left:4px solid #2563eb;">
                                                <p class="text-muted small mb-1">
                                                    <i class="fas fa-graduation-cap me-1 text-primary"></i>Mata Kuliah
                                                </p>
                                                <h6 class="fw-semibold mb-0">{{ $d->pertemuan->jadwal->matkul->nama }}</h6>
                                            </div>
                                        </div>

                                        {{-- FILE --}}
                                        <div class="col-md-6">
                                            <div class="p-3 rounded shadow-sm bg-light"
                                                style="border-left:4px solid #0ea5e9;">
                                                <p class="text-muted small mb-1">
                                                    <i class="fas fa-file-alt me-1 text-info"></i>Intruksi Tugas
                                                </p>
                                                <a href="{{ asset('img/tugas/'.$d->file) }}" 
                                                  target="_blank" class="fw-semibold text-info">
                                                    {{ $d->file }}
                                                </a>
                                            </div>
                                        </div>

                                        {{-- UPLOAD --}}
                                        <div class="col-md-6">
                                            <div class="p-3 rounded shadow-sm bg-light"
                                                style="border-left:4px solid #ef4444;">
                                                <p class="text-muted small mb-1">
                                                    <i class="fas fa-calendar-alt me-1 text-danger"></i>Diunggah Pada
                                                </p>
                                                <h6 class="fw-semibold mb-0">
                                                    {{ $d->created_at->format('d M Y') }}
                                                </h6>
                                            </div>
                                        </div>

                                        {{-- PENGUMPULAN --}}
                                        <div class="col-md-6">
                                            <div class="p-3 rounded shadow-sm bg-light"
                                                style="border-left:4px solid #eab308;">
                                                <p class="text-muted small mb-1">
                                                    <i class="fas fa-link me-1 text-warning"></i>Pengumpulan Tugas
                                                </p>
                                                <a href="{{ url('backend/tugas/'.$d->id) }}" 
                                                  class="fw-semibold text-warning">
                                                    Data Pengumpulan Tugas
                                                </a>
                                            </div>
                                        </div>

                                    </div>

                                    {{-- DESKRIPSI --}}
                                    <div class="mt-4">
                                        <label class="fw-bold mb-2">
                                            <i class="fas fa-align-left me-1"></i>Deskripsi Materi
                                        </label>
                                        <div class="p-3 bg-white border rounded shadow-sm" style="font-size:14px; line-height:1.5;">
                                            {!! $d->desc !!}
                                        </div>
                                    </div>

                                </div>

                                {{-- FOOTER --}}
                                <div class="modal-footer border-0 p-3">
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

          {{--  <div class="tab-content" id="pills-tabContent">

            <div class="tab-pane fade {{ $activeTab == 'tugas' ? 'show active' : '' }}" id="pills-tugas" role="tabpanel">
            </div>

            <div class="tab-pane fade {{ $activeTab == 'pengumpulan' ? 'show active' : '' }}" id="tab-pengumpulan" role="tabpanel">

            <!-- Table Pengumpulan -->
            <div class="table-responsive">
                <table id="add-row2" class="display table table-striped table-hover">
                    <thead>
                      <tr>
                          <th>No</th>
                          <th>Mahasiswa</th>
                          <th>Kelas</th>
                          <th>Tugas</th>
                          <th>File</th>
                          <th>Tgl Upload</th>
                          <th>Status</th>
                          <th>Detail</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($data as $tugas)
                       @foreach ($tugas->kelas->mhs as $p)
                      <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $p->nama }}</td>
                          <td>{{ $p->kelas->nama }}</td>
                          <td>{{ $p->kelas->judul }}</td>
                          <td><a href="{{ asset('file/tugas/'.$p->file) }}" target="_blank">{{ $p->file }}</a></td>
                          <td>{{ $p->created_at->format('d M Y H:i') }}</td>

                          <td>
                              @if ($p->status == 'Telat')
                                  <span class="badge bg-danger">Terlambat</span>
                              @elseif ($p->status == 'Pending')
                                  <span class="badge bg-warning">Belum Mengumpulkan</span>
                              @else
                                  <span class="badge bg-success">Tepat Waktu</span>
                              @endif
                          </td>

                          <td>
                              <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailKumpul{{ $p->id }}">
                                  <i class="fa fa-eye"></i>
                              </button>
                          </td>
                      </tr>

                      <!-- MODAL DETAIL -->
                      <div class="modal fade" id="detailKumpul{{ $p->id }}">
                          <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content p-3">
                                  
                                  <h5 class="fw-bold mb-2">{{ $p->mhs->nama }}</h5>
                                  <p><b>Kelas:</b> {{ $p->tugas->kelas->nama }}</p>
                                  <p><b>Tugas:</b> {{ $p->tugas->judul }}</p>
                                  <p><b>File:</b> <a href="{{ asset('file/tugas/'.$p->file) }}" target="_blank">{{ $p->file }}</a></p>
                                  <p><b>Diupload:</b> {{ $p->created_at->format('d M Y H:i') }}</p>
                                  <p><b>Status:</b> 
                                      @if ($p->created_at > $p->tugas->deadline)
                                          <span class="badge bg-danger">Terlambat</span>
                                      @else
                                          <span class="badge bg-success">Tepat Waktu</span>
                                      @endif
                                  </p>

                                  <button type="button" class="btn btn-secondary mt-2" data-bs-dismiss="modal">Close</button>
                              </div>
                          </div>
                      </div>
                      @endforeach
                      @endforeach
                  </tbody>

                </table>
            </div>

          </div>  --}}
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
    <script>
        $(document).ready(function () {
        
        // Add Row
        $("#add-row2").DataTable({});

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