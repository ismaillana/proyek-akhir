@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{route('ijazah.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>
            @if (@$ijazah->exists)
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
            Data Ijazah
        </h1>
      </div>

      @if (@$ijazah->exists)
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST"
            action="{{route('ijazah.update', $ijazah) }}">
            @method('put')
      @else
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST" 
            action="{{route('ijazah.store')}}">
      @endif
        {{ csrf_field() }}
        <div class="section-body">
          <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>Form Ijazah</h4>
                </div>
                <div class="card-body">
                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                            Nama Alumni<sup class="text-danger">*</sup>
                        </label>

                        <div class="col-sm-12 col-md-7">
                            <select name="mahasiswa_id" id="mahasiswa_id"
                                class="form-control select2">
                                <option value="" selected="" disabled="">Pilih Nama Alumni</option>
                                @foreach ($alumni as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('user_id', @$ijazah->mahasiswa->user_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->user->name }}
                                    </option>
                                @endforeach
                            </select>

                            @if ($errors->has('mahasiswa_id'))
                                <span class="text-danger">
                                    {{ $errors->first('mahasiswa_id') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                            No Ijazah<sup class="text-danger">*</sup>
                        </label>

                        <div class="col-sm-12 col-md-7">
                            <input type="text" class="form-control @error('no_ijazah')is-invalid @enderror"
                            id="no_ijazah" name="no_ijazah" placeholder="Masukkan Nomor Ijazah" 
                            value="{{ old('no_ijazah', @$ijazah->no_ijazah) }}">
                            @if ($errors->has('no_ijazah'))
                                <span class="text-danger">{{ $errors->first('no_ijazah') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-4">
                        <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                            Tahun Lulus<sup class="text-danger">*</sup>
                        </label>

                        <div class="col-sm-12 col-md-7">
                            <div class="input-group">
                                <div class="input-group-text">
                                    Tahun
                                </div>
                            
                                <input type="number" class="form-control @error('tahun_lulus')is-invalid @enderror"
                                id="tahun_lulus" name="tahun_lulus" placeholder="Masukkan Tahun Lulusan" 
                                value="{{ old('tahun_lulus', @$ijazah->tahun_lulus )}}">
                            </div>

                            @if ($errors->has('tahun_lulus'))
                                <span class="text-danger">{{ $errors->first('tahun_lulus') }}</span>
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