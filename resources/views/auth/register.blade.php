
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Register &mdash; Polsub</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <!-- CSS Libraries -->
  <link rel="shortcut icon" href="{{asset('/assets/img/logoPOLSUB.png')}}">
  <link rel="stylesheet" href="{{ asset('/node_modules/izitoast/dist/css/iziToast.min.css')}}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('/assets/css/components.css')}}">
</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
            <div class="login-brand">
              <img src="{{asset('/assets/img/logoPOLSUB.png')}}" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              <div class="card-header">
                <div class="section-header-back">
                  <a href="/" class="btn btn-icon">
                    <i class="fas fa-arrow-left"></i></a>
                </div>  
                
                <h4>
                  Form Registrasi
                </h4>
              </div>

              <div class="card-body">
                  @php
                      $user = \App\Models\User::role('bagian-akademik')->first();
                  @endphp
                <div class="alert alert-light alert-has-icon">
                  <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                  <div class="alert-body">
                    <div class="alert-title">Informasi</div>
                    Untuk Mahasiswa dan Alumni yang belum memiliki akun dapat menghubungi <a href="https://api.whatsapp.com/send?phone=0{{Str::substr(@$user->wa, 2)}}">Admin.</a>Untuk Instansi yang telah melakukan registrasi jangan lupa untuk melakukan verifikasi Email! Terima Kasih!
                  </div>
                </div>

                <form method="POST" action="{{ route('register') }}">
                  @csrf
                  <div class="row">
                    <div class="form-group col-6">
                        <label for="name">{{ __('Name') }}</label>

                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" 
                              autocomplete="name" autofocus placeholder="Masukan Nama Perusahaan">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>

                    <div class="form-group col-6">
                        <label for="wa">{{ __('No WhatsApp') }}</label>
                          <div class="input-group">
                            <div class="input-group-text">
                              +62
                            </div>
                            
                            <input id="wa" type="text" class="form-control @error('wa') is-invalid @enderror" name="wa" value="{{ old('wa',) }}" 
                              autocomplete="wa" autofocus placeholder="Masukan No WhatsApp">
                            @error('wa')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                    </div>

                  <div class="form-group col-6">
                      <label for="alamat">{{ __('Alamat') }}</label>

                          <input id="alamat" type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" 
                            value="{{ old('alamat') }}" autocomplete="alamat" autofocus placeholder="Masukan Alamat">

                          @error('alamat')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                  </div>
                    <div class="form-group col-6">
                        <label for="email">{{ __('Email Address') }}</label>

                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" 
                              autocomplete="email" placeholder="Masukan Email">

                            @error('email')
                                <span class="invalid-feedback" >
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-6">
                      <label for="password">{{ __('Password') }}</label>
                                
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" 
                                  autocomplete="new-password" placeholder="Masukan Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="password-confirm">{{ __('Confirm Password') }}</label>

                            <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" 
                              autocomplete="new-password" placeholder="Masukan Konfirmasi Password">
                        
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                  </div>

                  
                  <div class="form-group col-12">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                      Register
                    </button>
                  </div>
                </form>
              </div>
              <div class="text-muted text-center">
                Sudah Punya Akun ?<a href="{{ route('login') }}"> Login</a>
              </div>
              <div class="simple-footer">
                Copyright &copy; {{ date('Y') }} <div class="bullet"></div> Design By <a href="https://polsub.ac.id/">POLSUB</a>
              </div>
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
  <script src="{{ asset('/node_modules/jquery-pwstrength/jquery.pwstrength.min.js')}}"></script>
  <script src="{{asset('/node_modules/izitoast/dist/js/iziToast.min.js')}}"></script>

  <!-- Template JS File -->
  <script src="{{asset('/assets/js/scripts.js')}}"></script>
  <script src="{{asset('/assets/js/custom.js')}}"></script>

  <!-- Page Specific JS File -->
  <script src="{{asset('/assets/js/page/auth-register.js')}}"></script>
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

    document.getElementById('wa').addEventListener('input', function(evt) {
        var input = evt.target;
        input.value = input.value.replace(/[^0-9]/g, ''); // Hanya membiarkan angka
    });
  </script>
</body>
</html>