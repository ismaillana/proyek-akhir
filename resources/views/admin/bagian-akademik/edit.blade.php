@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{route('bagianAkademik.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>
            Edit Data Bagian Akademik
        </h1>
      </div>

        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST"
            action="{{route('bagianAkademik.update', $bagianAkademik) }}">
            @method('put')
            {{ csrf_field() }}
            <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Bagian Akademik</h4>
                        </div>

                        <div class="card-body">
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Nama Bagian Akademik<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('name')is-invalid @enderror"
                                        id="name" name="name" placeholder="Masukkan Nama Bagian Akademik" 
                                        value="{{ old('name', @$bagianAkademik->name) }}">

                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    NIP<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('nomor_induk')is-invalid @enderror"
                                        id="nomor_induk" name="nomor_induk" placeholder="Masukkan NIP" 
                                        value="{{ old('nomor_induk', @$bagianAkademik->nomor_induk) }}">

                                    @if ($errors->has('nomor_induk'))
                                        <span class="text-danger">{{ $errors->first('nomor_induk') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Email<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="email" class="form-control @error('email')is-invalid @enderror"
                                        id="email" name="email" placeholder="Masukkan Email" 
                                        value="{{ old('email', @$bagianAkademik->email) }}">

                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                No WhatsApp<sup class="text-danger">*</sup>
                                </label>
                                    
                                
                                <div class="col-sm-12 col-md-7">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            +62
                                        </div>

                                        <input type="text" maxlength="13" class="form-control @error('wa') is-invalid @enderror"
                                            id="wa" name="wa" placeholder="Masukan Nomer Whatsapp "
                                            value="{{ old('wa', Str::substr(@$bagianAkademik->wa, 2)) }}">
                                    </div>

                                    @if ($errors->has('wa'))
                                        <span class="text-danger">{{ $errors->first('wa') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="image" class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Foto Pribadi
                                </label>
                                <div class="col-sm-12 col-md-7">
                                    <input class="dropify @error('image') is-invalid @enderror" 
                                        data-height='250' type="file" name="image" id="image" 
                                        data-default-file="{{ @$bagianAkademik->image_url }}">
                                </div>
                            </div>
                            
                            <div class="form-group row mb-4">
                                <div class="col-sm-12 col-md-7 offset-md-3">
                                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                                        Edit
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
                cancelButtonText: 'Batal',
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

        document.getElementById('wa').addEventListener('input', function(evt) {
            var input = evt.target;
            input.value = input.value.replace(/[^0-9]/g, ''); // Hanya membiarkan angka
        });

        document.getElementById('nomor_induk').addEventListener('input', function(evt) {
            var input = evt.target;
            input.value = input.value.replace(/[^0-9]/g, ''); // Hanya membiarkan angka
        });
</script>
@endsection