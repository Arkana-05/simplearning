@extends('layouts.app')
@section('title')
    <title>Data Pengumpulan Tugas Kelas {{ $data->kelas->nama }} | Sistem Informasi E-learning</title>
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
                <a href="{{ url('/backend/tugas') }}">Tugas</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Pengumpulan Tugas Kelas {{ $data->kelas->nama }}</a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
  <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">Data Pengumpulan Tugas Kelas {{ $data->jadwal->kelas->nama }}</h4>
          </div>
        </div>
        <div class="card-body">
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="info-box p-3 rounded shadow-sm"
                        style="background:#f8fafc; border-left:4px solid #3b82f6;">
                        <p class="text-muted small mb-1">
                            <i class="fa fa-users me-1 text-primary"></i> Jumlah Mahasiswa
                        </p>
                        <h6 class="fw-semibold mb-0 text-primary">
                            {{ $data->jadwal->kelas->mhs->count() }}
                        </h6>
                    </div>
                </div>

                {{-- DEADLINE --}}
                <div class="col-md-3">
                    <div class="info-box p-3 rounded shadow-sm"
                        style="background:#f9fef2; border-left:4px solid #4ae02c;">
                        <p class="text-muted small mb-1">
                            <i class="fa fa-clipboard-check me-1 text-success"></i> Tepat Waktu
                        </p>
                        <h6 class="fw-semibold text-success mb-0">
                            {{ $data->submit->where('status','Slesai')->count() }}
                        </h6>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-box p-3 rounded shadow-sm"
                        style="background:#e9e8fe; border-left:4px solid #6644ef;">
                        <p class="text-muted small mb-1">
                            <i class="fa fa-book me-1 text-secondary"></i> Terlambat
                        </p>
                        <h6 class="fw-semibold mb-0 text-secondary">
                            {{ $data->submit->where('status','Telat')->count() }}
                        </h6>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-box p-3 rounded shadow-sm"
                        style="background:#fee8e8; border-left:4px solid #ef4444;">
                        <p class="text-muted small mb-1">
                            <i class="fa fa-info-circle me-1 text-danger"></i> Tidak Mengumpulkan
                        </p>
                        <h6 class="fw-semibold mb-0 text-danger">
                            {{ $blm}}
                        </h6>
                    </div>
                </div>

            </div>
          <div class="table-responsive">
            <table id="add-row" class="display table table-striped table-hover" >
                <thead>
                    <tr>
                    <th>No</th>
                    <th>File</th>
                    <th>Mahasiswa</th>
                    <th>Mata Kuliah</th>
                    <th>Status</th>
                    <th style="width: 10%">Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                    <th>No</th>
                    <th>File</th>
                    <th>Mahasiswa</th>
                    <th>Mata Kuliah</th>
                    <th>Status</th>
                    <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                @foreach ($data->jadwal->kelas->mhs as $mhs)
                    @php
                        $submit = $mhs->submit->where('tugas_id', $data->id)->first();
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if ($submit)
                                <a href="{{ asset('img/tugas/submit/'.$submit->file) }}" target="_blank" class="fw-semibold text-info">
                                    {{ $submit->file }}
                                </a>
                            @else
                                <span class="text-muted">Belum upload</span>
                            @endif
                        </td>
                        <td>{{ $mhs->nama }}</td>
                        <td>{{ $data->jadwal->matkul->nama }}</td>
                        <td>
                            @if (!$submit)
                                <span class="badge bg-warning">Belum Mengumpulkan</span>
                            @elseif ($submit->status == 'Telat')
                                <span class="badge bg-danger">Terlambat</span>
                            @else
                                <span class="badge bg-success">Tepat Waktu</span>
                            @endif
                        </td>
                        <td>
                            <div class="form-button-action">

                                <button type="button" class="btn btn-link btn-danger" 
                                        data-bs-toggle="modal" data-bs-target="#detailTugas{{ $mhs->id }}" 
                                        style="padding: 8px;">
                                    <i class="fa fa-eye"></i>
                                </button>

                                <div class="modal fade" id="detailTugas{{ $mhs->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                                        <div class="modal-content shadow border-0" style="border-radius: 22px; overflow: hidden;">

                                            <div class="p-4 text-white" 
                                                style="background: linear-gradient(135deg, #1e40af, #1d4ed8);">
                                                <h4 class="fw-bold mb-1">
                                                    <i class="fa fa-book-open me-2"></i> Detail Tugas
                                                </h4>
                                                <small class="opacity-75">Informasi lengkap tugas & pengumpulan</small>
                                            </div>

                                            <div class="modal-body p-4">

                                                <div class="mb-4">
                                                    <h5 class="fw-bold mb-1">{{ $data->judul }}</h5>
                                                    <p class="text-muted mb-0" style="font-size: 14px;">
                                                        <i class="fa fa-graduation-cap me-1"></i>
                                                        Mata Kuliah:
                                                        <span class="fw-semibold text-dark">
                                                            {{ $data->jadwal->matkul->nama }}
                                                        </span>
                                                    </p>
                                                </div>

                                                {{-- GRID INFO --}}
                                                <div class="row g-3">

                                                    {{-- TUGAS DIMULAI --}}
                                                    <div class="col-md-4">
                                                        <div class="info-box p-3 rounded shadow-sm"
                                                            style="background:#f8fafc; border-left:4px solid #3b82f6;">
                                                            <p class="text-muted small mb-1">
                                                                <i class="fa fa-clock me-1 text-primary"></i> Tugas Dimulai
                                                            </p>
                                                            <h6 class="fw-semibold mb-0">
                                                                {{ \Carbon\Carbon::parse($data->mulai)->format('d F Y - H:i') }}
                                                            </h6>
                                                        </div>
                                                    </div>

                                                    {{-- DEADLINE --}}
                                                    <div class="col-md-4">
                                                        <div class="info-box p-3 rounded shadow-sm"
                                                            style="background:#fef2f2; border-left:4px solid #ef4444;">
                                                            <p class="text-muted small mb-1">
                                                                <i class="fa fa-hourglass-end me-1 text-danger"></i> Deadline
                                                            </p>
                                                            <h6 class="fw-semibold text-danger mb-0">
                                                                {{ \Carbon\Carbon::parse($data->deadline)->format('d F Y - H:i') }}
                                                            </h6>
                                                        </div>
                                                    </div>

                                                    {{-- JUDUL --}}
                                                    <div class="col-md-4">
                                                        <div class="info-box p-3 rounded shadow-sm"
                                                            style="background:#fefce8; border-left:4px solid #eab308;">
                                                            <p class="text-muted small mb-1">
                                                                <i class="fa fa-book me-1 text-warning"></i> Judul Tugas
                                                            </p>
                                                            <h6 class="fw-semibold mb-0">
                                                                {{ $data->judul }}
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- DESKRIPSI --}}
                                                <div class="mt-4">
                                                    <label class="fw-bold mb-2">
                                                        <i class="fa fa-align-left me-1"></i> Deskripsi Tugas:
                                                    </label>
                                                    <div class="p-3 bg-white shadow-sm border rounded" style="font-size: 14px;">
                                                        {!! $data->desc !!}
                                                    </div>
                                                </div>

                                                {{-- INFORMASI PENGUMPULAN --}}
                                                <div class="mt-4">
                                                    <h5 class="fw-bold mb-3">
                                                        <i class="fa fa-user-check me-2"></i> Informasi Pengumpulan Mahasiswa
                                                    </h5>

                                                    <div class="row g-3">

                                                        {{-- NAMA MAHASISWA --}}
                                                        <div class="col-md-6">
                                                            <div class="info-box p-3 rounded shadow-sm"
                                                                style="background:#f8fafc; border-left:4px solid #16a34a;">
                                                                <p class="text-muted small mb-1">
                                                                    <i class="fa fa-user me-1 text-success"></i> Nama Mahasiswa
                                                                </p>
                                                                <h6 class="fw-semibold mb-0">
                                                                    {{ $mhs->nama }}
                                                                </h6>
                                                            </div>
                                                        </div>

                                                        {{-- WAKTU UPLOAD --}}
                                                        <div class="col-md-6">
                                                            <div class="info-box p-3 rounded shadow-sm"
                                                                style="background:#fef2f2; border-left:4px solid #dc2626;">
                                                                <p class="text-muted small mb-1">
                                                                    <i class="fa fa-clock me-1 text-danger"></i> Waktu Upload
                                                                </p>
                                                                <h6 class="fw-semibold mb-0">
                                                                    {{ $submit ? $submit->created_at->format('d F Y - H:i') : '-' }}
                                                                </h6>
                                                            </div>
                                                        </div>

                                                        {{-- PERTEMUAN --}}
                                                        <div class="col-md-6">
                                                            <div class="info-box p-3 rounded shadow-sm"
                                                                style="background:#f8fafc; border-left:4px solid #0ea5e9;">
                                                                <p class="text-muted small mb-1">
                                                                    <i class="fa fa-layer-group me-1 text-info"></i> Pertemuan
                                                                </p>
                                                                <h6 class="fw-semibold mb-0">
                                                                    {{ $data->pertemuan->nama }}
                                                                </h6>
                                                            </div>
                                                        </div>

                                                        {{-- FILE --}}
                                                        <div class="col-6">
                                                            <div class="info-box p-3 rounded shadow-sm"
                                                                style="background:#f0f9ff; border-left:4px solid #0ea5e9;">
                                                                <p class="text-muted small mb-1">
                                                                    <i class="fa fa-file-alt me-1 text-info"></i> File Tugas
                                                                </p>

                                                                @if ($submit)
                                                                    <a href="{{ asset('img/tugas/submit/'.$submit->file) }}" target="_blank" 
                                                                        class="fw-semibold text-info">
                                                                        {{ $submit->file }}
                                                                    </a>
                                                                @else
                                                                    <span class="text-muted">Belum upload</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- FORM NILAI --}}
                                                @if ($submit)
                                                <div class="mt-4">
                                                    <h5 class="fw-bold mb-3">
                                                        <i class="fa fa-edit me-2"></i> Beri Penilaian
                                                    </h5>

                                                    <form action="{{ route('submit.nilai', $submit->id) }}" method="POST">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label class="fw-semibold">Nilai</label>
                                                            <input type="number" name="nilai" min="0" max="100"
                                                                value="{{ $submit->nilai }}"
                                                                class="form-control shadow-sm" placeholder="Masukkan nilai (0 - 100)">
                                                        </div>

                                                        <button type="submit" class="btn btn-primary px-4">
                                                            <i class="fa fa-save me-1"></i> Simpan Nilai
                                                        </button>
                                                    </form>
                                                </div>
                                                @endif

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