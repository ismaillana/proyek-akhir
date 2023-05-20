@extends('layout.frontend.base')

@section('content')
  <section class="wrapper bg-soft-primary">
    <div class="container pt-10 pb-15 pt-md-14 pb-md-20 text-center">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h3 class="display-1 mb-2">Form Pengajuan</h3>
        </div>
        <!-- /column -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->
  </section>
  <!-- /section -->
  <section class="wrapper bg-light angled upper-end">
    <div class="container pb-11">
      <div class="row mb-14 mb-md-16">
        <div class="col-xl-10 mx-auto mt-n19">
          
          <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST" 
            action="{{route('izin-penelitian.store')}}">
              {{ csrf_field() }}
          <div class="card">
            <div class="card-header">
                <h4 class="display-4 mt-3  text-center">
                    Surat Izin Penelitian
                </h4>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                            <div class="messages"></div>
                            <div class="row gx-4">
                              <div class="col-md-12">
                                  <div class="form-floating mb-4">
                                      <input id="mahasiswa_id" type="text" name="mahasiswa_id" class="form-control" 
                                        value="{{$mahasiswa->user->name}}" readonly>
                                          <label for="form_name">
                                            Nama Mahasiswa <span class="text-danger">*</span>
                                          </label>
                                  </div>
                              </div>

                              <div class="col-md-12">
                                  <div class="form-floating mb-4">
                                    <input id="nim" type="text" name="nim" class="form-control" 
                                      value="{{$mahasiswa->nim}}" readonly>
                                    <label for="form_nim">
                                      NIM <span class="text-danger">*</span>
                                    </label>
                                  </div>
                              </div>

                              <div class="col-md-12">
                                  <div class="form-floating mb-4">
                                    <input id="jurusan" type="text" name="jurusan" class="form-control" 
                                      value="{{$mahasiswa->jurusan->name}}" readonly>
                                    <label for="form_jurusan">
                                      Jurusan<span class="text-danger">*</span></label>
                                  </div>
                              </div>

                              <div class="col-md-12">
                                  <div class="form-floating mb-4">
                                    <input id="prodi" type="text" name="prodi" class="form-control" 
                                      value="{{$mahasiswa->programStudi->name}}" readonly>
                                    <label for="form_prodi">
                                      Program Studi<span class="text-danger">*</span>
                                    </label>
                                  </div>
                              </div>

                              <div class="col-md-12">
                                  <div class="form-floating mb-4">
                                    <input id="nama_tempat" type="text" name="nama_tempat" class="form-control @error('nama_tempat')is-invalid @enderror" 
                                      value="{{ old('nama_tempat', @$izinPenelitian->name_tempat) }}" placeholder="Nama Tempat Penelitian (Instansi)">
                                    <label for="form_nama_tempat">
                                      Nama Tempat Penelitian (Instansi)<span class="text-danger">*</span>
                                    </label>
                                    @if ($errors->has('nama_tempat'))
                                        <span class="text-danger">{{ $errors->first('nama_tempat') }}</span>
                                    @endif
                                  </div>
                              </div>
                            
                              <div class="col-12">
                                  <div class="form-floating mb-4">
                                    <textarea id="alamat_penelitian" name="alamat_penelitian" class="form-control @error('alamat_penelitian')is-invalid @enderror" 
                                      style="height: 150px" placeholder="Alamat Lengkap">{{ old('alamat_penelitian', @$aktifKuliah->alamat_penelitian) }}</textarea>
                                    <label for="form_message">
                                      Alamat Lengkap <span class="text-danger">*</span>
                                    </label>
                                    @if ($errors->has('alamat_penelitian'))
                                        <span class="text-danger">{{ $errors->first('alamat_penelitian') }}</span>
                                    @endif
                                  </div>
                              </div>

                              <div class="col-md-12">
                                  <div class="form-floating mb-4">
                                    <input id="tujuan_surat" type="text" name="tujuan_surat" class="form-control @error('tujuan_surat')is-invalid @enderror" 
                                      value="{{ old('tujuan_surat', @$izinPenelitian->tujuan_surat) }}" placeholder="Ditujukan Kepada">
                                    <label for="form_tujuan_surat">
                                      Ditujukan Kepada<span class="text-danger">*</span>
                                    </label>
                                    @if ($errors->has('tujuan_surat'))
                                        <span class="text-danger">{{ $errors->first('tujuan_surat') }}</span>
                                    @endif
                                  </div>
                              </div>

                              <div class="col-md-12">
                                  <div class="form-floating mb-4">
                                    <input id="perihal" type="text" name="perihal" class="form-control @error('perihal')is-invalid @enderror"  
                                      value="{{ old('perihal', @$izinPenelitian->perihal) }}" placeholder="Perihal">
                                    <label for="form_perihal">
                                      Perihal<span class="text-danger">*</span>
                                    </label>
                                    @if ($errors->has('perihal'))
                                        <span class="text-danger">{{ $errors->first('perihal') }}</span>
                                    @endif
                                  </div>
                              </div>

                              <div class="col-12 text-center">
                                  <input type="submit" class="btn btn-primary rounded-pill btn-send mb-3" value="Kirim Pengajuan">
                                  <p class="text-muted"><strong>*</strong> These fields are .</p>
                              </div>
                              <!-- /column -->
                            </div>
                            <!-- /.row -->
                            <!-- /form -->
                          </div>
                          <!-- /column -->
                        </div>
                      </div>
                      <!--/.row -->
                    </div>
                    <!-- /.card -->
                  </form>
        </div>
        <!-- /column -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->
  </section>
@endsection