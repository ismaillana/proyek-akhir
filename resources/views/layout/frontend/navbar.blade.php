<header class="wrapper bg-dark">
  <nav class="navbar navbar-expand-lg center-nav transparent navbar-dark">
    <div class="container flex-lg-row flex-nowrap align-items-center">
      <div class="navbar-brand w-100">
        <a href="./index.html">
          <img class="logo-dark" src="{{ asset('template/assets/img/logoPOLSUB.png')}}" srcset="{{ asset('template/assets/img/logoPOLSUB.png 2x')}}" alt="" width="10%" />
          
          <img class="logo-light" src="{{ asset('template/assets/img/logoPOLSUB.png')}}" srcset="{{ asset('template/assets/img/logoPOLSUB.png 2x')}}" alt="" width="10%" />
          POLSUB
        </a>
      </div>
      <div class="navbar-collapse offcanvas-nav">
        <div class="offcanvas-header d-lg-none d-xl-none">
          <a href="/index.html">
            <img src="{{ asset('template/assets/img/logoPOLSUB.png')}}" srcset="{{ asset('template/assets/img/logoPOLSUB.png 2x')}}" alt="" width="10%" />
            POLSUB
          </a>
          <button type="button" class="btn-close btn-close-white offcanvas-close offcanvas-nav-close" aria-label="Close"></button>
        </div>
        <ul class="navbar-nav">
        @guest
          <li class="nav-item">
            <a class="nav-link" href="/">
              Beranda
            </a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              Pengajuan
            </a>
            <ul class="dropdown-menu">
              <li class="dropdown">
                <a class="dropdown-item" href="{{ route('pengajuan.aktif-kuliah.index') }}">
                  Surat Keterangan Aktif Kuliah
                </a>
              </li>

              <li class="dropdown">
                <a class="dropdown-item" href="{{route('pengajuan.pengantar-pkl.index')}}">
                  Surat Pengantar PKL
                </a>
              </li>

              <li class="dropdown">
                <a class="dropdown-item" href="{{route('pengajuan.izin-penelitian.index')}}">
                  Surat Izin Penelitian
                </a>
              </li>

              <li class="nav-item">
                <a class="dropdown-item" href="{{route('pengajuan.dispensasi.index')}}">
                  Surat Dispensasi
                </a>
              </li>

              <li class="nav-item">
                <a class="dropdown-item" href="{{route('pengajuan.legalisir.index')}}">
                  Legalisir
                </a>
              </li>

              <li class="nav-item">
                <a class="dropdown-item" href="{{route('pengajuan.verifikasi-ijazah.index')}}">
                  Cek Keaslian Ijazah
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              Riwayat Pengajuan
            </a>
            <ul class="dropdown-menu">
              <li class="dropdown">
                <a class="dropdown-item" href="{{route('pengajuan.riwayat-aktif-kuliah')}}">
                  Surat Keterangan Aktif Kuliah
                </a>
              </li>

              <li class="dropdown">
                <a class="dropdown-item" href="{{route('pengajuan.riwayat-pengantar-pkl')}}">
                  Surat Pengantar PKL
                </a>
              </li>

              <li class="dropdown">
                <a class="dropdown-item" href="{{route('pengajuan.riwayat-izin-penelitian')}}">
                  Surat Izin Penelitian
                </a>
              </li>

              <li class="nav-item">
                <a class="dropdown-item" href="{{route('pengajuan.riwayat-dispensasi')}}">
                  Surat Dispensasi
                </a>
              </li>

              <li class="nav-item">
                <a class="dropdown-item" href="{{route('pengajuan.riwayat-legalisir')}}">
                  Legalisir
                </a>
              </li>

              <li class="nav-item">
                <a class="dropdown-item" href="{{route('pengajuan.riwayat-verifikasi-ijazah')}}">
                  Cek Keaslian Ijazah
                </a>
              </li>
            </ul>
          </li>
        @else

        @role('mahasiswa')
          <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
            <a class="nav-link" href="{{route('home')}}">
              Beranda
            </a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              Pengajuan
            </a>
            <ul class="dropdown-menu">
              <li class="dropdown">
                <a class="dropdown-item" href="{{route('pengajuan.aktif-kuliah.index')}}">
                  Surat Keterangan Aktif Kuliah
                </a>
              </li>

              <li class="dropdown">
                <a class="dropdown-item" href="{{route('pengajuan.pengantar-pkl.index')}}">
                  Surat Pengantar PKL
                </a>
              </li>

              <li class="dropdown">
                <a class="dropdown-item" href="{{route('pengajuan.izin-penelitian.index')}}">
                  Surat Izin Penelitian
                </a>
              </li>

              <li class="nav-item">
                <a class="dropdown-item" href="{{route('pengajuan.dispensasi.index')}}">
                  Surat Dispensasi
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" >
              Riwayat Pengajuan
            </a>
            <ul class="dropdown-menu">
              <li class="dropdown">
                <a class="dropdown-item" href="{{route('pengajuan.riwayat-aktif-kuliah')}}">
                  Surat Keterangan Aktif Kuliah
                </a>
              </li>

              <li class="dropdown">
                <a class="dropdown-item" href="{{route('pengajuan.riwayat-pengantar-pkl')}}">
                  Surat Pengantar PKL
                </a>
              </li>

              <li class="dropdown">
                <a class="dropdown-item" href="{{route('pengajuan.riwayat-izin-penelitian')}}">
                  Surat Izin Penelitian
                </a>
              </li>

              <li class="nav-item">
                <a class="dropdown-item" href="{{route('pengajuan.riwayat-dispensasi')}}">
                  Surat Dispensasi
                </a>
              </li>
            </ul>
          </li>
        @endrole

        @role('alumni')
          <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
            <a class="nav-link" href="{{route('home')}}">
              Beranda
            </a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              Pengajuan
            </a>
            <ul class="dropdown-menu">
              <li class="nav-item">
                <a class="dropdown-item" href="{{route('pengajuan.legalisir.index')}}">
                  Legalisir
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              Riwayat Pengajuan
            </a>
            <ul class="dropdown-menu">
              <li class="nav-item">
                <a class="dropdown-item" href="{{route('pengajuan.riwayat-legalisir')}}">
                  Legalisir
                </a>
              </li>
            </ul>
          </li>
        @endrole

        @role('instansi')
          <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
            <a class="nav-link" href="{{route('home')}}">
              Beranda
            </a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              Pengajuan
            </a>
            <ul class="dropdown-menu">
              <li class="nav-item">
                <a class="dropdown-item" href="{{route('pengajuan.verifikasi-ijazah.index')}}">
                  Cek Keaslian Ijazah
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              Riwayat Pengajuan
            </a>
            <ul class="dropdown-menu">
              <li class="nav-item">
                <a class="dropdown-item" href="{{route('pengajuan.riwayat-verifikasi-ijazah')}}">
                  Cek Keaslian Ijazah
                </a>
              </li>
            </ul>
          </li>
        @endrole
        @endguest
      </div>

      <div class="navbar-other w-100 d-flex ms-auto">
        <ul class="navbar-nav flex-row align-items-center ms-auto" data-sm-skip="true">
          @guest
            <li class="nav-item dropdown language-select text-uppercase">
              <a class="nav-link" title="belum login !">
                <i class="uil uil-info-circle"></i>
              </a>
            </li>
          @else
            <li class="nav-item dropdown language-select">
              <a class="nav-link dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Akun
              </a>
              <ul class="dropdown-menu">
                @role('mahasiswa|alumni')
                  <li class="nav-item">
                    <a class="dropdown-item" href="{{ route('profil-mahasiswa') }}">
                      Profil
                    </a>
                  </li>
                @endrole

                @role('instansi')
                  <li class="nav-item">
                    <a class="dropdown-item" href="{{ route('profil-instansi') }}">
                      Profil
                    </a>
                  </li>
                @endrole

                <li class="nav-item">
                  <a class="dropdown-item" href="{{ route('password-user') }}">
                    Password
                  </a>
                </li>

                <li class="nav-item">
                  <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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
      </div>
    </div>
  </nav>
</header>