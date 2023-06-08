@extends('layout.frontend.base')

@section('content')
<section class="wrapper bg-dark angled lower-start">
  <div class="container py-14 pt-md-10 pb-md-21">
    <div class="row gx-lg-8 gx-xl-12 gy-10 gy-lg-0 mb-2 align-items-end">
      <div class="col-lg-12 text-center">
        <h2 class="fs-16 text-uppercase text-line text-primary mb-3">Pengajuan</h2>
        <h3 class="display-4 text-center text-white">Verifikasi Ijazah</h3>
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
            <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST" 
              action="{{route('verifikasi-ijazah.store')}}">
              {{ csrf_field() }}
              <div class="card card-border-start border-primary">
                <div class="card-header">
                    <h4>
                        Form Verifikasi Ijazah
                    </h4>
                </div>

                <div class="card-body">
                    <div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                      @if ($pengajuan->status == 'Selesai' || $pengajuan->status == 'Tolak')
                        <div class="col-md-12">
                            <div class="form-floating mb-4">
                                <input id="name" type="text" name="name" class="form-control @error('name')is-invalid @enderror" 
                                  value="{{ old('name', @$verifikasiIjazah->name) }}" placeholder="Nama Mahasiswa">
                                
                                <label for="form_name">
                                    Nama Mahasiswa <span class="text-danger">*</span>
                                </label>

                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                          <div class="form-floating mb-4">
                              <input id="nim" type="text" name="nim" class="form-control @error('nim')is-invalid @enderror" 
                                value="{{ old('nim', @$verifikasiIjazah->nim) }}" placeholder="NIM">

                              <label for="form_name">
                                  NIM<span class="text-danger">*</span>
                              </label>

                              @if ($errors->has('nim'))
                                  <span class="text-danger">{{ $errors->first('nim') }}</span>
                              @endif
                          </div>
                        </div>

                        <div class="col-md-12">
                          <div class="form-floating mb-4">
                              <input id="no_ijazah" type="text" name="no_ijazah" class="form-control @error('no_ijazah')is-invalid @enderror" 
                                value="{{ old('no_ijazah', @$verifikasiIjazah->no_ijazah) }}" placeholder="No_Ijazah">

                              <label for="form_name">
                                  No Ijazah<span class="text-danger">*</span>
                              </label>

                              @if ($errors->has('no_ijazah'))
                                  <span class="text-danger">{{ $errors->first('no_ijazah') }}</span>
                              @endif
                          </div>
                        </div>

                        <div class="col-md-12">
                          <div class="form-floating mb-4">
                              <input id="tahun_lulus" type="text" name="tahun_lulus" class="form-control @error('tahun_lulus')is-invalid @enderror" 
                                value="{{ old('tahun_lulus', @$verifikasiIjazah->tahun_lulus) }}" placeholder="Tahun Lulus">

                              <label for="form_name">
                                  Tahun Lulus<span class="text-danger">*</span>
                              </label>

                              @if ($errors->has('tahun_lulus'))
                                  <span class="text-danger">{{ $errors->first('tahun_lulus') }}</span>
                              @endif
                          </div>
                        </div>

                        <div class="col-md-12">
                          <label for="form_name">
                              Dokumen<span class="text-danger">*</span>
                          </label>

                          <div class="form-floating mb-4">
                              <div class="col-sm-12 col-md-12">
                                <input id="dokumen" type="file" name="dokumen" class="form-control @error('dokumen')is-invalid @enderror" 
                                  value="{{ old('dokumen', @$verifikasiIjazah->dokumen) }}" placeholder="Tahun Lulus">

                                @if ($errors->has('dokumen'))
                                    <span class="text-danger">{{ $errors->first('dokumen') }}</span>
                                @endif
                              </div>
                          </div>
                        </div>

                        <div class="col-12 text-center">
                          <button type="submit" class="btn btn-primary rounded-pill btn-send mb-3" id="btnSubmit">
                            Kirim Pengajuan
                            <span class="spinner-border ml-2 d-none" id="loader"
                                style="width: 1rem; height: 1rem;" role="status">
                            </span>
                          </button>
                        </div>
                      @else
                        <div class="text-center">
                          <img class="img-fluid mb-2" width="250" src="{{ asset('template/assets/img/illustrations/3d1.png')}}" 
                          srcset="{{ asset('template/assets/img/illustrations/3d1@2x.png 2x')}}" alt="" />
                          
                          <p>
                            Pengajuan Dapat Dilakukan Kembali Setelah Pengajuan Sebelumnya Selesai!
                            <span class="text-danger">*</span>
                          </p>
                        </div>
                      @endif
                    </div>
                </div>
              </div>
            </form>
          </div>
        </div>
    </div>
  </div>
</section>
@endsection

@section('script')
<script>
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