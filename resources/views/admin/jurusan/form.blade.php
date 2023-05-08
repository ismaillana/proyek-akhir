@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{route('jurusan.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>
            @if (@$jurusan->exists)
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
            Data Jurusan
        </h1>
      </div>

      @if (@$jurusan->exists)
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST"
            action="{{route('jurusan.update', $jurusan) }}">
            @method('put')
      @else
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST" 
            action="{{route('jurusan.store')}}">
      @endif
        {{ csrf_field() }}
        <div class="section-body">
            <h2 class="section-title">Create New Post</h2>
            <p class="section-lead">
            On this page you can create a new post and fill in all fields.
            </p>

            <div class="row">
            <div class="col-12">
                <div class="card">
                <div class="card-header">
                    <h4>Form Jurusan</h4>
                </div>
                <div class="card-body">
                    <div class="form-group row mb-4">
                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                        Nama Jurusan<sup class="text-danger">*</sup>
                    </label>

                    <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control @error('name')is-invalid @enderror"
                        id="name" name="name" placeholder="Masukkan Nama Jurusan" 
                        value="{{ old('name', @$jurusan->name) }}">
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