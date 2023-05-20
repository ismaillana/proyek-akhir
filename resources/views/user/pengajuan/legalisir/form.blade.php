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
            action="{{route('legalisir.store')}}">
              {{ csrf_field() }}
          <div class="card">
            <div class="card-header">
                <h4 class="display-4 mt-3  text-center">
                    Legalisir
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
                                    <input id="tahun_lulus" type="text" name="tahun_lulus" class="form-control @error('tahun_lulus')is-invalid @enderror" 
                                      value="{{ $ijazah->tahun_lulus }}" placeholder="Tahun Lulusan" readonly>
                                    <label for="form_nama_tempat">
                                      Tahun Lulusan<span class="text-danger">*</span>
                                    </label>
                                    @if ($errors->has('tahun_lulus'))
                                        <span class="text-danger">{{ $errors->first('tahun_lulus') }}</span>
                                    @endif
                                  </div>
                              </div>

                              <div class="col-md-12">
                                  <div class="form-floating mb-4">
                                    <input id="no_ijazah" type="text" name="no_ijazah" class="form-control @error('no_ijazah')is-invalid @enderror" 
                                      value="{{ $ijazah->no_ijazah }}" placeholder="Nomor Ijazah" readonly>
                                    <label for="form_nama_tempat">
                                      Nomor Ijazah<span class="text-danger">*</span>
                                    </label>
                                    @if ($errors->has('no_ijazah'))
                                        <span class="text-danger">{{ $errors->first('no_ijazah') }}</span>
                                    @endif
                                  </div>
                              </div>

                              <div class="col-md-12">
                                  <div class="form-floating mb-4">
                                    <input id="keperluan" type="text" name="keperluan" class="form-control @error('keperluan')is-invalid @enderror" 
                                      value="{{ old('keperluan', @$legalisir->keperluan) }}" placeholder="Keperluan">
                                    <label for="form_nama_tempat">
                                      Keperluan<span class="text-danger">*</span>
                                    </label>
                                    @if ($errors->has('keperluan'))
                                        <span class="text-danger">{{ $errors->first('keperluan') }}</span>
                                    @endif
                                  </div>
                              </div>

                              <div class="col-md-12">
                                  <div class="form-floating mb-4">
                                    <input id="pekerjaan_terakhir" type="text" name="pekerjaan_terakhir" class="form-control @error('pekerjaan_terakhir')is-invalid @enderror" 
                                      value="{{ old('pekerjaan_terakhir', @$legalisir->pekerjaan_terakhir) }}" placeholder="Pekerjaan Terakhir">
                                    <label for="form_nama_tempat">
                                      Pekerjaan Terakhir<span class="text-danger">*</span>
                                    </label>
                                    @if ($errors->has('pekerjaan_terakhir'))
                                        <span class="text-danger">{{ $errors->first('pekerjaan_terakhir') }}</span>
                                    @endif
                                  </div>
                              </div>

                              <div class="col-md-12">
                                  <div class="form-floating mb-4">
                                    <input id="tempat_pekerjaan_terakhir" type="text" name="tempat_pekerjaan_terakhir" class="form-control @error('tempat_pekerjaan_terakhir')is-invalid @enderror" 
                                      value="{{ old('tempat_pekerjaan_terakhir', @$legalisir->tempat_pekerjaan_terakhir) }}" placeholder="Tempat Pekerjaan Terakhir">
                                    <label for="form_nama_tempat">
                                      Tempat Pekerjaan Terakhir<span class="text-danger">*</span>
                                    </label>
                                    @if ($errors->has('tempat_pekerjaan_terakhir'))
                                        <span class="text-danger">{{ $errors->first('tempat_pekerjaan_terakhir') }}</span>
                                    @endif
                                  </div>
                              </div>

                              <div class="col-md-12">
                                  <div class="form-floating mb-4">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                      <label class="form-check-label" for="flexCheckDefault"> Default checkbox </label>
                                    </div>
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                      <label class="form-check-label" for="flexCheckChecked"> Checked checkbox </label>
                                    </div>
                                    @if ($errors->has('no_ijazah'))
                                        <span class="text-danger">{{ $errors->first('no_ijazah') }}</span>
                                    @endif
                                  </div>
                              </div>

                              <div class="col-md-12">
                                <label for="form_nama_tempat">
                                  Tempat Pekerjaan Terakhir<span class="text-danger">*</span>
                                </label>
                                  <div class="form-floating mb-4">
                                    {{-- <div class="col-sm-12 col-md-7"> --}}
                                      <input class="dropify @error('image') is-invalid @enderror" 
                                      data-height='250' type="file" name="image" id="image" 
                                      data-default-file="{{ @$mahasiswa->image_url }}">
                                  {{-- </div> --}}
                                    
                                    @if ($errors->has('no_ijazah'))
                                        <span class="text-danger">{{ $errors->first('no_ijazah') }}</span>
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