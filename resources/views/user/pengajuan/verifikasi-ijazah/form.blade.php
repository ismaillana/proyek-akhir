@extends('layout.frontend.base')

@section('content')
<head>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"
      rel="stylesheet" />
</head>

<section class="wrapper bg-dark angled lower-start">
  <div class="container py-14 pt-md-10 pb-md-21">
    <div class="row gx-lg-8 gx-xl-12 gy-10 gy-lg-0 mb-2 align-items-end">
      <div class="col-lg-12 text-center">
        <h2 class="fs-16 text-uppercase text-line text-primary mb-3">
          Pengajuan
        </h2>

        <h3 class="display-4 text-center text-white">
          Verifikasi Ijazah
        </h3>
      </div>
    </div>
  </div>
</section>

<section class="wrapper bg-light angled upper-end lower-start">
  <div class="container py-16 py-md-18 position-relative">
    <div class="position-relative mt-n18 mt-md-n23">
      <div class="shape rounded-circle bg-line primary rellax w-18 h-18" data-rellax-speed="1" style="top: -2rem; right: -2.7rem; z-index:0;"></div>
      <div class="shape rounded-circle bg-soft-primary rellax w-18 h-18" data-rellax-speed="1" style="bottom: -1rem; left: -3rem; z-index:0;"></div>
      
        <div class="row">
          <div class="col-12">
            <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST" 
              action="{{route('pengajuan.verifikasi-ijazah.store')}}">
              {{ csrf_field() }}
              <div class="card card-border-start border-primary">
                <div class="card-header">
                    <h4>
                        Form Verifikasi Ijazah
                    </h4>
                </div>

                <div class="card-body">
                    <div class="col-lg-10 offset-lg-1 col-xl-8 offset-xl-2">
                      @if (@$pengajuan->status == 'Selesai' || @$pengajuan->status == 'Tolak' || @$pengajuan == null)
                        <!-- Repeater container -->
                        <div class="repeater-container">
                          <!-- Repeated form fields -->
                          <div class="repeater-item">
                            <div class="form-floating mb-4">
                              <input id="nama" type="text" name="nama[]" class="form-control @error('nama')is-invalid @enderror" 
                                 placeholder="Masukan Nama Mahasiswa">
                              
                              <label for="form_nama_mahasiswa">
                                Nama Mahasiswa<span class="text-danger">*</span>
                              </label>

                              @if ($errors->has('nama'))
                                  <span class="text-danger">{{ $errors->first('nama') }}</span>
                              @endif
                            </div>

                            <div class="form-floating mb-4">
                              <input id="nim" type="text" name="nim[]" class="form-control @error('nim')is-invalid @enderror" 
                                 placeholder="Masukan NIM Mahasiswa">
                              
                              <label for="form_nim_mahasiswa">
                                NIM Mahasiswa<span class="text-danger">*</span>
                              </label>

                              @if ($errors->has('nim'))
                                  <span class="text-danger">{{ $errors->first('nim') }}</span>
                              @endif
                            </div>

                            <div class="form-floating mb-4">
                              <input id="no_ijazah" type="text" name="no_ijazah[]" class="form-control @error('no_ijazah')is-invalid @enderror" 
                                 placeholder="Masukan Nomor Ijazah Mahasiswa">
                              
                              <label for="form_no_ijazah_mahasiswa">
                                Nomor Ijazah Mahasiswa<span class="text-danger">*</span>
                              </label>

                              @if ($errors->has('no_ijazah'))
                                  <span class="text-danger">{{ $errors->first('no_ijazah') }}</span>
                              @endif
                            </div>

                            <div class="form-floating mb-4">
                              <input id="tahun_lulus" type="text" name="tahun_lulus[]" class="form-control @error('tahun_lulus')is-invalid @enderror" 
                                 placeholder="Masukan Tahun Lulus Mahasiswa">
                              
                              <label for="form_tahun_lulus_mahasiswa">
                                Tahun Lulus Mahasiswa<span class="text-danger">*</span>
                              </label>

                              @if ($errors->has('tahun_lulus'))
                                  <span class="text-danger">{{ $errors->first('tahun_lulus') }}</span>
                              @endif
                            </div>

                            <button type="button" class="btn btn-danger btn-remove-repeater d-none mb-4">
                              Hapus
                            </button>
                          </div>
                        </div>

                        <button type="button" class="btn btn-primary btn-add-repeater mb-4">
                          Tambah Mahasiswa
                        </button>

                        <div class="col-md-12">
                          <label for="form_name">
                              Dokumen Surat Pengajuan<span class="text-danger">*</span>
                          </label>

                          <div class="form-floating mb-4">
                              <div class="col-sm-12 col-md-12">
                                <input id="dokumen" type="file" name="dokumen" class="form-control @error('dokumen')is-invalid @enderror" 
                                  value="{{ old('dokumen', @$verifikasiIjazah->dokumen) }}" placeholder="Tahun Lulus">

                                @if ($errors->has('dokumen'))
                                    <span class="text-danger">{{ $errors->first('dokumen') }}</span>
                                @endif
                              </div>

                              <div class="text text-info">
                                <small>
                                    Masukkan Dokumen Surat Pengajuan Verifikasi Ijazah!
                                </small>
                            </div>
                          </div>
                        </div>

                        <div class="col-12 text-center">
                          <button type="submit" class="btn btn-primary rounded-pill btn-send mb-3" id="btnSubmit">
                            Kirim Pengajuan
                            <span class="spinner-border ml-2 d-none" id="loader"
                                style="width: 1rem; height: 1rem;" role="status">
                            </span>
                          </button>
                        </div>
                      @else
                        <div class="text-center">
                          <img class="img-fluid mb-2" width="250" src="{{ asset('template/assets/img/illustrations/3d1.png')}}" 
                          srcset="{{ asset('template/assets/img/illustrations/3d1@2x.png 2x')}}" alt="" />
                          
                          <p>
                            Pengajuan Dapat Dilakukan Kembali Setelah Pengajuan Sebelumnya Selesai!
                            <span class="text-danger">*</span>
                          </p>
                        </div>
                      @endif
                    </div>
                </div>
              </div>
            </form>
          </div>
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
            text: 'Apakah anda yakin Data Sudah Benar ?',
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

    $(document).ready(function() {
      // Add new repeater item
      $(".btn-add-repeater").click(function() {
        var newItem = $(".repeater-item").first().clone();
        newItem.find("input").val(""); // Clear input values in the new item
        newItem.find(".btn-remove-repeater").removeClass("d-none"); // Show the remove button
        $(".repeater-container").append(newItem);
        toggleDeleteButtons(); // Check and update delete buttons
      });

      // Remove repeater item
      $(document).on("click", ".btn-remove-repeater", function() {
        $(this).closest(".repeater-item").remove();
        toggleDeleteButtons(); // Check and update delete buttons
      });

      function toggleDeleteButtons() {
        var deleteButtons = $(".btn-remove-repeater");
        if (deleteButtons.length > 1) {
          deleteButtons.removeClass("d-none"); // Show all delete buttons when there is more than one repeated item
        } else {
          deleteButtons.addClass("d-none"); // Hide delete buttons when there is only one repeated item
        }
      }

      $('#myForm').submit(function(e) {
        let form = this;
        e.preventDefault();

        confirmSubmit(form);
      });

      // Rest of your JavaScript code...
    });
  </script>
@endsection
