@extends('layouts.app')
@section('title')
    <title>Detail Jadwal | Sistem Informasi E-learning</title>
    <style>
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.12);
            transition: all 0.3s;
        }
        .row .card.shadow-sm {
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('header')
    <div class="page-header">
        <h3 class="fw-bold">Jadwal Perkuliahan</h3>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="{{ url('/backend/dashboard') }}"><i class="icon-home"></i></a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="{{ url('backend/jadwal-ds') }}">Jadwal</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Absensi</a></li>
        </ul>
    </div>
@endsection
@section('kelas')
    @if($activePertemuan->absen?->status == 'Hadir' && $activePertemuan?->status == 'Belum Mulai')
        <form action="{{ url('backend/update-status/'.$activePertemuan->id) }}" method="POST" class="mt-2 ms-auto me-3"> 
            @csrf
            @method('PUT')
            <input type="hidden" value="Selesai" name="status">
            <input type="hidden" value="{{ $data->id }}" name="jadwal_id">
            <button type="submit" class="btn btn-primary px-3 d-flex align-items-center gap-1">
                <i class="fas fa-check-circle"></i> Kelas Selesai
            </button>
        </form>
    @endif
@endsection

@section('content')
<div class="container">

    
    {{-- Card Info --}}
    <div class="row mb-3">
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm text-center p-3" style="border-radius:15px;">
                <div class="mb-2" style="font-size:22px;"><i class="fas fa-calendar-alt text-primary"></i></div>
                <small class="text-muted">Hari & Jam</small>
                <h6 class="fw-bold">{{ $data->hari }}, {{ $data->jam_s }} - {{ $data->jam_e }}</h6>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm text-center p-3" style="border-radius:15px;">
                <div class="mb-2" style="font-size:22px;"><i class="fas fa-door-open text-success"></i></div>
                <small class="text-muted">Ruang</small>
                <h6 class="fw-bold">{{ $data->ruang->nama }}</h6>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm text-center p-3" style="border-radius:15px;">
                <div class="mb-2" style="font-size:22px;"><i class="fas fa-chalkboard-teacher text-warning"></i></div>
                <small class="text-muted">Kelas</small>
                <h6 class="fw-bold">{{ $data->kelas->nama }}</h6>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm text-center p-3" style="border-radius:15px;">
                <div class="mb-2" style="font-size:22px;"><i class="fas fa-clipboard-check text-info"></i></div>
                <small class="text-muted">Pertemuan</small>
                <h6 class="fw-bold">
                    {{ $data->pertemuan->where('status', 'Selesai')->count() }}/{{ $data->pertemuan->count() }}
                </h6>
            </div>
        </div>
    </div>

    {{-- Form Absen Dosen --}}
    <div class="card shadow-sm mt-4" style="border-radius: 20px;">
        <div class="card-body">
            <h5 class="fw-bold mb-3">Absensi Dosen 
                <span class="badge bg-primary">
                    {{ $activePertemuan->absen->status ?? 'Belum Absen' }}
                </span>

            </h5>

            {{-- Jika belum mulai --}}
            @if(!$activePertemuan->absen)
            <form action="{{ url('backend/absen-ds/submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6 mb-3">
                        <label for="file_bukti" class="form-label">Upload Bukti Kehadiran</label>
                        <input class="form-control @error('file') is-invalid @enderror" type="file" id="file" name="file" required>
                        @error('file')
                            <div class="invalid invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>

                    <div class="col-6 mb-3">
                        <label for="pertemuan_ke" class="form-label">Pertemuan Ke</label>
                        <select class="form-select  @error('pertemuan_id') is-invalid @enderror" name="pertemuan_id" required>
                            <option value="">-- Pilih Pertemuan ke --</option>
                            @foreach ($data->pertemuan as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                        @error('pertemuan_id')
                            <div class="invalid invalid-feedback">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi / Catatan</label>
                    <textarea class="  @error('nama') is-invalid @enderror" id="texteditor" name="desc" rows="3" placeholder="Tulis catatan..."></textarea>
                </div>

                <input type="hidden" name="dosen_id" value="{{ Auth::user()->dosen->id }}">
                <input type="hidden" name="status" value="Hadir">
                <input type="hidden" name="jadwal_id" value="{{ $data->id }}">

                <button type="submit" class="btn btn-success px-4">
                    <i class="fas fa-check-circle me-2"></i> Absen
                </button>
            </form>
            @endif

            {{-- Jika kelas selesai --}}
            @if($activePertemuan->absen?->status == 'Hadir' && $activePertemuan?->status == 'Belum Mulai')
            <div class="alert alert-warning text-center shadow-sm mt-4" role="alert" style="border-radius: 15px;"> 
                <i class="fas fa-info-circle me-2"></i> 
                Silahkan Klik Tombol Kelas Selesai untuk Mengakhiri Perkuliahan. <br> 
            </div>
            @endif
            @if($activePertemuan?->status == 'Selesai')
            <div class="alert d-flex align-items-center p-3 mt-3" 
                style="border-radius: 12px; background: #e8f7ee; border-left: 6px solid #34c759;">
                <i class="fas fa-check-circle me-3" style="font-size: 20px; color:#34c759;"></i>
                <div>
                    <h6 class="mb-1 fw-bold" style="color:#228b41;">Kelas Telah Selesai</h6>
                    <small style="color:#4f6254;">Pertemuan ini sudah ditandai selesai oleh dosen {{ $activePertemuan->absen->dosen->nama ?? '-'  }}.</small>
                </div>
            </div>
            @endif

        </div>
    </div>

    {{-- Daftar Mahasiswa --}}
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-sm" style="border-radius: 20px;">
                <div class="card-body">
                    <div class="mb-4">
                        {{--  <h5 class="fw-bold mb-1">{{ $d->judul }}</h5>  --}}
                        <p class="text-muted mb-0" style="font-size: 14px;">
                            <i class="fa fa-graduation-cap me-1"></i>
                            <span class="fw-semibold text-dark">
                                Daftar Mahasiswa - Pertemuan {{ $activePertemuan->nama }}
                            </span>
                        </p>
                    </div>
                    <div class="row g-3 mb-4">

                        {{-- MULAI --}}
                        <div class="col-md-3">
                            <div class="info-box p-3 rounded shadow-sm"
                                style="background:#f8fafc; border-left:4px solid #3b82f6;">
                                <p class="text-muted small mb-1">
                                    <i class="fa fa-users me-1 text-primary"></i> Jumlah Mahasiswa
                                </p>
                                <h6 class="fw-semibold mb-0 text-primary">
                                    {{ $data->kelas->mhs->count() }}
                                </h6>
                            </div>
                        </div>

                        {{-- DEADLINE --}}
                        <div class="col-md-3">
                            <div class="info-box p-3 rounded shadow-sm"
                                style="background:#f9fef2; border-left:4px solid #4ae02c;">
                                <p class="text-muted small mb-1">
                                    <i class="fa fa-clipboard-check me-1 text-success"></i> Hadir
                                </p>
                                <h6 class="fw-semibold text-success mb-0">
                                    {{ $hadir }}
                                </h6>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="info-box p-3 rounded shadow-sm"
                                style="background:#e9e8fe; border-left:4px solid #6644ef;">
                                <p class="text-muted small mb-1">
                                    <i class="fa fa-book me-1 text-secondary"></i> Belum Absen
                                </p>
                                <h6 class="fw-semibold mb-0 text-secondary">
                                    {{ $belumAbsen}}
                                </h6>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="info-box p-3 rounded shadow-sm"
                                style="background:#fee8e8; border-left:4px solid #ef4444;">
                                <p class="text-muted small mb-1">
                                    <i class="fa fa-info-circle me-1 text-danger"></i> Tidak Hadir
                                </p>
                                <h6 class="fw-semibold mb-0 text-danger">
                                    {{ $alfa}}
                                </h6>
                            </div>
                        </div>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="add-row">
                            <thead class="table-light text-center">
                                <tr>
                                    <th rowspan="2">No</th>
                                    <th rowspan="2" >Mahasiswa</th>
                                    <th colspan="{{ $data->pertemuan->count() }}">Pertemuan</th>
                                </tr>
                                <tr>
                                    @foreach($data->pertemuan as $p)
                                        <th>{{ $p->nama }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data->kelas->mhs as $key => $mhs)
                                    <tr class="text-center">
                                        <td>{{ $key + 1 }}</td>
                                        <td class="text-start"><strong>{{ $mhs->nama }}</strong> <br> {{ $mhs->nim }}</td>
                                        
                                        @foreach($data->pertemuan as $p)
                                            @php
                                                $absen = $p->absenmh->where('mhs_id', $mhs->id)->first();
                                            @endphp
                                            <td>
                                                @if($absen?->status == 'Hadir')
                                                    <span class="badge bg-success" data-bs-toggle="tooltip" data-bs-title="Hadir"><i class="fas fa-check-circle"></i></span>
                                                @elseif($absen?->status == 'Tidak Hadir')
                                                    <span class="badge bg-danger" data-bs-toggle="tooltip" data-bs-title="Tidak Hadir"><i class="fas fa-close-circle"></i></span>
                                                @else
                                                    <span class="badge bg-secondary" data-bs-toggle="tooltip" data-bs-title="Belum Absen"><i class="fas fa-info-circle"></i></span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#texteditor'))
            .catch(error => console.error(error));
        
        $(document).ready(function () {
            $("#add-row").DataTable();
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
