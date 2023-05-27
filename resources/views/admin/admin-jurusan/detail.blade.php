@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{route('adminJurusan.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>
            Detail Data Admin Jurusan
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
                                <h4>Form Detail Admin Jurusan</h4>
                            </div>

                            <div class="card-body">
                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                        Nama Admin Jurusan<sup class="text-danger">*</sup>
                                    </label>

                                    <div class="col-sm-12 col-md-7">
                                        <input type="text" class="form-control @error('name')is-invalid @enderror"
                                            id="name" name="name" placeholder="Masukkan Nama Admin Jurusan" 
                                            value="{{ old('name', @$adminJurusan->user->name) }}" disabled readonly>
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                        NIP<sup class="text-danger">*</sup>
                                    </label>

                                    <div class="col-sm-12 col-md-7">
                                        <input type="number" class="form-control @error('nomor_induk')is-invalid @enderror"
                                            id="nomor_induk" name="nomor_induk" placeholder="Masukkan NIP" 
                                            value="{{ old('nomor_induk', @$adminJurusan->user->nomor_induk) }}" disabled readonly>
                                    </div>
                                </div>

                                <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                        Email<sup class="text-danger">*</sup>
                                    </label>

                                    <div class="col-sm-12 col-md-7">
                                        <input type="email" class="form-control @error('email')is-invalid @enderror"
                                            id="email" name="email" placeholder="Masukkan Email" 
                                            value="{{ old('email', @$adminJurusan->user->email) }}" disabled readonly>
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
                                                value="{{ old('wa', Str::substr(@$adminJurusan->user->wa, 2)) }}" disabled readonly>
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
                                            is-invalid @enderror" disabled>
                                            <option disabled>Pilih Jurusan</option>
                                            @foreach ($jurusan as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('jurusan_id', @$adminJurusan->jurusan_id) == $item->id ? 'selected' : '' }}>
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
                                            data-default-file="{{ @$adminJurusan->image_url }}" disabled>
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