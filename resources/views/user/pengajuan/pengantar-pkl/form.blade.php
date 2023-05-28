@extends('layout.frontend.base')

@section('content')
  <section class="wrapper bg-soft-primary">
    <div class="container pt-10 pb-15 pt-md-14 pb-md-20 text-center">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <h3 class="display-1 mb-2">Form Pengajuan</h3>
        </div>
      </div>
    </div>
  </section>
  <!-- /section -->
  <section class="wrapper bg-light angled upper-end">
    <div class="container pb-11">
      <div class="row mb-14 mb-md-16">
        <div class="col-xl-10 mx-auto mt-n19">
          
          <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST" 
            action="{{route('pengantar-pkl.store')}}">
            {{ csrf_field() }}
            <div class="card">
              <div class="card-header">
                  <h4 class="display-4 mt-3  text-center">
                      Pengantar PKL
                  </h4>
              </div>

              <div class="card-body">
                <div class="row">
                  <div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                    <div class="row gx-4">
                      <div class="col-md-12">
                          <div class="form-floating mb-4">
                            <input id="mulai" type="datetime-local" name="mulai" class="form-control @error('mulai')is-invalid @enderror" 
                              value="{{ old('mulai', @$pengantarPkl->mulai) }}" placeholder="Waktu Mulai">
                            
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
                                value="{{ old('selesai', @$pengantarPkl->selesai) }}" placeholder="Waktu Selesai">
                            
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
                            id="nama_mahasiswa" multiple aria-placeholder="kjgfsdg">
                            @foreach ($mahasiswa as $item)
                                <option value="{{ $item->id }}"
                                  {{ old('nama_mahasiswa', @$pengantarPkl->nama_mahasiswa) == $item->id ? 'selected' : '' }}>
                                  {{ $item->user->name }} - {{$item->nim}}
                                </option>
                            @endforeach
                          </select>

                          @if ($errors->has('nama_mahasiswa'))
                              <span class="text-danger">{{ $errors->first('nama_mahasiswa') }}</span>
                          @endif
                      </div>

                      <div class="col-md-12">
                          <div class="form-floating mb-4 mt-4">
                            <input id="nama_perusahaan" type="text" name="nama_perusahaan" class="form-control @error('nama_perusahaan')is-invalid @enderror" 
                              value="{{ old('nama_perusahaan', @$pengantarPkl->nama_perusahaan) }}" placeholder="Nama Perusahaan">
                            
                            <label for="form_nama_perusahaan">
                              Nama Perusahaan<span class="text-danger">*</span>
                            </label>

                            @if ($errors->has('nama_perusahaan'))
                                <span class="text-danger">{{ $errors->first('nama_perusahaan') }}</span>
                            @endif
                          </div>
                      </div>

                      <div class="col-md-12">
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

                      <div class="col-md-12">
                          <div class="form-floating mb-4 mt-4">
                            <input id="telepon" type="text" name="telepon" class="form-control @error('telepon')is-invalid @enderror" 
                              value="{{ old('telepon', @$pengantarPkl->telepon) }}" placeholder="Nomor Telepon Perusahaan">
                            
                            <label for="form_nama_perusahaan">
                              Nomor Telepon Perusahaan
                            </label>

                            @if ($errors->has('telepon'))
                                <span class="text-danger">{{ $errors->first('telepon') }}</span>
                            @endif
                          </div>
                      </div>

                      <div class="col-md-12">
                          <div class="form-floating mb-4">
                            <input id="kepada" type="text" name="kepada" class="form-control @error('kepada')is-invalid @enderror" 
                              value="{{ old('kepada', @$pengantarPkl->kepada) }}" placeholder="Ditujakan Kepada">
                            
                            <label for="form_nama_tempat">
                              Ditujakan Kepada<span class="text-danger">*</span>
                            </label>

                            @if ($errors->has('kepada'))
                                <span class="text-danger">{{ $errors->first('kepada') }}</span>
                            @endif
                          </div>
                      </div>

                      <div class="col-12">
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

                      <div class="col-12 text-center">
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
            </div>
          </form>
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