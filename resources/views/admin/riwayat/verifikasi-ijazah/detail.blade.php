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
                                        <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                    @elseif (@$verifikasiIjazah->status == 'Konfirmasi')
                                        <span class="badge badge-primary">Dikonfirmasi</span>
                                    @elseif (@$verifikasiIjazah->status == 'Proses')
                                        <span class="badge badge-success">Diproses</span>
                                    @elseif (@$verifikasiIjazah->status == 'Tolak')
                                        <span class="badge badge-danger">Ditolak</span>
                                    @elseif (@$verifikasiIjazah->status == 'Kendala')
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
                                    Pengaju<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('instansi_id')is-invalid @enderror"
                                        id="instansi_id" name="instansi_id" placeholder="Masukkan Koordinator PKL" 
                                        value="{{ old('instansi_id', @$verifikasiIjazah->instansi->user->name) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Nama Mahasiswa<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('name')is-invalid @enderror"
                                        id="name" name="name" placeholder="Masukkan Nama Mahasiswa" 
                                        value="{{ old('name', @$verifikasiIjazah->nama) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    NIM<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="number" class="form-control @error('nomor_induk')is-invalid @enderror"
                                        id="nomor_induk" name="nomor_induk" placeholder="" 
                                        value="{{ old('nim', @$verifikasiIjazah->nim) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Nomor Ijazah<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="number" class="form-control @error('no_ijazah')is-invalid @enderror"
                                        id="no_ijazah" name="no_ijazah" placeholder="" 
                                        value="{{ old('no_ijazah', @$verifikasiIjazah->no_ijazah) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Tahun Lulus<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="number" class="form-control @error('tahun_lulus')is-invalid @enderror"
                                        id="tahun_lulus" name="tahun_lulus" placeholder="" 
                                        value="{{ old('tahun_lulus', @$verifikasiIjazah->tahun_lulus) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Tanggal Pengajuan<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('tanggal_pengajuan')is-invalid @enderror"
                                        id="tanggal_pengajuan" name="tanggal_pengajuan" placeholder="" 
                                        value="{{ old('created_at', @$verifikasiIjazah->created_at) }}" disabled readonly>
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
