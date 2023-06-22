@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{route('pengajuan-izin-penelitian.index')}}" class="btn btn-icon">
                    <i class="fas fa-arrow-left"></i>
                </a>

                <h1>
                    Detail Pengajuan
                </h1>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4>
                                    Detail Pengajuan Surat Izin Penelitian
                                </h4>

                                <div class="d-flex">
                                <h4>
                                    Status Pengajuan
                                </h4>
                                    @if (@$izinPenelitian->status == 'Menunggu Konfirmasi')
                                        <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                    @elseif (@$izinPenelitian->status == 'Konfirmasi')
                                        <span class="badge badge-primary">Dikonfirmasi</span>
                                    @elseif (@$izinPenelitian->status == 'Proses')
                                        <span class="badge badge-success">Diproses</span>
                                    @elseif (@$izinPenelitian->status == 'Tolak')
                                        <span class="badge badge-danger">Ditolak</span>
                                    @elseif (@$izinPenelitian->status == 'Kendala')
                                        <span class="badge badge-danger">Ada Kendala</span>
                                    @else
                                        <span class="badge badge-success">Selesai</span>
                                    @endif
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Nama Pengaju<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('name')is-invalid @enderror"
                                        id="name" name="name" placeholder="Masukkan Koordinator PKL" 
                                        value="{{ old('name', @$izinPenelitian->mahasiswa->user->name) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    NIM<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <input type="number" class="form-control @error('nomor_induk')is-invalid @enderror"
                                        id="nomor_induk" name="nomor_induk" placeholder="Masukkan NIP" 
                                        value="{{ old('nim', @$izinPenelitian->mahasiswa->nim) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Tanggal Pengajuan<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <input type="" class="form-control @error('created_at')is-invalid @enderror"
                                        id="created_at" name="created_at" placeholder="" 
                                        value="{{ old('created_at', @$izinPenelitian->created_at) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Tempat Penelitian<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('nama_tempat')is-invalid @enderror"
                                        id="nama_tempat" name="nama_tempat" placeholder="" 
                                        value="{{ old('nama_tempat', @$izinPenelitian->nama_tempat) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Alamat Tempat Penelitian<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('alamat_tempat')is-invalid @enderror"
                                        id="alamat_tempat" name="alamat_tempat" placeholder="" 
                                        value="{{ old('alamat_tempat', @$izinPenelitian->alamat_tempat) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Ditujukan Kepada<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('tujuan_surat')is-invalid @enderror"
                                        id="tujuan_surat" name="tujuan_surat" placeholder="" 
                                        value="{{ old('tujuan_surat', @$izinPenelitian->tujuan_surat) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Perihal<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('perihal')is-invalid @enderror"
                                        id="perihal" name="perihal" placeholder="" 
                                        value="{{ old('perihal', @$izinPenelitian->perihal) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Dokumen Permohonan<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <label>
                                        @if (@$izinPenelitian->dokumen_permohonan !== null)
                                            <a class="btn btn-primary" href="{{ asset('storage/public/dokumen/dokumen-permohonan/'. @$izinPenelitian->dokumen_permohonan)}}" 
                                                    download="{{@$izinPenelitian->dokumen_permohonan}}">
                                                        Download Dokumen
                                            </a>
                                        @else
                                            Belum Ada Dokumen Permohonan Dari Admin Jurusan
                                        @endif
                                    </label>
                                </div>
                            </div>
                            <hr>
                            @role('bagian-akademik')
                            <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST"
                                action="{{route('update-surat-aktif-kuliah', $izinPenelitian->id) }}">
                                    @csrf

                                <div class="form-group row">
                                    <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                        Nomor Surat<sup class="text-danger">*</sup>
                                    </label>
    
                                    <div class="col-sm-12 col-md-9">
                                        <input type="text" class="form-control @error('no_surat')is-invalid @enderror"
                                            id="no_surat" name="no_surat" placeholder="Masukkan Nomor Surat" 
                                            value="{{ old('no_surat', @$izinPenelitian->no_surat) }}">

                                        @if ($errors->has('no_surat'))
                                            <span class="text-danger">{{ $errors->first('no_surat') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-7 offset-md-3">
                                        <button type="submit" class="btn btn-primary" id="btnSubmit">
                                            @if (@$izinPenelitian->no_surat == null)
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
                            @if ($user->hasRole('admin-jurusan'))
                                @if (@$izinPenelitian->status == "Menunggu Konfirmasi")
                                    <div class="text-md-right">
                                        <div class="float-lg-left mb-lg-0 mb-3">
                                            <button class="btn btn-primary btn-icon icon-left" data-toggle="modal" data-target="#konfirmasi{{$izinPenelitian->id}}">
                                                <i class="fas fa-check"></i> 
                                                Konfirmasi
                                            </button>

                                            <button class="btn btn-danger btn-icon icon-left" data-toggle="modal" data-target="#tolak{{$izinPenelitian->id}}">
                                                <i class="fas fa-times"></i> 
                                                Tolak
                                            </button>
                                        </div>
                                    </div> 
                                @else

                                @endif
                            @else
                                <div class="text-md-right">
                                    <a href="{{ route('print-izin-penelitian', Crypt::encryptString($izinPenelitian->id)) }}" class="btn btn-warning btn-icon icon-left">
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

<div class="modal fade" tabindex="-1" role="dialog" id="konfirmasi{{$izinPenelitian->id}}">
    <div class="modal-dialog" role="document">
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{ route('konfirmasi-izin-penelitian', $izinPenelitian->id)}}" method="POST">
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
                    <div class="form-group row mb-4">
                        <label for="image" class="col-form-label text-md-left col-12">
                            Dokumen Permohonan
                        </label>

                        <div class="col-sm-12 col-md-12">
                            <div class="input-group">
                                <input class="dropify @error('dokumen_permohonan') is-invalid @enderror" type="file" 
                                    name="dokumen_permohonan" data-height='250' data-allowed-file-extensions="pdf doc docx" data-max-file-size="5M">
                            </div>

                            @if ($errors->has('dokumen_permohonan'))
                                <span class="text-danger">
                                    {{ $errors->first('dokumen_permohonan') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Save changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="tolak{{$izinPenelitian->id}}">
    <div class="modal-dialog" role="document">
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{ route('tolak-izin-penelitian', $izinPenelitian->id)}}" method="POST">
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
                    <div class="form-group row mb-4" id="catatan">
                        <label for="name" class="col-sm-3 col-form-label">
                            Catatan Penolakan <sup class="text-danger">*</sup>
                        </label>

                        <div class="col-sm-9">
                            <textarea name="catatan" class="summernote-simple" id="catatan" cols="30" rows="10"
                                placeholder="Masukan Catatan">{{ old('catatan', @$izinPenelitian->catatan) }}</textarea>
                            
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
                        Close
                    </button>

                    <button type="submit" class="btn btn-primary">
                        Save changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
