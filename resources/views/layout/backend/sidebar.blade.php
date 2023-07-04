<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="{{route('dashboard')}}">
          <img src="{{asset('/assets/img/logoPOLSUB.png')}}" height="50 px" width="50 px" alt="img">
          SIPAM
        </a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{route('dashboard')}}">
          <img src="{{asset('/assets/img/logoPOLSUB.png')}}" height="50 px" width="50 px" alt="img">
        </a>
      </div>

      <ul class="sidebar-menu">
        @role('super-admin')
          <li class="menu-header">Dashboard Super Admin</li>
            <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
              <a href="{{route('dashboard')}}" class="nav-link">
                <i class="fas fa-home"></i>
                <span>Dashboard</span></a>
            </li>
          <li class="menu-header">Master Data</li>
            <li class="nav-item dropdown {{ request()->is('super-admin/jurusan*') ? 'active' : ''}} ||
              {{ request()->is('super-admin/prodi*') ? 'active' : ''}} ||">
              <a class="nav-link has-dropdown" data-toggle="dropdown">
                <i class="fas fa-columns"></i> 
                  <span>Master Data</span>
              </a>
              <ul class="dropdown-menu">
                <li class="{{ request()->is('super-admin/jurusan*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{ route('jurusan.index') }}">
                    Jurusan
                  </a>
                </li>
                <li class="{{ request()->is('super-admin/prodi*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('prodi.index')}}">
                    Program Studi
                  </a>
                </li>
              </ul>
            </li>
          <li class="menu-header">Manajemen User</li>
            <li class="nav-item dropdown 
              {{ request()->is('super-admin/adminJurusan*') ? 'active' : ''}} ||
              {{ request()->is('super-admin/bagianAkademik*') ? 'active' : ''}} ||">
    
              <a class="nav-link has-dropdown" data-toggle="dropdown">
                <i class="far fa-user"></i> 
                <span>Manajemen User</span>
              </a>
              <ul class="dropdown-menu">
                <li class="{{ request()->is('super-admin/bagianAkademik*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('bagianAkademik.index')}}">
                    Bagian Akademik
                  </a>
                </li>
                <li class="{{ request()->is('super-admin/adminJurusan*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('adminJurusan.index')}}">
                    Admin Jurusan
                  </a>
                </li>
              </ul>
            </li>
          <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
              <i class="fas fa-rocket"></i> Documentation
            </a>
          </div>
        @endrole

        @role('bagian-akademik')
          <li class="menu-header">Dashboard Bgian Akademik</li>
            <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
              <a href="{{route('dashboard')}}" class="nav-link"><i class="fas fa-home"></i>
                  <span>Dashboard</span></a>
            </li>

          <li class="menu-header">Manajemen User</li>
            <li class="nav-item dropdown 
              {{ request()->is('menu-admin/mahasiswa*') ? 'active' : ''}} ||
              {{ request()->is('menu-admin/instansi*') ? 'active' : ''}} ||
              {{ request()->is('menu-admin/koorPkl*') ? 'active' : ''}} ||
              {{ request()->is('menu-admin/import-excel*') ? 'active' : ''}} ||">
    
              <a class="nav-link has-dropdown" data-toggle="dropdown">
                <i class="far fa-user"></i> 
                <span>Manajemen User</span>
              </a>
              <ul class="dropdown-menu">
                <li class="{{ request()->is('menu-admin/mahasiswa*') ? 'active' : ''}} ||
                {{ request()->is('menu-admin/import-excel*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('mahasiswa.index')}}">
                    Mahasiswa Alumni
                  </a>
                </li>
                <li class="{{ request()->is('menu-admin/instansi*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('instansi.index')}}">
                    Instansi
                  </a>
                </li>
              </ul>
            </li>
          <li class="menu-header">Pengajuan</li>
            <li class="nav-item dropdown
            {{ request()->is('menu-admin/pengajuan-aktif-kuliah*') ? 'active' : ''}} ||
            {{ request()->is('menu-admin/pengajuan-izin-penelitian*') ? 'active' : ''}} ||
            {{ request()->is('menu-admin/pengajuan-verifikasi-ijazah*') ? 'active' : ''}} ||
            {{ request()->is('menu-admin/pengajuan-legalisir*') ? 'active' : ''}} ||
            {{ request()->is('menu-admin/pengajuan-dispensasi*') ? 'active' : ''}} ||
            {{ request()->is('menu-admin/pengajuan-pengantar-pkl*') ? 'active' : ''}}">
              <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i> <span>Pengajuan</span></a>
              <ul class="dropdown-menu">
                <li class="{{ request()->is('menu-admin/pengajuan-aktif-kuliah*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('pengajuan-aktif-kuliah.index')}}">
                    Surat Aktif Kuliah
                  </a>
                </li>
                <li class="{{ request()->is('menu-admin/pengajuan-pengantar-pkl*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('pengajuan-pengantar-pkl.index')}}">
                    Pengantar PKL
                  </a>
                </li>
                <li class="{{ request()->is('menu-admin/pengajuan-izin-penelitian*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('pengajuan-izin-penelitian.index')}}">
                    Izin Penelitian
                  </a>
                </li>
                <li class="{{ request()->is('menu-admin/pengajuan-dispensasi*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('pengajuan-dispensasi.index')}}">
                    Surat Dispensasi
                  </a>
                </li>
                <li class="{{ request()->is('menu-admin/pengajuan-legalisir*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('pengajuan-legalisir.index')}}">
                    Legalisir
                  </a>
                </li>
                <li class="{{ request()->is('menu-admin/pengajuan-verifikasi-ijazah*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('pengajuan-verifikasi-ijazah.index')}}">
                    Verifikasi Ijazah
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown
            {{ request()->is('menu-admin/riwayat-pengajuan-aktif-kuliah*') ? 'active' : ''}} ||
            {{ request()->is('menu-admin/riwayat-pengajuan-izin-penelitian*') ? 'active' : ''}} ||
            {{ request()->is('menu-admin/riwayat-pengajuan-verifikasi-ijazah*') ? 'active' : ''}} ||
            {{ request()->is('menu-admin/riwayat-pengajuan-legalisir*') ? 'active' : ''}} ||
            {{ request()->is('menu-admin/riwayat-pengajuan-dispensasi*') ? 'active' : ''}} ||
            {{ request()->is('menu-admin/riwayat-pengajuan-pengantar-pkl*') ? 'active' : ''}}">
              <a href="#" class="nav-link has-dropdown"><i class="far fa-file-alt"></i> <span>Riwayat Pengajuan</span></a>
              <ul class="dropdown-menu">
                <li class="{{ request()->is('menu-admin/riwayat-pengajuan-aktif-kuliah*') ? 'active' : ''}}">
                    <a class="nav-link" href="{{route('riwayat-pengajuan-aktif-kuliah')}}">
                    Surat Aktif Kuliah
                  </a>
                </li>
                <li class="{{ request()->is('menu-admin/riwayat-pengajuan-pengantar-pkl*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('riwayat-pengajuan-pengantar-pkl')}}">
                    Pengantar PKL
                  </a>
                </li>
                <li class="{{ request()->is('menu-admin/riwayat-pengajuan-izin-penelitian*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('riwayat-pengajuan-izin-penelitian')}}">
                    Izin Penelitian
                  </a>
                </li>
                <li class="{{ request()->is('menu-admin/riwayat-pengajuan-legalisir*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('riwayat-pengajuan-legalisir')}}">
                    Legalisir
                  </a>
                </li>
                <li class="{{ request()->is('menu-admin/riwayat-pengajuan-dispensasi*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('riwayat-pengajuan-dispensasi')}}">
                    Surat Dispensasi
                  </a>
                </li>
                <li class="{{ request()->is('menu-admin/riwayat-pengajuan-verifikasi-ijazah*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('riwayat-pengajuan-verifikasi-ijazah')}}">
                    Verifikasi Ijazah
                  </a>
                </li>
              </ul>
            </li>

          <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
              <i class="fas fa-rocket"></i> Documentation
            </a>
          </div>
        @endrole

        @role('admin-jurusan')
          <li class="menu-header">Dashboard Admin Jurusan</li>
            <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
              <a href="{{route('dashboard')}}" class="nav-link"><i class="fas fa-home"></i>
                  <span>Dashboard</span></a>
            </li>
          <li class="menu-header">Master Data</li>
            <li class="{{ request()->is('menu-admin/tempat-pkl*') ? 'active' : ''}}">
              <a class="nav-link" href="{{route('tempat-pkl.index')}}">
                <i class="fas fa-columns"></i>
                <span>Tempat PKL</span>
              </a>
            </li>
          <li class="menu-header">Manajemen User</li>
            <li class="nav-item dropdown 
              {{ request()->is('menu-admin/koorPkl*') ? 'active' : ''}} ||">
              <li class="{{ request()->is('menu-admin/koorPkl*') ? 'active' : ''}}">
                <a class="nav-link" href="{{route('koorPkl.index')}}">
                  <i class="far fa-user"></i> 
                  <span>Koor.PKL Jurusan</span> 
                </a>
              </li>
            </li>
          <li class="menu-header">Pengajuan</li>
            <li class="nav-item dropdown
            {{ request()->is('menu-admin/pengajuan-izin-penelitian*') ? 'active' : ''}} ||
            {{ request()->is('menu-admin/pengajuan-dispensasi*') ? 'active' : ''}} ||
            {{ request()->is('menu-admin/pengajuan-pengantar-pkl*') ? 'active' : ''}}">
              <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i> <span>Pengajuan</span></a>
              <ul class="dropdown-menu">
                <li class="{{ request()->is('menu-admin/pengajuan-izin-penelitian*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('pengajuan-izin-penelitian.index')}}">
                    Izin Penelitian
                  </a>
                </li>
                <li class="{{ request()->is('menu-admin/pengajuan-pengantar-pkl*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('pengajuan-pengantar-pkl.index')}}">
                    Pengantar PKL
                  </a>
                </li>
                <li class="{{ request()->is('menu-admin/pengajuan-dispensasi*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('pengajuan-dispensasi.index')}}">
                    Surat Dispensasi
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown
            {{ request()->is('menu-admin/riwayat-pengajuan-izin-penelitian*') ? 'active' : ''}} ||
            {{ request()->is('menu-admin/riwayat-pengajuan-dispensasi*') ? 'active' : ''}} ||
            {{ request()->is('menu-admin/riwayat-pengajuan-pengantar-pkl*') ? 'active' : ''}}">
              <a href="#" class="nav-link has-dropdown"><i class="far fa-file-alt"></i> <span>Riwayat Pengajuan</span></a>
              <ul class="dropdown-menu">
                <li class="{{ request()->is('menu-admin/riwayat-pengajuan-izin-penelitian*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('riwayat-pengajuan-izin-penelitian')}}">
                    Izin Penelitian
                  </a>
                </li>
                <li class="{{ request()->is('menu-admin/riwayat-pengajuan-pengantar-pkl*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('riwayat-pengajuan-pengantar-pkl')}}">
                    Pengantar PKL
                  </a>
                </li>
                <li class="{{ request()->is('menu-admin/riwayat-pengajuan-dispensasi*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('riwayat-pengajuan-dispensasi')}}">
                    Surat Dispensasi
                  </a>
                </li>
              </ul>
            </li>

          <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
              <i class="fas fa-rocket"></i> Documentation
            </a>
          </div>
        @endrole

        @role('koor-pkl')
          <li class="menu-header">Dashboard Koordinator PKL</li>
            <li class="nav-item {{ request()->is('dashboard') ? 'active' : ''}}">
              <a href="{{route('dashboard')}}" class="nav-link"><i class="fas fa-home"></i>
                  <span>Dashboard</span></a>
            </li>
          <li class="menu-header">Master Data</li>
            <li class="{{ request()->is('menu-admin/tempat-pkl*') ? 'active' : ''}}">
              <a class="nav-link" href="{{route('tempat-pkl.index')}}">
                <i class="fas fa-columns"></i>
                <span>Tempat PKL</span>
              </a>
            </li>
          <li class="menu-header">Pengajuan</li>
            <li class="nav-item dropdown
            {{ request()->is('menu-admin/pengajuan-pengantar-pkl*') ? 'active' : ''}}">
              <a href="#" class="nav-link has-dropdown"><i class="fas fa-th-large"></i> <span>Pengajuan</span></a>
              <ul class="dropdown-menu">
                <li class="{{ request()->is('menu-admin/pengajuan-pengantar-pkl*') ? 'active' : ''}}">
                  <a class="nav-link" href="{{route('pengajuan-pengantar-pkl.index')}}">
                    Pengantar PKL
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown
            {{ request()->is('menu-admin/riwayat-pengajuan-pengantar-pkl*') ? 'active' : ''}}">
              <a href="#" class="nav-link has-dropdown"><i class="far fa-file-alt"></i> <span>Riwayat Pengajuan</span></a>
              <ul class="dropdown-menu">
                <li>
                  <a class="nav-link" href="{{route('riwayat-pengajuan-pengantar-pkl')}}">
                    Pengantar PKL
                  </a>
                </li>
              </ul>
            </li>

          <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
              <i class="fas fa-rocket"></i> Documentation
            </a>
          </div>
        @endrole
      </ul>
    </aside>
  </div>