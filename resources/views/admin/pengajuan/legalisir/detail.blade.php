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
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4>
                                    Detail Pengajuan Legalisir
                                </h4>

                                <div class="d-flex">
                                <h4>
                                    Status Pengajuan
                                </h4>
                                    @if (@$legalisir->status == 'Menunggu Konfirmasi')
                                        <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                    @elseif (@$legalisir->status == 'Konfirmasi')
                                        <span class="badge badge-primary">Dikonfirmasi</span>
                                    @elseif (@$legalisir->status == 'Proses')
                                        <span class="badge badge-success">Diproses</span>
                                    @elseif (@$legalisir->status == 'Tolak')
                                        <span class="badge badge-danger">Ditolak</span>
                                    @elseif (@$legalisir->status == 'Kendala')
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
                            @if (@$legalisir->status == "Menunggu Konfirmasi")
                                <div class="text-md-right">
                                    <div class="float-lg-left mb-lg-0 mb-3">
                                        <button class="btn btn-primary btn-icon icon-left" data-toggle="modal" data-target="#konfirmasi{{$legalisir->id}}">
                                            <i class="fas fa-check"></i> 
                                            Konfirmasi
                                        </button>

                                        <button class="btn btn-danger btn-icon icon-left" data-toggle="modal" data-target="#tolak{{$legalisir->id}}">
                                            <i class="fas fa-times"></i> 
                                            Tolak
                                        </button>
                                    </div>

                                    <button class="btn btn-warning btn-icon icon-left">
                                        <i class="fas fa-print"></i> 
                                        Print
                                    </button>
                                </div>
                            @else
                                <div class="text-md-right">
                                    <button class="btn btn-warning btn-icon icon-left">
                                        <i class="fas fa-print"></i> 
                                        Print
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="konfirmasi{{$legalisir->id}}">
    <div class="modal-dialog" role="document">
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{ route('konfirmasi-legalisir', $legalisir->id)}}" method="POST">
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

<div class="modal fade" tabindex="-1" role="dialog" id="tolak{{$legalisir->id}}">
    <div class="modal-dialog" role="document">
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{ route('tolak-legalisir', $legalisir->id)}}" method="POST">
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
                                placeholder="Masukan Catatan">{{ old('catatan', @$legalisir->catatan) }}</textarea>
                            
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
