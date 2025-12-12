@extends('layouts.app')
@section('title')
    <title>Pengumpulan Tugas | Sistem Informasi E-learning</title>
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
        <h3 class="fw-bold mb-3">Pengumpulan Tugas</h3>
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
            <a href="#">Pengumpulan Tugas</a>
        </li>
        </ul>
    </div>
@endsection

@section('content')
  <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">Data Pengumpulan Tugas</h4>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="add-row" class="display table table-striped table-hover" >
              <thead>
                <tr>
                  <th>No</th>
                  <th style="width: 10%">File</th>
                  <th>Mahasiswa</th>
                  <th>Matkul</th>
                  <th>Pertemuan</th>
                  <th>Pengumpulan</th>
                  <th>Status</th>
                  <th style="width: 10%">Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>File</th>
                  <th>Mahasiswa</th>
                  <th>Matkul</th>
                  <th>Pertemuan</th>
                  <th>Pengumpulan</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody>
              @foreach ($data as $d)                
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>
                     @if ($d->link) 
                          <a href="{{ $d->link }}" target="_blank">Buka Link</a>
                      @elseif ($d->file)
                          <a href="{{ asset('img/materi/'.$d->file) }}" target="_blank">Download File</a>
                      @else
                          <span class="text-danger">Tidak ada file/link</span>
                      @endif
                  </td>
                  <td>{{ $d->mhs->nama }}</td>
                  <td>{{ $d->tugas->jadwal->matkul->nama }}</td>
                  <td>{{ $d->tugas->pertemuan->nama }}</td>
                  <td>{{ $d->created_at->format('d M Y') }}</td>
                  @if($d->status == 'Telat')
                    <td><span class="badge badge-danger mb-1" style="border-radius: 50px;">{{ $d->status }}</span></td>
                  @elseif($d->status == 'Pending')
                    <td><span class="badge badge-warning mb-1" style="border-radius: 50px;">{{ $d->status }}</span></td>
                  @else()
                    <td><span class="badge badge-success mb-1" style="border-radius: 50px;">{{ $d->status }}</span></td>
                  @endif
                  <td>
                    <div class="form-button-action">

                      <button type="button" class="btn btn-link btn-danger" data-bs-toggle="modal" data-bs-target="#detailTugas{{ $d->id }}" style="padding: 8px;">
                          <i class="fa fa-eye"></i>
                      </button>

                      <div class="modal fade" id="detailTugas{{ $d->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
                          <div class="modal-content shadow border-0 rounded-3">
                            <div class="modal-body p-4">
                              <div class="mt-4">
                                <h5 class="fw-bold mb-3">
                                    <i class="fa fa-edit me-2"></i> Beri Penilaian
                                </h5>

                                <form action="{{ route('submit.nilai', $d->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="fw-semibold">Nilai</label>
                                        <input type="number" name="nilai" min="0" max="100" value="{{ $d->nilai }}" class="form-control shadow-sm" placeholder="Masukkan nilai (0 - 100)">
                                    </div>

                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fa fa-save me-1"></i> Simpan Nilai
                                    </button>
                                </form>
                              </div>
                            </div>

                            {{-- FOOTER --}}
                            <div class="modal-footer border-0 p-3">
                                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                                    <i class="fa fa-times me-1"></i> Tutup
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