
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Login &mdash; Polsub</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('/node_modules/izitoast/dist/css/iziToast.min.css')}}">

  <!-- Template CSS -->
  <link rel="shortcut icon" href="{{asset('/assets/img/logoPOLSUB.png')}}">
  <link rel="stylesheet" href="{{asset('/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('/assets/css/components.css')}}">
  <style>
    .fa-eye-slash {
        cursor: pointer;
    }
  </style>
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="{{asset('/assets/img/logoPOLSUB.png')}}" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              
              <div class="card-header">
                <div class="section-header-back">
                  <a href="/" class="btn btn-icon">
                    <i class="fas fa-arrow-left"></i></a>
                </div>  

                <h4>Form Login</h4>
              </div>

              <div class="card-body">
                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                  @csrf
                  <div class="form-group">
                    <label for="username">{{ __('Nomor Induk / Email') }}</label>
                        <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" 
                          value="{{ old('username') }}" required autocomplete="username" autofocus>
                        <div class="invalid-feedback">
                          <strong>Masukkan Nomor Induk/Email</strong>
                        </div>
                        {{-- @error('username')
                            <span class="invalid-feedback">
                                <strong>Masukkan </strong>
                            </span>
                        @enderror

                        @error('nomor_induk')
                            <span class="invalid-feedback" role="alert">
                                <strong>jdks</strong>
                            </span>
                        @enderror --}}
                  </div>

                  <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                      <div class="input-group">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                          name="password" required autocomplete="current-password">

                        <span class="input-group-text">
                          <i id="password-toggle" class="fa fa-eye-slash" onclick="togglePassword()"></i>
                        </span>
                      </div>

                        <div class="invalid-feedback">
                            <strong>Masukkan Password</strong>
                        </div>
                  </div>

                  <div class="form-group">
                    Lupa Password ? <a href="https://api.whatsapp.com/send?phone=083804046583">Hubungi Admin!</a>
                    
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="text-muted text-center">
              Tidak Punya Akun ?<a href="{{ route('register') }}"> Daftar</a>
            </div>
            <div class="simple-footer">
              Copyright &copy; {{ date('Y') }} <div class="bullet"></div> Design By <a href="https://polsub.ac.id/">POLSUB</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{asset('/assets/js/stisla.js')}}"></script>

  <!-- JS Libraies -->
  <script src="{{asset('/node_modules/izitoast/dist/js/iziToast.min.js')}}"></script>

  <!-- Template JS File -->
  <script src="{{asset('/assets/js/scripts.js')}}"></script>
  <script src="{{asset('/assets/js/custom.js')}}"></script>

  <!-- Page Specific JS File -->
  <script src="{{asset('/assets/js/page/modules-toastr.js')}}"></script>
  <script>
      $(document).ready(function() {
          @if (session('success'))
              iziToast.success({
                  title: 'Registrasi Berhasil!',
                  message: "{{ session('success') }}",
                  position: 'topRight'
              });
          @endif ()

          @if (session('error'))
              iziToast.error({
                  title: 'Registrasi Gagal!',
                  message: "{{ session('error') }}",
                  position: 'topRight'
              });
          @endif ()

      });

      function togglePassword() {
          var passwordInput = document.getElementById("password");
          var passwordToggle = document.getElementById("password-toggle");

          if (passwordInput.type === "password") {
              passwordInput.type = "text";
              passwordToggle.classList.remove("fa-eye-slash");
              passwordToggle.classList.add("fa-eye");
          } else {
              passwordInput.type = "password";
              passwordToggle.classList.remove("fa-eye");
              passwordToggle.classList.add("fa-eye-slash");
          }
      }
  </script>
</body>
</html>