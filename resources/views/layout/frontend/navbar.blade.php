<nav class="navbar navbar-expand-lg extended navbar-light navbar-bg-light caret-none">
  <div class="container flex-lg-column">
    <div class="topbar d-flex flex-row w-100 justify-content-between align-items-center">
      <div class="navbar-brand"><a href="/"><img src="{{ asset('template/assets/img/logo-dark.png')}}" srcset="{{asset('template/assets/img/logo-dark@2x.png 2x')}}" alt="" /></a></div>
      <div class="navbar-other ms-auto">
        <ul class="navbar-nav flex-row align-items-center" data-sm-skip="true">
          @guest
            <li class="nav-item">
              <a class="nav-link" data-toggle="offcanvas-info">
                <i class="uil uil-info-circle"></i>
              </a>
            </li>
          @else
            <li class="nav-item dropdown language-select">
              <a class="nav-link dropdown-item dropdown-toggle" data-bs-toggle="dropdown">{{ Auth::user()->name }}</a>
                <ul class="dropdown-menu">
                  <li class="nav-item">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                      onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                          {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                    </form>
                  </li>
                </ul>
            </li>
          @endguest
          <li class="nav-item d-lg-none">
            <div class="navbar-hamburger"><button class="hamburger animate plain" data-toggle="offcanvas-nav"><span></span></button></div>
          </li>
        </ul>
        <!-- /.navbar-nav -->
      </div>
      <!-- /.navbar-other -->
    </div>
    <!-- /.d-flex -->
    <div class="navbar-collapse-wrapper bg-white d-flex flex-row align-items-center">
      <div class="navbar-collapse offcanvas-nav">
        <div class="offcanvas-header d-lg-none d-xl-none">
          <a href="./index.html"><img src="{{asset('template/assets/img/logo-light.png')}}" srcset="{{asset('template/assets/img/logo-light@2x.png 2x')}}" alt="" /></a>
          <button type="button" class="btn-close btn-close-white offcanvas-close offcanvas-nav-close" aria-label="Close"></button>
        </div>
        <ul class="navbar-nav">
          @guest
            <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
              <a class="nav-link" href="/">
                Home
              </a>
            </li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#!">Pengajuan</a>
              <ul class="dropdown-menu">
                <li class="dropdown">
                  <a class="dropdown-item" href="#">
                    Surat Keterangan Aktif Kuliah
                  </a>
                </li>
                <li class="dropdown">
                  <a class="dropdown-item" href="#">
                    Surat Izin Penelitian
                  </a>
                </li>
                <li class="dropdown">
                  <a class="dropdown-item" href="#">
                    Surat Pengantar PKL
                  </a>
                </li>
                <li class="nav-item">
                  <a class="dropdown-item" href="./pricing.html">
                    Surat Izin Dispensasi
                  </a>
                </li>
                <li class="nav-item">
                  <a class="dropdown-item" href="./onepage.html">
                    Legalisir
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#!">Riwayat Pengajuan</a>
              <ul class="dropdown-menu">
                <li class="dropdown">
                  <a class="dropdown-item" href="#">
                    Surat Keterangan Aktif Kuliah
                  </a>
                </li>
                <li class="dropdown">
                  <a class="dropdown-item" href="#">
                    Surat Izin Penelitian
                  </a>
                </li>
                <li class="dropdown">
                  <a class="dropdown-item" href="#">
                    Surat Pengantar PKL
                  </a>
                </li>
                <li class="nav-item">
                  <a class="dropdown-item" href="./pricing.html">
                    Surat Izin Dispensasi
                  </a>
                </li>
                <li class="nav-item">
                  <a class="dropdown-item" href="./onepage.html">
                    Legalisir
                  </a>
                </li>
              </ul>
            </li>
          @else 
          @role('mahasiswa')
            <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
              <a class="nav-link" href="{{route('home')}}">
                Home
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="">
                Pengajuan
              </a>
              <ul class="dropdown-menu">
                <li class="dropdown">
                  <a class="dropdown-item" href="{{route('aktif-kuliah.create')}}">
                    Surat Keterangan Aktif Kuliah
                  </a>
                </li>
                <li class="dropdown">
                  <a class="dropdown-item" href="{{route('izin-penelitian.create')}}">
                    Surat Izin Penelitian
                  </a>
                </li>
                <li class="dropdown">
                  <a class="dropdown-item" href="#">
                    Surat Pengantar PKL
                  </a>
                </li>
                <li class="nav-item">
                  <a class="dropdown-item" href="./pricing.html">
                    Surat Izin Dispensasi
                  </a>
                </li>
                <li class="nav-item">
                  <a class="dropdown-item" href="{{route('legalisir.create')}}">
                    Legalisir
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#!">Riwayat Pengajuan</a>
              <ul class="dropdown-menu">
                <li class="dropdown">
                  <a class="dropdown-item" href="#">
                    Surat Keterangan Aktif Kuliah
                  </a>
                </li>
                <li class="dropdown">
                  <a class="dropdown-item" href="#">
                    Surat Izin Penelitian
                  </a>
                </li>
                <li class="dropdown">
                  <a class="dropdown-item" href="#">
                    Surat Pengantar PKL
                  </a>
                </li>
                <li class="nav-item">
                  <a class="dropdown-item" href="./pricing.html">
                    Surat Izin Dispensasi
                  </a>
                </li>
                <li class="nav-item">
                  <a class="dropdown-item" href="./onepage.html">
                    Legalisir
                  </a>
                </li>
              </ul>
            </li>
          @endrole

          @role('alumni')
            <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
              <a class="nav-link" href="{{route('home')}}">
                Home
              </a>
            </li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#!">Pengajuan</a>
              <ul class="dropdown-menu">
                <li class="nav-item">
                  <a class="dropdown-item" href="{{route('legalisir.create')}}">
                    Legalisir
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#!">Riwayat Pengajuan</a>
              <ul class="dropdown-menu">
                <li class="nav-item">
                  <a class="dropdown-item" href="./onepage.html">
                    Legalisir
                  </a>
                </li>
              </ul>
            </li>
          @endrole

          @role('instansi')
            <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
              <a class="nav-link" href="{{route('home')}}">
                Home
              </a>
            </li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#!">Pengajuan</a>
              <ul class="dropdown-menu">
                <li class="dropdown">
                  <a class="dropdown-item" href="{{route('verifikasi-ijazah.create')}}">
                    Cek Keaslian Ijazah
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#!">Riwayat Pengajuan</a>
              <ul class="dropdown-menu">
                <li class="dropdown">
                  <a class="dropdown-item" href="#">
                    Cek Keaslian Ijazah
                  </a>
                </li>
              </ul>
            </li>
          @endrole

          @endguest

        </ul>
        <!-- /.navbar-nav -->
      </div>
      <!-- /.navbar-collapse -->
      {{-- <div class="navbar-other ms-auto w-100 d-none d-lg-block">
        <nav class="nav justify-content-end text-end">
          @guest

              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    <i class="uil uil-info-circle"></i>
                    Anda Belum Login!
                  </a>
                </li>
              </ul>

          @else
              <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                          document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
              </ul>
          @endguest
        </nav> --}}
        <!-- /.social -->
      </div>
      <!-- /.navbar-other -->
    </div>
    <!-- /.navbar-collapse-wrapper -->
  </div>
  <!-- /.container -->
</nav>
<!-- /.navbar -->