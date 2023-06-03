@extends('layout.frontend.base')

@section('content')
  <section class="wrapper bg-dark angled lower-start">
    <div class="container py-14 pt-md-10 pb-md-21">
      <div class="row gx-lg-8 gx-xl-12 gy-10 gy-lg-0 mb-2 align-items-end">
        <div class="col-lg-12 text-center">
          <h2 class="fs-16 text-uppercase text-line text-primary mb-3">Pengajuan</h2>
          <h3 class="display-4 text-center text-white">Surat Keterangan Aktif Kuliah</h3>
        </div>
      </div>
    </div>
  </section>

  <section class="wrapper bg-light angled upper-end lower-start">
    <div class="container py-16 py-md-18 position-relative">
      <div class="position-relative mt-n18 mt-md-n23 mb-16 mb-md-18">
        <div class="shape rounded-circle bg-line primary rellax w-18 h-18" data-rellax-speed="1" style="top: -2rem; right: -2.7rem; z-index:0;"></div>
        <div class="shape rounded-circle bg-soft-primary rellax w-18 h-18" data-rellax-speed="1" style="bottom: -1rem; left: -3rem; z-index:0;"></div>
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST" 
          action="{{route('aktif-kuliah.store')}}">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
              <div class="card card-border-start border-primary">
                <div class="card-header">
                    <h4 class="display-4 mt-3  text-center">
                        Surat Keterangan Aktif Kuliah
                    </h4>
                </div>

                <div class="card-body">
                  <div class="">
                      <div class="form-floating mb-4">
                          <input id="mahasiswa_id" type="text" name="mahasiswa_id" class="form-control" 
                            value="{{$mahasiswa->user->name}}" readonly>

                          <label for="form_name">
                            Nama Mahasiswa <span class="text-danger">*</span>
                          </label>
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="nim" type="text" name="nim" class="form-control" 
                          value="{{$mahasiswa->nim}}" readonly>

                        <label for="form_nim">
                          NIM<span class="text-danger">*</span>
                        </label>
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="jurusan" type="text" name="jurusan" class="form-control" 
                          value="{{$mahasiswa->jurusan->name}}" readonly>

                        <label for="form_jurusan">
                          Jurusan<span class="text-danger">*</span></label>
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="prodi" type="text" name="prodi" class="form-control" 
                          value="{{$mahasiswa->programStudi->name}}" readonly>
                          
                        <label for="form_prodi">
                          Program Studi<span class="text-danger">*</span>
                        </label>
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="tempat_lahir" type="text" name="tempat_lahir" class="form-control @error('tempat_lahir')is-invalid @enderror" 
                          value="{{ old('tempat_lahir', @$aktifKuliah->tempat_lahir) }}" placeholder="Tempat Lahir">
                        
                        <label for="form_tempat_lahir">
                          Tempat Lahir<span class="text-danger">*</span>
                        </label>

                        @if ($errors->has('tempat_lahir'))
                            <span class="text-danger">{{ $errors->first('tempat_lahir') }}</span>
                        @endif
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="tanggal_lahir" type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir')is-invalid @enderror" 
                          value="{{ old('tanggal_lahir', @$aktifKuliah->tanggal_lahir) }}" placeholder="Tanggal Lahir">
                        
                        <label for="form_email">
                          Tanggal Lahir<span class="text-danger">*</span>
                        </label>

                        @if ($errors->has('tanggal_lahir'))
                            <span class="text-danger">{{ $errors->first('tanggal_lahir') }}</span>
                        @endif
                      </div>
                  </div>

                  <div class="">
                      <div class="form-select-wrapper mb-4">
                        <select class="form-select @error('semester')is-invalid @enderror" id="form-select" name="semester" >
                            <option selected disabled value="">Pilih Semester</option>
                            <option value="1"
                              {{ old('semester', @$aktifKuliah->semester) == '1' ? 'selected' : '' }}>
                                1</option>
                            <option value="2"
                              {{ old('semester', @$aktifKuliah->semester) == '2' ? 'selected' : '' }}>
                                2</option>
                            <option value="3"
                              {{ old('semester', @$aktifKuliah->semester) == '3' ? 'selected' : '' }}>
                                3</option>
                            <option value="4"
                              {{ old('semester', @$aktifKuliah->semester) == '4' ? 'selected' : '' }}>
                                4</option>
                            <option value="5"
                              {{ old('semester', @$aktifKuliah->semester) == '5' ? 'selected' : '' }}>
                                5</option>
                            <option value="6"
                              {{ old('semester', @$aktifKuliah->semester) == '6' ? 'selected' : '' }}>
                                6</option>
                        </select>

                        @if ($errors->has('semester'))
                          <span class="text-danger">
                              {{ $errors->first('semester') }}
                          </span>
                        @endif
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="tahun_ajaran" type="text" name="tahun_ajaran" class="form-control @error('tahun_ajaran')is-invalid @enderror" 
                          value="{{ old('tahun_ajaran', @$aktifKuliah->tahun_ajaran) }}" placeholder="Tahun Ajaran">
                        
                        <label for="form_tahun_ajaran">
                          Tahun Ajaran<span class="text-danger">*</span>
                        </label>

                        @if ($errors->has('tahun_ajaran'))
                            <span class="text-danger">{{ $errors->first('tahun_ajaran') }}</span>
                        @endif
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="orang_tua" type="text" name="orang_tua" class="form-control @error('orang_tua')is-invalid @enderror"  
                          value="{{ old('orang_tua', @$aktifKuliah->orang_tua) }}" placeholder="Nama Orang Tua">
                        
                        <label for="form_orang_tua">
                          Nama Orang Tua<span class="text-danger">*</span>
                        </label>

                        @if ($errors->has('orang_tua'))
                            <span class="text-danger">{{ $errors->first('orang_tua') }}</span>
                        @endif
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="pekerjaan" type="text" name="pekerjaan" class="form-control @error('pekerjaan')is-invalid @enderror" 
                          value="{{ old('pekerjaan', @$aktifKuliah->pekerjaan) }}" placeholder="Pekerjaan Orang Tua">
                        
                        <label for="form_pekerjaan">
                          Pekerjaan Orang Tua<span class="text-danger">*</span>
                        </label>
                        
                        @if ($errors->has('pekerjaan'))
                            <span class="text-danger">{{ $errors->first('pekerjaan') }}</span>
                        @endif
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="nip_nrp" type="text" name="nip_nrp" class="form-control" 
                          value="{{ old('nip_nrp', @$aktifKuliah->nip_nrp) }}" placeholder="NIP/NRP Orang Tua">
                        
                        <label for="form_nip_nrp">
                          NIP/NRP Orang Tua
                        </label>
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="pangkat" type="text" name="pangkat" class="form-control"
                          value="{{ old('pangkat', @$aktifKuliah->pangkat) }}" placeholder="Pangkat Orang Tua">
                        
                        <label for="form_pangkat">
                          Pangkat Orang Tua
                        </label>
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="jabatan" type="text" name="jabatan" class="form-control" 
                          value="{{ old('jabatan', @$aktifKuliah->jabatan) }}" placeholder="Jabatan Orang Tua">
                        
                        <label for="form_jabatan">
                          Jabatan Orang Tua
                        </label>
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="instansi" type="text" name="instansi" class="form-control"
                          value="{{ old('instansi', @$aktifKuliah->instansi) }}" placeholder="Instansi">
                        
                        <label for="form_instansi">
                          Instansi
                        </label>
                      </div>
                  </div>

                  <div class="">
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
                </div>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
              <div class="card card-border-start border-primary">
                <div class="card-header">
                    <h4 class="display-4 mt-3  text-center">
                        Surat Keterangan Aktif Kuliah
                    </h4>
                </div>

                <div class="card-body">
                  <div class="">
                      <div class="form-floating mb-4">
                          <input id="mahasiswa_id" type="text" name="mahasiswa_id" class="form-control" 
                            value="{{$mahasiswa->user->name}}" readonly>

                          <label for="form_name">
                            Nama Mahasiswa <span class="text-danger">*</span>
                          </label>
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="nim" type="text" name="nim" class="form-control" 
                          value="{{$mahasiswa->nim}}" readonly>

                        <label for="form_nim">
                          NIM<span class="text-danger">*</span>
                        </label>
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="jurusan" type="text" name="jurusan" class="form-control" 
                          value="{{$mahasiswa->jurusan->name}}" readonly>

                        <label for="form_jurusan">
                          Jurusan<span class="text-danger">*</span></label>
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="prodi" type="text" name="prodi" class="form-control" 
                          value="{{$mahasiswa->programStudi->name}}" readonly>
                          
                        <label for="form_prodi">
                          Program Studi<span class="text-danger">*</span>
                        </label>
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="tempat_lahir" type="text" name="tempat_lahir" class="form-control @error('tempat_lahir')is-invalid @enderror" 
                          value="{{ old('tempat_lahir', @$aktifKuliah->tempat_lahir) }}" placeholder="Tempat Lahir">
                        
                        <label for="form_tempat_lahir">
                          Tempat Lahir<span class="text-danger">*</span>
                        </label>

                        @if ($errors->has('tempat_lahir'))
                            <span class="text-danger">{{ $errors->first('tempat_lahir') }}</span>
                        @endif
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="tanggal_lahir" type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir')is-invalid @enderror" 
                          value="{{ old('tanggal_lahir', @$aktifKuliah->tanggal_lahir) }}" placeholder="Tanggal Lahir">
                        
                        <label for="form_email">
                          Tanggal Lahir<span class="text-danger">*</span>
                        </label>

                        @if ($errors->has('tanggal_lahir'))
                            <span class="text-danger">{{ $errors->first('tanggal_lahir') }}</span>
                        @endif
                      </div>
                  </div>

                  <div class="">
                      <div class="form-select-wrapper mb-4">
                        <select class="form-select @error('semester')is-invalid @enderror" id="form-select" name="semester" >
                            <option selected disabled value="">Pilih Semester</option>
                            <option value="1"
                              {{ old('semester', @$aktifKuliah->semester) == '1' ? 'selected' : '' }}>
                                1</option>
                            <option value="2"
                              {{ old('semester', @$aktifKuliah->semester) == '2' ? 'selected' : '' }}>
                                2</option>
                            <option value="3"
                              {{ old('semester', @$aktifKuliah->semester) == '3' ? 'selected' : '' }}>
                                3</option>
                            <option value="4"
                              {{ old('semester', @$aktifKuliah->semester) == '4' ? 'selected' : '' }}>
                                4</option>
                            <option value="5"
                              {{ old('semester', @$aktifKuliah->semester) == '5' ? 'selected' : '' }}>
                                5</option>
                            <option value="6"
                              {{ old('semester', @$aktifKuliah->semester) == '6' ? 'selected' : '' }}>
                                6</option>
                        </select>

                        @if ($errors->has('semester'))
                          <span class="text-danger">
                              {{ $errors->first('semester') }}
                          </span>
                        @endif
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="tahun_ajaran" type="text" name="tahun_ajaran" class="form-control @error('tahun_ajaran')is-invalid @enderror" 
                          value="{{ old('tahun_ajaran', @$aktifKuliah->tahun_ajaran) }}" placeholder="Tahun Ajaran">
                        
                        <label for="form_tahun_ajaran">
                          Tahun Ajaran<span class="text-danger">*</span>
                        </label>

                        @if ($errors->has('tahun_ajaran'))
                            <span class="text-danger">{{ $errors->first('tahun_ajaran') }}</span>
                        @endif
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="orang_tua" type="text" name="orang_tua" class="form-control @error('orang_tua')is-invalid @enderror"  
                          value="{{ old('orang_tua', @$aktifKuliah->orang_tua) }}" placeholder="Nama Orang Tua">
                        
                        <label for="form_orang_tua">
                          Nama Orang Tua<span class="text-danger">*</span>
                        </label>

                        @if ($errors->has('orang_tua'))
                            <span class="text-danger">{{ $errors->first('orang_tua') }}</span>
                        @endif
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="pekerjaan" type="text" name="pekerjaan" class="form-control @error('pekerjaan')is-invalid @enderror" 
                          value="{{ old('pekerjaan', @$aktifKuliah->pekerjaan) }}" placeholder="Pekerjaan Orang Tua">
                        
                        <label for="form_pekerjaan">
                          Pekerjaan Orang Tua<span class="text-danger">*</span>
                        </label>
                        
                        @if ($errors->has('pekerjaan'))
                            <span class="text-danger">{{ $errors->first('pekerjaan') }}</span>
                        @endif
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="nip_nrp" type="text" name="nip_nrp" class="form-control" 
                          value="{{ old('nip_nrp', @$aktifKuliah->nip_nrp) }}" placeholder="NIP/NRP Orang Tua">
                        
                        <label for="form_nip_nrp">
                          NIP/NRP Orang Tua
                        </label>
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="pangkat" type="text" name="pangkat" class="form-control"
                          value="{{ old('pangkat', @$aktifKuliah->pangkat) }}" placeholder="Pangkat Orang Tua">
                        
                        <label for="form_pangkat">
                          Pangkat Orang Tua
                        </label>
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="jabatan" type="text" name="jabatan" class="form-control" 
                          value="{{ old('jabatan', @$aktifKuliah->jabatan) }}" placeholder="Jabatan Orang Tua">
                        
                        <label for="form_jabatan">
                          Jabatan Orang Tua
                        </label>
                      </div>
                  </div>

                  <div class="">
                      <div class="form-floating mb-4">
                        <input id="instansi" type="text" name="instansi" class="form-control"
                          value="{{ old('instansi', @$aktifKuliah->instansi) }}" placeholder="Instansi">
                        
                        <label for="form_instansi">
                          Instansi
                        </label>
                      </div>
                  </div>

                  <div class="">
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
                </div>
              </div>
            </div>
          </div>
        </form>
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
</script>   
@endsection