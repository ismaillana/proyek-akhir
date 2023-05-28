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
                    <div class="row gx-4">
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
                        <label for="form_name" class="mb-1">
                            Jenis Dokumen<span class="text-danger">*</span>
                        </label>

                          <select class="form-select @error('jenis_legalisir_id')
                          is-invalid @enderror" name="jenis_legalisir_id[]"
                            id="jenis_legalisir_id" multiple>
                            @foreach ($jenisDokumen as $item)
                                <option value="{{ $item->id }}"
                                  {{ old('jenis_legalisir_id', @$legalisir->jenis_legalisir_id) == $item->id ? 'selected' : '' }}>
                                  {{ $item->name }}
                                </option>
                            @endforeach
                          </select>

                          @if ($errors->has('jenis_legalisir_id'))
                              <span class="text-danger">{{ $errors->first('jenis_legalisir_id') }}</span>
                          @endif
                      </div>

                      <div class="col-md-12">
                        <label for="form_name" class="mt-1 mb-1">
                            Dokumen<span class="text-danger">*</span>
                        </label>

                        <div class="form-floating mb-4">
                            <div class="col-sm-12 col-md-12">
                              <input id="dokumen" type="file" name="dokumen" class="form-control @error('dokumen')is-invalid @enderror" 
                              value="{{ old('dokumen', @$legalisir->dokumen) }}" placeholder="Tahun Lulus">
                              
                              @if ($errors->has('dokumen'))
                                  <span class="text-danger">{{ $errors->first('dokumen') }}</span>
                              @endif
                            </div>
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
<script type="text/javascript">
  new MultiSelectTag('jenis_legalisir_id')  // id

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