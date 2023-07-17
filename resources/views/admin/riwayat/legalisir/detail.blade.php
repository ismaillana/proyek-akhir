@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{route('riwayat-pengajuan-legalisir')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>

        <h1>
            Detail Riwayat Pengajuan
        </h1>
      </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4>
                                    Detail Riwayat Pengajuan Legalisir
                                </h4>

                                <div class="d-flex">
                                <h4>
                                    Status Pengajuan
                                </h4>
                                    @if (@$legalisir->status == 'Menunggu Konfirmasi')
                                        <span class="btn btn-warning">Menunggu Konfirmasi</span>
                                    @elseif (@$legalisir->status == 'Konfirmasi')
                                        <span class="btn btn-primary">Dikonfirmasi</span>
                                    @elseif (@$legalisir->status == 'Proses')
                                        <span class="btn btn-success">Diproses</span>
                                    @elseif (@$legalisir->status == 'Tolak')
                                        <span class="btn btn-danger">Ditolak</span>
                                    @elseif (@$legalisir->status == 'Kendala')
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
                                        value="{{ old('name', @$legalisir->mahasiswa->user->name) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    NIM<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <input type="number" class="form-control @error('nomor_induk')is-invalid @enderror"
                                        id="nomor_induk" name="nomor_induk" placeholder="Masukkan NIP" 
                                        value="{{ old('nim', @$legalisir->mahasiswa->nim) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Tanggal Pengajuan<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <input type="" class="form-control @error('created_at')is-invalid @enderror"
                                        id="created_at" name="created_at" placeholder="" 
                                        value="{{ \Carbon\Carbon::parse(@$legalisir->created_at)->translatedFormat('d F Y H:i:s') }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Keperluan<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('keperluan')is-invalid @enderror"
                                        id="keperluan" name="keperluan" placeholder="" 
                                        value="{{ old('keperluan', @$legalisir->keperluan) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Pekerjaan Terakhir<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('pekerjaan_terakhir')is-invalid @enderror"
                                        id="pekerjaan_terakhir" name="pekerjaan_terakhir" placeholder="" 
                                        value="{{ old('pekerjaan_terakhir', @$legalisir->pekerjaan_terakhir) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Tempat Kerja Terakhir<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('nama_tempat')is-invalid @enderror"
                                        id="nama_tempat" name="nama_tempat" placeholder="" 
                                        value="{{ old('nama_tempat', @$legalisir->nama_tempat) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Jenis Dokumen Legalisir<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    @if (@$legalisir->jenis_legalisir)
                                        @foreach ( @$legalisir->jenis_legalisir as $dokumen)
                                            
                                        <input type="text" class="form-control @error('jenis_legalisir')is-invalid @enderror mb-2"
                                            id="jenis_legalisir" name="jenis_legalisir" placeholder="" 
                                            value="{{$dokumen}}" disabled readonly>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Dokumen Yang Akan Dilegalisir<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <label>
                                        <a class="btn btn-primary" href="{{ asset('storage/public/dokumen/'. @$legalisir->dokumen)}}" 
                                                download="{{@$legalisir->dokumen}}">
                                                    Download Dokumen
                                        </a>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
