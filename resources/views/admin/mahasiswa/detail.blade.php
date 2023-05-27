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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Detail Mahasiswa</h4>
                        </div>
                        
                        <div class="card-body">
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Nama Mahasiswa<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('name')is-invalid @enderror"
                                        id="name" name="name" placeholder="Masukkan Nama Mahasiswa" 
                                        value="{{ old('name', @$mahasiswa->user->name) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    NIM<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="number" class="form-control @error('nomor_induk')is-invalid @enderror"
                                        id="nomor_induk" name="nomor_induk" placeholder="Masukkan NIM" 
                                        value="{{ old('nomor_induk', @$mahasiswa->user->nomor_induk) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Email<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="email" class="form-control @error('email')is-invalid @enderror"
                                        id="email" name="email" placeholder="Masukkan Email" 
                                        value="{{ old('email', @$mahasiswa->user->email) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                No WhatsApp<sup class="text-danger">*</sup>
                                </label>
                                    
                                <div class="col-sm-12 col-md-7">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            +62
                                        </div>

                                        <input type="number" class="form-control @error('wa') is-invalid @enderror"
                                            id="wa" name="wa" placeholder="Masukan Nomer Whatsapp "
                                            value="{{ old('wa', Str::substr(@$mahasiswa->user->wa, 2)) }}" disabled readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Angkatan<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            Tahun
                                        </div>
                                    
                                        <input type="number" class="form-control @error('angkatan')is-invalid @enderror"
                                            id="angkatan" name="angkatan" placeholder="Masukkan Nama Program Studi" 
                                            value="{{ old('angkatan', @$mahasiswa->angkatan )}}" disabled readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Jurusan<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <select name="jurusan_id" id="jurusan_id"
                                        class="form-control @error('jurusan_id')
                                        is-invalid @enderror" disabled @readonly(true)>
                                        <option value="" selected="" disabled="">Pilih Jurusan</option>
                                        @foreach ($jurusan as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('jurusan_id', @$mahasiswa->jurusan_id) == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Program Studi<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <select name="program_studi_id" id="program_studi_id"
                                        class="form-control @error('program_studi_id')
                                        is-invalid @enderror" disabled readonly>
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

                            <div class="form-group row mb-4">
                                <label for="image" class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Foto Pribadi
                                </label>
                                <div class="col-sm-12 col-md-7">
                                    <input class="dropify @error('image') is-invalid @enderror" 
                                        data-height='250' type="file" name="image" id="image" 
                                        data-default-file="{{ @$mahasiswa->image_url }}" readonly disabled>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Status<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <select name="status" id="status"
                                        class="form-control @error('status')
                                        is-invalid @enderror" disabled readonly>
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

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Role<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <select name="roles" id="roles"
                                        class="form-control @error('roles')
                                        is-invalid @enderror" disabled readonly>
                                        <option value="" selected="" disabled="">Pilih Role</option>
                                        @foreach ($roles as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('roles',@$item->id) == $item->id ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('roles'))
                                        <span class="text-danger">
                                            {{ $errors->first('roles') }}
                                        </span>
                                    @endif
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