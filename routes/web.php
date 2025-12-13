<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MhsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\ProdiController;
use App\Http\Controllers\RuangController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\MatkulController;
use App\Http\Controllers\SubmitController;
use App\Http\Controllers\AbsendsController;
use App\Http\Controllers\MhsRoleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenRoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class,  'index'])->name('home');
Route::prefix('backend/')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('backend.dashboard')->middleware('auth');
    Route::resource('dosen', DosenController::class)->names('backend.dosen')->middleware('auth');
    Route::resource('mahasiswa', MhsController::class)->names('backend.mahasiswa')->middleware('auth');
    Route::resource('prodi', ProdiController::class)->names('backend.prodi')->middleware('auth');
    Route::resource('kelas', KelasController::class)->names('backend.kelas')->middleware('auth');
    Route::resource('ruang', RuangController::class)->names('backend.ruang')->middleware('auth');
    Route::resource('matkul', MatkulController::class)->names('backend.matkul')->middleware('auth');
    Route::resource('jadwal', JadwalController::class)->names('backend.jadwal')->middleware('auth');
    Route::resource('absends', AbsendsController::class)->names('backend.absends')->middleware('auth');
    Route::resource('absen', AbsenController::class)->names('backend.absen')->middleware('auth');
    Route::resource('materi', MateriController::class)->names('backend.materi')->middleware('auth');
    Route::resource('tugas', TugasController::class)->names('backend.tugas')->middleware('auth');
    Route::resource('tugas-sub', SubmitController::class)->names('backend.tugas-sub')->middleware('auth');
    Route::resource('nilai', NilaiController::class)->names('backend.nilai')->middleware('auth');

    Route::get('/profile/{id}/edit', [DosenRoleController::class,  'profile'])->name('profile')->middleware('auth');
    Route::put('backend/profile', [DosenRoleController::class, 'update'])->name('backend.profile.update');
    
    // ROLE DOSEN
    Route::get('/ajar', [DosenRoleController::class,  'index'])->name('ajar')->middleware('auth');
    Route::get('/tugas-ds/{id}', [DosenRoleController::class,  'tugas'])->name('tugas')->middleware('auth');
    Route::get('/detail-ajar/{id}', [DosenRoleController::class,  'detail'])->name('detail.ajar')->middleware('auth');
    Route::get('/jadwal-detail/{id}', [DosenRoleController::class,  'detail_jadwal'])->name('jadwal.detail')->middleware('auth');
    Route::get('/jadwal-ds', [DosenRoleController::class,  'jadwal'])->name('jadwal-ds')->middleware('auth');
    Route::get('/absen-ds/{jadwal_id}/{pertemuan_id}', [DosenRoleController::class,  'absen_ds'])->name('absen-ds')->middleware('auth');
    Route::post('/absen-ds/submit', [DosenRoleController::class,  'submit_absends'])->name('submit-absends')->middleware('auth');
    Route::put('/update-status/{id}', [DosenRoleController::class,  'update_status'])->name('update-status')->middleware('auth');
    Route::post('/submit/{id}/nilai', [SubmitController::class, 'nilaistore'])->name('submit.nilai')->middleware('auth');
    Route::get('backend/check-absen/{id}', [DosenRoleController::class, 'checkAbsenAjax']);

    
    //  ROLE MHS
    Route::get('/jadwalmh-detail/{id}', [MhsRoleController::class,  'detail_jadwal'])->name('jadwalmh.detail')->middleware('auth');
    Route::get('/jadwalmh', [MhsRoleController::class,  'jadwal'])->name('jadwalmh')->middleware('auth');
    Route::get('/tugas-submit/{id}', [MhsRoleController::class,  'tugas_sub'])->name('tugas-submit')->middleware('auth');
    Route::post('/update-status-mh/{id}', [MhsRoleController::class,  'update_status'])->name('update-status-mh')->middleware('auth');

});

