@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{route('riwayat-pengajuan-izin-penelitian')}}" class="btn btn-icon">
                    <i class="fas fa-arrow-left"></i>
                </a>

                <h1>
                    Detail Riwayat Pengajuan
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
                                    Detail Riwayat Pengajuan Surat Izin Penelitian
                                </h4>

                                <div class="d-flex">
                                <h4>
                                    Status Pengajuan
                                </h4>
                                    @if (@$izinPenelitian->status == 'Menunggu Konfirmasi')
                                        <span class="btn btn-warning">Menunggu Konfirmasi</span>
                                    @elseif (@$izinPenelitian->status == 'Konfirmasi')
                                        <span class="btn btn-primary">Dikonfirmasi</span>
                                    @elseif (@$izinPenelitian->status == 'Proses')
                                        <span class="btn btn-success">Diproses</span>
                                    @elseif (@$izinPenelitian->status == 'Tolak')
                                        <span class="btn btn-danger">Ditolak</span>
                                    @elseif (@$izinPenelitian->status == 'Kendala')
                                        <span class="btn btn-danger">Ada Kendala</span>
                                    @else
                                        <span class="btn btn-success">Selesai</span>
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
                                        value="{{ \Carbon\Carbon::parse(@$izinPenelitian->created_at)->translatedFormat('d F Y H:i:s') }}" disabled readonly>
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
                                <div class="form-group row">
                                    <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                        Nomor Surat<sup class="text-danger">*</sup>
                                    </label>
    
                                    <div class="col-sm-12 col-md-9">
                                        <input type="text" class="form-control @error('no_surat')is-invalid @enderror"
                                            id="no_surat" name="no_surat" placeholder="Masukkan Nomor Surat" 
                                            value="{{ old('no_surat', @$izinPenelitian->no_surat) }}" readonly disabled>
                                    </div>
                                </div>
                            <hr>
                                <div class="text-md-right">
                                    <a href="{{ route('print-izin-penelitian', Crypt::encryptString($izinPenelitian->id)) }}" class="btn btn-warning btn-icon icon-left">
                                        <i class="fas fa-print"></i> 
                                            Print
                                    </a>
                                </div>
                            @endrole
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
