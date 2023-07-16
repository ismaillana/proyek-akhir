@extends('layout.frontend.base')

@section('content')
  <section class="wrapper bg-dark angled lower-start">
    <div class="container py-14 pt-md-10 pb-md-21">
      <div class="row gx-lg-8 gx-xl-12 gy-10 gy-lg-0 mb-2 align-items-end">
        <div class="col-lg-12 text-center">
          <h2 class="fs-16 text-uppercase text-line text-primary mb-3">
            Pengajuan
          </h2>

          <h4 class="display-4 text-center text-white">
            Surat Izin Dispensasi Kuliah
          </h4>
        </div>
      </div>
    </div>
  </section>
  <!-- /section -->
  <section class="wrapper bg-light angled upper-end lower-start">
    <div class="container py-16 py-md-18 position-relative">
      <div class="position-relative mt-n18 mt-md-n23">
        <div class="shape rounded-circle bg-line primary rellax w-18 h-18" data-rellax-speed="1" style="top: -2rem; right: -2.7rem; z-index:0;"></div>
        <div class="shape rounded-circle bg-soft-primary rellax w-18 h-18" data-rellax-speed="1" style="bottom: -1rem; left: -3rem; z-index:0;"></div>
        
          <div class="row">
            <div class="col-12">
              <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST" 
                action="{{route('pengajuan.dispensasi.store')}}">
                {{ csrf_field() }}
                <div class="card card-border-start border-primary">
                  <div class="card-header">
                      <h4>
                          Form Pengajuan Dispenasasi
                      </h4>
                  </div>

                  <div class="card-body bg-light">
                    <div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                      @if (@$pengajuan->status == 'Selesai' || @$pengajuan->status == 'Tolak' || @$pengajuan == null)
                        <div class="col-md-12">
                            <div class="form-floating mb-4">
                              <input id="kegiatan" type="text" name="kegiatan" class="form-control @error('kegiatan')is-invalid @enderror" 
                                value="{{ old('kegiatan', @$dispensasi->kegiatan) }}" placeholder="Nama Kegiatan">
                              
                              <label for="form_nama_kegiatan">
                                Nama Kegiatan<span class="text-danger">*</span>
                              </label>

                              @if ($errors->has('kegiatan'))
                                  <span class="text-danger">{{ $errors->first('kegiatan') }}</span>
                              @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-floating mb-4">
                              <input id="nama_tempat" type="text" name="nama_tempat" class="form-control @error('nama_tempat')is-invalid @enderror" 
                                value="{{ old('nama_tempat', @$dispensasi->nama_tempat) }}" placeholder="Tempat Kegiatan">
                              
                              <label for="form_nama_tempat">
                                Tempat Kegiatan<span class="text-danger">*</span>
                              </label>

                              @if ($errors->has('nama_tempat'))
                                  <span class="text-danger">{{ $errors->first('nama_tempat') }}</span>
                              @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-floating mb-4">
                              <input id="tgl_mulai" type="datetime-local" name="tgl_mulai" class="form-control @error('tgl_mulai')is-invalid @enderror" 
                                value="{{ old('tgl_mulai', @$dispensasi->tgl_mulai) }}" placeholder="Tanggal Mulai">
                              
                              <label for="form_nama_tempat">
                                Tanggal Mulai<span class="text-danger">*</span>
                              </label>

                              @if ($errors->has('tgl_mulai'))
                                  <span class="text-danger">{{ $errors->first('tgl_mulai') }}</span>
                              @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-floating mb-4">
                              <input id="tgl_selesai" type="datetime-local" name="tgl_selesai" class="form-control @error('tgl_selesai')is-invalid @enderror" 
                                  value="{{ old('tgl_selesai', @$dispensasi->tgl_selesai) }}" placeholder="Tanggal Selesai">
                              
                              <label for="form_nama_tempat">
                                  Tanggal Selesai<span class="text-danger">*</span>
                              </label>
                              
                              @if ($errors->has('tgl_selesai'))
                                  <span class="text-danger">{{ $errors->first('tgl_selesai') }}</span>
                              @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="form_name" class="mb-1">
                                Nama Mahasiswa<span class="text-danger">*</span>
                            </label>

                            <select class="form-select @error('nama_mahasiswa')
                              is-invalid @enderror" name="nama_mahasiswa[]"
                              id="nama_mahasiswa" multiple>

                              @foreach ($user as $item)
                                  <option value="{{ $item->id }}"
                                    {{ old('nama_mahasiswa', @$dispensasi->nama_mahasiswa) == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} - {{$item->nomor_induk}}
                                  </option>
                              @endforeach
                            </select>

                            @if ($errors->has('nama_mahasiswa'))
                                <span class="text-danger">{{ $errors->first('nama_mahasiswa') }}</span>
                            @endif
                        </div>

                        <div class="col-md-12">
                            <label for="form_name" class="mt-1 mb-1">
                                Dokumen Pendukung Pengajuan<span class="text-danger">*</span>
                            </label>

                            <div class="form-floating mb-4">
                                <div class="col-sm-12 col-md-12">
                                  <input id="dokumen" type="file" name="dokumen" class="form-control @error('dokumen')is-invalid @enderror" 
                                    value="{{ old('dokumen', @$dispensasi->dokumen) }}" placeholder="Tahun Lulus">
                                  
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
  new MultiSelectTag('nama_mahasiswa')  // id

        $('#myForm').submit(function(e) {
            let form = this;
            e.preventDefault();

            confirmSubmit(form);
        });
        // Form
        function confirmSubmit(form, buttonId) {
            Swal.fire({
                icon: 'question',
                text: 'Apakah anda yakin Data Sudah Benar ?',
                showCancelButton: true,
                buttonsStyling: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
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