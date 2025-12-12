@extends('layouts.app')
@section('title')
    <title>Data Ajar | Sistem Informasi E-learning</title>

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
            background: linear-gradient(135deg, #3e7bfa, #5b9dff);
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
        <h3 class="fw-bold mb-3">Data Ajar </h3>
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
            <a href="#">Ajar </a>
        </li>
        </ul>
    </div>
@endsection

@section('content')
<div class="row">
@foreach ($jadwal as $j)
<div class="col-md-4 mb-4">
    <div class="card-ajar border-0 shadow-lg position-relative">

        <div class="ajar-header p-4">
            <h4 class="fw-bold text-white mb-0">{{ $j->matkul->nama }}</h4>
            <span class="ajar-status" style="background: {{ $j->status_info[1] }};">
                {{ $j->status_info[0] }}
            </span>
        </div>

        <div class="card-body p-4">

            <div class="ajar-info">
                <div><i class="fas fa-calendar-alt me-2 text-primary"></i>
                    {{ $j->hari }}, {{ $j->jam_s }} - {{ $j->jam_e }}
                </div>
                <div><i class="fas fa-chalkboard me-2 text-primary"></i>
                    Kelas: <strong>{{ $j->kelas->nama }}</strong>
                </div>
                <div><i class="fas fa-door-open me-2 text-primary"></i>
                    Ruang: <strong>{{ $j->ruang->nama }}</strong>
                </div>
                <div><i class="fas fa-book-open me-2 text-primary"></i>
                    SKS: <strong>{{ $j->matkul->sks }}</strong>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-3">
                <small class="fw-bold text-secondary">Progress</small>
                <small class="fw-bold text-secondary">{{ $j->progress_text }}%</small>
            </div>

            <div class="progress glossy-progress mt-1">
                <div class="progress-bar"
                    style="width: {{ $j->progress }}%; background: {{ $j->status_info[1] }};">
                </div>
            </div>

            <div class="d-flex align-items-center mt-4">

                <div class="avatar-modern-group">
                    @foreach ($j->mahasiswaList->take($j->limitShow) as $m)
                        <img src="{{ $m->foto ? asset('img/mahasiswa/profile/'.$m->foto) : asset('assets/img/person_circle_icon_159926.png') }}">
                    @endforeach

                    @if ($j->mahasiswaList->count() > $j->limitShow)
                        <span class="more-avatar">
                            +{{ $j->mahasiswaList->count() - $j->limitShow }}
                        </span>
                    @endif
                </div>

                <a href="{{ url('backend/detail-ajar/'.$j->matkul->id) }}"
                   class="detail-btn ms-auto">Detail</a>
            </div>

        </div>
    </div>
</div>

@endforeach
</div>
@endsection
