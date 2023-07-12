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
            Surat Keterangan Aktif Kuliah
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
              <div class="card card-border-start border-primary">
                <div class="card-header">
                    <h4>
                      Form Pengajuan Surat Keterangan Aktif Kuliah
                    </h4>
                </div>

                <div class="card-body">
                  @if (@$pengajuan->status == 'Selesai' || @$pengajuan->status == 'Tolak' || @$pengajuan == null)
                    <div class="accordion accordion-wrapper" id="accordionExample">
                      <div class="card accordion-item">
                        <div class="card-header" id="headingOne">
                          <button class="accordion-button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"> 
                            Pastikan Data Benar & Lengkap 
                          </button>
                        </div>
                        <div class="row">

                          <div id="collapseOne" class="accordion-collapse collapse show col-md-6" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="card-body">
                              <ul>
                                <li>
                                  Nama Mahasiswa: {{(@$mahasiswa->user->name)}}
                                </li>
  
                                <li>
                                  NIM: {{(@$mahasiswa->nim)}}
                                </li>
  
                                <li>
                                  Jurusan: {{@$mahasiswa->programStudi->jurusan->name}}
                                </li>
  
                                <li>
                                  Program Studi: {{@$mahasiswa->programStudi->name}}
                                </li>
                              </ul>
                            </div>
                          </div>
  
                          <div id="collapseOne" class="accordion-collapse collapse show col-md-6" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="card-body">
                              <ul>
                                <li>
                                  Nama Orang Tua: {{(@$mahasiswa->orang_tua)}}
                                </li>
  
                                <li>
                                  Pekerjaan: {{(@$mahasiswa->pekerjaan)}}
                                </li>
  
                                <li>
                                  NIP/NRP: {{@$mahasiswa->nip_nrp}}
                                </li>
  
                                <li>
                                  Pangkat: {{@$mahasiswa->pangkat}}
                                </li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST" 
                      action="{{route('pengajuan.aktif-kuliah.store')}}">
                      {{ csrf_field() }}

                      <div class="col-md-12">
                        <div class="form-select-wrapper mb-4 mt-4">
                          <select class="form-select" aria-label="Default select example" id="status_data" name="status_data">
                            <option disabled selected value="">Pilih Status Data</option>
                            <option value="Data Sudah Sesuai"> Data Sudah Sesuai</option>
                            <option value="Update Data"> Update Data</option>
                            
                          </select>
                          @if ($errors->has('status_data'))
                              <span class="text-danger">{{ $errors->first('status_data') }}</span>
                          @endif
                        </div>
                      </div>

                      <div class="col-md-12" id="data9" style="display: none;">
                        <div class="form-floating mb-4">
                          <input id="tempat_lahir" type="text" name="tempat_lahir" class="form-control @error('tempat_lahir')is-invalid @enderror" 
                            value="{{ old('tempat_lahir', @$aktifKuliah->mahasiswa->tempat_lahir) }}" placeholder="Masukan Tempat Lahir Mahasiswa">
                          
                          <label for="form_tujuan_surat">
                            Tempat Lahir<span class="text-danger">*</span>
                          </label>

                          @if ($errors->has('tempat_lahir'))
                              <span class="text-danger">{{ $errors->first('tempat_lahir') }}</span>
                          @endif
                        </div>
                      </div>

                      <div class="col-md-12" id="data10" style="display: none;">
                        <div class="form-floating mb-4">
                          <input id="tanggal_lahir" type="text" name="tanggal_lahir" class="form-control @error('tanggal_lahir')is-invalid @enderror" 
                            value="{{ old('tanggal_lahir', @$aktifKuliah->mahasiswa->tanggal_lahir) }}" placeholder="Masukan Tanggal Lahir Mahasiswa">
                          
                          <label for="form_tujuan_surat">
                            Tanggal Lahir<span class="text-danger">*</span>
                          </label>

                          @if ($errors->has('tanggal_lahir'))
                              <span class="text-danger">{{ $errors->first('tanggal_lahir') }}</span>
                          @endif
                        </div>
                      </div>

                      <div class="col-md-12" id="data7" style="display: none;">
                        <div class="form-select-wrapper mb-4 mt-4">
                          <select class="form-select" aria-label="Default select example" id="semester" name="semester">
                            <option disabled selected value="">Pilih Semester</option>
                            <option value="1"
                              {{ old('semester', @$aktifKuliah->mahasiswa->semester) == '1' ? 'selected' : '' }}>
                                1</option>
                            <option value="2"
                              {{ old('semester', @$aktifKuliah->mahasiswa->semester) == '2' ? 'selected' : '' }}>
                                2</option>
                            <option value="3"
                              {{ old('semester', @$aktifKuliah->mahasiswa->semester) == '3' ? 'selected' : '' }}>
                                3</option>
                            <option value="4"
                              {{ old('semester', @$aktifKuliah->mahasiswa->semester) == '4' ? 'selected' : '' }}>
                                4</option>
                            <option value="5"
                              {{ old('semester', @$aktifKuliah->mahasiswa->semester) == '5' ? 'selected' : '' }}>
                                5</option>
                            <option value="6"
                              {{ old('semester', @$aktifKuliah->mahasiswa->semester) == '6' ? 'selected' : '' }}>
                                6</option>
                            
                          </select>
                              @if ($errors->has('semester'))
                                  <span class="text-danger">{{ $errors->first('semester') }}</span>
                              @endif
                        </div>
                      </div>
                      
                      <div class="col-md-12" id="data8" style="display: none;">
                        <div class="form-floating mb-4">
                          <input id="tahun_ajaran" type="text" name="tahun_ajaran" class="form-control @error('tahun_ajaran')is-invalid @enderror" 
                            value="{{ old('tahun_ajaran', @$aktifKuliah->mahasiswa->tahun_ajaran) }}" placeholder="Masukan Tahun Ajaran">
                          
                          <label for="form_tahun_ajaran">
                            Tahun Ajaran<span class="text-danger">*</span>
                          </label>

                          @if ($errors->has('tahun_ajaran'))
                              <span class="text-danger">{{ $errors->first('tahun_ajaran') }}</span>
                          @endif
                        </div>
                      </div>

                      <div class="col-md-12" id="data" style="display: none;">
                        <div class="form-floating mb-4">
                          <input id="orang_tua" type="text" name="orang_tua" class="form-control @error('orang_tua')is-invalid @enderror" 
                            value="{{ old('orang_tua', @$aktifKuliah->mahasiswa->orang_tua) }}" placeholder="Masukan Nama Orang Tua">
                          
                          <label for="form_tujuan_surat">
                            Nama Orang Tua<span class="text-danger">*</span>
                          </label>

                          @if ($errors->has('orang_tua'))
                              <span class="text-danger">{{ $errors->first('orang_tua') }}</span>
                          @endif
                        </div>
                      </div>

                      <div class="col-md-12" id="data1" style="display: none;">
                        <div class="form-floating mb-4">
                          <input id="pekerjaan" type="text" name="pekerjaan" class="form-control @error('pekerjaan')is-invalid @enderror" 
                            value="{{ old('pekerjaan', @$aktifKuliah->mahasiswa->pekerjaan) }}" placeholder="Masukan Pekerjaan Orang Tua">
                          
                          <label for="form_tujuan_surat">
                            Pekerjaan Orang Tua<span class="text-danger">*</span>
                          </label>

                          @if ($errors->has('pekerjaan'))
                              <span class="text-danger">{{ $errors->first('pekerjaan') }}</span>
                          @endif
                        </div>
                      </div>

                      <div class="col-md-12" id="data2" style="display: none;">
                        <div class="form-floating mb-4">
                          <input id="nip_nrp" type="text" name="nip_nrp" class="form-control @error('nip_nrp')is-invalid @enderror" 
                            value="{{ old('nip_nrp', @$aktifKuliah->mahasiswa->nip_nrp) }}" placeholder="Masukan NIP/NRP">
                          
                          <label for="form_tujuan_surat">
                            NIP/NRP<span class="text-danger">*</span>
                          </label>

                          @if ($errors->has('nip_nrp'))
                              <span class="text-danger">{{ $errors->first('nip_nrp') }}</span>
                          @endif
                        </div>
                      </div>

                      <div class="col-md-12" id="data3" style="display: none;">
                        <div class="form-floating mb-4">
                          <input id="pangkat" type="text" name="pangkat" class="form-control @error('pangkat')is-invalid @enderror" 
                            value="{{ old('pangkat', @$aktifKuliah->mahasiswa->pangkat) }}" placeholder="Masukan Pangkat/Golongan Orang Tua">
                          
                          <label for="form_tujuan_surat">
                            Pangkat/Golongan Orang Tua<span class="text-danger">*</span>
                          </label>

                          @if ($errors->has('pangkat'))
                              <span class="text-danger">{{ $errors->first('pangkat') }}</span>
                          @endif
                        </div>
                      </div>

                      <div class="col-md-12" id="data5" style="display: none;">
                        <div class="form-floating mb-4">
                          <input id="jabatan" type="text" name="jabatan" class="form-control @error('jabatan')is-invalid @enderror" 
                            value="{{ old('jabatan', @$aktifKuliah->mahasiswa->jabatan) }}" placeholder="Masukan Jabatan">
                          
                          <label for="form_tujuan_surat">
                            Jabatan<span class="text-danger">*</span>
                          </label>

                          @if ($errors->has('jabatan'))
                              <span class="text-danger">{{ $errors->first('jabatan') }}</span>
                          @endif
                        </div>
                      </div>

                      <div class="col-md-12" id="data6" style="display: none;">
                        <div class="form-floating mb-4">
                          <input id="instansi" type="text" name="instansi" class="form-control @error('instansi')is-invalid @enderror" 
                            value="{{ old('instansi', @$aktifKuliah->mahasiswa->instansi) }}" placeholder="Masukan Instansi">
                          
                          <label for="form_tujuan_surat">
                            Instansi<span class="text-danger">*</span>
                          </label>

                          @if ($errors->has('instansi'))
                              <span class="text-danger">{{ $errors->first('instansi') }}</span>
                          @endif
                        </div>
                      </div>

                      <div class="col-md-12">
                        <div class="form-floating mb-4">
                          <textarea id="keperluan" name="keperluan" class="form-control @error('keperluan')is-invalid @enderror" 
                            style="height: 150px" placeholder="Keperluan">{{ old('keperluan', @$aktifKuliah->keperluan) }}</textarea>
                          
                          <label for="form_message">
                            Keperluan <span class="text-danger">*</span>
                          </label>
                          
                          @if ($errors->has('keperluan'))
                              <span class="text-danger">{{ $errors->first('keperluan') }}</span>
                          @endif
                        </div>
                      </div>  

                      <div class="text-center">
                        <button type="submit" class="btn btn-primary rounded-pill btn-send mb-3" id="btnSubmit">
                          Kirim Pengajuan
                          <span class="spinner-border ml-2 d-none" id="loader"
                              style="width: 1rem; height: 1rem;" role="status">
                          </span>
                        </button>
                      </div>
                    </form>
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
          </div>
      </div>
    </div>
  </section>
