@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{route('pengajuan-aktif-kuliah.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>

        <h1>
            Detail Pengajuan
        </h1>
      </div>

      <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{route('konfirmasi.aktif.kuliah', $aktifKuliah->id)}}" method="POST">
        {{-- @method('put') --}}
        {{ csrf_field() }}
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Detail Pengajuan Surat Aktif Kuliah</h4>
                        </div>
                        
                        <div class="card-body">
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Nama Pengaju<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('name')is-invalid @enderror"
                                        id="name" name="name" placeholder="Masukkan Koordinator PKL" 
                                        value="{{ old('name', @$aktifKuliah->mahasiswa->user->name) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    NIM<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <input type="number" class="form-control @error('nomor_induk')is-invalid @enderror"
                                        id="nomor_induk" name="nomor_induk" placeholder="Masukkan NIP" 
                                        value="{{ old('nim', @$aktifKuliah->mahasiswa->nim) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Tanggal Pengajuan<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <input type="" class="form-control @error('created_at')is-invalid @enderror"
                                        id="created_at" name="created_at" placeholder="" 
                                        value="{{ old('created_at', @$aktifKuliah->created_at) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="name" class="col-sm-3 col-form-label">
                                    Keperluan <sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <textarea name="keperluan" class="form-control" id="keperluan" cols="30" rows="10"
                                        placeholder="Masukan Keperluan" readonly disabled>{{ old('keperluan', @$aktifKuliah->keperluan) }}</textarea>
                                </div>
                            </div>

                            @if (@$aktifKuliah->status == 'Menunggu Konfirmasi')
                                
                            <div class="form-group row mb-4">
                                <label for="satatus" class="col-sm-3 col-form-label">
                                    Status<sup class="text-danger">*</sup>
                                </label>
                                
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <select class="form-control select2 @error('status')is-invalid @enderror" id="status" name="status" >
                                            <option selected value="">Pilih Status</option>
                                            <option value="Menunggu Konfirmasi"
                                                {{ old('status', @$aktifKuliah->status) == 'Menunggu Konfirmasi' ? 'selected' : '' }}>
                                                    Menunggu Konfirmasi</option>
                                            <option value="Ditolak"
                                                {{ old('status', @$aktifKuliah->status) == 'Ditolak' ? 'selected' : '' }}>
                                                    Ditolak</option>       
                                            <option value="Dikonfirmasi"
                                                {{ old('status', @$aktifKuliah->status) == 'Dikonfirmasi' ? 'selected' : '' }}>
                                                    Dikonfirmasi</option>
                                        </select>
            
                                        @if ($errors->has('status'))
                                            <span class="text-danger">
                                                {{ $errors->first('status') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-4" id="catatan">
                                <label for="name" class="col-sm-3 col-form-label">
                                    Catatan Penolakan <sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <textarea name="catatan" class="summernote-simple" id="catatan" cols="30" rows="10"
                                        placeholder="Masukan Catatan">{{ old('catatan', @$aktifKuliah->catatan) }}</textarea>
                                    
                                    @if ($errors->has('catatan'))
                                        <span class="text-danger">
                                            {{ $errors->first('catatan') }}
                                        </span>
                                    @endif
                                </div>

                            </div>
                            <button type="submit" class="btn btn-primary btn-icon icon-left" id="btnSubmit"><i class="fas fa-check"></i> Konfirmasi
                                <span class="spinner-border ml-2 d-none" id="loader"
                                    style="width: 1rem; height: 1rem;" role="status">
                                    <span class="sr-only">Loading...</span>
                                </span>
                            </button>
                            @elseif (@$aktifKuliah->status == 'Disetujui')
                            <div class="form-group row mb-4">
                                <label for="satatus" class="col-sm-3 col-form-label">
                                    Status<sup class="text-danger">*</sup>
                                </label>
                                
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <select class="form-control select2 @error('status')is-invalid @enderror" id="status" name="status" disabled readonly>
                                            <option selected value="">Pilih Status</option>
                                            <option value="Menunggu Konfirmasi"
                                                {{ old('status', @$aktifKuliah->status) == 'Menunggu Konfirmasi' ? 'selected' : '' }}>
                                                    Menunggu Konfirmasi</option>
                                            <option value="Ditolak"
                                                {{ old('status', @$aktifKuliah->status) == 'Ditolak' ? 'selected' : '' }}>
                                                    Ditolak</option>       
                                            <option value="Dikonfirmasi"
                                                {{ old('status', @$aktifKuliah->status) == 'Dikonfirmasi' ? 'selected' : '' }}>
                                                    Dikonfirmasi</option>
                                        </select>
            
                                        @if ($errors->has('status'))
                                            <span class="text-danger">
                                                {{ $errors->first('status') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="form-group row mb-4">
                                <label for="satatus" class="col-sm-3 col-form-label">
                                    Status<sup class="text-danger">*</sup>
                                </label>
                                
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <select class="form-control select2 @error('status')is-invalid @enderror" id="status" name="status" readonly disabled>
                                            <option selected value="">Pilih Status</option>
                                            <option value="Menunggu Konfirmasi"
                                                {{ old('status', @$aktifKuliah->status) == 'Menunggu Konfirmasi' ? 'selected' : '' }}>
                                                    Menunggu Konfirmasi</option>
                                            <option value="Ditolak"
                                                {{ old('status', @$aktifKuliah->status) == 'Ditolak' ? 'selected' : '' }}>
                                                    Ditolak</option>       
                                            <option value="Dikonfirmasi"
                                                {{ old('status', @$aktifKuliah->status) == 'Dikonfirmasi' ? 'selected' : '' }}>
                                                    Dikonfirmasi</option>
                                        </select>
            
                                        @if ($errors->has('status'))
                                            <span class="text-danger">
                                                {{ $errors->first('status') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="name" class="col-sm-3 col-form-label">
                                    Catatan Penolakan <sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <textarea name="catatan" class="summernote-simple" cols="30" rows="10"
                                        placeholder="Masukan Catatan" readonly disabled>{{ $aktifKuliah->catatan }}</textarea>
                                </div>

                            </div>
                            @endif

                            <hr>
                            <div class="text-md-right">
                                <div class="float-lg-left mb-lg-0 mb-3">
                                    <button class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Tolak</button>
                                </div>
                                <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </form>
    </section>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        $("#catatan").hide();

        $('#status').on('change', function() {
            var selectedVal = $(this).val();

            if (selectedVal == 'Ditolak') {
                $('#catatan').show();
            } else {
                $("#catatan").hide();
            }
        })

        $('#myForm').submit(function(e) {
            let form = this;
            e.preventDefault();

            confirmSubmit(form);
        });

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
