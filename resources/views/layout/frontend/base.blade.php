
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="An impressive and flawless site template that includes various UI elements and countless features, attractive ready-made blocks and rich pages, basically everything you need to create a unique and professional website.">
  <meta name="keywords" content="bootstrap 5, business, corporate, creative, gulp, marketing, minimal, modern, multipurpose, one page, responsive, saas, sass, seo, startup">
  <meta name="author" content="elemis">
  <title>Sandbox - Modern & Multipurpose Bootstrap 5 Template</title>
  <link rel="shortcut icon" href="{{asset('template/assets/img/favicon.png')}}">
  <link rel="stylesheet" href="{{asset('template/assets/css/plugins.css')}}">
  <link rel="stylesheet" href="{{asset('template/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('template/assets/css/colors/orange.css')}}">
</head>

<body>
  <div class="content-wrapper">
    <!-- /header -->
    @include('layout.frontend.header')
    
    {{-- <!--/.modal -->
    <div class="modal fade modal-popup" id="modal-02" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-md">
          <div class="modal-content text-center">
            <div class="modal-body">
              <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              <div class="row">
                <div class="col-md-10 offset-md-1">
                  <figure class="mb-6"><img src="{{asset('template/assets/img/illustrations/i7.png')}}" srcset="{{asset('template/assets/img/illustrations/i7@2x.png 2x')}}" alt="" /></figure>
                </div>
                <!-- /column -->
              </div>
              <!-- /.row -->
              <h3>Join the mailing list and get %10 off</h3>
              <p class="mb-6">Nullam quis risus eget urna mollis ornare vel eu leo. Donec ullamcorper nulla non metus auctor fringilla.</p>
              <div class="newsletter-wrapper">
                <div class="row">
                  <div class="col-md-10 offset-md-1">
                    <!-- Begin Mailchimp Signup Form -->
                    <div id="mc_embed_signup">
                      <form action="https://elemisfreebies.us20.list-manage.com/subscribe/post?u=aa4947f70a475ce162057838d&amp;id=b49ef47a9a" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                        <div id="mc_embed_signup_scroll">
                          <div class="mc-field-group input-group form-floating">
                            <input type="email" value="" name="EMAIL" class="required email form-control" placeholder="Email Address" id="mce-EMAIL">
                            <label for="mce-EMAIL">Email Address</label>
                            <input type="submit" value="Join" name="subscribe" id="mc-embedded-subscribe" class="btn btn-primary">
                          </div>
                          <div id="mce-responses" class="clear">
                            <div class="response" id="mce-error-response" style="display:none"></div>
                            <div class="response" id="mce-success-response" style="display:none"></div>
                          </div> <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                          <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_ddc180777a163e0f9f66ee014_4b1bcfa0bc" tabindex="-1" value=""></div>
                          <div class="clear"></div>
                        </div>
                      </form>
                    </div>
                    <!--End mc_embed_signup-->
                  </div>
                  <!-- /.newsletter-wrapper -->
                </div>
                <!-- /column -->
              </div>
              <!-- /.row -->
            </div>
            <!--/.modal-body -->
          </div>
          <!--/.modal-content -->
        </div>
        <!--/.modal-dialog -->
    </div> --}}

    @yield('content')
    
  </div>
  <!-- /.content-wrapper -->

  <!-- /.footer -->
  @include('layout.frontend.footer')
  
  <div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
    </svg>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
  <script src="{{asset('template/assets/js/plugins.js')}}"></script>
  <script src="{{asset('template/assets/js/theme.js')}}"></script>
</body>

</html>