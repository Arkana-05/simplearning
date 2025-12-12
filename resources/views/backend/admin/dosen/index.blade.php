@extends('layouts.app')
@section('title')
    <title>Data Master Dosen | Sistem Informasi E-learning</title>
@endsection

@section('header')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Data Dosen</h3>
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
            <a href="#">Dosen</a>
        </li>
        </ul>
    </div>
@endsection

@section('content')
  <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">Data Dosen</h4>
            <a class="btn btn-primary btn-round ms-auto" href="{{ route('backend.dosen.create') }}">
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
                  <th>NID</th>
                  <th>Kode Dosen</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th style="width: 10%">Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>NID</th>
                  <th>Kode Dosen</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody>
              @foreach ($dosen as $d)                
                <tr>
                  <td>{{ $d->nid }}</td>
                  <td>{{ $d->kode_dosen }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>{{ $d->email }}</td>
                  <td>
                    <div class="form-button-action">
                      <a href="{{ Route('backend.dosen.edit', $d->id) }}" type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"  style="padding: 10px">
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
                              <p>Are you sure for delete data {{ $d->nama }}?</p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                              <form action="{{ Route('backend.dosen.destroy', $d->id) }}"
                                  method="post">
                                  @csrf
                                  @method('delete')
                                  <button class="btn btn-primary" type="submit">Yes, Sure</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="modal fade" id="detailBackdrop{{ $d->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Data Dosen {{ $d->nama }}</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <form action="">
                                <div class="row">
                                    <!-- field lama -->

                                    <div class="col-12 mt-2">
                                        <label><i class="fas fa-book me-2"></i><strong> Jadwal Mengajar </strong></label>
                                        <ul class="list-group mt-2 p-2">

                                            @forelse ($d->jadwal as $j)
                                                <li class="list-group-item justify-content-between">
                                                    <span class="col-1">{{ $loop->iteration }}</span>
                                                    <span class="col-7">{{ $j->matkul->nama }} - {{ $j->kelas->nama }}</span>
                                                    <span class="col-4">{{ $j->hari }} | {{ $j->jam_s }} - {{ $j->jam_e }}</span>
                                                </li>
                                            @empty
                                                <li class="list-group-item text-muted">
                                                    Tidak ada jadwal mengajar
                                                </li>
                                            @endforelse

                                        </ul>
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