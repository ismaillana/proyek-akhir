@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
            <a href="{{route('riwayat-pengajuan-aktif-kuliah')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>

            <h1>
                Detail Riwayat
            </h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4>
                                    Detail Riwayat Pengajuan Surat Aktif Kuliah
                                </h4>

                                <div class="d-flex">

                                <h4>
                                    Status Pengajuan
                                </h4>
                                    @if (@$aktifKuliah->status == 'Menunggu Konfirmasi')
                                        <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                    @elseif (@$aktifKuliah->status == 'Konfirmasi')
                                        <span class="badge badge-primary">Dikonfirmasi</span>
                                    @elseif (@$aktifKuliah->status == 'Proses')
                                        <span class="badge badge-success">Diproses</span>
                                    @elseif (@$aktifKuliah->status == 'Tolak')
                                        <span class="badge badge-danger">Ditolak</span>
                                    @elseif (@$aktifKuliah->status == 'Kendala')
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
                                    <textarea name="keperluan" class="summernote-simple" id="keperluan" cols="30" rows="10"
                                        placeholder="Masukan Keperluan" readonly disabled>{{ old('keperluan', @$aktifKuliah->keperluan) }}</textarea>
                                </div>
                            </div>
                            {{-- <hr>
                            
                                <div class="text-md-right">
                                    <button class="btn btn-warning btn-icon icon-left">
                                        <i class="fas fa-print"></i> 
                                        Print
                                    </button>
                                </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
