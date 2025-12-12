@extends('layouts.app')
@section('title')
    <title>Data Master Jadwal Kuliah | Sistem Informasi E-learning</title>
@endsection

@section('header')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Data Jadwal </h3>
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
            <a href="#">Jadwal </a>
        </li>
        </ul>
    </div>
@endsection

@section('content')
  <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">Data Jadwal Kuliah</h4>
            <a class="btn btn-primary btn-round ms-auto" href="{{ route('backend.jadwal.create') }}">
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
                  <th>Jadwal</th>
                  <th>Nama Matkul</th>
                  <th>Dosen</th>
                  <th>SKS</th>
                  <th >Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Jadwal</th>
                  <th>Nama Matkul</th>
                  <th>Dosen</th>
                  <th>SKS</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody>
              @foreach ($data as $d)                
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $d->hari }}, {{ $d->jam_s }} - {{ $d->jam_e }}</td>
                  <td>{{ $d->matkul->nama }}</td>
                  <td>{{ $d->dosen->nama }}</td>
                  <td>{{ $d->matkul->sks }}</td>
                  <td>
                    <div class="form-button-action">
                      <a href="{{ Route('backend.jadwal.edit', $d->id) }}" type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"  style="padding: 10px">
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
                              <p>Are you sure for delete data jadwal {{ $d->matkul->nama }}?</p>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                              <form action="{{ Route('backend.jadwal.destroy', $d->id) }}"
                                  method="post">
                                  @csrf
                                  @method('delete')
                                  <button class="btn btn-primary" type="submit">Yes, Sure</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <!-- Modal -->
                      <div class="modal fade" id="detailBackdrop{{ $d->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content" style="border-radius:18px; overflow:hidden; border:0;">

                            <!-- HEADER -->
                            <div style="background: linear-gradient(135deg, #4f46e5, #6366f1); padding: 32px; color: white;">
                              <span class="badge bg-light text-dark mb-2 px-3 py-1" style="font-size:12px; border-radius:6px;">
                                Detail Jadwal Mata Kuliah
                              </span>

                              <h2 class="fw-bold m-0">
                                {{ $d->matkul->nama }}
                              </h2>
                              <p class="m-0" style="opacity:0.9;">
                                {{ $d->kelas->nama }} • {{ $d->matkul->kode }} • {{ $d->matkul->sks }} SKS
                              </p>
                            </div>

                            <div class="modal-body p-4">
                              <div class="row g-4">
                                <div class="col-md-6">
                                  <div class="p-3 shadow-sm rounded-4 bg-white border" style="height:100%;">
                                    <div class="d-flex align-items-center mb-2">
                                      <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                                        <i class="fas fa-user"></i>
                                      </div>
                                      <div class="ms-3">
                                        <div class="text-muted" style="font-size:12px;">Dosen Pengampu</div>
                                        <div class="fw-semibold">{{ $d->dosen->nama }}</div>
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="col-md-6">
                                  <div class="p-3 shadow-sm rounded-4 bg-white border">
                                    <div class="d-flex align-items-center mb-2">
                                      <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                                        <i class="fas fa-door-open"></i>
                                      </div>
                                      <div class="ms-3">
                                        <div class="text-muted" style="font-size:12px;">Ruang</div>
                                        <div class="fw-semibold">{{ $d->ruang->nama }}</div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row g-4 py-4">
                                <div class="col-md-6">
                                  <div class="p-3 shadow-sm rounded-4 bg-white border">
                                    <div class="d-flex align-items-center">
                                      <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                                        <i class="fas fa-clipboard-check"></i>
                                      </div>
                                      <div class="ms-3">
                                        <div class="text-muted" style="font-size:12px;">Jumlah Pertemuan</div>
                                        <div class="fw-semibold">{{ $d->pertemuan->count() }} Pertemuan</div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="p-3 shadow-sm rounded-4 bg-white border">
                                    <div class="d-flex align-items-center">
                                      <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                                        <i class="fas fa-users"></i>
                                      </div>
                                      <div class="ms-3">
                                        <div class="text-muted" style="font-size:12px;">Mahasiswa Terdaftar</div>
                                        <div class="fw-semibold">{{ $d->kelas->mhs->count() }} Mahasiswa</div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="row g-4 mb-3">
                                <div class="col-md-6">
                                  <div class="p-3 shadow-sm rounded-4 bg-white border">
                                    <div class="d-flex align-items-center mb-2">
                                      <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                                        <i class="fas fa-calendar-check"></i>
                                      </div>
                                      <div class="ms-3">
                                        <div class="text-muted" style="font-size:12px;">Tanggal Mulai Kelas</div>
                                        <div class="fw-semibold">{{ \Carbon\Carbon::parse($d->tanggal_mulai)->format('d M Y') }}</div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="p-3 shadow-sm rounded-4 bg-white border">
                                    <div class="d-flex align-items-center mb-2">
                                      <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px;">
                                        <i class="fas fa-calendar-alt"></i>
                                      </div>
                                      <div class="ms-3">
                                        <div class="text-muted" style="font-size:12px;">Jadwal</div>
                                        <div class="fw-semibold">{{ $d->hari }}, {{ $d->jam_s }} - {{ $d->jam_e }}</div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>

                              <div class="p-4 rounded-4 shadow-sm border bg-white">
                                @php
                                  $total = $d->pertemuan->count();
                                  $selesai = $d->pertemuan->where('status', 'Selesai')->count();
                                  $progress = $total > 0 ? round (($selesai / $total) * 100) : 0;
                                @endphp

                                <div class="d-flex justify-content-between mb-2">
                                  <h6 class="fw-bold mb-0">Progress Pembelajaran</h6>
                                  <span class="fw-bold text-primary">{{ $progress }}%</span>
                                </div>

                                <div class="progress rounded-pill" style="height: 12px;">
                                  <div class="progress-bar bg-primary rounded-pill" role="progressbar" style="width: {{ $progress }}%;"></div>
                                </div>

                                <div class="text-muted mt-3" style="font-size:13px;">
                                  Perkembangan mata kuliah berdasarkan jumlah pertemuan yang telah dilaksanakan.
                                </div>

                              </div>

                            </div>

                            <div class="modal-footer border-0 p-3">
                              <button type="button" class="btn btn-primary px-4 py-2" style="border-radius:10px;" data-bs-dismiss="modal">
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