@endsection

@section('script')
<script type="text/javascript">
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
            var statusSelect = document.getElementById("status_data");
            var alasanInput = document.getElementById("data");
            var alasanInput1 = document.getElementById("data1");
            var alasanInput2 = document.getElementById("data2");
            var alasanInput3 = document.getElementById("data3");
            var alasanInput5 = document.getElementById("data5");
            var alasanInput6 = document.getElementById("data6");
            var alasanInput7 = document.getElementById("data7");
            var alasanInput8 = document.getElementById("data8");
            var alasanInput9 = document.getElementById("data9");
            var alasanInput10 = document.getElementById("data10");

            statusSelect.addEventListener("change", function() {
                var selectedValue = this.value;
                if (selectedValue === "Update Data") {
                    alasanInput.style.display = "block";
                    alasanInput1.style.display = "block";
                    alasanInput2.style.display = "block";
                    alasanInput3.style.display = "block";
                    alasanInput5.style.display = "block";
                    alasanInput6.style.display = "block";
                    alasanInput7.style.display = "block";
                    alasanInput8.style.display = "block";
                    alasanInput9.style.display = "block";
                    alasanInput10.style.display = "block";
                } else {
                    alasanInput.style.display = "none";
                    alasanInput1.style.display = "none";
                    alasanInput2.style.display = "none";
                    alasanInput3.style.display = "none";
                    alasanInput5.style.display = "none";
                    alasanInput6.style.display = "none";
                    alasanInput7.style.display = "none";
                    alasanInput8.style.display = "none";
                    alasanInput9.style.display = "none";
                    alasanInput10.style.display = "none";
                }
            });
        });

        document.getElementById('nip_nrp').addEventListener('input', function(evt) {
            var input = evt.target;
            input.value = input.value.replace(/[^0-9]/g, ''); // Hanya membiarkan angka
        });

        document.getElementById('tahun_ajaran').addEventListener('input', function(evt) {
            var input = evt.target;
            input.value = input.value.replace(/[^0-9]/g, ''); // Hanya membiarkan angka
        });
</script>   
@endsection