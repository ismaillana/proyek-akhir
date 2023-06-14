@extends('layout.frontend.base')

@section('content')
  
  <!-- /section -->
  <section class="wrapper bg-light">
    <div class="container py-14 pt-lg-16 pb-lg-0">
      <div class="row gx-lg-8 gx-xl-0 gy-10 align-items-center">
        <div class="col-md-8 col-lg-6 position-relative">
            <div class="shape bg-dot primary rellax w-17 h-21" data-rellax-speed="1" style="top: -2rem; left: -1.9rem;"></div>
            <div class="shape rounded bg-soft-primary rellax d-md-block" data-rellax-speed="0" style="bottom: -1.8rem; right: -1.5rem; width: 85%; height: 90%; "></div>
            <figure class="rounded"><img src="{{ asset('template/assets/img/photos/about14.jpg')}}" srcset="{{ asset('template/assets/img/photos/about14@2x.jpg 2x')}}" alt="" /></figure>
          </div>
        <!--/column -->
        <div class="col-lg-6 col-xl-5 offset-xl-1">
          <h2 class="display-4 mb-3">Get in Touch</h2>
          <p class="lead mb-8 pe-xl-10">Have any questions? Reach out to us from our contact form and we will get back to you shortly.</p>
          <form class="contact-form needs-validation" method="post" action="./assets/php/contact.php" novalidate>
            <div class="messages"></div>
            <div class="form-floating mb-4">
              <input id="form_name2" type="text" name="name" class="form-control" placeholder="Jane" required="required" data-error="Name is required.">
              <label for="form_name2">Name *</label>
              <div class="valid-feedback">
                Looks good!
              </div>
              <div class="invalid-feedback">
                Please enter your name.
              </div>
            </div>
            <div class="form-floating mb-4">
              <input id="form_email2" type="email" name="email" class="form-control" placeholder="jane.doe@example.com" required="required" data-error="Valid email is required.">
              <label for="form_email2">Email *</label>
              <div class="valid-feedback">
                Looks good!
              </div>
              <div class="invalid-feedback">
                Please provide a valid email address.
              </div>
            </div>
            <div class="form-floating mb-4">
              <textarea id="form_message2" name="message" class="form-control" placeholder="Your message" style="height: 150px" required></textarea>
              <label for="form_message2">Message *</label>
              <div class="valid-feedback">
                Looks good!
              </div>
              <div class="invalid-feedback">
                Please enter your messsage.
              </div>
            </div>
            <input type="submit" class="btn btn-primary rounded-pill btn-send mb-3" value="Send message">
            <p class="text-muted"><strong>*</strong> These fields are required.</p>
          </form>
          <!-- /form -->
        </div>
        <!--/column -->
      </div>
      <!--/.row -->
    </div>
    <!-- /.container -->
  </section>
  <!-- /section -->
@endsection

@section('script')
<script>
  new MultiSelectTag('nama_mahasiswa')  // id

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
                cancelButtonText: 'Cancel',
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