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
                            
                            @if ($errors->has('status_data'))
                                <span class="text-danger">{{ $errors->first('status_data') }}</span>
                            @endif
                          </select>
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
                            value="{{ old('pangkat', @$aktifKuliah->mahasiswa->pangkat) }}" placeholder="Masukan Pangkat">
                          
                          <label for="form_tujuan_surat">
                            Pangkat<span class="text-danger">*</span>
                          </label>

                          @if ($errors->has('pangkat'))
                              <span class="text-danger">{{ $errors->first('pangkat') }}</span>
                          @endif
                        </div>
                      </div>

                      <div class="col-md-12" id="data4" style="display: none;">
                        <div class="form-floating mb-4">
                          <input id="golongan" type="text" name="golongan" class="form-control @error('golongan')is-invalid @enderror" 
                            value="{{ old('golongan', @$aktifKuliah->mahasiswa->golongan) }}" placeholder="Masukan Golongan">
                          
                          <label for="form_tujuan_surat">
                            Golongan<span class="text-danger">*</span>
                          </label>

                          @if ($errors->has('golongan'))
                              <span class="text-danger">{{ $errors->first('golongan') }}</span>
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
            var alasanInput4 = document.getElementById("data4");
            var alasanInput5 = document.getElementById("data5");
            var alasanInput6 = document.getElementById("data6");

            statusSelect.addEventListener("change", function() {
                var selectedValue = this.value;
                if (selectedValue === "Update Data") {
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

        document.getElementById('nip_nrp').addEventListener('input', function(evt) {
            var input = evt.target;
            input.value = input.value.replace(/[^0-9]/g, ''); // Hanya membiarkan angka
        });
</script>   
@endsection