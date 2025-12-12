@extends('layouts.app')
@section('title')
    <title>Data Master Kelas | Sistem Informasi E-learning</title>
@endsection

@section('header')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Data Kelas</h3>
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
            <a href="#">Kelas</a>
        </li>
        </ul>
    </div>
@endsection

@section('content')
  <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">Data Kelas</h4>
            <a class="btn btn-primary btn-round ms-auto" href="{{ route('backend.kelas.create') }}">
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
                  <th>Prodi</th>
                  <th>Nama</th>
                  <th >Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Prodi</th>
                  <th>Nama</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody>
              @foreach ($data as $d)                
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $d->prodi->nama }}</td>
                  <td>{{ $d->nama }}</td>
                  <td>
                    <div class="form-button-action">
                      <a href="{{ Route('backend.kelas.edit', $d->id) }}" type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"  style="padding: 10px">
                        <i class="fa fa-edit"></i>
                      </a>

                      <button type="button" class="btn btn-link btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop{{ $d->id }}" value="{{ $d->id }}" style="padding: 10px">
                        <i class="fa fa-times"></i>
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
                              <form action="{{ Route('backend.kelas.destroy', $d->id) }}"
                                  method="post">
                                  @csrf
                                  @method('delete')
                                  <button class="btn btn-primary" type="submit">Yes, Sure</button>
                              </form>
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