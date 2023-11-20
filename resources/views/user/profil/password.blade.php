@extends('layout.frontend.base')

@section('content')
  
  <!-- /section -->
  <section class="wrapper bg-light">
    <div class="container py-14 py-md-16">
      <div class="card bg-soft-primary">
        <div class="card-body p-12">
          <div class="row gx-md-8 gx-xl-12 gy-10">
            <div class="col-lg-6">	
              <figure class="rounded">
                <img src="{{ asset('template/assets/img/illustrations/i5.png')}}" srcset="{{ asset('template/assets/img/illustrations/i5@2x.png 2x')}}" alt="" />
              </figure>
            </div>
            <!-- /column -->
            <div class="col-lg-6">
              <h2 class="display-4 mb-3">
                Ubah Password
              </h2>
              <p class="lead mb-8 pe-xl-10">
                Perbaiki informasi pribadi disini!
              </p>

              <form id="myForm" class="contact-form needs-validation" method="POST" action="{{route('update-password-user', $user)}}">
                @csrf
                <div class="messages"></div>
                <div class="row gx-4">
                  <div class="col-md-12">
                    <div class="form-floating mb-4">
                      <input id="password" type="password" name="password" class="form-control border-0" placeholder="Password Baru">
                      <label for="password">Password Baru*</label>
                      
                      @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                      @endif
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-floating mb-4">
                      <input id="password" type="password" name="password_confirmation" class="form-control border-0" placeholder="Masukan Konfirmasi Password">
                      <label for="password">Konfirmasi Password *</label>
                      
                      @if ($errors->has('password_confirmation'))
                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                      @endif
                    </div>
                  </div>

                  <div class="col-12">
                    <button class="btn btn-primary rounded-pill btn-send mb-3" id="btnSubmit" type="submit">
                      Submit
                      <span class="spinner-border ml-2 d-none" id="loader"
                          style="width: 1rem; height: 1rem;" role="status">
                      </span>
                    </button>
                  </div>
                  <!-- /column -->
                </div>
                <!-- /.row -->
              </form>
              <!-- /form -->
            </div>
            <!-- /column -->
          </div>
          <!-- /.row -->
        </div>
        <!--/.card-body -->
      </div>
      <!--/.card -->
    </div>
    <!-- /.container -->
  </section>
  <!-- /section -->
  <!-- /section -->
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