@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{route('alumni.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>
            @if (@$mahasiswa->exists)
                Edit
                @php
                    $aksi = 'Edit';
                @endphp
            @else
                Tambah
                @php
                    $aksi = 'Tambah'
                @endphp
            @endif
            Data Mahasiswa
        </h1>
      </div>

      @if (@$mahasiswa->exists)
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST"
            action="{{route('alumni.update', $mahasiswa) }}">
            @method('put')
      @else
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST" 
            action="{{route('alumni.store')}}">
      @endif
        {{ csrf_field() }}
        <div class="section-body">
          <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>Form Mahasiswa</h4>
                </div>
                <div class="card-body">
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                            Nama Mahasiswa<sup class="text-danger">*</sup>
                        </label>

                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control @error('name')is-invalid @enderror"
                            id="name" name="name" placeholder="Masukkan Nama Mahasiswa" 
                            value="{{ old('name', @$mahasiswa->user->name) }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                            NIM<sup class="text-danger">*</sup>
                        </label>

                        <div class="col-sm-12 col-md-7">
                            <input type="number" class="form-control @error('nomor_induk')is-invalid @enderror"
                            id="nomor_induk" name="nomor_induk" placeholder="Masukkan NIM" 
                            value="{{ old('nomor_induk', @$mahasiswa->user->nomor_induk) }}">
                            @if ($errors->has('nomor_induk'))
                                <span class="text-danger">{{ $errors->first('nomor_induk') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                            Email<sup class="text-danger">*</sup>
                        </label>

                        <div class="col-sm-12 col-md-7">
                            <input type="email" class="form-control @error('email')is-invalid @enderror"
                            id="email" name="email" placeholder="Masukkan Email" 
                            value="{{ old('email', @$mahasiswa->user->email) }}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                           No WhatsApp<sup class="text-danger">*</sup>
                        </label>
                            
                           
                        <div class="col-sm-12 col-md-7">
                            <div class="input-group">
                                <div class="input-group-text">
                                    +62
                                </div>

                                <input type="number" class="form-control @error('wa') is-invalid @enderror"
                                    id="wa" name="wa" placeholder="Masukan Nomer Whatsapp "
                                    value="{{ old('wa', Str::substr(@$mahasiswa->user->wa, 2)) }}">
                            </div>
                            @if ($errors->has('wa'))
                                <span class="text-danger">{{ $errors->first('wa') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                            Angkatan<sup class="text-danger">*</sup>
                        </label>

                        <div class="col-sm-12 col-md-7">
                            <div class="input-group">
                                <div class="input-group-text">
                                    Tahun
                                </div>
                            
                                <input type="number" class="form-control @error('angkatan')is-invalid @enderror"
                                id="angkatan" name="angkatan" placeholder="Masukkan Nama Program Studi" 
                                value="{{ old('angkatan', @$mahasiswa->angkatan )}}">
                            </div>

                            @if ($errors->has('angkatan'))
                                <span class="text-danger">{{ $errors->first('angkatan') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                            Jurusan<sup class="text-danger">*</sup>
                        </label>

                        <div class="col-sm-12 col-md-7">
                            <select name="jurusan_id" id="jurusan_id"
                                class="form-control @error('jurusan_id')
                                is-invalid @enderror">
                                <option value="" selected="" disabled="">Pilih Jurusan</option>
                                @foreach ($jurusan as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('jurusan_id', @$mahasiswa->jurusan_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>

                            @if ($errors->has('jurusan_id'))
                                <span class="text-danger">
                                    {{ $errors->first('jurusan_id') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                            Program Studi<sup class="text-danger">*</sup>
                        </label>

                        <div class="col-sm-12 col-md-7">
                            <select name="program_studi_id" id="program_studi_id"
                                class="form-control @error('program_studi_id')
                                is-invalid @enderror">
                                <option value="" selected="" disabled="">Pilih Program Studi</option>
                                @foreach ($prodi as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('program_studi_id', @$mahasiswa->program_studi_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>

                            @if ($errors->has('program_studi_id'))
                                <span class="text-danger">
                                    {{ $errors->first('program_studi_id') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label for="image" class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                            Foto Pribadi
                        </label>
                        <div class="col-sm-12 col-md-7">
                              <input class="dropify @error('image') is-invalid @enderror" 
                              data-height='250' type="file" name="image" id="image" 
                              data-default-file="{{ @$mahasiswa->image_url }}">
                          </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                            Status
                        </label>

                        <div class="col-sm-12 col-md-7">
                            <select name="status" id="status"
                                class="form-control @error('status')
                                is-invalid @enderror">
                                <option disabled selected>Pilih Status</option>
                                {{-- @foreach ($jurusan as $item) --}}
                                    {{-- <option value="{{ $item->status }}"
                                        {{ old('status', @$mahasiswa->status) == $item->status ? 'selected' : '' }}>
                                        {{ $item->status }}
                                    </option> --}}
                                <option value="Mahasiswa Aktif"
                                    {{ old('status', @$mahasiswa->status) == 'Mahasiswa Aktif' ? 'selected' : '' }}>
                                        Mahasiswa Aktif</option>
                                <option value="Alumni"
                                    {{ old('status', @$mahasiswa->status) == 'Alumni' ? 'selected' : '' }}>
                                        Alumni</option>
                                {{-- @endforeach --}}
                            </select>

                            @if ($errors->has('status'))
                                <span class="text-danger">
                                    {{ $errors->first('status') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                        <div class="col-sm-12 col-md-7">
                            <button class="btn btn-primary">{{ $aksi }}</button>
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