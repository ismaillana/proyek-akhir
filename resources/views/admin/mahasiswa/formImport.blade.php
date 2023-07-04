@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{route('mahasiswa.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>

        <h1>
            Import Data Mahasiswa
        </h1>
      </div>

        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST" 
            action="{{route('import-excel-store')}}">
            {{ csrf_field() }}
            <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Mahasiswa</h4>
                        </div>
                        
                        <div class="card-body">
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Program Studi<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <select name="program_studi_id" id="program_studi_id"
                                        class="form-control @error('program_studi_id')
                                        is-invalid @enderror">
                                        <option value="" selected="" disabled="">Pilih Program Studi</option>
                                        @foreach ($prodi as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('program_studi_id', @$mahasiswa->program_studi_id) == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('program_studi_id'))
                                        <span class="text-danger">
                                            {{ $errors->first('program_studi_id') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="image" class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    File Excel
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <div class="input-group">
                                        <input class="dropify @error('file') is-invalid @enderror" type="file" 
                                            name="file" data-height='250' data-allowed-file-extensions="xlsx xls" data-max-file-size="5M">
                                    </div>

                                    <div class="text text-info">
                                        <small>
                                            Panduan / Contoh File Import Mahasiswa bisa dilihat pada link berikut
                                            <a href="{{ asset('/ImportMahasiswa.xlsx')}}" class="mr-2" download>
                                                Download File
                                            </a>
                                        </small>
                                    </div>

                                    @if ($errors->has('file'))
                                        <span class="text-danger">
                                            {{ $errors->first('file') }}
                                        </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row mb-4">
                                <div class="col-sm-12 col-md-7 offset-md-3">
                                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                                        Import
                                        <span class="spinner-border ml-2 d-none" id="loader"
                                            style="width: 1rem; height: 1rem;" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </form>
    </section>
</div>
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
</script>
@endsection