@extends('layouts.app')
@section('title')
    <title>Edit Data Nilai {{ $data->mhs->nama }} | Sistem Informasi E-learning</title>
@endsection
@section('header')
    <div class="page-header">
        <h3 class="fw-bold mb-3">Nilai Mahasiswa</h3>
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
                <a href="{{ url('/backend/materi') }}">Nilai</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="#">Edit Data</a>
            </li>
        </ul>
    </div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title">Form Edit Nilai {{ $data->mhs->nama }}</div>
        </div>
        <form action="{{ Route('backend.nilai.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div id="form-container">
                    <div class="row form-row">
                        
                        <div class="col-6">
                            <div class="form-group">
                                <label for="defaultSelect">Nama Mahasiswa</label>
                                <select class="form-select form-control @error('mhs_id') is-invalid @enderror" id="defaultSelect" value="{{ old('mhs_id') }}" name="mhs_id">
                                    <option value="">-- Pilih Nama Mahasiswa --</option>
                                    @foreach ($matkul as $p)
                                    <option value="{{ $p->id }}" {{ old('mhs_id', $data->mhs_id) == $p->id ? 'selected' : null }}>{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-6">
                            <div class="form-group">
                                <label for="defaultSelect">Mata Kuliah</label>
                                <select class="form-select form-control @error('matkul_id') is-invalid @enderror" id="defaultSelect" value="{{ old('matkul_id') }}" name="matkul_id">
                                    <option value="">-- Pilih Mata Kuliah --</option>
                                    @foreach ($matkul as $p)
                                    <option value="{{ $p->id }}" {{ old('matkul_id', $data->matkul_id) == $p->id ? 'selected' : null }}>{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">
                                <label for="kehadiran">Nilai Kehadiran</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('kehadiran') is-invalid @enderror" name="kehadiran" placeholder="Kehadiran" value="{{ old('kehadiran', $data->kehadiran) }}">
                                    @error('kehadiran')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">
                                <label for="tugas">Nilai Tugas</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('tugas') is-invalid @enderror" name="tugas" placeholder="Tugas" value="{{ old('tugas', $data->tugas) }}">
                                    @error('tugas')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">
                                <label for="uts">Nilai UTS</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('uts') is-invalid @enderror" name="uts" placeholder="UTS" value="{{ old('uts', $data->uts) }}">
                                    @error('uts')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">
                                <label for="uas">Nilai UAS</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('uas') is-invalid @enderror" name="uas" placeholder="UAS" value="{{ old('uas', $data->uas) }}">
                                    @error('uas')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">
                                <label for="project">Nilai Project</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('project') is-invalid @enderror" name="project" placeholder="Project" value="{{ old('project', $data->project) }}">
                                    @error('project')
                                        <div class="invalid invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-2">
                            <div class="form-group">
                                <label for="total">Nilai Akhir</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @error('total') is-invalid @enderror" name="total" id="total" placeholder="Nilai Akhir" 
                                        value="{{ old('total', $data->total) }}" readonly>
                                    @error('total')
                                        <div class="invalid invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        
                    </div> 
                </div>
            </div>
            <div class="card-action">
            <button class="btn btn-success">Submit</button>
            <a href="{{ url('backend/materi') }}" class="btn btn-danger">Cancel</a>
            </div>
        </form>
      </div>
    </div>
  </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#texteditor'))
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        // Ambil elemen input
        const kehadiran = document.querySelector('input[name="kehadiran"]');
        const tugas = document.querySelector('input[name="tugas"]');
        const uts = document.querySelector('input[name="uts"]');
        const uas = document.querySelector('input[name="uas"]');
        const project = document.querySelector('input[name="project"]');
        const total = document.getElementById('total');

        function hitungTotal() {
            const k = parseFloat(kehadiran.value) || 0;
            const t = parseFloat(tugas.value) || 0;
            const u = parseFloat(uts.value);
            const ua = parseFloat(uas.value);
            const p = parseFloat(project.value);

            let nilaiTotal = 0;

            if(!isNaN(u) && !isNaN(ua)) {
                // Rumus kehadiran 20%, tugas 25%, UTS 25%, UAS 30%
                nilaiTotal = k*0.2 + t*0.25 + u*0.25 + ua*0.3;
            } else if(!isNaN(p)) {
                // Rumus kehadiran 25%, tugas 25%, project 50%
                nilaiTotal = k*0.25 + t*0.25 + p*0.5;
            }

            total.value = nilaiTotal.toFixed(2); // 2 decimal
        }

        // Event listener input
        [kehadiran, tugas, uts, uas, project].forEach(input => {
            input.addEventListener('input', hitungTotal);
        });

        // Hitung sekali saat load form
        hitungTotal();
    </script>
@endsection