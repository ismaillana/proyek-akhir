@extends('layout.frontend.base')

@section('content')
  <section class="wrapper bg-dark angled lower-start">
    <div class="container py-14 pt-md-10 pb-md-21">
      <div class="row gx-lg-8 gx-xl-12 gy-10 gy-lg-0 mb-2 align-items-end">
        <div class="col-lg-12 text-center">
          <h2 class="fs-16 text-uppercase text-line text-primary mb-3">Pengajuan</h2>
          <h3 class="display-4 text-center text-white">Surat Izin Dispensasi Kuliah</h3>
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
                action="{{route('dispensasi.store')}}">
                {{ csrf_field() }}
                <div class="card card-border-start border-primary">
                  <div class="card-header">
                      <h4>
                          Form Pengajuan Dispenasasi
                      </h4>
                  </div>

                  <div class="card-body">
                    <div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
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
                            <input id="tempat" type="text" name="tempat" class="form-control @error('tempat')is-invalid @enderror" 
                              value="{{ old('tempat', @$dispensasi->tempat) }}" placeholder="Tempat Kegiatan">
                            
                            <label for="form_nama_tempat">
                              Tempat Kegiatan<span class="text-danger">*</span>
                            </label>

                            @if ($errors->has('tempat'))
                                <span class="text-danger">{{ $errors->first('tempat') }}</span>
                            @endif
                          </div>
                      </div>

                      <div class="col-md-12">
                          <div class="form-floating mb-4">
                            <input id="mulai" type="datetime-local" name="mulai" class="form-control @error('mulai')is-invalid @enderror" 
                              value="{{ old('mulai', @$dispensasi->mulai) }}" placeholder="Waktu Mulai">
                            
                            <label for="form_nama_tempat">
                              Waktu Mulai<span class="text-danger">*</span>
                            </label>

                            @if ($errors->has('mulai'))
                                <span class="text-danger">{{ $errors->first('mulai') }}</span>
                            @endif
                          </div>
                      </div>

                      <div class="col-md-12">
                          <div class="form-floating mb-4">
                            <input id="selesai" type="datetime-local" name="selesai" class="form-control @error('selesai')is-invalid @enderror" 
                                value="{{ old('selesai', @$dispensasi->selesai) }}" placeholder="Waktu Selesai">
                            
                            <label for="form_nama_tempat">
                                Waktu Selesai<span class="text-danger">*</span>
                            </label>
                            
                            @if ($errors->has('selesai'))
                                <span class="text-danger">{{ $errors->first('selesai') }}</span>
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
                              Dokumen<span class="text-danger">*</span>
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