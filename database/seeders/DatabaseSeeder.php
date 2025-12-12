<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Absen;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Prodi;
use App\Models\Ruang;
use App\Models\Tugas;
use App\Models\Jadwal;
use App\Models\Materi;
use App\Models\Matkul;
use App\Models\Submit;
use App\Models\Mahasiswa;
use App\Models\Pertemuan;
use App\Models\Absendosen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==== USER ADMIN ====
        User::create([
            'email' => 'admin@kampus.ac.id',
            'password' => Hash::make('admin@kampus.ac.id'),
            'level' => 'admin'
        ]);

        // ==== USER DOSEN ====
        $dosen1 = User::create([
            'email' => 'karina@bsi.ac.id',
            'password' => Hash::make('karina@bsi.ac.id'),
            'level' => 'dosen'
        ]);

        $dosen2 = User::create([
            'email' => 'lucia@bsi.ac.id',
            'password' => Hash::make('lucia@bsi.ac.id'),
            'level' => 'dosen'
        ]);

        // ==== USER MAHASISWA ====
        $mhs1 = User::create([
            'email' => '19241186@bsi.ac.id',
            'password' => Hash::make('19241186@bsi.ac.id'),
            'level' => 'mhs'
        ]);

        $mhs2 = User::create([
            'email' => '19241173@bsi.ac.id',
            'password' => Hash::make('19241173@bsi.ac.id'),
            'level' => 'mhs'
        ]);

        $mhs3 = User::create([
            'email' => '19241181@bsi.ac.id',
            'password' => Hash::make('19241181@bsi.ac.id'),
            'level' => 'mhs'
        ]);

        $mhs4 = User::create([
            'email' => '19241183@bsi.ac.id',
            'password' => Hash::make('19241183@bsi.ac.id'),
            'level' => 'mhs'
        ]);

        $mhs5 = User::create([
            'email' => '19241184@bsi.ac.id',
            'password' => Hash::make('19241184@bsi.ac.id'),
            'level' => 'mhs'
        ]);

        // ==== PRODI ====
        $prodiSI = Prodi::create(['nama' => 'Sistem Informasi']);
        $prodiSIA = Prodi::create(['nama' => 'Sistem Informasi Akuntansi']);
        $prodiTI = Prodi::create(['nama' => 'Teknik Informatika']);

        // ==== KELAS ====
        $kelasA = Kelas::create(['nama' => '19.3A.13', 'prodi_id' => $prodiSI->id]);
        $kelasB = Kelas::create(['nama' => '19.3B.13', 'prodi_id' => $prodiSI->id]);
        $kelasSIA = Kelas::create(['nama' => '64.3A.13', 'prodi_id' => $prodiSIA->id]);

        // ==== DOSEN ====
        $DS1 = Dosen::create([
            'nid' => 'DS001',
            'kode_dosen' => 'KBS',
            'nama' => 'Karina Baskara',
            'email' => 'karina@bsi.ac.id',
            'user_id' => $dosen1->id,
            'foto' => ''
        ]);

        $DS2 = Dosen::create([
            'nid' => 'DS002',
            'kode_dosen' => 'KBS',
            'nama' => 'Luci Augustine',
            'email' => 'lucia@bsi.ac.id',
            'user_id' => $dosen2->id,
            'foto' => ''
        ]);

        // ==== MAHASISWA ====
        $MH1 = Mahasiswa::create([
            'foto' => '',
            'nim' => '19241186',
            'nama' => 'Arka Nuriyah',
            'email' => '19241186@bsi.ac.id',
            'prodi_id' => $prodiSI->id,
            'kelas_id' => $kelasA->id,
            'user_id' => $mhs1->id,
            'semester' => 3
        ]);
        $MH2 = Mahasiswa::create([
            'foto' => '',
            'nim' => '19241173',
            'nama' => 'Luna Putri Alya',
            'email' => '19241173@bsi.ac.id',
            'prodi_id' => $prodiSI->id,
            'kelas_id' => $kelasA->id,
            'user_id' => $mhs2->id,
            'semester' => 3
        ]);
        $MH3 = Mahasiswa::create([
            'foto' => '',
            'nim' => '19241181',
            'nama' => 'Avira Naka',
            'email' => '19241181@bsi.ac.id',
            'prodi_id' => $prodiSI->id,
            'kelas_id' => $kelasA->id,
            'user_id' => $mhs3->id,
            'semester' => 3
        ]);
        $MH4 = Mahasiswa::create([
            'foto' => '',
            'nim' => '19241183',
            'nama' => 'Melati Shahada C.',
            'email' => '19241183@bsi.ac.id',
            'prodi_id' => $prodiSI->id,
            'kelas_id' => $kelasA->id,
            'user_id' => $mhs4->id,
            'semester' => 3
        ]);
        $MH5 = Mahasiswa::create([
            'foto' => '',
            'nim' => '19241184',
            'nama' => 'Zia Fawzia Amamara',
            'email' => '19241184@bsi.ac.id',
            'prodi_id' => $prodiSI->id,
            'kelas_id' => $kelasB->id,
            'user_id' => $mhs5->id,
            'semester' => 3
        ]);

        // ==== MATAKULIAH ====
        $MK1 = Matkul::create(['kode' => 'MK001','nama' => 'Pemrograman Web','sks' => 3,'prodi_id' => $prodiSI->id]);
        $MK2 = Matkul::create(['kode' => 'MK002','nama' => 'Basis Data','sks' => 3,'prodi_id' => $prodiSI->id]);
        $MK3 = Matkul::create(['kode' => 'MK003','nama' => 'Sistem Informasi Manajemen','sks' => 3,'prodi_id' => $prodiSI->id]);
        $MK4 = Matkul::create(['kode' => 'MK004','nama' => 'Fullstack Development','sks' => 3,'prodi_id' => $prodiSI->id]);
        $MK5 = Matkul::create(['kode' => 'MK005','nama' => 'Statistika','sks' => 2,'prodi_id' => $prodiSI->id]);

        // ==== RUANG ====
        $R1 = Ruang::create(['nama' => '301']);
        $R2 = Ruang::create(['nama' => '302']);
        $R3 = Ruang::create(['nama' => '303']);

        // ==== JADWAL ====
        $JD1 = Jadwal::create([
            'hari' => 'Senin',
            'tanggal_mulai' => '2025-12-08',
            'jam_s' => '08:00',
            'jam_e' => '10:00',
            'semester' => 3,
            'ruang_id' => $R1->id,
            'matkul_id' => $MK1->id,
            'kelas_id' => $kelasB->id,
            'dosen_id' => $DS1->id,
        ]);
        $JD7 = Jadwal::create([
            'hari' => 'Senin',
            'tanggal_mulai' => '2025-12-08',
            'jam_s' => '10:00',
            'jam_e' => '12:30',
            'semester' => 3,
            'ruang_id' => $R1->id,
            'matkul_id' => $MK1->id,
            'kelas_id' => $kelasA->id,
            'dosen_id' => $DS1->id,
        ]);

        $JD2 = Jadwal::create([
            'hari' => 'Senin',
            'tanggal_mulai' => '2025-12-08',
            'jam_s' => '10:00',
            'jam_e' => '12:30',
            'ruang_id' => $R1->id,
            'matkul_id' => $MK2->id,
            'kelas_id' => $kelasA->id,
            'dosen_id' => $DS2->id,
            'semester' => 3
        ]);

        $JD3 = Jadwal::create([
            'hari' => 'Kamis',
            'tanggal_mulai' => '2025-12-11',
            'jam_s' => '10:00',
            'jam_e' => '12:30',
            'ruang_id' => $R1->id,
            'matkul_id' => $MK3->id,
            'kelas_id' => $kelasA->id,
            'dosen_id' => $DS1->id,
            'semester' => 3
        ]);

        $JD4 = Jadwal::create([
            'hari' => 'Selasa',
            'tanggal_mulai' => '2025-12-09',
            'jam_s' => '10:00',
            'jam_e' => '12:30',
            'ruang_id' => $R1->id,
            'matkul_id' => $MK4->id,
            'kelas_id' => $kelasA->id,
            'dosen_id' => $DS1->id,
            'semester' => 3
        ]);

        $JD5 = Jadwal::create([
            'hari' => 'Rabu',
            'tanggal_mulai' => '2025-12-10',
            'jam_s' => '08:00',
            'jam_e' => '10:00',
            'ruang_id' => $R1->id,
            'matkul_id' => $MK5->id,
            'kelas_id' => $kelasA->id,
            'dosen_id' => $DS1->id,
            'semester' => 3
        ]);

        $JD6 = Jadwal::create([
            'hari' => 'Jumat',
            'tanggal_mulai' => '2025-12-10',
            'jam_s' => '08:00',
            'jam_e' => '10:00',
            'ruang_id' => $R1->id,
            'matkul_id' => $MK5->id,
            'kelas_id' => $kelasB->id,
            'dosen_id' => $DS1->id,
            'semester' => 3
        ]);

        // ==== AUTO GENERATE 14 PERTEMUAN ====
        $this->makePertemuan($JD1);
        $this->makePertemuan($JD2);
        $this->makePertemuan($JD3);
        $this->makePertemuan($JD4);
        $this->makePertemuan($JD5);
        $this->makePertemuan($JD6);
        $this->makePertemuan($JD7);

        // ==== MATERI ====
        $MAT1 = Materi::create([
            'judul' => 'Intro Pemrograman Web',
            'file' => 'intro_web.pdf',
            'desc' => 'Pengenalan Web Development',
            'matkul_id' => $MK1->id,
            'kelas_id' => $kelasB->id
        ]);

        $MAT2 = Materi::create([
            'judul' => 'ERD Dasar',
            'file' => 'erd.pdf',
            'desc' => 'Entity Relationship Diagram',
            'matkul_id' => $MK2->id,
            'kelas_id' => $kelasA->id
        ]);
        
        $MAT3 = Materi::create([
            'judul' => 'Belajar FrontEnd',
            'file' => 'front.pdf',
            'desc' => 'Dasar-dasar pembuatan halaman landing page menggunakan HTML< CSS dan JavaScript',
            'matkul_id' => $MK4->id,
            'kelas_id' => $kelasA->id
        ]);


        // ==== TUGAS ====
        $TG1 = Tugas::create([
            'judul' => 'Tugas HTML',
            'desc' => 'Buat halaman HTML',
            'file' => 'file.pdf',
            'mulai' => now(),
            'deadline' => now()->addDays(7),
            'jadwal_id' => $JD1->id,
            'pertemuan_id' => Pertemuan::where('jadwal_id', $JD1->id)->first()->id,
            'kelas_id' => $kelasA->id
        ]);

        $TG2 = Tugas::create([
            'judul' => 'Jurnal Penelitian E-learning',
            'desc' => 'Buat Jurnal Penelitian E-learning',
            'file' => 'file.pdf',
            'mulai' => now(),
            'deadline' => now()->addDays(7),
            'jadwal_id' => $JD1->id,
            'pertemuan_id' => Pertemuan::where('jadwal_id', $JD1->id)->first()->id,
            'kelas_id' => $kelasB->id
        ]);

        // ==== SUBMIT TUGAS ====
        Submit::create([
            'tugas_id' => $TG1->id,
            'mhs_id' => $MH5->id,
            'file' => 'tugas1.pdf',
            'status' => 'Telat',
            'nilai' => 85
        ]);

        // ==== NILAI ====
        Nilai::create([
            'mhs_id' => $MH1->id,
            'matkul_id' => $MK1->id,
            'project' => 88,
            'kehadiran' => 88,
            'tugas' => 88,
            'uas' => 88,
            'uts' => 88,
            'total' => 88
        ]);

        // ==== ABSEN DOSEN ====
        Absendosen::create([
            'desc' => 'Membahas tentang kontrak perkuliahan',
            'file' => 'file.pdf',
            'status' => 'Hadir',
            'pertemuan_id' => Pertemuan::where('jadwal_id', $JD1->id)->first()->id,
            'jadwal_id' => $JD1->id,
            'dosen_id' => $DS2->id,
        ]);

        // ==== ABSEN MAHASISWA ====
        Absen::create([
            'status' => 'Hadir',
            'jadwal_id' => $JD1->id,
            'pertemuan_id' => Pertemuan::where('jadwal_id', $JD1->id)->first()->id,
            'mhs_id' => $MH5->id,
        ]);
    }

    private function makePertemuan($jadwal)
    {
        $tanggal = Carbon::parse($jadwal->tanggal_mulai);

        for ($i = 1; $i <= 15; $i++) {
            Pertemuan::create([
                'nama' => $i,
                'tanggal_mulai' => $tanggal->format('Y-m-d'),
                'status' => $i == 1 ? : 'Belum Mulai',
                'jadwal_id' => $jadwal->id
            ]);

            $tanggal->addDays(7);
        }
    }
}
