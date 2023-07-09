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
          Surat Izin Penelitian
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
                        Tracking Pengajuan Surat Izin Penelitian
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
                                            @elseif ($item->status == 'Dikonfirmasi')
                                                <span class="badge bg-blue rounded-pill">Dikonfirmasi</span>
                                            @elseif ($item->status == 'Diproses')
                                                <span class="badge bg-green rounded-pill">Diproses</span>
                                            @elseif ($item->status == 'Ditolak')
                                                <span class="badge bg-red rounded-pill">Ditolak</span>
                                            @elseif ($item->status == 'Ada Kendala')
                                                <span class="badge bg-red rounded-pill">Ada Kendala</span>
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

@section('script')
<script type="text/javascript">
  new MultiSelectTag('jenis_legalisir_id')  // id

        $('#myForm').submit(function(e) {
            let form = this;
            e.preventDefault();

            confirmSubmit(form);
        });
        // Form
        function confirmSubmit(form, buttonId) {
            Swal.fire({
                icon: 'question',
                text: 'Apakah anda yakin ingin menyimpan data ini ?',
                showCancelButton: true,
                buttonsStyling: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    let button = 'btnSubmit';

                    if (buttonId) {
                        button = buttonId;
                    }

                    $('#' + button).attr('disabled', 'disabled');
                    $('#loader').removeClass('d-none');

                    form.submit();
                }
            });
        }
</script>
@endsection