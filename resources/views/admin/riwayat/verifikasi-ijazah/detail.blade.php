@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
            <a href="{{route('riwayat-pengajuan-verifikasi-ijazah')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
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
                                <div class="form-group row">
                                    <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                        Nomor Surat<sup class="text-danger">*</sup>
                                    </label>
    
                                    <div class="col-sm-12 col-md-9">
                                        <input type="text" class="form-control @error('no_surat')is-invalid @enderror"
                                            id="no_surat" name="no_surat" placeholder="Masukkan Nomor Surat" 
                                            value="{{ old('no_surat', @$verifikasiIjazah->no_surat) }}" readonly disabled>
                                    </div>
                                </div>
                            @endrole
                            <hr>
                                <div class="text-md-right">
                                    <a href="{{ route('print-verifikasi-ijazah', Crypt::encryptString($verifikasiIjazah->id)) }}" class="btn btn-warning btn-icon icon-left">
                                        <i class="fas fa-print"></i> 
                                            Print
                                    </a>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
