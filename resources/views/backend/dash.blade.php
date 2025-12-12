@extends('layouts.app')
@section('title')
    <title>Dashboard {{ Auth::user()->level }} | Sistem Informasi E-learning</title>
@endsection
@section('header')
    <h3 class="fw-bold mb-3">Dashboard</h3>
    <h6 class="op-7 mb-2">Selamat Datang di Sistem Laporan Penjualan, 
    @if (Auth::user()->level == 'admin')
        Admin
    @elseif (Auth::user()->level == 'dosen')
        {{ Auth::user()->dosen->nama ?? 'Dosen' }}
    @elseif (Auth::user()->level == 'mhs')
        {{ Auth::user()->mhs->nama ?? 'Mahasiswa' }}
    @endif!</h6>
@endsection
@section('content')
    @if (Auth::user()->level == 'admin')
        <div class="row">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Dosen</p>
                                    <h4 class="card-title">{{ $dosen }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fas fa-user-graduate"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Mahasiswa</p>
                                    <h4 class="card-title">{{ $mhs }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-book"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Mata Kuliah</p>
                                    <h4 class="card-title">{{ $matkul }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Jadwal</p>
                                    <h4 class="card-title">{{ $jadwal }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm card-round">
                    <div class="card-header">
                        <h4 class="card-title">Jadwal Hari Ini</h4>
                    </div>
                    <div class="card-body">
                        @if ($jadwal_hari_ini->count() > 0)
                            <ul class="list-group">
                                @foreach ($jadwal_hari_ini as $j)
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>{{ $j->matkul->nama }} ({{ $j->jam_s }} - {{ $j->jam_e }})</span>
                                        <span class="badge bg-primary">{{ $j->kelas->nama }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">Tidak ada jadwal hari ini.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm card-round">
                    <div class="card-header">
                        <h4 class="card-title">Dosen Baru Bergabung</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($dosen_baru as $d)
                                <li class="list-group-item d-flex justify-content-between">
                                    {{ $d->nama }}
                                    <span class="badge bg-success">Baru</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-12">
                <div class="card shadow-sm card-round">
                    <div class="card-header">
                        <h4 class="card-title">Jadwal Terbaru</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0" id="add-row">
                                <thead>
                                    <tr>
                                        <th>Mata Kuliah</th>
                                        <th>Hari</th>
                                        <th>Waktu</th>
                                        <th>Kelas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jadwal_terbaru as $j)
                                        <tr>
                                            <td>{{ $j->matkul->nama }}</td>
                                            <td>{{ $j->hari }}</td>
                                            <td>{{ $j->jam_s }} - {{ $j->jam_e }}</td>
                                            <td>{{ $j->kelas->nama }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif (Auth::user()->level == 'dosen')
        <div class="row">

            {{-- Total Jadwal --}}
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div>
                            <div class="col ms-3">
                                <p class="card-category">Total Jadwal</p>
                                <h4 class="card-title">{{ $total_jadwal }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Mata Kuliah --}}
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-book"></i>
                                </div>
                            </div>
                            <div class="col ms-3">
                                <p class="card-category">Mata Kuliah</p>
                                <h4 class="card-title">{{ $total_matkul }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Kelas --}}
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col ms-3">
                                <p class="card-category">Kelas Diajar</p>
                                <h4 class="card-title">{{ $total_kelas }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm card-round">
                    <div class="card-header">
                        <h4 class="card-title">Semua Jadwal Mengajar</h4>
                    </div>
                    <div class="card-body p-2 table-responsive">
                        <table class="table table-striped mb-0" id="add-row">
                            <thead>
                                <tr>
                                    <th>Mata Kuliah</th>
                                    <th>Hari</th>
                                    <th>Waktu</th>
                                    <th>Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jadwal_dosen as $j)
                                    <tr>
                                        <td>{{ $j->matkul->nama }}</td>
                                        <td>{{ $j->hari }}</td>
                                        <td>{{ $j->jam_s }} - {{ $j->jam_e }}</td>
                                        <td>{{ $j->kelas->nama }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm card-round">
                    <div class="card-header">
                        <h4 class="card-title">Jadwal Hari Ini</h4>
                    </div>
                    <div class="card-body">
                        @if ($jadwal_hari_ini->count())
                            <ul class="list-group">
                                @foreach ($jadwal_hari_ini as $j)
                                    <li class="list-group-item d-flex justify-content-between">
                                        <div>
                                            <strong>{{ $j->matkul->nama }}</strong><br>
                                            <small>{{ $j->jam_s }} - {{ $j->jam_e }}</small>
                                        </div>
                                        <span class="badge bg-primary">{{ $j->kelas->nama }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">Tidak ada jadwal hari ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @elseif (Auth::user()->level == 'mhs')
        <div class="row">

            {{-- Card Jumlah Mata Kuliah --}}
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-book-open"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Mata Kuliah</p>
                                    <h4 class="card-title">{{ $total_matkul ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Kelas --}}
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-door-open"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Kelas Anda</p>
                                    <h4 class="card-title">{{ Auth::user()->mhs->kelas->nama ?? '-' }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Kehadiran --}}
            <div class="col-sm-6 col-md-4">
                <div class="card card-stats card-round shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Total Kehadiran</p>
                                    <h4 class="card-title">{{ $kehadiran ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm card-round">
                    <div class="card-header">
                        <h4 class="card-title">Daftar Mata Kuliah Anda</h4>
                    </div>
                    <div class="card-body p-2">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0" id="add-row">
                                <thead>
                                    <tr>
                                        <th>Mata Kuliah</th>
                                        <th>Dosen</th>
                                        <th>Hari</th>
                                        <th>Waktu</th>
                                        <th>Kelas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jadwal_mhs as $j)
                                        <tr>
                                            <td>{{ $j->matkul->nama }}</td>
                                            <td>{{ $j->dosen->nama }}</td>
                                            <td>{{ $j->hari }}</td>
                                            <td>{{ $j->jam_s }} - {{ $j->jam_e }}</td>
                                            <td>{{ $j->kelas->nama }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm card-round">
                    <div class="card-header">
                        <h4 class="card-title">Jadwal Hari Ini</h4>
                    </div>
                    <div class="card-body">
                        @if ($jadwal_hari_ini->count() > 0)
                            <ul class="list-group">
                                @foreach ($jadwal_hari_ini as $j)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $j->matkul->nama }}</strong><br>
                                            <span class="text-muted">{{ $j->jam_s }} - {{ $j->jam_e }}</span>
                                        </div>
                                        <span class="badge bg-primary">{{ $j->kelas->nama }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">Tidak ada jadwal hari ini.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
        </div>
    @endif

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

    <script>
        $(document).ready(function () {
        
        // Add Row
        $("#add-row").DataTable({});

        });
    </script>
@endsection