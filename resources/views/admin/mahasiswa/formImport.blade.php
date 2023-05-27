@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{route('mahasiswa.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
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
            action="{{route('mahasiswa.update', $mahasiswa) }}">
            @method('put')
      @else
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST" 
            action="{{route('mahasiswa.store')}}">
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
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
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
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
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
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Status<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <select name="status" id="status"
                                        class="form-control @error('status')
                                        is-invalid @enderror">
                                        <option disabled selected>Pilih Status</option>
                                        <option value="Mahasiswa Aktif"
                                            {{ old('status', @$mahasiswa->status) == 'Mahasiswa Aktif' ? 'selected' : '' }}>
                                                Mahasiswa Aktif</option>
                                        <option value="Alumni"
                                            {{ old('status', @$mahasiswa->status) == 'Alumni' ? 'selected' : '' }}>
                                                Alumni</option>
                                    </select>

                                    @if ($errors->has('status'))
                                        <span class="text-danger">
                                            {{ $errors->first('status') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label for="image" class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    File Excel
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <div class="input-group">
                                        <input class="dropify @error('file') is-invalid @enderror" type="file" 
                                            name="file" data-height='250' data-allowed-file-extensions="xlsx xls" data-max-file-size="5M">
                                    </div>

                                    <div class="text text-info">
                                        <small>
                                            Panduan / Contoh File Import Produk bisa dilihat pada link berikut
                                            <a href="#" class="mr-2">
                                                Download File
                                            </a>
                                        </small>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row mb-4">
                                <div class="col-sm-12 col-md-7 offset-md-3">
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