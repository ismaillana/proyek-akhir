@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{route('instansi.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>
            @if (@$instansi->exists)
                Edit
                @php
                    $aksi = 'Edit';
                @endphp
            @else
                Tambah
                @php
                    $aksi = 'Tambah'
                @endphp
            @endif
            Data Instansi
        </h1>
      </div>

      @if (@$instansi->exists)
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST"
            action="{{route('instansi.update', $instansi) }}">
            @method('put')
      @else
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST" 
            action="{{route('instansi.store')}}">
      @endif
            {{ csrf_field() }}
            <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Instansi</h4>
                        </div>
                        
                        <div class="card-body">
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Nama Instansi<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('name')is-invalid @enderror"
                                        id="name" name="name" placeholder="Masukkan Nama instansi" 
                                        value="{{ old('name', @$instansi->user->name) }}">

                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
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
                                        value="{{ old('email', @$instansi->user->email) }}">

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
                                            value="{{ old('wa', Str::substr(@$instansi->user->wa, 2)) }}">
                                    </div>

                                    @if ($errors->has('wa'))
                                        <span class="text-danger">{{ $errors->first('wa') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Alamat<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('alamat')is-invalid @enderror"
                                        id="alamat" name="alamat" placeholder="Masukkan Alamat" 
                                        value="{{ old('alamat', @$instansi->alamat) }}">

                                    @if ($errors->has('alamat'))
                                        <span class="text-danger">{{ $errors->first('alamat') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Password<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="password" class="form-control @error('password')is-invalid @enderror"
                                        id="password" name="password" placeholder="Masukkan Password" 
                                        value="{{ old('password', @$instansi->password) }}">

                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <div class="col-sm-12 col-md-7 offset-md-3">
                                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                                        {{ $aksi }}
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
</script>
@endsection