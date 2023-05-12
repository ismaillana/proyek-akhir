@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{route('prodi.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>
            @if (@$prodi->exists)
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
            Data Program Studi
        </h1>
      </div>

      @if (@$prodi->exists)
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST"
            action="{{route('prodi.update', $prodi) }}">
            @method('put')
      @else
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST" 
            action="{{route('prodi.store')}}">
      @endif
        {{ csrf_field() }}
        <div class="section-body">
          <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>Form Program Studi</h4>
                </div>
                <div class="card-body">
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
                                        {{ old('jurusan_id', @$prodi->jurusan_id) == $item->id ? 'selected' : '' }}>
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
                            Nama Program Studi<sup class="text-danger">*</sup>
                        </label>

                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control @error('name')is-invalid @enderror"
                            id="name" name="name" placeholder="Masukkan Nama Program Studi" 
                            value="{{ old('name', @$prodi->name) }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
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