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
            Surat Pengantar PKL
          </h4>
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
                action="{{route('pengajuan.pengantar-pkl.store')}}">
                {{ csrf_field() }}
                <div class="card card-border-start border-primary">
                  <div class="card-header">
                      <h4>
                          Form Pengantar PKL
                      </h4>
                  </div>

                  <div class="card-body">
                    <div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                      {{-- @if (@$dataPengajuan->status == 'Selesai PKL' || @$dataPengajuan->status == 'Ditolak Perusahaan' || @$dataPengajuan->status == 'Tolak' || @$dataPengajuan == null) --}}
                        <div class="col-md-12">
                            <div class="form-floating mb-4">
                              <input id="tgl_mulai" type="date" name="tgl_mulai" class="form-control @error('tgl_mulai')is-invalid @enderror" 
                                value="{{ old('tgl_mulai', @$pengantarPkl->tgl_mulai) }}" placeholder="Tanggal Mulai">
                              
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
                              <input id="tgl_selesai" type="date" name="tgl_selesai" class="form-control @error('tgl_selesai')is-invalid @enderror" 
                                  value="{{ old('tgl_selesai', @$pengantarPkl->tgl_selesai) }}" placeholder="Tanggal Selesai">
                              
                              <label for="form_tanggal_selesai">
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
                          <div class="form-floating mb-4">
                            <select class="form-select @error('nama_mahasiswa')
                              is-invalid @enderror" name="nama_mahasiswa[]"
                              id="nama_mahasiswa" multiple >
                              @foreach ($mahasiswaLain as $item)
                                  <option value="{{ $item->id }}"
                                    {{ old('mahasiswa_id', @$pengantarPkl->mahasiswa_id) == $item->id ? 'selected' : '' }}>
                                    {{ @$item->user->name }} - {{@$item->user->nomor_induk}}
                                  </option>
                              @endforeach
                            </select>
                          </div>
                            @if ($errors->has('nama_mahasiswa'))
                                <span class="text-danger">{{ $errors->first('nama_mahasiswa') }}</span>
                            @endif
                        </div>

                        <div class="col-md-12">
                          <div class="form-floating mb-4 mt-4 col-sm-12">
                            <select style="max-width: 100%;" class="form-select @error('tempat_pkl_id') 
                            is-invalid @enderror" id="tempat_pkl_id" name="tempat_pkl_id">
                              <option disabled selected value="">Pilih Perusahaan<span class="text-danger">*</span></option>
                              @foreach ($tempatPkl as $item)
                                  <option value="{{ $item->id }}"
                                    {{ old('tempat_pkl_id', @$pengantarPkl->tempat_pkl_id) == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                  </option>
                              @endforeach

                              <option value="perusahaan_lainnya">Perusahaan Lainnya</option>
                            </select>

                            @if ($errors->has('tempat_pkl_id'))
                                <span class="text-danger">{{ $errors->first('tempat_pkl_id') }}</span>
                            @endif
                          </div>
                        </div>

                        <div class="col-md-12" id="data" style="display: none;">
                            <div class="form-floating mb-4 mt-4">
                              <input id="name" type="text" name="name" class="form-control @error('name')is-invalid @enderror" 
                                value="{{ old('name', @$pengantarPkl->name) }}" placeholder="Nama Perusahaan">
                              
                              <label for="form_nama_perusahaan">
                                Nama Perusahaan<span class="text-danger">*</span>
                              </label>

                              @if ($errors->has('name'))
                                  <span class="text-danger">{{ $errors->first('name') }}</span>
                              @endif
                            </div>
                        </div>

                        <div class="col-md-12" id="data1" style="display: none;">
                            <div class="form-floating mb-4 mt-4">
                              <input id="web" type="text" name="web" class="form-control @error('web')is-invalid @enderror" 
                                value="{{ old('web', @$pengantarPkl->web) }}" placeholder="Link Website Perusahaan">
                              
                              <label for="form_nama_perusahaan">
                                Link Website Perusahaan
                              </label>

                              @if ($errors->has('web'))
                                  <span class="text-danger">{{ $errors->first('web') }}</span>
                              @endif
                            </div>
                        </div>

                        <div class="col-md-12" id="data2" style="display: none;">
                            <div class="form-floating mb-4 mt-4">
                              <input id="telepon" type="text" name="telepon" maxlength="13" class="form-control @error('telepon')is-invalid @enderror" 
                                value="{{ old('telepon', @$pengantarPkl->telepon) }}" placeholder="Nomor Telepon Perusahaan">
                              
                              <label for="form_nama_perusahaan">
                                Nomor Telepon Perusahaan
                              </label>

                              @if ($errors->has('telepon'))
                                  <span class="text-danger">{{ $errors->first('telepon') }}</span>
                              @endif
                            </div>
                        </div>

                        <div class="col-12" id="data3" style="display: none;">
                            <div class="form-floating mb-4">
                              <textarea id="alamat" name="alamat" class="form-control @error('alamat')is-invalid @enderror" 
                                style="height: 150px" placeholder="Alamat Lengkap">{{ old('alamat', @$pengantarPkl->alamat) }}</textarea>
                              
                              <label for="form_message">
                                Alamat Lengkap <span class="text-danger">*</span>
                              </label>

                              @if ($errors->has('alamat'))
                                  <span class="text-danger">{{ $errors->first('alamat') }}</span>
                              @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                          <div class="form-floating mb-4">
                            <input id="tujuan_surat" type="text" name="tujuan_surat" class="form-control @error('tujuan_surat')is-invalid @enderror" 
                              value="{{ old('tujuan_surat', @$pengantarPkl->tujuan_surat) }}" placeholder="Ditujakan Kepada">
                            
                            <label for="form_nama_tempat">
                              Ditujakan Kepada<span class="text-danger">*</span>
                            </label>

                            @if ($errors->has('tujuan_surat'))
                                <span class="text-danger">{{ $errors->first('tujuan_surat') }}</span>
                            @endif
                          </div>
                        </div>

                        <div class="col-md-12 mb-4">
                          <div class="form-floating">
                            <input id="link_pendukung" type="text" name="link_pendukung" class="form-control @error('link_pendukung')is-invalid @enderror" 
                              value="{{ old('link_pendukung', @$pengantarPkl->link_pendukung) }}" placeholder="Link Drive Dokumen Pendukung">
                            
                            <label for="form_nama_tempat">
                              Link Drive Dokumen Pendukung
                            </label>
                          </div>

                          <div class="text text-info">
                              <small>
                                  Masukkan Link Drive Yang Berisi Dokumen Pendukung. Pastikan Pengaturan Link Dapat Diakses Semua Orang!
                              </small>
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
                      {{-- @else
                        <div class="text-center">
                          <img class="img-fluid mb-2" width="250" src="{{ asset('template/assets/img/illustrations/3d1.png')}}" 
                          srcset="{{ asset('template/assets/img/illustrations/3d1@2x.png 2x')}}" alt="" />
                          
                          <p>
                            Pengajuan Dapat Dilakukan Kembali Jika Mahasiswa Ditolak Oleh Perusahaan Atau Setelah Mahasiswa Selesai Melaksanakan PKL!
                            <span class="text-danger">*</span>
                          </p>
                        </div>
                      @endif --}}
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

        document.addEventListener("DOMContentLoaded", function() {
            var statusSelect = document.getElementById("tempat_pkl_id");
            var alasanInput = document.getElementById("data");
            var alasanInput1 = document.getElementById("data1");
            var alasanInput2 = document.getElementById("data2");
            var alasanInput3 = document.getElementById("data3");

            statusSelect.addEventListener("change", function() {
                var selectedValue = this.value;
                if (selectedValue === "perusahaan_lainnya") {
                    alasanInput.style.display = "block";
                    alasanInput1.style.display = "block";
                    alasanInput2.style.display = "block";
                    alasanInput3.style.display = "block";
                } else {
                    alasanInput.style.display = "none";
                    alasanInput1.style.display = "none";
                    alasanInput2.style.display = "none";
                    alasanInput3.style.display = "none";
                }
            });
        });

        document.getElementById('telepon').addEventListener('input', function(evt) {
            var input = evt.target;
            input.value = input.value.replace(/[^0-9]/g, ''); // Hanya membiarkan angka
        });

            // Mendapatkan tanggal hari ini dalam format YYYY-MM-DD
        var today = new Date().toISOString().split('T')[0];
        // Mengatur atribut min pada input field dengan tanggal hari ini
        document.getElementById("tgl_mulai").setAttribute("min", today);
        document.getElementById("tgl_selesai").setAttribute("min", today);

            // Memperbarui atribut min pada input tanggal selesai saat input tanggal mulai berubah
        document.getElementById("tgl_mulai").addEventListener("change", function() {
            var mulai = this.value;
            document.getElementById("tgl_selesai").setAttribute("min", mulai);
        });

  new MultiSelectTag('nama_mahasiswa')  // id

</script>
@endsection