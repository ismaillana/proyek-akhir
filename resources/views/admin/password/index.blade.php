@extends('layout.backend.base')
@section('content')
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
            <a href="{{route('dashboard')}}" class="btn btn-icon">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <h1>
            Password
        </h1>
      </div>
      <div class="section-body">
        <h2 class="section-title">Hai, {{@$user->name}}</h2>
        <p class="section-lead">
          Ubah Data Password Anda.
        </p>

        <div class="row mt-sm-4">
          <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
              <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST"
                action="{{route('update-password', $user) }}">
                @csrf
                <div class="card-header">
                  <h4>
                    Edit Profile
                  </h4>
                </div>

                <div class="card-body">
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                            Password<sup class="text-danger">*</sup>
                        </label>

                        <div class="col-sm-12 col-md-7">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                name="password" autocomplete="new-password" placeholder="Masukkan Password">

                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                            Konfirmasi Password<sup class="text-danger">*</sup>
                        </label>

                        <div class="col-sm-12 col-md-7">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" 
                                autocomplete="new-password" placeholder="Konfirmasi Password">

                            @if ($errors->has('password_confirmation'))
                                <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <div class="col-sm-12 col-md-7 offset-md-3">
                            <button type="submit" class="btn btn-primary" id="btnSubmit">
                                Simpan
                                <span class="spinner-border ml-2 d-none" id="loader"
                                    style="width: 1rem; height: 1rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
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
</script>
@endsection