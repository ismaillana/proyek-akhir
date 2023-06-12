@extends('layout.frontend.base')

@section('content')
  <section class="wrapper bg-dark angled lower-start">
    <div class="container py-14 pt-md-10 pb-md-21">
      <div class="row gx-lg-8 gx-xl-12 gy-10 gy-lg-0 mb-2 align-items-end">
        <div class="col-lg-12 text-center">
          <h2 class="fs-16 text-uppercase text-line text-primary mb-3">
            Pengajuan
          </h2>

          <h4 class="display-4 text-center text-white">
            Surat Keterangan Aktif Kuliah
          </h4>
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
              <div class="card card-border-start border-primary">
                <div class="card-header">
                    <h4>
                      Form Pengajuan Surat Keterangan Aktif Kuliah
                    </h4>
                </div>

                <div class="card-body">
                  @if (@$pengajuan->status == 'Selesai' || @$pengajuan->status == 'Tolak' || @$pengajuan == null)
                    <div class="accordion accordion-wrapper" id="accordionExample">
                      <div class="card plain accordion-item">
                        <div class="card-header" id="headingOne">
                          <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Pastikan Data Benar & Lengkap<sup class="text-danger">*</sup></button>
                        </div>
            
                        <div id="collapseOne" class="accordion-collapse collapse hide" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                          <div class="card-body">
                            <ul class="unordered-list bullet-primary">
                              <li>
                                Nama Mahasiswa: {{(@$mahasiswa->user->name)}}
                              </li>
                              <li>NIM: {{(@$mahasiswa->nim)}}</li>
                              <li>Jurusan: {{@$mahasiswa->jurusan->name}}</li>
                              <li>Program Studi: {{@$mahasiswa->programStudi->name}}</li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>

                    <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST" 
                      action="{{route('pengajuan.aktif-kuliah.store')}}">
                      {{ csrf_field() }}

                      <div class="col-md-12">
                        <div class="form-floating mb-4">
                          <textarea id="keperluan" name="keperluan" class="form-control @error('keperluan')is-invalid @enderror" 
                            style="height: 150px" placeholder="Keperluan">{{ old('keperluan', @$aktifKuliah->keperluan) }}</textarea>
                          
                          <label for="form_message">
                            Keperluan <span class="text-danger">*</span>
                          </label>
                          
                          @if ($errors->has('keperluan'))
                              <span class="text-danger">{{ $errors->first('keperluan') }}</span>
                          @endif
                        </div>
                      </div>  

                      <div class="text-center">
                        <button type="submit" class="btn btn-primary rounded-pill btn-send mb-3" id="btnSubmit">
                          Kirim Pengajuan
                          <span class="spinner-border ml-2 d-none" id="loader"
                              style="width: 1rem; height: 1rem;" role="status">
                          </span>
                        </button>
                      </div>
                    </form>
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
          </div>
      </div>
    </div>
  </section>
@endsection

@section('script')
<script type="text/javascript">
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