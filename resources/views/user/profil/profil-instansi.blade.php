@extends('layout.frontend.base')

@section('content')
  
  <!-- /section -->
  <section class="wrapper bg-light">
    <div class="container py-14 lg-4 pb-lg-8">
      <div class="row gx-lg-8 gx-xl-0 gy-10 align-items-center">
        <div class="col-md-8 col-lg-6 position-relative">
            <div class="shape bg-dot primary rellax w-17 h-21" data-rellax-speed="1" style="top: -2rem; left: -1.9rem;"></div>
            <div class="shape rounded bg-soft-primary rellax d-md-block" data-rellax-speed="0" style="bottom: -1.8rem; right: -1.5rem; width: 85%; height: 90%; "></div>
          <figure class="rounded">
            <img src="{{ asset('template/assets/img/illustrations/i5.png')}}" srcset="{{ asset('template/assets/img/illustrations/i5@2x.png 2x')}}" alt="" />
          </figure>
        </div>

        <div class="col-lg-6 col-xl-5 offset-xl-1">
          <h2 class="display-4 mb-3">
            Profil Instansi
          </h2>
          <p class="lead mb-8 pe-xl-10">
            Perbaiki informasi pribadi disini!
          </p>

          <form id="myForm" class="contact-form needs-validation" enctype="multipart/form-data" method="POST" action="{{route('update-profil-instansi', $user)}}">
            @csrf
            <div class="messages"></div>
            <div class="form-floating mb-4">
              <input id="form_name2" type="text" name="name" class="form-control" placeholder="Masukkan Nama Perusahaan" value="{{ old('name', @$user->name) }}">
              <label for="form_name2">Nama Perusahaan *</label>

              @if ($errors->has('name'))
                  <span class="text-danger">{{ $errors->first('name') }}</span>
              @endif
            </div>

            <div class="form-floating mb-4">
              <input id="form_email2" type="email" name="email" class="form-control" placeholder="Masukkan Email" value="{{ old('email', @$user->email) }}">
              <label for="form_email2">Email *</label>

              @if ($errors->has('email'))
                  <span class="text-danger">{{ $errors->first('email') }}</span>
              @endif
            </div>

            <div class="form-floating mb-4">
              <input id="wa" type="text" maxlength="13" name="wa" class="form-control" placeholder="Masukkan No WhatsApp" value="{{ old('wa', Str::substr(@$user->wa, 2)) }}">
              <label for="wa">No WhatsApp *</label>

              @if ($errors->has('wa'))
                  <span class="text-danger">{{ $errors->first('wa') }}</span>
              @endif
            </div>

            <div class="form-floating mb-4">
              <textarea id="form_message2" name="alamat" class="form-control" placeholder="Your message" style="height: 150px">
                {{ old('alamat', @$instansi->alamat) }}
              </textarea>
              <label for="form_message2">Alamat *</label>

              @if ($errors->has('alamat'))
                  <span class="text-danger">{{ $errors->first('alamat') }}</span>
              @endif
            </div>

            <button class="btn btn-primary rounded-pill btn-send mb-3" id="btnSubmit" type="submit">
              Submit
              <span class="spinner-border ml-2 d-none" id="loader"
                  style="width: 1rem; height: 1rem;" role="status">
              </span>
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>
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