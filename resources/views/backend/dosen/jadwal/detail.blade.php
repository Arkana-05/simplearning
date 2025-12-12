@extends('layouts.app')
@section('title')
    <title>Detail Jadwal {{ $data->matkul->nama }} | Sistem Informasi E-learning</title>
     <style>
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.12);
            transition: all 0.3s;
        }
        .row .card.shadow-sm{
            margin-bottom: 10px;
        }

    </style>
@endsection
@section('header')
    <div class="page-header">
        <h3 class="fw-bold">Jadwal Perkuliahan </h3>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ url('/backend/dashboard') }}">
                <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="{{ url('backend/jadwal-ds') }}">Jadwal </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ $data->matkul->nama }} </a>
            </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        {{-- Card Hari & Jam --}}
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm text-center p-3" style="border-radius:15px;">
                <div class="mb-2" style="font-size:22px;">
                    <i class="fas fa-calendar-alt text-primary"></i>
                </div>
                <small class="text-muted">Hari & Jam</small>
                <h6 class="fw-bold">{{ $data->hari }}, {{ $data->jam_s }} - {{ $data->jam_e }}</h6>
            </div>
        </div>

        {{-- Card Ruang --}}
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm text-center p-3" style="border-radius:15px;">
                <div class="mb-2" style="font-size:22px;">
                    <i class="fas fa-door-open text-success"></i>
                </div>
                <small class="text-muted">Ruang</small>
                <h6 class="fw-bold">{{ $data->ruang->nama }}</h6>
            </div>
        </div>

        {{-- Card Kelas --}}
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm text-center p-3" style="border-radius:15px;">
                <div class="mb-2" style="font-size:22px;">
                    <i class="fas fa-chalkboard-teacher text-warning"></i>
                </div>
                <small class="text-muted">Kelas</small>
                <h6 class="fw-bold">{{ $data->kelas->nama }}</h6>
            </div>
        </div>

        {{-- Card Pertemuan --}}
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm text-center p-3" style="border-radius:15px;">
                <div class="mb-2" style="font-size:22px;">
                    <i class="fas fa-clipboard-check text-info"></i>
                </div>
                <small class="text-muted">Pertemuan</small>
                <h6 class="fw-bold">{{ $data->pertemuan->where('status', 'Selesai')->count() }}/{{ $data->pertemuan->count() }}</h6>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm text-center p-3" style="border-radius:15px;">
                <div class="mb-2" style="font-size:22px;">
                    <i class="fas fa-clock text-dark"></i>
                </div>
                <small class="text-muted">Status Kelas</small>
                <h6 class="fw-bold">{{ $activePertemuan->status == 'Mulai' ? 'Sedang Berlangsung' : ($data->pertemuan->first()?->status ?? 'Belum Ada Absen') }}</h6>
            </div>
        </div>

        {{-- Card Ruang --}}
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm text-center p-3" style="border-radius:15px;">
                <div class="mb-2" style="font-size:22px;">
                    <i class="fas fa-users text-secondary"></i>
                </div>
                <small class="text-muted">Jumlah Mahasiswa</small>
                <h6 class="fw-bold">{{ $data->kelas->mhs->count() }}</h6>
            </div>
        </div>

        {{-- Card Kelas --}}
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm text-center p-3" style="border-radius:15px;">
                <div class="mb-2" style="font-size:22px;">
                    <i class="fas fa-check text-success"></i>
                </div>
                <small class="text-muted">Dosen Hadir</small>
                <h6 class="fw-bold">{{ $data->absendosen->where('status', 'Hadir')->count() }}</h6>

            </div>
        </div>

        {{-- Card Pertemuan --}}
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm text-center p-3" style="border-radius:15px;">
                <div class="mb-2" style="font-size:22px;">
                    <i class="fas fa-exclamation-circle text-danger"></i>
                </div>
                <small class="text-muted">Dosen Tidak Hadir</small>
                <h6 class="fw-bold">{{ $data->absendosen->where('status', 'Tidak Hadir')->count() }}</h6>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6 col-lg-12">
            <div class="card shadow-sm mt-4" style="border-radius: 20px;">
                <div class="card-body">
                    <form action="{{ url('backend/update-status/'.$activePertemuan->id) }}" method="POST" class="d-flex align-items-center justify-content-between p-2 mb-3"> 
                        @csrf 
                        @method('PUT')
                        <input type="hidden" value="Mulai" name="status">
                        <input type="hidden" value="{{ $data->id }}" name="jadwal_id">

                        <h5 class="card-title mb-0">Data Absensi Perkuliahan</h5>
                        @if($jadwalSudahSelesai)
                            <span class="badge bg-danger p-2">Kelas sudah terlewat</span>                        
                        @else
                            @if($activePertemuan && $activePertemuan->status == 'Belum Mulai' && $bolehMulai)
                                <button type="submit" class="btn btn-primary btn-round">
                                    <i class="fas fa-play me-1"></i> Mulai
                                </button>

                            @elseif($activePertemuan && $activePertemuan->status != 'Belum Mulai')
                                <a href="{{ url('backend/absen-ds/'.$data->id.'/'.$activePertemuan->id) }}" 
                                class="btn btn-success btn-round px-3 d-flex align-items-center gap-1">
                                    <i class="fas fa-clipboard-check"></i> Absensi
                                </a>
                            @endif
                        @endif

                    </form>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle" id="add-row">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Bukti</th>
                                    <th>KDMK</th>
                                    <th>KDSN</th>
                                    <th>Status</th>
                                    <th>Nama Matkul</th>
                                    <th>Pertemuan</th>
                                    <th style="width: 10%">Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data->absendosen as $p)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><img src="{{ asset('https://simplearning-j968.vercel.app/img/dosen/absenfile/'.$p->file) ?? '-' }}" width="100px" class="mt-2" alt="bukti" id="gambar-preview"></td>
                                    <td>{{ $p->jadwal->matkul->kode }}</td> 
                                    <td>{{ $p->dosen->kode_dosen ?? '-' }}</td> 
                                    <td>{{ $p->status ?? '-' }}</td> 
                                    <td>{{ $p->jadwal->matkul->nama }}</td> 
                                    <td>{{ $p->pertemuan->nama }}</td> 
                                    <td>{!! $p->desc ?? 'Tidak ada rangkuman' !!}</td>    
                                    {{-- <td>{{ $d->absen->desc == '-' }}</td> --}}
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
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