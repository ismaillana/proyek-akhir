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
            action="{{route('dispensasi.store')}}">
              {{ csrf_field() }}
          <div class="card">
            <div class="card-header">
                <h4 class="display-4 mt-3  text-center">
                    Dispenasasi
                </h4>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                            <div class="messages"></div>
                            <div class="row gx-4">

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
                                    @foreach ($mahasiswa as $item)
                                        <option value="{{ $item->id }}"
                                          {{ old('nama_mahasiswa', @$dispensasi->nama_mahasiswa) == $item->id ? 'selected' : '' }}>
                                          {{ $item->user->name }} - {{$item->nim}}
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

@section('script')
<script>
  new MultiSelectTag('nama_mahasiswa')  // id
</script>
@endsection