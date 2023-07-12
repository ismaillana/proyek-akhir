@extends('layout.frontend.base')

@section('content')
<section class="bg-dark angled lower-start">
  <div class="container pt-7 pt-md-11 pb-8">
    <div class="row gx-0 gy-10 align-items-center">
      <div class="col-lg-6" data-cues="slideInDown" data-group="page-title" data-delay="600">
        <h1 class="display-1 text-white mb-4">
          Pengajuan Administrasi
          <br />
            <span class="typer text-primary text-nowrap" data-delay="100" data-words="surat ket. aktif kuliah, surat pengantar PKL, surat izin penelitian, surat izin dispensasi, Legalisir, Cek Keaslian Ijazah"></span>
            <span class="cursor text-primary" data-owner="typer"></span>
        </h1>
        <p class="lead fs-24 lh-sm text-white mb-7 pe-md-18 pe-lg-0 pe-xxl-15">
          Sistem ini dapat digunakan oleh Mahasiswa Aktif dan Alumni Politeknik Negeri Subang. 
          Dan Instansi tempat Alumni bekerja untuk mengajukan beberapa pelayanan administrasi kepada bagian akademik.
        </p>

        <div>
          @guest
            <span>
              <a href="{{ route('login') }}" class="btn btn-primary rounded me-2">
                Login
              </a>
            </span>
            
            <span>
              <a href="{{ route('register') }}" class="btn btn-yellow rounded">
                Registrasi
              </a>
            </span>
          @else
            <p class="lead fs-24 lh-sm text-white mb-7 pe-md-18 pe-lg-0 pe-xxl-15">
              Kamu Berhasil Login..
            </p>
          @endguest
        </div>
      </div>

      <div class="col-lg-5 offset-lg-1" data-cues="slideInDown">
        <div class="position-relative">
          <figure><img class="img-auto" src="{{ asset('template/assets/img/illustrations/i9.png')}}" 
            srcset="{{ asset('template/assets/img/illustrations/i9@2x.png 2x')}}" alt="" /></figure>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="wrapper bg-light">
  <div class="container pt-19 pt-md-21 pb-10 md-18">
    <div class="row gy-10 gy-sm-13 gx-lg-3 mb-16 mb-md-18 align-items-center">
      <div class="col-md-8 col-lg-6 position-relative">
        <div class="shape bg-dot primary rellax w-17 h-21" data-rellax-speed="1" style="top: -2rem; left: -1.9rem;"></div>
        <div class="shape rounded bg-soft-primary rellax d-md-block" data-rellax-speed="0" style="bottom: -1.8rem; right: -1.5rem; width: 85%; height: 90%; "></div>
        <figure class="rounded"><img src="{{ asset('template/assets/img/photos/about7.jpg')}}" srcset="{{ asset('template/assets/img/photos/about7@2x.jpg 2x')}}" alt="" /></figure>
      </div>

      <div class="col-lg-5 col-xl-4 offset-lg-1">
        <h2 class="fs-16 text-uppercase text-line text-primary mb-3">Mau Melakukan Pengajuan?</h2>
        <h3 class="display-4 mb-7">Berikut Langkah Melakukan Pengajuan.</h3>
        <div class="d-flex flex-row mb-6">
          <div>
            <span class="icon btn btn-block btn-soft-primary disabled me-5"><span class="number fs-18">1</span></span>
          </div>
          <div>
            <h4 class="mb-1">Menyiapkan Berkas/Data</h4>
            <p class="mb-0">Siapkan data dan berkas pengajuan sebelum melakukan pengajuan</p>
          </div>
        </div>
        <div class="d-flex flex-row mb-6">
          <div>
            <span class="icon btn btn-block btn-soft-primary disabled me-5"><span class="number fs-18">2</span></span>
          </div>
          <div>
            <h4 class="mb-1">Cek Data</h4>
            <p class="mb-0">Ketika mengisi data pengajuan pastikan data yang diinputkan sudah benar dan sesuai</p>
          </div>
        </div>
        <div class="d-flex flex-row">
          <div>
            <span class="icon btn btn-block btn-soft-primary disabled me-5"><span class="number fs-18">3</span></span>
          </div>
          <div>
            @php
                $user = \App\Models\User::role('bagian-akademik')->first();
            @endphp
            <h4 class="mb-1">Progres pengajuan</h4>
            <p class="mb-0">Cek progres pengajuan melalui halaman riwayat->tracking. Atau <a href="https://api.whatsapp.com/send?phone=0{{Str::substr(@$user->wa, 2)}}">Hubungi Admin!</a> </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
