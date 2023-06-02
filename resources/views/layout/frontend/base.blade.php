<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="An impressive and flawless site template that includes various UI elements and countless features, attractive ready-made blocks and rich pages, basically everything you need to create a unique and professional website.">
  <meta name="keywords" content="bootstrap 5, business, corporate, creative, gulp, marketing, minimal, modern, multipurpose, one page, responsive, saas, sass, seo, startup">
  <meta name="author" content="elemis">
  <title>Sandbox - Modern & Multipurpose Bootstrap 5 Template</title>
  <link rel="shortcut icon" href="{{ asset('template/assets/img/favicon.png')}}">
  <link rel="stylesheet" href="{{ asset('template/assets/css/plugins.css')}}">
  <link rel="stylesheet" href="{{ asset('template/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{ asset('template/assets/css/colors/aqua.css')}}">
  <link rel="preload" href="{{ asset('template/assets/css/fonts/thicccboi.css')}}" as="style" onload="this.rel='stylesheet'">
  <!--SweetAlert2-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css">
  <!--Multiple-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css">
</head>

<body>
  <div class="content-wrapper">
    <!-- /header -->
    @include('layout.frontend.navbar')
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
  @include('layout.frontend.footer')
  <div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
  <!--Sweet Alert2-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>

  <script src="{{ asset('template/assets/js/plugins.js')}}"></script>
  <script src="{{ asset('template/assets/js/theme.js')}}"></script>

  <script>
    $(document).ready(function() {
        @if (session('success'))
            Swal.fire({
              icon: 'success',
              title: 'Berhasil!',
              text: "{{ session('success') }}",
              showConfirmButton: false,
              timer: 1500
            })
        @endif ()

        @if (session('error'))
            Swal.fire({
              icon: 'warning',
              title: "Pengajuan Gagal Dibuat",
              showConfirmButton: false,
              timer: 1500
            })
        @endif ()
    });
</script>
@yield('script')
</body>

</html>