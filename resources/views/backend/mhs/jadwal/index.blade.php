@extends('layouts.app')
@section('title')
    <title>Data Jadwal Perkuliahan | Sistem Informasi E-learning</title>

    <style>
        .card-ajar, .card-jadwal {
            border-radius: 22px;
            overflow: hidden;
            background: #ffffff;
            transition: 0.25s;
        }
        .card-ajar:hover, .card-jadwal:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.12);
        }

        .ajar-header, .jadwal-header {
            position: relative;
            padding-bottom: 45px !important;
        }

        .ajar-status, .jadwal-tag {
            position: absolute;
            bottom: -18px;
            right: 20px;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: bold;
            color: white;
        }

        .jadwal-tag {
            background: rgba(255,255,255,0.25);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255,255,255,0.4);
        }

        .ajar-info div, .jadwal-info div {
            font-size: 14px;
            margin-bottom: 6px;
            color: #4b4b4b;
        }

        .glossy-progress {
            height: 10px !important;
            background: #e9f0ff;
            border-radius: 20px;
        }
        .glossy-progress .progress-bar {
            border-radius: 20px;
            box-shadow: inset 0 0 4px rgba(255,255,255,0.5);
        }

        /* Avatar Group */
        .avatar-modern-group {
            display: flex;
            align-items: center;
        }
        .avatar-modern-group img,
        .more-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 3px solid #fff;
            object-fit: cover;
            margin-left: -12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .more-avatar {
            background: #dfe9ff;
            color: #3e7bfa;
            font-weight: 700;
            font-size: 14px;
        }

        .detail-btn {
            background: #3e7bfa;
            color: white;
            border-radius: 30px;
            padding: 6px 18px;
            font-weight: 600;
            font-size: 13px;
        }
        .detail-btn:hover {
            background: #1f5de7;
        }



    </style>
@endsection

@section('header')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Jadwal Perkuliahan </h3>
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
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">{{ Auth::user()->mhs->nama }} </a>
            </li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="row">
        @foreach ($jadwal as $j)
            @php
                $total = $j->pertemuan->count();
                $selesai = $j->pertemuan->where('status', 'Selesai')->count();
                $progress = $total > 0 ? ($selesai / $total) * 100 : 0;
            @endphp
            <div class="col-md-4 mb-4">
                <div class="card-ajar border-0 shadow-lg position-relative">

                    <div class="ajar-header p-4" style="background: linear-gradient(135deg, #3e7bfa, #5b9dff);">
                        <h4 class="fw-bold text-white mb-0">{{ $j->matkul->nama }}</h4>

                        @if ($progress == 100)
                            <span class="ajar-status" style="background: #33c363;">
                                SELESAI
                            </span>

                        @elseif ($progress == 0)
                            <span class="ajar-status" style="background: #e9a834;">
                                BELUM BERJALAN
                            </span>

                        @else
                            <span class="ajar-status" style="background: #3e7bfa;">
                                BERJALAN
                            </span>
                        @endif
                    </div>

                    <div class="card-body p-4">
                        <div class="ajar-info">
                            <div>
                                <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                <strong>{{ $j->hari }}</strong>,
                                {{ $j->jam_s }} - {{ $j->jam_e }}
                            </div>

                            <div>
                                <i class="fas fa-door-open me-2 text-primary"></i>
                                Ruang: <strong>{{ $j->ruang->nama }}</strong>
                            </div>

                            <div>
                                <i class="fas fa-chalkboard-teacher me-2 text-primary"></i>
                                Kelas: <strong>{{ $j->kelas->nama }}</strong>
                            </div>

                            <div>
                                <i class="fas fa-clipboard-check me-2 text-primary"></i>
                                Pertemuan: <strong>{{ $selesai }}/{{ $total }}</strong>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <small class="fw-bold text-secondary">Progress Pertemuan</small>
                            <small class="fw-bold text-secondary">{{ round($progress) }}%</small>
                        </div>

                        <div class="progress glossy-progress mt-1">
                            <div class="progress-bar"
                                style="width: {{ $progress }}%; background: #3e7bfa;">
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-2 mt-3">

                            {{--  @if($j->canAccess)  --}}
                                @php
                                    $hariJadwal = strtolower($j->hari);
                                @endphp
                                <a href="{{ url('backend/jadwalmh-detail/'.$j->id) }}" class="btn {{ $hariJadwal == $hariSekarang ? 'btn-success' : 'btn-outline-danger' }} btn-sm px-3 d-flex align-items-center gap-1">
                                    <i class="fas fa-check-circle"></i> Masuk Kelas
                                </a>
                                <a href="{{ Route('backend.materi.show', $j->matkul_id) }}" data-bs-toggle="tooltip" data-bs-title="Materi" class="btn btn-primary btn-sm px-3 d-flex align-items-center gap-1">
                                    <i class="fas fa-clipboard-list"></i> 
                                </a>
                                <a href="{{ url('backend/tugas-ds/'.$j->id) }}" data-bs-toggle="tooltip" data-bs-title="Tugas" class="btn btn-info btn-sm px-3 d-flex align-items-center gap-1">
                                    <i class="fas fa-graduation-cap"></i> 
                                </a>
                                {{--  <form action="{{ url('backend/update-status/'.$j->pertemuan->first()->id) }}" method="POST" class="m-0"> 
                                    @csrf 
                                    @method('PUT')
                                    <input type="hidden" value="Mulai" name="status">
                                    <input type="hidden" value="{{ $j->id }}" name="jadwal_id">
                                    <button type="submit"
                                        class="btn btn-primary btn-sm px-3 d-flex align-items-center gap-1">
                                        <i class="fas fa-play"></i> Mulai
                                    </button>
                                </form>  --}}
                            {{--  @else
                                <button class="btn btn-outline-danger btn-sm px-3 d-flex align-items-center gap-1" data-bs-toggle="tooltip" data-bs-title="Belum masuk waktu kelas ({{ $j->hari }}, {{ $j->jam_s }} - {{ $j->jam_e }})"> 
                                    <i class="fas fa-ban"></i> Mulai Kelas
                                </button>
                                <a href="{{ Route('backend.materi.show', $j->matkul_id) }}" data-bs-toggle="tooltip" data-bs-title="Materi" class="btn btn-primary btn-sm px-3 d-flex align-items-center gap-1">
                                    <i class="fas fa-clipboard-list"></i> 
                                </a>
                                <a href="{{ url('backend/tugas-ds/'.$j->id) }}" data-bs-toggle="tooltip" data-bs-title="Tugas" class="btn btn-info btn-sm px-3 d-flex align-items-center gap-1">
                                    <i class="fas fa-graduation-cap"></i> 
                                </a>
                                <button class="btn btn-outline-secondary btn-sm px-3 d-flex align-items-center gap-1"
                                    data-bs-toggle="tooltip"
                                    data-bs-title="Belum masuk waktu kelas ({{ $j->hari }}, {{ $j->jam_s }} - {{ $j->jam_e }})">
                                    <i class="fas fa-lock"></i> Mulai
                                </button>
                            @endif  --}}

                        </div>


                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
@section('script')
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