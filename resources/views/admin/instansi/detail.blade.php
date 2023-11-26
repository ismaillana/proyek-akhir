@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{route('instansi.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>
            Detail Data Instansi
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
                            <h4>Form Instansi</h4>
                        </div>
                        
                        <div class="card-body">
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Nama Instansi<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('name')is-invalid @enderror"
                                        id="name" name="name" placeholder="Masukkan Nama instansi" 
                                        value="{{ old('name', @$instansi->user->name) }}" disabled readonly>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Email<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="email" class="form-control @error('email')is-invalid @enderror"
                                        id="email" name="email" placeholder="Masukkan Email" 
                                        value="{{ old('email', @$instansi->user->email) }}" readonly disabled>
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
                                            value="{{ old('wa', Str::substr(@$instansi->user->wa, 2)) }}" disabled readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                    Alamat<sup class="text-danger">*</sup>
                                </label>

                                <div class="col-sm-12 col-md-7">
                                    <input type="text" class="form-control @error('alamat')is-invalid @enderror"
                                        id="alamat" name="alamat" placeholder="Masukkan Alamat" 
                                        value="{{ old('alamat', @$instansi->alamat) }}" disabled readonly>
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