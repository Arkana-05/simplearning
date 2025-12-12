<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    @yield('title')
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport"/>
    <link rel="icon" href="{{ asset('https://simplearning-j968.vercel.app/assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon"/>

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>

    {{--  Fonts and icons  --}} 
    <script src="{{ asset('https://simplearning-j968.vercel.app/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
      WebFont.load({
        google: { families: ["Public Sans:300,400,500,600,700"] },
        custom: {
          families: [
            "Font Awesome 5 Solid",
            "Font Awesome 5 Regular",
            "Font Awesome 5 Brands",
            "simple-line-icons",
          ],
          urls: ["https://simplearning-j968.vercel.app/assets/css/fonts.min.css"],
        },
        active: function () {
          sessionStorage.fonts = true;
        },
      });
    </script>

    {{--  CSS Files  --}}
    <link rel="stylesheet" href="{{ asset('https://simplearning-j968.vercel.app/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('https://simplearning-j968.vercel.app/assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('https://simplearning-j968.vercel.app/assets/css/kaiadmin.min.css') }}" />

    {{--  CSS Just for demo purpose, don't include it in your project  --}}
    <link rel="stylesheet" href="{{ asset('https://simplearning-j968.vercel.app/assets/css/demo.css') }}" />
    
    {{--  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">  --}}
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


  
  </head>
  <body>
    <div class="wrapper">
      {{--  Sidebar   --}}
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          {{--  Logo Header   --}}
          <div class="logo-header" data-background-color="dark">
            <a href="{{ url('backend/dashboard')}}" class="logo">
              <img src="{{ asset('https://simplearning-j968.vercel.app/assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand" height="20" />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          {{--  End Logo Header   --}}
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item {{ (Request::is('backend/dashboard') ? 'active' : '') }}">
                <a href="{{ url('backend/dashboard') }}">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                  {{--  <span class="caret"></span>  --}}
                </a>
              </li>
              {{--  <li class="nav-item {{ (Request::is('backend/jadwal') ? 'active' : '') }}">
                <a href="{{ url('backend/jadwal-kelas') }}">
                  <i class="fas fa-calendar-alt"></i>
                  <p>Jadwal</p>
                </a>
              </li>
              <li class="nav-item {{ (Request::is('backend/absends') ? 'active' : '') }}">
                <a href="{{ url('backend/absends') }}">
                  <i class="fab fa-wpforms"></i>
                  <p>Absen</p>
                </a>
              </li>
              <li class="nav-item {{ (Request::is('backend/absen') ? 'active' : '') }}">
                <a href="{{ url('backend/absen') }}">
                  <i class="fab fa-wpforms"></i>
                  <p>Absen</p>
                </a>
              </li> --}}
              @if (Auth::user()->level == 'mhs')
            <li class="nav-item {{ (Request::is('backend/jadwalmh', 'backend/jadwalmh/create', 'backend/jadwalmh/*/edit', 'backend/detail-jadwalmh/*', 'backend/tugas-ds/*', 'backend/materi/*', 'backend/tugas-sub/create', 'backend/tugas-sub/*/edit', 'backend/tugas-submit/*', 'backend/jadwalmh-detail/*') ? 'active' : '') }}">
                <a href="{{ url('backend/jadwalmh') }}">
                  <i class="fas fa-graduation-cap"></i>
                  <p>Jadwal</p>
                </a>
              </li>
              @endif 
              {{--  @if (Auth::user()->level == 'dosen')
              <li class="nav-item {{ (Request::is('backend/ajar', 'backend/ajar/create', 'backend/ajar/*/edit', 'backend/detail-ajar/*') ? 'active' : '') }}">
                <a href="{{ url('backend/ajar') }}">
                  <i class="fas fa-users"></i>
                  <p>Data Ajar</p>
                </a>
              </li>
              @endif   --}}
              @if (Auth::user()->level == 'admin')
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Group Menu</h4>
              </li>
                <li class="nav-item {{ (Request::is('backend/dosen', 'backend/mahasiswa', 'backend/prodi', 'backend/dosen/create', 'backend/dosen/*/edit', 'backend/mahasiswa/create', 'backend/mahasiswa/*/edit', 'backend/prodi/create', 'backend/prodi/*/edit', 'backend/kelas', 'backend/kelas/create', 'backend/kelas/*/edit', 'backend/ruang', 'backend/ruang/create', 'backend/ruang/*/edit') ? 'active' : '') }}">
                  <a data-bs-toggle="collapse" href="#base">
                    <i class="fas fa-layer-group"></i>
                    <p>Data Master</p>
                    <span class="caret"></span>
                  </a>
                  <div class="{{ (Request::is('backend/dashboard', 'backend/absends', 'backend/absen', 'backend/absends/create', 'backend/absends/*/edit', 'backend/absen/create', 'backend/absen/*/edit', 'backend/jadwal', 'backend/jadwal/create', 'backend/jadwal/*/edit', 'backend/matkul', 'backend/matkul/create', 'backend/matkul/*/edit', 'backend/materi', 'backend/materi/create', 'backend/materi/*/edit', 'backend/tugas', 'backend/tugas/create', 'backend/tugas/*/edit', 'backend/tugas/*', 'backend/nilai', 'backend/nilai/create', 'backend/nilai/*/edit', 'backend/tugas-sub', 'backend/tugas-sub/create', 'backend/tugas-sub/*/edit') ? 'collapse' : '') }}" id="base">
                    <ul class="nav nav-collapse">
                      <li class="{{ (Request::is('backend/dosen', 'backend/dosen/create', 'backend/dosen/*/edit') ? 'active' : '') }}">
                        <a href="{{ url('backend/dosen') }}">
                          <span class="sub-item">Dosen</span>
                        </a>
                      </li>
                      <li class="{{ (Request::is('backend/mahasiswa', 'backend/mahasiswa/create', 'backend/mahasiswa/*/edit') ? 'active' : '') }}">
                        <a href="{{ url('backend/mahasiswa') }}">
                          <span class="sub-item">Mahasiswa</span>
                        </a>
                      </li>
                      <li class="{{ (Request::is('backend/prodi', 'backend/prodi/create', 'backend/prodi/*/edit') ? 'active' : '') }}">
                        <a href="{{ url('backend/prodi') }}">
                          <span class="sub-item">Prodi</span>
                        </a>
                      </li>
                      <li class="{{ (Request::is('backend/kelas', 'backend/kelas/create', 'backend/kelas/*/edit') ? 'active' : '') }}">
                        <a href="{{ url('backend/kelas') }}">
                          <span class="sub-item">Kelas</span>
                        </a>
                      </li>
                      <li class="{{ (Request::is('backend/ruang', 'backend/ruang/create', 'backend/ruang/*/edit') ? 'active' : '') }}">
                        <a href="{{ url('backend/ruang') }}">
                          <span class="sub-item">Ruang</span>
                        </a>
                      </li>
                      
                    </ul>
                  </div>
                </li>

              {{--  <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Data Absensi</h4>
              </li>  --}}
              <li class="nav-item {{ (Request::is('backend/absends', 'backend/absen', 'backend/absends/create', 'backend/absends/*/edit', 'backend/absen/create', 'backend/absen/*/edit') ? 'active' : '') }}">
                <a data-bs-toggle="collapse" href="#absen">
                  <i class="fas fa-clipboard-list"></i>
                  <p>Data Absensi</p>
                  <span class="caret"></span>
                </a>
                  <div class="{{ (Request::is('backend/dashboard', 'backend/dosen', 'backend/mahasiswa', 'backend/prodi', 'backend/dosen/create', 'backend/dosen/*/edit', 'backend/mahasiswa/create', 'backend/mahasiswa/*/edit', 'backend/prodi/create', 'backend/prodi/*/edit', 'backend/kelas', 'backend/kelas/create', 'backend/kelas/*/edit', 'backend/ruang', 'backend/ruang/create', 'backend/ruang/*/edit', 'backend/jadwal', 'backend/jadwal/create', 'backend/jadwal/*/edit', 'backend/matkul', 'backend/matkul/create', 'backend/matkul/*/edit', 'backend/materi', 'backend/materi/create', 'backend/materi/*/edit', 'backend/tugas', 'backend/tugas/create', 'backend/tugas/*/edit', 'backend/tugas/*', 'backend/nilai', 'backend/nilai/create', 'backend/nilai/*/edit', 'backend/tugas-sub', 'backend/tugas-sub/create', 'backend/tugas-sub/*/edit') ? 'collapse' : '') }}" id="absen">
                  <ul class="nav nav-collapse">
                    <li class="{{ (Request::is('backend/absends', 'backend/absends/create', 'backend/absends/*/edit') ? 'active' : '') }}">
                      <a href="{{ url('backend/absends') }}">
                        <span class="sub-item">Dosen</span>
                      </a>
                    </li>
                    <li class="{{ (Request::is('backend/absen', 'backend/absen/create', 'backend/absen/*/edit') ? 'active' : '') }}">
                      <a href="{{ url('backend/absen') }}">
                        <span class="sub-item">Mahasiswa</span>
                      </a>
                    </li>
                  </ul>
                  </div>
              </li>
              @endif


              @if (Auth::user()->level == 'dosen')
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Jadwal Perkuliahan</h4>
              </li>
              @endif
              @if (Auth::user()->level == 'admin')
              <li class="nav-item {{ (Request::is('backend/jadwal', 'backend/jadwal/create', 'backend/jadwal/*/edit','backend/jadwal-ds', 'backend/jadwal-ds/create', 'backend/jadwal-ds/*/edit', 'backend/absen-ds/*', 'backend/jadwal-detail/*', 'backend/materi/*', 'backend/matkul', 'backend/matkul/create', 'backend/matkul/*/edit', 'backend/materi', 'backend/materi/create', 'backend/materi/*/edit', 'backend/tugas', 'backend/tugas/create', 'backend/tugas/*/edit', 'backend/tugas/*', 'backend/nilai', 'backend/nilai/create', 'backend/nilai/*/edit', 'backend/tugas-sub', 'backend/tugas-sub/create', 'backend/tugas-sub/*/edit', 'backend/tugas-ds/*') ? 'active' : '') }}">
                <a data-bs-toggle="collapse" href="#jadwal">
                  <i class="fas fa-graduation-cap"></i>
                  <p>Jadwal</p>
                  <span class="caret"></span>
                </a>
                <div class="{{ (Request::is('backend/dashboard', 'backend/dosen', 'backend/mahasiswa', 'backend/prodi', 'backend/dosen/create', 'backend/dosen/*/edit', 'backend/mahasiswa/create', 'backend/mahasiswa/*/edit', 'backend/prodi/create', 'backend/prodi/*/edit', 'backend/kelas', 'backend/kelas/create', 'backend/kelas/*/edit', 'backend/ruang', 'backend/ruang/create', 'backend/ruang/*/edit', 'backend/absends', 'backend/absen', 'backend/absends/create', 'backend/absends/*/edit', 'backend/absen/create', 'backend/absen/*/edit', 'backend/ajar', 'backend/ajar/create', 'backend/ajar/*/edit', 'backend/detail-ajar/*', 'backend/jadwalmh') ? 'collapse' : '') }}" id="jadwal">
                  <ul class="nav nav-collapse">
                    <li class="{{ (Request::is('backend/matkul', 'backend/matkul/create', 'backend/matkul/*/edit') ? 'active' : '') }}">
                      <a href="{{ url('backend/matkul') }}">
                        <span class="sub-item">Mata Kuliah</span>
                      </a>
                    </li>
                    <li class="{{ (Request::is('backend/jadwal', 'backend/jadwal/create', 'backend/jadwal/*/edit') ? 'active' : '') }}">
                      <a href="{{ url('backend/jadwal') }}">
                        <span class="sub-item">Jadwal</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              @endif
              @if (Auth::user()->level == 'dosen')
              <li class="nav-item {{ (Request::is('backend/jadwal', 'backend/jadwal/create', 'backend/jadwal/*/edit','backend/jadwal-ds', 'backend/jadwal-ds/create', 'backend/jadwal-ds/*/edit', 'backend/absen-ds/*', 'backend/jadwal-detail/*', 'backend/materi/*', 'backend/matkul', 'backend/matkul/create', 'backend/matkul/*/edit', 'backend/materi', 'backend/materi/create', 'backend/materi/*/edit', 'backend/tugas', 'backend/tugas/create', 'backend/tugas/*/edit', 'backend/tugas/*', 'backend/nilai', 'backend/nilai/create', 'backend/nilai/*/edit', 'backend/tugas-sub', 'backend/tugas-sub/create', 'backend/tugas-sub/*/edit', 'backend/tugas-ds/*') ? 'active' : '') }}">
                <a data-bs-toggle="collapse" href="#jadwal">
                  <i class="fas fa-graduation-cap"></i>
                  <p>Jadwal</p>
                  <span class="caret"></span>
                </a>
                <div class="{{ (Request::is('backend/dashboard', 'backend/dosen', 'backend/mahasiswa', 'backend/prodi', 'backend/dosen/create', 'backend/dosen/*/edit', 'backend/mahasiswa/create', 'backend/mahasiswa/*/edit', 'backend/prodi/create', 'backend/prodi/*/edit', 'backend/kelas', 'backend/kelas/create', 'backend/kelas/*/edit', 'backend/ruang', 'backend/ruang/create', 'backend/ruang/*/edit', 'backend/absends', 'backend/absen', 'backend/absends/create', 'backend/absends/*/edit', 'backend/absen/create', 'backend/absen/*/edit', 'backend/ajar', 'backend/ajar/create', 'backend/ajar/*/edit', 'backend/detail-ajar/*', 'backend/jadwalmh') ? 'collapse' : '') }}" id="jadwal">
                  <ul class="nav nav-collapse">
                    <li class="{{ (Request::is('backend/materi', 'backend/materi/create', 'backend/materi/*/edit') ? 'active' : '') }}">
                      <a href="{{ url('backend/materi') }}">
                        <span class="sub-item">Materi</span>
                      </a>
                    </li>
                    <li class="{{ (Request::is('backend/jadwal-ds', 'backend/jadwal-ds/create', 'backend/jadwal-ds/*/edit', 'backend/absen-ds/*/*', 'backend/jadwal-detail/*', 'backend/materi/*', 'backend/tugas-ds/*') ? 'active' : '') }}">
                      <a href="{{ url('backend/jadwal-ds') }}">
                        <span class="sub-item">Jadwal</span>
                      </a>
                    </li>
                    <li class="{{ (Request::is('backend/tugas', 'backend/tugas/create', 'backend/tugas/*/edit', 'backend/tugas/*') ? 'active' : '') }}">
                      <a href="{{ url('backend/tugas') }}">
                        <span class="sub-item">Tugas</span>
                      </a>
                    </li>
                    <li class="{{ (Request::is('backend/tugas-sub', 'backend/tugas-sub/create', 'backend/tugas-sub/*/edit') ? 'active' : '') }}">
                      <a href="{{ url('backend/tugas-sub') }}">
                        <span class="sub-item">Pengumpulan Tugas</span>
                      </a>
                    </li>
                    <li class="{{ (Request::is('backend/nilai', 'backend/nilai/create', 'backend/nilai/*/edit') ? 'active' : '') }}">
                      <a href="{{ url('backend/nilai') }}">
                        <span class="sub-item">Nilai</span>
                      </a>
                    </li>
                  </ul>
                </div>
                @endif
              </li>
            </ul>
          </div>
        </div>
      </div>
      {{--  End Sidebar   --}}

      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            {{--  Logo Header   --}}
            <div class="logo-header" data-background-color="dark">
              <a href="{{ url('backend/dashboard')}}" class="logo">
                <img src="{{ asset('https://simplearning-j968.vercel.app/assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand" height="20" />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            {{--  End Logo Header   --}}
          </div>
          {{--  Navbar Header   --}}
          <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom" >
            <div class="container-fluid">
              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false" >
                    <div class="avatar-sm">
                      @if (Auth::user()->level == 'admin')
                        <img src="{{ asset('https://simplearning-j968.vercel.app/assets/img/person_circle_icon_159926.png') }}" alt="image profile" class="avatar-img rounded" />
                      @elseif (Auth::user()->level == 'dosen')
                        <img src="{{ Auth::user()->dosen->foto ? asset('https://simplearning-j968.vercel.app/img/dosen/profile/' . Auth::user()->dosen->foto) : asset('https://simplearning-j968.vercel.app/assets/img/person_circle_icon_159926.png') }}" alt="image profile" class="avatar-img rounded" />
                      @elseif (Auth::user()->level == 'mhs')
                        <img src="{{ Auth::user()->mhs->foto ? asset('https://simplearning-j968.vercel.app/img/mahasiswa/profile/' . Auth::user()->mhs->foto) : asset('https://simplearning-j968.vercel.app/assets/img/person_circle_icon_159926.png') }}" alt="image profile" class="avatar-img rounded" />
                      @endif
                      {{--  <img src="{{ asset('https://simplearning-j968.vercel.app/assets/img/person_circle_icon_159926.png') }}" alt="..." class="avatar-img rounded-circle" />  --}}
                    </div>
                    <span class="profile-username">
                      <span class="op-7">Hi,</span>
                      <span class="fw-bold">
                        @if (Auth::user()->level == 'admin')
                            Admin
                        @elseif (Auth::user()->level == 'dosen')
                            {{ Auth::user()->dosen->nama ?? 'Dosen' }}
                        @elseif (Auth::user()->level == 'mhs')
                            {{ Auth::user()->mhs->nama ?? 'Mahasiswa' }}
                        @endif
                      </span>
                    </span>
                  </a>
                  <ul class="dropdown-menu dropdown-user animated fadeIn" style="border-radius: 10px;">
                    <div class="dropdown-user-scroll scrollbar-outer">
                      <li>
                        <div class="user-box">
                          <div class="avatar-lg">
                            @if (Auth::user()->level == 'admin')
                              <img src="{{ asset('https://simplearning-j968.vercel.app/assets/img/person_circle_icon_159926.png') }}" alt="image profile" class="avatar-img rounded" />
                            @elseif (Auth::user()->level == 'dosen')
                              <img src="{{ Auth::user()->dosen->foto ? asset('https://simplearning-j968.vercel.app/img/dosen/profile/' . Auth::user()->dosen->foto) : asset('https://simplearning-j968.vercel.app/assets/img/person_circle_icon_159926.png') }}" alt="image profile" class="avatar-img rounded" />
                            @elseif (Auth::user()->level == 'mhs')
                              <img src="{{ Auth::user()->mhs->foto ? asset('https://simplearning-j968.vercel.app/img/mahasiswa/profile/' . Auth::user()->mhs->foto) : asset('https://simplearning-j968.vercel.app/assets/img/person_circle_icon_159926.png') }}" alt="image profile" class="avatar-img rounded" />
                            @endif
                          </div>
                          <div class="u-text">
                            <h4>
                              @if (Auth::user()->level == 'admin')
                                  Admin
                              @elseif (Auth::user()->level == 'dosen')
                                  {{ Auth::user()->dosen->nama ?? 'Dosen' }}
                              @elseif (Auth::user()->level == 'mhs')
                                  {{ Auth::user()->mhs->nama ?? 'Mahasiswa' }}
                              @endif
                            </h4>
                            <p class="text-muted">{{ Auth::user()->email }}</p>
                          </div>
                        </div>
                      </li>
                      <div class="dropdown-divider"></div>
                      <li>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt text-danger me-2"></i>Logout</a>
                      </li>

                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                      </form>

                    </div>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>
          {{--  End Navbar   --}}
        </div>

        {{--  dash & box  --}}
        <div class="container">
          <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4" >
              <div>
                @yield('header')
              </div>
                @yield('kelas')
            </div>

            @yield('content')
            
          </div>
        </div>

        <footer class="footer">
          <div class="container-fluid d-flex justify-content-between">
            <div class="copyright">
              {{ date('Y') }}, made with <i class="fa fa-heart heart text-danger"></i> by
              <a href="http://www.themekita.com">ThemeKita</a> 
              dimodifikasi oleh Arka
            </div>
            <div>
              Distributed by
              <a target="_blank" href="https://themewagon.com/">ThemeWagon</a>.
            </div>
          </div>
        </footer>
      </div>

    </div>

      {{--  Core JS Files     --}}
    <script src="{{ asset('https://simplearning-j968.vercel.app/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('https://simplearning-j968.vercel.app/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('https://simplearning-j968.vercel.app/assets/js/core/bootstrap.min.js') }}"></script>

    {{--  jQuery Scrollbar   --}}
    <script src="{{ asset('https://simplearning-j968.vercel.app/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

    {{--  Chart JS   --}}
    <script src="{{ asset('https://simplearning-j968.vercel.app/assets/js/plugin/chart.js/chart.min.js') }}"></script>

    {{--  jQuery Sparkline   --}}
    <script src="{{ asset('https://simplearning-j968.vercel.app/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

    {{--  Chart Circle   --}}
    <script src="{{ asset('https://simplearning-j968.vercel.app/assets/js/plugin/chart-circle/circles.min.js') }}"></script>

    {{--  Datatables   --}}
    <script src="{{ asset('https://simplearning-j968.vercel.app/assets/js/plugin/datatables/datatables.min.js') }}"></script>

    {{--  Bootstrap Notify   --}}
    <script src="{{ asset('https://simplearning-j968.vercel.app/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

    {{--  jQuery Vector Maps   --}}
    <script src="{{ asset('https://simplearning-j968.vercel.app/assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('https://simplearning-j968.vercel.app/assets/js/plugin/jsvectormap/world.js') }}"></script>

    {{--  Sweet Alert   --}}
    <script src="{{ asset('https://simplearning-j968.vercel.app/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

    {{--  Kaiadmin JS   --}}
    <script src="{{ asset('https://simplearning-j968.vercel.app/assets/js/kaiadmin.min.js') }}"></script>

    {{--  Kaiadmin DEMO methods, dont include it in your project!   --}}
    <script src="{{ asset('https://simplearning-j968.vercel.app/assets/js/setting-demo.js') }}"></script>
    <script src="{{ asset('https://simplearning-j968.vercel.app/assets/js/demo.js') }}"></script>
    
    {{--  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>  --}}
    @yield('script')
  </body>
</html>
