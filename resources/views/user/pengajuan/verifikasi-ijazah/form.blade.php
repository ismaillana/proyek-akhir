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
            action="{{route('verifikasi-ijazah.store')}}">
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
                                      <input id="name" type="text" name="name" class="form-control @error('name')is-invalid @enderror" 
                                        value="{{ old('name', @$verifikasiIjazah->name) }}" placeholder="Nama Mahasiswa">
                                        <label for="form_name">
                                            Nama Mahasiswa <span class="text-danger">*</span>
                                        </label>
                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                  </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-floating mb-4">
                                    <input id="nim" type="text" name="nim" class="form-control @error('nim')is-invalid @enderror" 
                                    value="{{ old('nim', @$verifikasiIjazah->nim) }}" placeholder="NIM">
                                    <label for="form_name">
                                        NIM<span class="text-danger">*</span>
                                    </label>
                                    @if ($errors->has('nim'))
                                        <span class="text-danger">{{ $errors->first('nim') }}</span>
                                    @endif
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-floating mb-4">
                                    <input id="no_ijazah" type="text" name="no_ijazah" class="form-control @error('no_ijazah')is-invalid @enderror" 
                                    value="{{ old('no_ijazah', @$verifikasiIjazah->no_ijazah) }}" placeholder="No_Ijazah">
                                    <label for="form_name">
                                        No Ijazah<span class="text-danger">*</span>
                                    </label>
                                    @if ($errors->has('no_ijazah'))
                                        <span class="text-danger">{{ $errors->first('no_ijazah') }}</span>
                                    @endif
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-floating mb-4">
                                    <input id="tahun_lulus" type="text" name="tahun_lulus" class="form-control @error('tahun_lulus')is-invalid @enderror" 
                                    value="{{ old('tahun_lulus', @$verifikasiIjazah->tahun_lulus) }}" placeholder="Tahun Lulus">
                                    <label for="form_name">
                                        Tahun Lulus<span class="text-danger">*</span>
                                    </label>
                                    @if ($errors->has('tahun_lulus'))
                                        <span class="text-danger">{{ $errors->first('tahun_lulus') }}</span>
                                    @endif
                                </div>
                              </div>

                              <div class="col-md-12">
                                <label for="form_name">
                                    Tahun Lulus<span class="text-danger">*</span>
                                </label>
                                <div class="form-floating mb-4">
                                    <div class="col-sm-12 col-md-12">
                                    <input id="dokumen" type="file" name="dokumen" class="form-control @error('dokumen')is-invalid @enderror" 
                                    value="{{ old('dokumen', @$verifikasiIjazah->dokumen) }}" placeholder="Tahun Lulus">
                                    @if ($errors->has('dokumen'))
                                        <span class="text-danger">{{ $errors->first('dokumen') }}</span>
                                    @endif
                                    </div>
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