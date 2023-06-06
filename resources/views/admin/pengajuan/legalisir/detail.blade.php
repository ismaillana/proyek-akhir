@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{route('pengajuan-legalisir.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>

        <h1>
            Detail Pengajuan
        </h1>
      </div>

      <form id="myForm" class="forms-sample" enctype="multipart/form-data">
        @method('put')
        {{ csrf_field() }}
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Detail Pengajuan Legalisir</h4>
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
                                        value="{{ old('created_at', @$legalisir->created_at) }}" disabled readonly>
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
                                    <input type="text" class="form-control @error('tempat_pekerjaan_terakhir')is-invalid @enderror"
                                        id="tempat_pekerjaan_terakhir" name="tempat_pekerjaan_terakhir" placeholder="" 
                                        value="{{ old('tempat_pekerjaan_terakhir', @$legalisir->tempat_pekerjaan_terakhir) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Jenis Dokumen Legalisir<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-9">
                                    <input type="text" class="form-control @error('jenis_legalisir_id')is-invalid @enderror"
                                        id="jenis_legalisir_id" name="jenis_legalisir_id" placeholder="" 
                                        value="{{ old('jenis_legalisir_id', @$legalisir->jenis_legalisir) }}" disabled readonly>
                                </div>
                            </div>
                            <hr>
                            <div class="text-md-right">
                                <div class="float-lg-left mb-lg-0 mb-3">
                                    <button class="btn btn-primary btn-icon icon-left"><i class="fas fa-check"></i> Konfirmasi</button>
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
