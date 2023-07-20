@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
            <a href="{{route('pengajuan-verifikasi-ijazah.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>

            <h1>
                Detail Pengajuan
            </h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4>
                                    Detail Pengajuan Verifikasi Ijazah
                                </h4>

                                <div class="d-flex">
                                <h4>
                                    Status Pengajuan
                                </h4>
                                    @if (@$verifikasiIjazah->status == 'Menunggu Konfirmasi')
                                        <span class="btn btn-warning">Menunggu Konfirmasi</span>
                                    @elseif (@$verifikasiIjazah->status == 'Konfirmasi')
                                        <span class="btn btn-primary">Dikonfirmasi</span>
                                    @elseif (@$verifikasiIjazah->status == 'Proses')
                                        <span class="btn btn-success">Diproses</span>
                                    @elseif (@$verifikasiIjazah->status == 'Tolak')
                                        <span class="btn btn-danger">Ditolak</span>
                                    @elseif (@$verifikasiIjazah->status == 'Kendala')
                                        <span class="btn btn-danger">Ada Kendala</span>
                                    @else
                                        <span class="btn btn-success">Selesai</span>
                                    @endif
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Tanggal Pengajuan<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-9">
                                    <input type="text" class="form-control @error('tanggal_pengajuan')is-invalid @enderror"
                                        id="tanggal_pengajuan" name="tanggal_pengajuan" placeholder="" 
                                        value="{{ \Carbon\Carbon::parse(@$verifikasiIjazah->created_at)->translatedFormat('d F Y H:i:s') }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Pengaju<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-9">
                                    <input type="text" class="form-control @error('instansi_id')is-invalid @enderror"
                                        id="instansi_id" name="instansi_id" placeholder="Masukkan Nama Instansi" 
                                        value="{{ old('instansi_id', @$verifikasiIjazah->instansi->user->name) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Nama Mahasiswa<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-9">
                                    <input type="text" class="form-control @error('name')is-invalid @enderror"
                                        id="name" name="name" placeholder="Masukkan Nama Mahasiswa" 
                                        value="{{ old('name', @$verifikasiIjazah->nama) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    NIM Mahasiswa<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-9">
                                    <input type="number" class="form-control @error('nomor_induk')is-invalid @enderror"
                                        id="nomor_induk" name="nomor_induk" placeholder="" 
                                        value="{{ old('nim', @$verifikasiIjazah->nim) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Nomor Ijazah<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-9">
                                    <input type="text" class="form-control @error('no_ijazah')is-invalid @enderror"
                                        id="no_ijazah" name="no_ijazah" placeholder="" 
                                        value="{{ old('no_ijazah', @$verifikasiIjazah->no_ijazah) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Tahun Lulus<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-9">
                                    <input type="number" class="form-control @error('tahun_lulus')is-invalid @enderror"
                                        id="tahun_lulus" name="tahun_lulus" placeholder="" 
                                        value="{{ old('tahun_lulus', @$verifikasiIjazah->tahun_lulus) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Dokumen Surat Pengajuan<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <label>
                                        <a class="btn btn-primary" href="{{ asset('storage/public/dokumen/'. @$verifikasiIjazah->dokumen)}}" 
                                                download="{{@$verifikasiIjazah->dokumen}}">
                                                    Download Dokumen
                                        </a>
                                    </label>
                                </div>
                            </div>
                            <hr>
                            @role('bagian-akademik')
                            <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST"
                                action="{{route('update-surat-aktif-kuliah', $verifikasiIjazah->id) }}">
                                    @csrf

                                <div class="form-group row">
                                    <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                        Nomor Surat<sup class="text-danger">*</sup>
                                    </label>
    
                                    <div class="col-sm-12 col-md-9">
                                        <input type="text" class="form-control @error('no_surat')is-invalid @enderror"
                                            id="no_surat" name="no_surat" pattern="\d{4}/PL41\.R1/[A-Za-z]{2}\.\d{2}/\d{4}" placeholder="Masukkan Nomor Surat" 
                                            value="{{ old('no_surat', @$verifikasiIjazah->no_surat) }}">

                                            <span class="invalid-feedback" role="alert" id="no-surat-error">
                                                @error('no_surat')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-9 offset-md-3">
                                        <button type="submit" class="btn btn-primary" id="btnSubmit">
                                            @if (@$verifikasiIjazah->no_surat == null)
                                                Tambah
                                            @else
                                                Update
                                            @endif
                                            <span class="spinner-border ml-2 d-none" id="loader"
                                                style="width: 1rem; height: 1rem;" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            @endrole
                            <hr>
                            @if (@$verifikasiIjazah->status == "Menunggu Konfirmasi")
                                <div class="text-md-right">
                                    <div class="float-lg-left mb-lg-0 mb-3">
                                        <button class="btn btn-primary btn-icon icon-left" data-toggle="modal" data-target="#konfirmasi{{$verifikasiIjazah->id}}">
                                            <i class="fas fa-check"></i> 
                                            Konfirmasi
                                        </button>

                                        <button class="btn btn-danger btn-icon icon-left" data-toggle="modal" data-target="#tolak{{$verifikasiIjazah->id}}">
                                            <i class="fas fa-times"></i> 
                                            Tolak
                                        </button>
                                    </div>

                                    <a href="{{ route('print-verifikasi-ijazah', Crypt::encryptString($verifikasiIjazah->id)) }}" class="btn btn-warning btn-icon icon-left">
                                        <i class="fas fa-print"></i> 
                                            Print
                                    </a>
                                </div>
                            @else
                                <div class="text-md-right">
                                    <a href="{{ route('print-verifikasi-ijazah', Crypt::encryptString($verifikasiIjazah->id)) }}" class="btn btn-warning btn-icon icon-left">
                                        <i class="fas fa-print"></i> 
                                            Print
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="konfirmasi{{$verifikasiIjazah->id}}">
    <div class="modal-dialog" role="document">
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{ route('konfirmasi-verifikasi-ijazah', $verifikasiIjazah->id)}}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Konfirmasi Pengajuan
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>
                        Setujui Pengajuan ?
                    </p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="tolak{{$verifikasiIjazah->id}}">
    <div class="modal-dialog" role="document">
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{ route('tolak-verifikasi-ijazah', $verifikasiIjazah->id)}}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Modal Catatan Penolakan
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group row" id="catatan">
                        <label for="name" class="col-sm-3 col-form-label">
                            Catatan Penolakan <sup class="text-danger">*</sup>
                        </label>

                        <div class="col-sm-9">
                            <textarea name="catatan" class="summernote-simple" id="catatan" cols="30" rows="10"
                                placeholder="Masukan Catatan">{{ old('catatan', @$verifikasiIjazah->catatan) }}</textarea>
                            
                            @if ($errors->has('catatan'))
                                <span class="text-danger">
                                    {{ $errors->first('catatan') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="modal-footer br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    document.getElementById('no_surat').addEventListener('input', function() {
        const inputElement = this;
        const pattern = /^\d{4}\/PL41\.R1\/[A-Za-z]{2}\.\d{2}\/\d{4}$/; 
        const errorMessage = 'Nomor surat harus sesuai format: 1300/PL41.R1/AL.02/2022';

        const isValidFormat = pattern.test(inputElement.value);

        const errorElement = document.getElementById('no-surat-error');
        if (!isValidFormat) {
            errorElement.textContent = errorMessage;
            inputElement.classList.add('is-invalid');
        } else {
            errorElement.textContent = '';
            inputElement.classList.remove('is-invalid');
        }
    });
</script>
@endsection
