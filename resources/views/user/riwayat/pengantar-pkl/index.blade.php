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
                        Riwayat Pengajuan Pengantar PKL
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
                                    Aksi
                                  </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pengantarPkl as $item)
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

                                        <td class="text-center">
                                            <a href="{{ route('pengajuan.tracking-pengantar-pkl', $item->id)}}"
                                                class="badge bg-black " title="Detail">
                                                Detail
                                            </a>
                                            @if ($item->status == 'Selesai')
                                              <a href="#" data-bs-toggle="modal" data-bs-target="#modal-03-{{$item->id}}"
                                                  class="badge bg-yellow" title="Konfirmasi">
                                                  Konfirmasi Penerimaan
                                              </a>
                                            @elseif ($item->status == 'Diterima Perusahaan')
                                              <a href="#" data-bs-toggle="modal" data-bs-target="#modal-04-{{$item->id}}"
                                                  class="badge bg-yellow" title="Konfirmasi">
                                                  Konfirmasi Selesai PKL
                                              </a>
                                            @else

                                            @endif
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
@foreach ($pengantarPkl as $pengantarPkl)
  <div class="modal fade" id="modal-03-{{$pengantarPkl->id}}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content text-center">
        <div class="modal-body">
          <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <h3 class="mb-4">Konfirmasi Hasil Pengajuan Surat Pengantar PKL</h3>
          <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{route('pengajuan.konfirmasi-terima', $pengantarPkl->id)}}" method="POST">
            @csrf
            <div class="form-floating mb-4">
              <select class="form-select" aria-label="Default select example" id="status" name="status">
                <option disabled selected>Pilih Status</option>
                <option value="Diterima Perusahaan"
                    {{ old('status', @$pengantarPkl->status) == 'Diterima Perusahaan' ? 'selected' : '' }}>
                        Diterima Perusahaan</option>
                <option value="Ditolak Perusahaan"
                    {{ old('status', @$pengantarPkl->status) == 'Ditolak Perusahaan' ? 'selected' : '' }}>
                        Ditolak Perusahaan</option>
              </select>

              @if ($errors->has('status'))
                  <span class="text-danger">
                      {{ $errors->first('status') }}
                  </span>
              @endif
              <label for="loginPassword">Status</label>
            </div>

            <div class="form-floating mb-4" id="bukti">
              <div class="col-sm-12 col-md-12">
                <label for="form_nama_tempat">
                  Bukti Penolakan<span class="text-danger">*</span>
                </label>

                <input id="image" type="file" name="image" class="form-control @error('image')is-invalid @enderror" 
                  value="{{ old('image', @$pengantarPkl->image) }}" placeholder="image">
                
                @if ($errors->has('image'))
                    <span class="text-danger">{{ $errors->first('image') }}</span>
                @endif
              </div>
            </div>

            <button class="btn btn-primary rounded-pill w-100 mb-2" type="submit">
              Submit
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-04-{{$pengantarPkl->id}}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content text-center">
        <div class="modal-body">
          <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <h3 class="mb-4">Konfirmasi PKL Telah Selesai</h3>
          <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{route('pengajuan.konfirmasi-selesai', $pengantarPkl->id)}}" method="POST">
            @csrf
            <div class="form-floating mb-4" id="bukti">
              <div class="col-sm-12 col-md-12">
                <label for="form_nama_tempat">
                  Bukti Selesai PKL<span class="text-danger">*</span>
                </label>
                <input id="bukti_selesai" type="file" name="bukti_selesai" class="form-control @error('bukti_selesai')is-invalid @enderror" 
                  value="{{ old('bukti_selesai', @$pengantarPkl->bukti_selesai) }}" placeholder="bukti_selesai">
                
                @if ($errors->has('bukti_selesai'))
                    <span class="text-danger">{{ $errors->first('bukti_selesai') }}</span>
                @endif
              </div>
            </div>

            <button class="btn btn-primary rounded-pill w-100 mb-2" type="submit">
              Submit
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endforeach

@endsection

@section('script')
<script type="text/javascript">
        $("#bukti").hide();

        $('#status').on('change', function(){
            var selectedVal = $(this).val();

            if (selectedVal == 'Ditolak Perusahaan') {
                $('#bukti').show();
            } else {
                $("#bukti").hide();
            }
        })
</script>
@endsection