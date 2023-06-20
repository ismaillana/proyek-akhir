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
                      @if (@$pengajuan->status == 'Diterima Perusahaan' || @$pengajuan->status == 'Ditolak Perusahaan' || @$pengajuan == null)
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
                              @foreach ($user as $item)
                                  <option value="{{ $item->id }}"
                                    {{ old('nama_mahasiswa', @$pengantarPkl->nama_mahasiswa) == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }} - {{$item->nomor_induk}}
                                  </option>
                              @endforeach
                            </select>
                          </div>
                            @if ($errors->has('nama_mahasiswa'))
                                <span class="text-danger">{{ $errors->first('nama_mahasiswa') }}</span>
                            @endif
                        </div>

                        <div class="col-md-12">
                          <div class="form-select-wrapper mb-4 mt-4">
                            <select class="form-select" aria-label="Default select example" id="tempat_pkl_id" name="tempat_pkl_id">
                              <option disabled selected value="">Pilih Perusahaan</option>
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
                              <input id="telepon" type="text" name="telepon" class="form-control @error('telepon')is-invalid @enderror" 
                                value="{{ old('telepon', @$pengajuan->telepon) }}" placeholder="Nomor Telepon Perusahaan">
                              
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
                                style="height: 150px" placeholder="Alamat Lengkap">{{ old('alamat', @$pengajuan->alamat) }}</textarea>
                              
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

        document.addEventListener("DOMContentLoaded", function() {
            var statusSelect = document.getElementById("tempat_pkl_id");
            var alasanInput = document.getElementById("data");
            var alasanInput1 = document.getElementById("data1");
            var alasanInput2 = document.getElementById("data2");
            var alasanInput3 = document.getElementById("data3");
            var alasanInput4 = document.getElementById("data4");
            var alasanInput5 = document.getElementById("data5");
            var alasanInput6 = document.getElementById("data6");

            statusSelect.addEventListener("change", function() {
                var selectedValue = this.value;
                if (selectedValue === "perusahaan_lainnya") {
                    alasanInput.style.display = "block";
                    alasanInput1.style.display = "block";
                    alasanInput2.style.display = "block";
                    alasanInput3.style.display = "block";
                    alasanInput4.style.display = "block";
                    alasanInput5.style.display = "block";
                    alasanInput6.style.display = "block";
                } else {
                    alasanInput.style.display = "none";
                    alasanInput1.style.display = "none";
                    alasanInput2.style.display = "none";
                    alasanInput3.style.display = "none";
                    alasanInput4.style.display = "none";
                    alasanInput5.style.display = "none";
                    alasanInput6.style.display = "none";
                }
            });
        });

  new MultiSelectTag('nama_mahasiswa')  // id

</script>
@endsection