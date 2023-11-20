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
                              <input id="date_time_awal" type="datetime-local" name="date_time_awal" class="form-control @error('date_time_awal')is-invalid @enderror" 
                                value="{{ old('date_time_awal', @$dispensasi->date_time_awal) }}" placeholder="Tanggaldan Waktu Mulai">
                              
                              <label for="form_nama_tempat">
                                Tanggal dan Waktu Mulai<span class="text-danger">*</span>
                              </label>

                              @if ($errors->has('date_time_awal'))
                                  <span class="text-danger">{{ $errors->first('date_time_awal') }}</span>
                              @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-floating mb-4">
                              <input id="date_time_akhir" type="datetime-local" name="date_time_akhir" class="form-control @error('date_time_akhir')is-invalid @enderror" 
                                  value="{{ old('date_time_akhir', @$dispensasi->date_time_akhir) }}" placeholder="Tanggal dan Waktu Selesai">
                              
                              <label for="form_nama_tempat">
                                  Tanggal dan Waktu Selesai<span class="text-danger">*</span>
                              </label>
                              
                              @if ($errors->has('date_time_akhir'))
                                  <span class="text-danger">{{ $errors->first('date_time_akhir') }}</span>
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
                                  
                                  <div class="text text-info">
                                    <small>
                                        Dokumen yang dilampirkan seperti surat undangan atau dokumen lainnya yang berkaitan.
                                    </small>
                                  </div>
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
            // Mendapatkan tanggal hari ini dalam format YYYY-MM-DD
        var today = new Date().toISOString().split('T')[0];

        // Mengatur atribut min pada input field dengan tanggal hari ini
        document.getElementById("date_time_awal").setAttribute("min", today);

        // Memperbarui atribut min pada input tanggal dan waktu selesai saat input tanggal dan waktu mulai berubah
        document.getElementById("date_time_awal").addEventListener("change", function() {
          var mulai = this.value;
          document.getElementById("date_time_akhir").setAttribute("min", mulai);
        });
</script>
@endsection