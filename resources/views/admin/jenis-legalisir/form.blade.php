@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{route('jenis-legalisir.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>
            @if (@$legalisir->exists)
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
            Data Jenis Legalisir
        </h1>
      </div>

      @if (@$legalisir->exists)
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST"
            action="{{route('jenis-legalisir.update', $legalisir) }}">
            @method('put')
      @else
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST" 
            action="{{route('jenis-legalisir.store')}}">
      @endif
            {{ csrf_field() }}
            <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Jenis Legalisir</h4>
                        </div>
                        
                        <div class="card-body">
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                                    Nama Dokumen<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('name')is-invalid @enderror"
                                        id="name" name="name" placeholder="Masukkan Nama Jurusan" 
                                        value="{{ old('name', @$legalisir->name) }}">
                                        
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
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