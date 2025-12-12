@extends('layouts.app')
@section('title')
    <title>Detail Data Ajar Mata Kuliah {{ $data->nama }} | Sistem Informasi E-learning</title>
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
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="{{ url('backend/ajar') }}">Data Ajar</a></li>
            <li class="separator"><i class="icon-arrow-right"></i></li>
            <li class="nav-item"><a href="#">Mata Kuliah {{ $data->nama }}</a></li>
        </ul>
    </div>
@endsection

@section('content')
<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Daftar Mahasiswa Kelas {{ $data->prodi->kelas->first()->nama }}</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="add-row" class="display table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Semester</th>
                            <th>Kelas</th>
                            <th>Prodi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Semester</th>
                            <th>Kelas</th>
                            <th>Prodi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($data->prodi->mhs as $mhs)
                        <tr>
                            <td>{{ $mhs->nim }}</td>
                            <td>{{ $mhs->nama }}</td>
                            <td>{{ $mhs->email }}</td>
                            <td>{{ $mhs->semester }}</td>
                            <td>{{ $mhs->kelas->nama }}</td>
                            <td>{{ $mhs->kelas->prodi->nama }}</td>
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
        $("#add-row").DataTable();
    });
</script>
@endsection
