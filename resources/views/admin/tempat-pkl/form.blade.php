@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{route('tempat-pkl.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>
            @if (@$tempatPKL->exists)
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
            Data Tempat PKL
        </h1>
      </div>

      @if (@$tempatPKL->exists)
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST"
            action="{{route('tempat-pkl.update', $tempatPKL) }}">
            @method('put')
      @else
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST" 
            action="{{route('tempat-pkl.store')}}">
      @endif
            {{ csrf_field() }}
            <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Form Tampat PKL</h4>
                        </div>

                        <div class="card-body">
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                                    Nama Tempat PKL<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('name')is-invalid @enderror"
                                        id="name" name="name" placeholder="Masukkan Nama Tempat PKL" 
                                        value="{{ old('name', @$tempatPKL->name) }}">

                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                                    Alamat<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('alamat')is-invalid @enderror"
                                        id="alamat" name="alamat" placeholder="Masukkan Alamat" 
                                        value="{{ old('alamat', @$tempatPKL->alamat) }}">

                                    @if ($errors->has('alamat'))
                                        <span class="text-danger">{{ $errors->first('alamat') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                                    No Telepon<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('telepon')is-invalid @enderror"
                                        id="telepon" name="telepon" placeholder="Masukkan No Telepon" 
                                        value="{{ old('telepon', @$tempatPKL->telepon) }}">

                                    @if ($errors->has('telepon'))
                                        <span class="text-danger">{{ $errors->first('telepon') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                                    Link Website
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('web')is-invalid @enderror"
                                        id="web" name="web" placeholder="Masukkan Link Website" 
                                        value="{{ old('web', @$tempatPKL->web) }}">
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