
<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>General Dashboard &mdash; Stisla</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{asset('/node_modules/jqvmap/dist/jqvmap.min.css')}}">
  <link rel="stylesheet" href="{{asset('/node_modules/weathericons/css/weather-icons.min.css')}}">
  <link rel="stylesheet" href="{{asset('/node_modules/weathericons/css/weather-icons-wind.min.css')}}">
  <link rel="stylesheet" href="{{asset('/node_modules/summernote/dist/summernote-bs4.css')}}">
  <link rel="stylesheet" href="{{asset('/node_modules/izitoast/dist/css/iziToast.min.css')}}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('/assets/css/components.css')}}">

  <!-- Script -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
  <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
          dataLayer.push(arguments);
      }
      gtag('js', new Date());

      gtag('config', 'UA-94034622-3');
  </script>
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
    <div class="navbar-bg"></div>
      <!-- Header-navbar -->
      @include('layout/backend/header')
      <!-- Sidebar -->
      @include('layout/backend/sidebar')
      <!-- Main Content -->
      @yield('content')
      <!-- Footer -->
      @include('layout/backend/footer')
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{ asset('/assets/js/stisla.js')}}"></script>

  <!-- JS Libraies -->
  <script src="{{asset('/node_modules/simpleweather/jquery.simpleWeather.min.js')}}"></script>
  <script src="{{asset('/node_modules/chart.js/dist/Chart.min.js')}}"></script>
  <script src="{{asset('/node_modules/jqvmap/dist/jquery.vmap.min.js')}}"></script>
  <script src="{{asset('/node_modules/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
  <script src="{{asset('/node_modules/summernote/dist/summernote-bs4.js')}}"></script>
  <script src="{{asset('/node_modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>
  <script src="{{asset('/node_modules/izitoast/dist/js/iziToast.min.js')}}"></script>

  <!-- Template JS File -->
  <script src="{{asset('/assets/js/scripts.js')}}"></script>
  <script src="{{asset('/assets/js/custom.js')}}"></script>

  <!-- Page Specific JS File -->
  <script src="{{asset('/assets/js/page/modules-toastr.js')}}"></script>
  <script src="{{asset('/assets/js/page/index-0.js')}}"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script>
      $(document).ready(function() {
          @if (session('success'))
              iziToast.success({
                  message: "{{ session('success') }}",
                  position: 'topRight'
              });
          @endif ()

          @if (session('error'))
              iziToast.error({
                  message: "{{ session('error') }}",
                  position: 'topRight'
              });
          @endif ()

          $('.dropify').dropify();

          $(".select2").select2();

          $('#datepicker').datepicker({
              uiLibrary: 'bootstrap4',
              format: 'yyyy-mm-dd'
          });

          $('#table-1').dataTable();

      });
  </script>

  @yield('script')

  @stack('js')
</body>
</html>
