<footer class="bg-dark text-inverse">
  <div class="container pt-15 md-18 md-15 pb-5">
    <div class="row gy-6 gy-lg-0">
      <div class="col-md-4 col-lg-3">
        <div class="widget">
          <img class="mb-4" src="{{ asset('template/assets/img/logoPOLSUB.png')}}" srcset="{{ asset('/assets/img/logoPOLSUB.png 2x')}}" alt="" width="10%"/>
          <p>Sistem Informasi Pelayanan Administrasi Mahasiswa POLSUB (SIPAM-POLSUB)</p>
          <p class="mb-4">© {{ date('Y') }} POLSUB. <br class="d-none d-lg-block" />Politeknik Negeri Subang.</p>
        </div>
      </div>

      <div class="col-md-4 col-lg-3">
        <div class="widget">
          @php
              $user = \App\Models\User::role('bagian-akademik')->first();
          @endphp
          <h4 class="widget-title text-white mb-3">Kontak Admin</h4>
          <a href=" ">polsub@gmail.com</a><br /> <a href="https://api.whatsapp.com/send?phone=0{{Str::substr(@$user->wa, 2)}}">+62{{Str::substr(@$user->wa, 2)}}</a>
        </div>
      </div>

      <div class="col-md-4 col-lg-3">
        <div class="widget">
          <h4 class="widget-title text-white mb-3">Dokumentasi</h4>
          <ul class="list-unstyled  mb-0">
            <li><a href="#">Penggunaan Aplikasi</a></li>
          </ul>
        </div>
      </div>

      <div class="col-md-12 col-lg-3">
        <div class="widget">
          <h4 class="widget-title text-white mb-3">Alamat</h4>
          <p class="mb-2">Kampus 1: Belakang RSUD, Jl. Brigjen Katamso No.37, Dangdeur, Kec. Subang, Kabupaten Subang, Jawa Barat 41211.</p>
          <p>Kampus 2: Blok Kaleng Banteng Desa Cibogo, Subang.</p>
        </div>
      </div>
    </div>
  </div>
</footer>