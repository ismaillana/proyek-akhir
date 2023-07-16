@extends('layout.frontend.base')

@section('content')
<section class="wrapper bg-dark angled lower-start">
  <div class="container py-14 pt-md-10 pb-md-21">
    <div class="row gx-lg-8 gx-xl-12 gy-10 gy-lg-0 mb-2 align-items-end">
      <div class="col-lg-12 text-center">
        <h2 class="fs-16 text-uppercase text-line text-primary mb-3">
          Riwayat
        </h2>

        <h3 class="display-4 text-center text-white">
          Verifikasi Ijazah
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
                        Riwayat Pengajuan Verifikasi Ijazah
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
                                    Tanggal Pengajuan
                                  </th>

                                  <th scope="col" class="text-center">
                                    Status
                                  </th>

                                  <th scope="col" class="text-center">
                                    Hasil
                                  </th>

                                  <th scope="col" class="text-center">
                                    Aksi
                                  </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($verifikasiIjazah as $item)
                                    <tr>
                                        <th scope="row">
                                            {{$loop->iteration}}
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
                                            @else
                                                <span class="badge bg-green rounded-pill">Selesai</span>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                          @if ($item->dokumen_hasil !== null )
                                            <a href="{{ asset('storage/public/dokumen/dokumen-hasil/'. @$item->dokumen_hasil)}}" 
                                              download="{{@$item->dokumen_hasil}}"
                                                class="btn btn-sm btn-outline-primary" title="Download Hasil">
                                                  Download Hasil
                                            </a>
                                          @else
                                            Belum Selesai
                                          @endif
                                        </td>

                                        <td class="text-center">
                                            <a href="{{ route('pengajuan.tracking-verifikasi-ijazah', $item->id)}}"
                                                class="btn btn-sm btn-outline-secondary" title="Detail">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    width="16" height="16" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
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