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
                                            {{$item->created_at}}
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
                                            <a href="{{ route('pengajuan.tracking-pengantar-pkl', $item->id)}}"
                                                class="badge bg-black " title="Detail">
                                                Detail
                                            </a>
                                            @if ($item->status == 'Selesai')
                                              <a href="#" data-bs-toggle="modal" data-bs-target="#modal-03-{{$item->id}}"
                                                  class="badge bg-yellow" title="Konfirmasi">
                                                  Konfirmasi
                                              </a>
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
@endforeach

@endsection

@section('script')
<script type="text/javascript">
        // $('#myForm').submit(function(e) {
        //     let form = this;
        //     e.preventDefault();

        //     confirmSubmit(form);
        // });
        // Form
        // function confirmSubmit(form, buttonId) {
        //     Swal.fire({
        //         icon: 'question',
        //         text: 'Apakah anda yakin ingin menyimpan data ini ?',
        //         showCancelButton: true,
        //         buttonsStyling: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'Simpan',
        //         cancelButtonText: 'Cancel',
        //     }).then((result) => {
        //         if (result.isConfirmed) {
        //             let button = 'btnSubmit';

        //             if (buttonId) {
        //                 button = buttonId;
        //             }

        //             $('#' + button).attr('disabled', 'disabled');
        //             $('#loader').removeClass('d-none');

        //             form.submit();
        //         }
        //     });
        // }

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