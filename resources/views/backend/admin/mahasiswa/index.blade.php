@extends('layouts.app')
@section('title')
    <title>Data Master Mahasiswa | Sistem Informasi E-learning</title>
@endsection

@section('header')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Data Mahasiswa</h3>
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
            <a href="#">Mahasiswa</a>
        </li>
        </ul>
    </div>
@endsection

@section('content')
  <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">Data Mahasiswa</h4>
            <a class="btn btn-primary btn-round ms-auto" href="{{ route('backend.mahasiswa.create') }}">
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
                  <th>NIM</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Semester</th>
                  <th style="width: 10%">Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>NIM</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Semester</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody>
              @foreach ($mahasiswa as $mhs)                
                <tr>
                  <td>{{ $mhs->nim }}</td>
                  <td>{{ $mhs->nama }}</td>
                  <td>{{ $mhs->email }}</td>
                  <td>{{ $mhs->semester }}</td>
                  <td>
                    <div class="form-button-action">
                      <a href="{{ Route('backend.mahasiswa.edit', $mhs->id) }}" type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"  style="padding: 10px">
                        <i class="fa fa-edit"></i>
                      </a>

                      <button type="button" class="btn btn-link btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $mhs->id }}" value="{{ $mhs->id }}" style="padding: 10px">
                        <i class="fa fa-times"></i>
                      </button>

                      <button type="button" class="btn btn-link btn-danger" data-bs-toggle="modal" data-bs-target="#detailBackdrop{{ $mhs->id }}" value="{{ $mhs->id }}" style="padding: 10px">
                        <i class="fa fa-eye"></i>
                      </button>

                      <div class="modal fade" id="staticBackdrop{{ $mhs->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Data </h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <p>Are you sure for delete data {{ $mhs->nama }}?</p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <form action="{{ Route('backend.mahasiswa.destroy', $mhs->id) }}"
                                  method="post">
                                  @csrf
                                  @method('delete')
                                  <button class="btn btn-primary" type="submit">Delete</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="modal fade" id="detailBackdrop{{ $mhs->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h1 class="modal-title fs-5" id="staticBackdropLabel">Detail Data {{ $mhs->nama }}</h1>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <form action="">
                                <div class="row">
                                    <!-- field lama -->
                                    <div class="col-12 mt-2">
                                      <div class="card card-profile">
                                        <div class="profile-picture" style="margin-bottom: -40px; margin-top: 20px; position: static;">
                                          <div class="avatar avatar-xl">
                                            @if ($mhs->foto)
                                            <img src="{{ asset('img/mahasiswa/profile/'. $mhs->foto ) }}" alt="..." class="avatar-img rounded-circle"/>
                                            @else
                                            <img src="{{ asset('assets/img/person_circle_icon_159926.png') }}" alt="..." class="avatar-img rounded-circle"/>
                                            @endif
                                          </div>
                                        </div>
                                        <div class="card-body">
                                          <div class="user-profile text-center">
                                            <div class="name">{{ $mhs->nama }}</div>
                                            <div class="job">{{ $mhs->email }}</div>
                                            <div class="desc">{{ $mhs->kelas->prodi->nama }} - {{ $mhs->kelas->nama }}</div>
                                          </div>
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