@extends('layout.frontend.base')

@section('content')
<section class="wrapper bg-dark angled lower-start">
  <div class="container py-14 pt-md-10 pb-md-21">
    <div class="row gx-lg-8 gx-xl-12 gy-10 gy-lg-0 mb-2 align-items-end">
      <div class="col-lg-12 text-center">
        <h2 class="fs-16 text-uppercase text-line text-primary mb-3">
          Tracking
        </h2>

        <h3 class="display-4 text-center text-white">
          Pengantar PKL
        </h3>
      </div>
    </div>
  </div>
</section>
<section class="wrapper bg-light angled upper-end lower-start">
  <div class="container py-16 py-md-18 position-relative">
    <div class="position-relative mt-n18 mt-md-n23">
      <div class="shape rounded-circle bg-line primary rellax w-18 h-18" data-rellax-speed="1" style="top: -2rem; right: -2.7rem; z-index:0;"></div>
      <div class="shape rounded-circle bg-soft-primary rellax w-18 h-18" data-rellax-speed="1" style="bottom: -1rem; left: -3rem; z-index:0;"></div>
        <div class="row">
          <div class="col-12">
              <div class="card card-border-start border-primary">
                <div class="card-header">
                    <h4>
                        Tracking Pengajuan Pengantar PKL
                    </h4>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                  <th scope="col">
                                    #
                                  </th>

                                  <th scope="col">
                                    Tanggal
                                  </th>

                                  <th scope="col" class="text-center">
                                    Status
                                  </th>

                                  <th scope="col">
                                    Catatan
                                  </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = $jumlah;

                                @endphp
                                @forelse ($riwayat as $item)
                                    <tr>
                                        <th scope="row">
                                            {{$i}}
                                        </th>

                                        <td>
                                          {{ Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y H:i:s') }}
                                        </td>

                                        <td class="text-center">
                                          @if ($item->status == 'Menunggu Konfirmasi')
                                              <span class="badge bg-primary rounded-pill">Menunggu Konfirmasi</span>
                                          @elseif ($item->status == 'Konfirmasi')
                                              <span class="badge bg-blue rounded-pill">Dikonfirmasi</span>
                                          @elseif ($item->status == 'Proses')
                                              <span class="badge bg-green rounded-pill">Diproses</span>
                                          @elseif ($item->status == 'Tolak')
                                              <span class="badge bg-red rounded-pill">Ditolak</span>
                                          @elseif ($item->status == 'Kendala')
                                              <span class="badge bg-red rounded-pill">Ada Kendala</span>
                                          @elseif ($item->status == 'Diterima Perusahaan')
                                              <span class="badge bg-warning rounded-pill">Diterima Perusahaan</span>
                                          @elseif ($item->status == 'Ditolak Perusahaan')
                                              <span class="badge bg-red rounded-pill">Ditolak Perusahaan</span>
                                          @elseif ($item->status == 'Selesai PKL')
                                              <span class="badge bg-green rounded-pill">Selesai PKL</span>
                                          @else
                                              <span class="badge bg-green rounded-pill">Selesai</span>
                                          @endif                    
                                        </td>

                                        <td>
                                            {{strip_tags($item->catatan)}}
                                        </td>
                                    </tr>
                                @php
                                    $i= $i-1;
                                @endphp
                                @empty
                                    <tr>
                                      <td colspan="4" class="text-center">
                                          <img class="img-fluid mb-2" width="250" src="{{ asset('template/assets/img/illustrations/3d1.png')}}" 
                                          srcset="{{ asset('template/assets/img/illustrations/3d1@2x.png 2x')}}" alt="" />
                                          
                                          <p>
                                          Anda belum pernah melakukan pengajuan layanan akademik ini!
                                          <span class="text-danger">*</span>
                                          </p>
                                      </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>
          </div>
        </div>
    </div>
  </div>
</section>
@endsection