@extends('layouts.app')
@section('title')
    <title>Materi | Sistem Informasi E-learning</title>
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
        <h3 class="fw-bold mb-3">Data Materi</h3>
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
            <a href="#">Materi</a>
        </li>
        </ul>
    </div>
@endsection

@section('content')
  <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">Data Materi</h4>
            <a class="btn btn-primary btn-round ms-auto" href="{{ route('backend.materi.create') }}">
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
                  {{--  <th>Kelas</th>  --}}
                  <th style="width: 10%">Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>File</th>
                  <th>Judul</th>
                  <th>Mata Kuliah</th>
                  {{--  <th>Kelas</th>  --}}
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody>
              @foreach ($data as $d)                
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td><a href="{{ asset('https://simplearning-j968.vercel.app/img/materi/'.$d->file) }}" target="_blank">Download File</a></td>
                  <td>{{ $d->judul }}</td>
                  <td>{{ $d->matkul->nama }}</td>
                  {{--  <td>{{ $d->kelas->nama }}</td>  --}}
                  <td>
                    <div class="form-button-action">
                      <a href="{{ Route('backend.materi.edit', $d->id) }}" type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"  style="padding: 10px">
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
                              <p>Are you sure for delete data materi {{ $d->matkul->nama }}?</p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                              <form action="{{ Route('backend.materi.destroy', $d->id) }}"
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
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 18px; overflow: hidden;">

                                {{-- HEADER --}}
                                <div class="p-4 bg-white border-bottom">
                                    <h4 class="fw-bold mb-1" style="color:#1f2937;">
                                        {{ $d->judul ?? 'Materi E-learning' }}
                                    </h4>
                                    <small class="text-secondary">Detail materi e-learning</small>
                                </div>

                                {{-- BODY --}}
                                <div class="modal-body p-4">

                                    {{-- GRID CARD --}}
                                    <div class="row g-3">

                                        {{-- MATA KULIAH --}}
                                        <div class="col-md-4">
                                            <div class="d-flex p-3 bg-white shadow-sm rounded"
                                                style="border:1px solid #e5e7eb; border-radius:14px;">

                                                <div class="me-3 d-flex align-items-center justify-content-center"
                                                    style="width:46px;height:46px;border-radius:12px;background:#eef2ff;">
                                                    <i class="fas fa-graduation-cap" style="color:#4f46e5;font-size:18px;"></i>
                                                </div>

                                                <div>
                                                    <div class="text-muted small">Mata Kuliah</div>
                                                    <div class="fw-semibold">{{ $d->matkul->nama }}</div>
                                                </div>

                                            </div>
                                        </div>

                                        {{-- FILE --}}
                                        <div class="col-md-4">
                                            <div class="d-flex p-3 bg-white shadow-sm rounded"
                                                style="border:1px solid #e5e7eb; border-radius:14px;">

                                                <div class="me-3 d-flex align-items-center justify-content-center"
                                                    style="width:46px;height:46px;border-radius:12px;background:#fef3c7;">
                                                    <i class="fas fa-file-alt" style="color:#d97706;font-size:18px;"></i>
                                                </div>

                                                <div>
                                                    <div class="text-muted small">File Materi</div>
                                                    <a href="{{ asset('https://simplearning-j968.vercel.app/img/materi/'.$d->file) }}" target="_blank"
                                                      class="fw-semibold text-decoration-none" style="color:#2563eb;">
                                                      {{ $d->file }}
                                                    </a>
                                                </div>

                                            </div>
                                        </div>

                                        {{-- TANGGAL UPLOAD --}}
                                        <div class="col-md-4">
                                            <div class="d-flex p-3 bg-white shadow-sm rounded"
                                                style="border:1px solid #e5e7eb; border-radius:14px;">

                                                <div class="me-3 d-flex align-items-center justify-content-center"
                                                    style="width:46px;height:46px;border-radius:12px;background:#dcfce7;">
                                                    <i class="fas fa-calendar-alt" style="color:#16a34a;font-size:18px;"></i>
                                                </div>

                                                <div>
                                                    <div class="text-muted small">Tanggal Upload</div>
                                                    <div class="fw-semibold">{{ $d->created_at->format('d M Y') }}</div>
                                                </div>

                                            </div>
                                        </div>

                                    </div> {{-- END GRID --}}

                                    {{-- DESKRIPSI --}}
                                    <div class="mt-4">
                                        <div class="fw-semibold mb-2" style="color:#111827;">
                                            <i class="fas fa-align-left me-1"></i> Deskripsi
                                        </div>

                                        <div class="p-3 bg-white shadow-sm"
                                            style="border-radius:14px; border:1px solid #e5e7eb; font-size:14px;">
                                            {!! $d->desc !!}
                                        </div>
                                    </div>

                                </div>

                                {{-- FOOTER --}}
                                <div class="modal-footer border-0 p-3">
                                    <button class="btn btn-primary btn-round px-4" data-bs-dismiss="modal" style="border-radius:10px;">
                                        Tutup
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