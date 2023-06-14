@extends('layout.frontend.base')

@section('content')
  
  <!-- /section -->
  <section class="wrapper bg-light">
    <div class="container py-14 py-md-16">
      <div class="card bg-soft-primary">
        <div class="card-body p-12">
          <div class="row gx-md-8 gx-xl-12 gy-10">
            <div class="col-lg-6">	
              <img src="./assets/img/icons/lineal/email.svg" class="svg-inject icon-svg icon-svg-sm mb-4" alt="" />
              <h2 class="display-4 mb-3 pe-lg-10">If you like what you see, let's work together.</h2>
              <p class="lead pe-lg-12 mb-0">I bring rapid solutions to make the life of my clients easier. Have any questions? Reach out to me from this contact form and I will get back to you shortly.</p>
            </div>
            <!-- /column -->
            <div class="col-lg-6">
              <form class="contact-form needs-validation" method="post" action="./assets/php/contact.php" novalidate>
                <div class="messages"></div>
                <div class="row gx-4">
                  <div class="col-md-6">
                    <div class="form-floating mb-4">
                      <input id="frm_name" type="text" name="name" class="form-control border-0" placeholder="Jane" required="required" data-error="First Name is required.">
                      <label for="frm_name">Name *</label>
                      <div class="invalid-feedback">
                        Please enter your name.
                      </div>
                    </div>
                  </div>
                  <!-- /column -->
                  <div class="col-md-6">
                    <div class="form-floating mb-4">
                      <input id="frm_email" type="email" name="email" class="form-control border-0" placeholder="jane.doe@example.com" required="required" data-error="Valid email is required.">
                      <label for="frm_email">Email *</label>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                      <div class="invalid-feedback">
                        Please provide a valid email address.
                      </div>
                    </div>
                  </div>
                  <!-- /column -->
                  <div class="col-12">
                    <div class="form-floating mb-4">
                      <textarea id="frm_message" name="message" class="form-control border-0" placeholder="Your message" style="height: 150px" required></textarea>
                      <label for="frm_message">Message *</label>
                      <div class="valid-feedback">
                        Looks good!
                      </div>
                      <div class="invalid-feedback">
                        Please enter your messsage.
                      </div>
                    </div>
                  </div>
                  <!-- /column -->
                  <div class="col-12">
                    <input type="submit" class="btn btn-outline-primary rounded-pill btn-send mb-3" value="Send message">
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