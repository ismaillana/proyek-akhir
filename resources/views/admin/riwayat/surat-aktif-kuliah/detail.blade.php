@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
            <a href="{{route('riwayat-pengajuan-aktif-kuliah')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
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
                                    Detail Riwayat Pengajuan Surat Aktif Kuliah
                                </h4>

                                <div class="d-flex">

                                <h4>
                                    Status Pengajuan
                                </h4>
                                    @if (@$aktifKuliah->status == 'Menunggu Konfirmasi')
                                        <span class="btn btn-warning">Menunggu Konfirmasi</span>
                                    @elseif (@$aktifKuliah->status == 'Konfirmasi')
                                        <span class="btn btn-primary">Dikonfirmasi</span>
                                    @elseif (@$aktifKuliah->status == 'Proses')
                                        <span class="btn btn-success">Diproses</span>
                                    @elseif (@$aktifKuliah->status == 'Tolak')
                                        <span class="btn btn-danger">Ditolak</span>
                                    @elseif (@$aktifKuliah->status == 'Kendala')
                                        <span class="btn btn-danger">Ada Kendala</span>
                                    @else
                                        <span class="btn btn-success">Selesai</span>
                                    @endif
                                </div>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="card-body">
                                <div class="form-group col-12">
                                    <label class="col-sm-12 col-form-label">
                                        Tanggal Pengajuan<sup class="text-danger">*</sup>
                                    </label>
    
                                    <div class="col-sm-12">
                                        <input type="" class="form-control @error('created_at')is-invalid @enderror"
                                            id="created_at" name="created_at" placeholder="-" 
                                            value="{{ \Carbon\Carbon::parse(@$aktifKuliah->created_at)->translatedFormat('d F Y H:i:s') }}" disabled readonly>
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label class="col-sm-12 col-form-label">
                                        Nama Pengaju<sup class="text-danger">*</sup>
                                    </label>
    
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control @error('name')is-invalid @enderror"
                                            id="name" name="name" placeholder="-" 
                                            value="{{ old('name', @$aktifKuliah->mahasiswa->user->name) }}" disabled readonly>
                                    </div>
                                </div>
    
                                <div class="form-group col-12">
                                    <label class="col-sm-12 col-form-label">
                                        NIM<sup class="text-danger">*</sup>
                                    </label>
    
                                    <div class="col-sm-12">
                                        <input type="number" class="form-control @error('nomor_induk')is-invalid @enderror"
                                            id="nomor_induk" name="nomor_induk" placeholder="-" 
                                            value="{{ old('nim', @$aktifKuliah->mahasiswa->nim) }}" disabled readonly>
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label class="col-sm-12 col-form-label">
                                        Tempat/Tanggal Lahir<sup class="text-danger">*</sup>
                                    </label>
    
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control @error('tempat_lahir')is-invalid @enderror"
                                            id="tempat_lahir" name="tempat_lahir" placeholder="-" 
                                            value="{{ old('tempat_lahir', @$aktifKuliah->mahasiswa->tempat_lahir) }}/{{ \Carbon\Carbon::parse(@$aktifKuliah->mahasiswa->tanggal_lahir)->translatedFormat('d F Y') }}" disabled readonly>
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label class="col-sm-12 col-form-label">
                                        Angkatan<sup class="text-danger">*</sup>
                                    </label>
    
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control @error('angkatan')is-invalid @enderror"
                                            id="angkatan" name="angkatan" placeholder="-" 
                                            value="{{ old('angkatan', @$aktifKuliah->mahasiswa->angkatan) }}" disabled readonly>
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label class="col-sm-12 col-form-label">
                                        Semester/Tahun Ajaran<sup class="text-danger">*</sup>
                                    </label>
    
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control @error('semester')is-invalid @enderror"
                                            id="semester" name="semester" placeholder="-" 
                                            value="{{ old('semester', @$aktifKuliah->mahasiswa->semester) }}/{{ old('tahun_ajaran', @$aktifKuliah->mahasiswa->tahun_ajaran) }}" disabled readonly>
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label class="col-sm-12 col-form-label">
                                        Jurusan/Program Studi<sup class="text-danger">*</sup>
                                    </label>
    
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control @error('jururusan_id')is-invalid @enderror"
                                            id="jururusan_id" name="jururusan_id" placeholder="-" 
                                            value="{{ old('program_studi_id', @$aktifKuliah->mahasiswa->programStudi->jurusan->name) }}/{{ old('program_studi_id', @$aktifKuliah->mahasiswa->programStudi->name) }}" disabled readonly>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="card-body">
                                <div class="form-group col-12">
                                    <label class="col-sm-12 col-form-label">
                                        Nama Orang Tua<sup class="text-danger">*</sup>
                                    </label>
    
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control @error('orang_tua')is-invalid @enderror"
                                            id="orang_tua" name="orang_tua" placeholder="-" 
                                            value="{{ old('orang_tua', @$aktifKuliah->mahasiswa->orang_tua) }}" disabled readonly>
                                    </div>
                                </div>
    
                                <div class="form-group col-12">
                                    <label class="col-sm-12 col-form-label">
                                        NIP/NRP<sup class="text-danger">*</sup>
                                    </label>
    
                                    <div class="col-sm-12">
                                        <input type="number" class="form-control @error('nip_nrp')is-invalid @enderror"
                                            id="nip_nrp" name="nip_nrp" placeholder="-" 
                                            value="{{ old('nip_nrp', @$aktifKuliah->mahasiswa->nip_nrp) }}" disabled readonly>
                                    </div>
                                </div>
    
                                <div class="form-group col-12">
                                    <label class="col-sm-12 col-form-label">
                                        Pangkat/Golongan<sup class="text-danger">*</sup>
                                    </label>
    
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control @error('pangkat')is-invalid @enderror"
                                            id="pangkat" name="pangkat" placeholder="-" 
                                            value="{{ old('pangkat', @$aktifKuliah->pangkat) }}" disabled readonly>
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label class="col-sm-12 col-form-label">
                                        Jabatan<sup class="text-danger">*</sup>
                                    </label>
    
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control @error('jabatan')is-invalid @enderror"
                                            id="jabatan" name="jabatan" placeholder="-" 
                                            value="{{ old('jabatan', @$aktifKuliah->jabatan) }}" disabled readonly>
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label class="col-sm-12 col-form-label">
                                        Pada Instansi<sup class="text-danger">*</sup>
                                    </label>
    
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control @error('instansi')is-invalid @enderror"
                                            id="instansi" name="instansi" placeholder="-" 
                                            value="{{ old('instansi', @$aktifKuliah->instansi) }}" disabled readonly>
                                    </div>
                                </div>
    
                                <div class="form-group col-12">
                                    <label for="name" class="col-sm-3 col-form-label">
                                        Keperluan <sup class="text-danger">*</sup>
                                    </label>
    
                                    <div class="col-sm-12">
                                        <textarea name="keperluan" class="summernote-simple" id="keperluan" cols="30" rows="10"
                                            placeholder="Masukan Keperluan" readonly disabled>{{ old('keperluan', @$aktifKuliah->keperluan) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <hr>
                            @role('bagian-akademik')
                                <div class="form-group row">
                                    <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                        Nomor Surat<sup class="text-danger">*</sup>
                                    </label>
    
                                    <div class="col-sm-12 col-md-9">
                                        <input type="text" class="form-control @error('no_surat')is-invalid @enderror"
                                            id="no_surat" name="no_surat" placeholder="Masukkan Nomor Surat" 
                                            value="{{ old('no_surat', @$aktifKuliah->no_surat) }}" readonly disabled>
                                    </div>
                                </div>
                            <hr>
                                <div class="text-md-right">
                                    <a href="{{ route('print-aktif-kuliah', Crypt::encryptString($aktifKuliah->id)) }}" target="_blank" class="btn btn-warning btn-icon icon-left">
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
