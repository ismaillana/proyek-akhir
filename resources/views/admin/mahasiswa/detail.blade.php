@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{route('mahasiswa.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>
            Detail Data Mahasiswa
        </h1>
      </div>

      <form id="myForm" class="forms-sample" enctype="multipart/form-data">
        @method('put')
        {{ csrf_field() }}
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Mahasiswa Alumni</h4>
                        </div>
                        
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    Nama Mahasiswa<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('name')is-invalid @enderror"
                                        id="name" name="name" placeholder="Masukkan Nama Mahasiswa" 
                                        value="{{ old('name', @$mahasiswa->user->name) }}" readonly disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    NIM<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12">
                                    <input type="number" class="form-control @error('nomor_induk')is-invalid @enderror"
                                        id="nomor_induk" name="nomor_induk" placeholder="Masukkan NIM" 
                                        value="{{ old('nomor_induk', @$mahasiswa->user->nomor_induk) }}" readonly disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    Tempat Lahir<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('tempat_lahir')is-invalid @enderror"
                                        id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan Tempat Lahir" 
                                        value="{{ old('tempat_lahir', @$mahasiswa->tempat_lahir) }}" readonly disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    Tanggal Lahir<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12">
                                    <input type="date" class="form-control @error('tanggal_lahir')is-invalid @enderror"
                                        id="tanggal_lahir" name="tanggal_lahir" placeholder="Masukkan Tempat Lahir" 
                                        value="{{ old('tanggal_lahir', @$mahasiswa->tanggal_lahir) }}" readonly disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    Email<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12">
                                    <input type="email" class="form-control @error('email')is-invalid @enderror"
                                        id="email" name="email" placeholder="Masukkan Email" 
                                        value="{{ old('email', @$mahasiswa->user->email) }}" readonly disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                No WhatsApp<sup class="text-danger">*</sup>
                                </label>
                                    
                                
                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            +62
                                        </div>

                                        <input type="number" class="form-control @error('wa') is-invalid @enderror"
                                            id="wa" name="wa" placeholder="Masukan Nomer Whatsapp "
                                            value="{{ old('wa', Str::substr(@$mahasiswa->user->wa, 2)) }}" readonly disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    Angkatan<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            Tahun
                                        </div>
                                    
                                        <input type="number" class="form-control @error('angkatan')is-invalid @enderror"
                                            id="angkatan" name="angkatan" placeholder="Masukkan Angkatan" 
                                            value="{{ old('angkatan', @$mahasiswa->angkatan )}}" readonly disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    Jurusan<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12">
                                    <select name="jurusan_id" id="jurusan_id"
                                        class="form-control @error('jurusan_id')
                                        is-invalid @enderror" readonly disabled>
                                        <option value="" selected="" disabled="">Pilih Jurusan</option>
                                        @foreach ($prodi as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('program_studi_id', @$mahasiswa->program_studi_id) == $item->id ? 'selected' : '' }}>
                                                {{ $item->jurusan->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            

                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    Program Studi<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12">
                                    <select name="program_studi_id" id="program_studi_id"
                                        class="form-control @error('program_studi_id')
                                        is-invalid @enderror" readonly disabled>
                                        <option value="" selected="" disabled="">Pilih Program Studi</option>
                                        @foreach ($prodi as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('program_studi_id', @$mahasiswa->program_studi_id) == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    Semester<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12">
                                    <select class="form-control @error('semester')is-invalid @enderror" id="semester" name="semester" readonly disabled>
                                        <option selected disabled value="">Pilih Semester</option>
                                        <option value="1"
                                          {{ old('semester', @$mahasiswa->semester) == '1' ? 'selected' : '' }}>
                                            1</option>
                                        <option value="2"
                                          {{ old('semester', @$mahasiswa->semester) == '2' ? 'selected' : '' }}>
                                            2</option>
                                        <option value="3"
                                          {{ old('semester', @$mahasiswa->semester) == '3' ? 'selected' : '' }}>
                                            3</option>
                                        <option value="4"
                                          {{ old('semester', @$mahasiswa->semester) == '4' ? 'selected' : '' }}>
                                            4</option>
                                        <option value="5"
                                          {{ old('semester', @$mahasiswa->semester) == '5' ? 'selected' : '' }}>
                                            5</option>
                                        <option value="6"
                                          {{ old('semester', @$mahasiswa->semester) == '6' ? 'selected' : '' }}>
                                            6</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    Tahun Ajaran<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            Tahun
                                        </div>
                                    
                                        <input type="number" class="form-control @error('tahun_ajaran')is-invalid @enderror"
                                            id="tahun_ajaran" name="tahun_ajaran" placeholder="Masukkan Tahun Ajaran" 
                                            value="{{ old('tahun_ajaran', @$mahasiswa->tahun_ajaran )}}" readonly disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Mahasiswa Alumni</h4>
                        </div>
                        
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    Nama Orang Tua<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('orang_tua')is-invalid @enderror"
                                        id="orang_tua" name="orang_tua" placeholder="Masukkan Nama Orang Tua" 
                                        value="{{ old('orang_tua', @$mahasiswa->orang_tua) }}" readonly disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    Pekerjaan Orang Tua<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('pekerjaan')is-invalid @enderror"
                                        id="pekerjaan" name="pekerjaan" placeholder="Masukkan Pekerjaan Orang Tua" 
                                        value="{{ old('pekerjaan', @$mahasiswa->pekerjaan) }}" readonly disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    NIP/NRP Orang Tua<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('nip_nrp')is-invalid @enderror"
                                        id="nip_nrp" name="nip_nrp" placeholder="Masukkan NIP/NRP Orang Tua" 
                                        value="{{ old('nip_nrp', @$mahasiswa->nip_nrp) }}" readonly disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    Pangkat/Golongan Orang Tua<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('pangkat')is-invalid @enderror"
                                        id="pangkat" name="pangkat" placeholder="Masukkan Pangkat Orang Tua" 
                                        value="{{ old('pangkat', @$mahasiswa->pangkat) }}" readonly disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    Jabatan Orang Tua<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('jabatan')is-invalid @enderror"
                                        id="jabatan" name="jabatan" placeholder="Masukkan Jabatan Orang Tua" 
                                        value="{{ old('jabatan', @$mahasiswa->jabatan) }}" readonly disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    Instansi Orang Tua<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('instansi')is-invalid @enderror"
                                        id="instansi" name="instansi" placeholder="Masukkan Instansi Orang Tua" 
                                        value="{{ old('instansi', @$mahasiswa->instansi) }}" readonly disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="image" class="col-sm-12 col-form-label">
                                    Foto Pribadi
                                </label>
                                <div class="col-sm-12">
                                    <input class="dropify @error('image') is-invalid @enderror" 
                                        data-height='250' type="file" name="image" id="image" 
                                        data-default-file="{{ @$mahasiswa->image_url }}" readonly disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-12 col-form-label">
                                    Status<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12">
                                    <select name="status" id="status"
                                        class="form-control @error('status')
                                        is-invalid @enderror" readonly disabled>
                                        <option disabled selected>Pilih Status</option>
                                        <option value="Mahasiswa Aktif"
                                            {{ old('status', @$mahasiswa->status) == 'Mahasiswa Aktif' ? 'selected' : '' }}>
                                                Mahasiswa Aktif</option>
                                        <option value="Alumni"
                                            {{ old('status', @$mahasiswa->status) == 'Alumni' ? 'selected' : '' }}>
                                                Alumni</option>
                                    </select>
                                </div>
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