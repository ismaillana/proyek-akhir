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
            Data Mahasiswa Alumni
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
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Mahasiswa Alumni</h4>
                            </div>
                            
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">
                                        Nama Mahasiswa/Alumni<sup class="text-danger">*</sup>
                                    </label>

                                    <div class="col-sm-12">
                                        <input type="text" class="form-control @error('name')is-invalid @enderror"
                                            id="name" name="name" placeholder="Masukkan Nama Mahasiswa" 
                                            value="{{ old('name', @$mahasiswa->user->name) }}">

                                        @if ($errors->has('name'))
                                            <span class="text-danger">{{ $errors->first('name') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">
                                        NIM<sup class="text-danger">*</sup>
                                    </label>

                                    <div class="col-sm-12">
                                        <input type="number" class="form-control @error('nomor_induk')is-invalid @enderror"
                                            id="nomor_induk" name="nomor_induk" placeholder="Masukkan NIM" 
                                            value="{{ old('nomor_induk', @$mahasiswa->user->nomor_induk) }}">

                                        @if ($errors->has('nomor_induk'))
                                            <span class="text-danger">{{ $errors->first('nomor_induk') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">
                                        Tempat Lahir<sup class="text-danger">*</sup>
                                    </label>

                                    <div class="col-sm-12">
                                        <input type="text" class="form-control @error('tempat_lahir')is-invalid @enderror"
                                            id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan Tempat Lahir" 
                                            value="{{ old('tempat_lahir', @$mahasiswa->tempat_lahir) }}">

                                        @if ($errors->has('tempat_lahir'))
                                            <span class="text-danger">{{ $errors->first('tempat_lahir') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">
                                        Tanggal Lahir<sup class="text-danger">*</sup>
                                    </label>

                                    <div class="col-sm-12">
                                        <input type="date" class="form-control @error('tanggal_lahir')is-invalid @enderror"
                                            id="tanggal_lahir" name="tanggal_lahir" placeholder="Masukkan Tempat Lahir" 
                                            value="{{ old('tanggal_lahir', @$mahasiswa->tanggal_lahir) }}">

                                        @if ($errors->has('tanggal_lahir'))
                                            <span class="text-danger">{{ $errors->first('tanggal_lahir') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">
                                        Email<sup class="text-danger">*</sup>
                                    </label>

                                    <div class="col-sm-12">
                                        <input type="email" class="form-control @error('email')is-invalid @enderror"
                                            id="email" name="email" placeholder="Masukkan Email" 
                                            value="{{ old('email', @$mahasiswa->user->email) }}">

                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">
                                    No WhatsApp<sup class="text-danger">*</sup>
                                    </label>
                                        
                                    
                                    <div class="col-sm-12">
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

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">
                                        Angkatan<sup class="text-danger">*</sup>
                                    </label>

                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                Tahun
                                            </div>
                                        
                                            <input type="number" class="form-control @error('angkatan')is-invalid @enderror"
                                                id="angkatan" name="angkatan" placeholder="Masukkan Angkatan" 
                                                value="{{ old('angkatan', @$mahasiswa->angkatan )}}">
                                        </div>

                                        @if ($errors->has('angkatan'))
                                            <span class="text-danger">{{ $errors->first('angkatan') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">
                                        Program Studi<sup class="text-danger">*</sup>
                                    </label>

                                    <div class="col-sm-12">
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

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">
                                        Semester<sup class="text-danger">*</sup>
                                    </label>

                                    <div class="col-sm-12">
                                        <select class="form-control @error('semester')is-invalid @enderror" id="semester" name="semester" >
                                            <option selected disabled value="">Pilih Semester</option>
                                            <option value="1"
                                              {{ old('semester', @$mahasiswa->semester) == '1' ? 'selected' : '' }}>
                                                1</option>
                                            <option value="2"
                                              {{ old('semester', @$mahasiswa->semester) == '2' ? 'selected' : '' }}>
                                                2</option>
                                            <option value="3"
                                              {{ old('semester', @$mahasiswa->semester) == '3' ? 'selected' : '' }}>
                                                3</option>
                                            <option value="4"
                                              {{ old('semester', @$mahasiswa->semester) == '4' ? 'selected' : '' }}>
                                                4</option>
                                            <option value="5"
                                              {{ old('semester', @$mahasiswa->semester) == '5' ? 'selected' : '' }}>
                                                5</option>
                                            <option value="6"
                                              {{ old('semester', @$mahasiswa->semester) == '6' ? 'selected' : '' }}>
                                                6</option>
                                        </select>

                                        @if ($errors->has('semester'))
                                            <span class="text-danger">{{ $errors->first('semester') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">
                                        Tahun Ajaran<sup class="text-danger">*</sup>
                                    </label>

                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <div class="input-group-text">
                                                Tahun
                                            </div>
                                        
                                            <input type="number" class="form-control @error('tahun_ajaran')is-invalid @enderror"
                                                id="tahun_ajaran" name="tahun_ajaran" placeholder="Masukkan Tahun Ajaran" 
                                                value="{{ old('tahun_ajaran', @$mahasiswa->tahun_ajaran )}}">
                                        </div>

                                        @if ($errors->has('tahun_ajaran'))
                                            <span class="text-danger">{{ $errors->first('tahun_ajaran') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Mahasiswa Alumni</h4>
                            </div>
                            
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">
                                        Nama Orang Tua<sup class="text-danger">*</sup>
                                    </label>

                                    <div class="col-sm-12">
                                        <input type="text" class="form-control @error('orang_tua')is-invalid @enderror"
                                            id="orang_tua" name="orang_tua" placeholder="Masukkan Nama Orang Tua" 
                                            value="{{ old('orang_tua', @$mahasiswa->orang_tua) }}">

                                        @if ($errors->has('orang_tua'))
                                            <span class="text-danger">{{ $errors->first('orang_tua') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">
                                        Pekerjaan Orang Tua<sup class="text-danger">*</sup>
                                    </label>

                                    <div class="col-sm-12">
                                        <input type="text" class="form-control @error('pekerjaan')is-invalid @enderror"
                                            id="pekerjaan" name="pekerjaan" placeholder="Masukkan Pekerjaan Orang Tua" 
                                            value="{{ old('pekerjaan', @$mahasiswa->pekerjaan) }}">

                                        @if ($errors->has('pekerjaan'))
                                            <span class="text-danger">{{ $errors->first('pekerjaan') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">
                                        NIP/NRP Orang Tua<sup class="text-danger">*</sup>
                                    </label>

                                    <div class="col-sm-12">
                                        <input type="text" class="form-control @error('nip_nrp')is-invalid @enderror"
                                            id="nip_nrp" name="nip_nrp" placeholder="Masukkan NIP/NRP Orang Tua" 
                                            value="{{ old('nip_nrp', @$mahasiswa->nip_nrp) }}">

                                        @if ($errors->has('nip_nrp'))
                                            <span class="text-danger">{{ $errors->first('nip_nrp') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">
                                        Pangkat/Golongan Orang Tua<sup class="text-danger">*</sup>
                                    </label>

                                    <div class="col-sm-12">
                                        <input type="text" class="form-control @error('pangkat')is-invalid @enderror"
                                            id="pangkat" name="pangkat" placeholder="Masukkan Pangkat Orang Tua" 
                                            value="{{ old('pangkat', @$mahasiswa->pangkat) }}">

                                        @if ($errors->has('pangkat'))
                                            <span class="text-danger">{{ $errors->first('pangkat') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">
                                        Jabatan Orang Tua<sup class="text-danger">*</sup>
                                    </label>

                                    <div class="col-sm-12">
                                        <input type="text" class="form-control @error('jabatan')is-invalid @enderror"
                                            id="jabatan" name="jabatan" placeholder="Masukkan Jabatan Orang Tua" 
                                            value="{{ old('jabatan', @$mahasiswa->jabatan) }}">

                                        @if ($errors->has('jabatan'))
                                            <span class="text-danger">{{ $errors->first('jabatan') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">
                                        Golongan<sup class="text-danger">*</sup>
                                    </label>

                                    <div class="col-sm-12">
                                        <input type="text" class="form-control @error('golongan')is-invalid @enderror"
                                            id="golongan" name="golongan" placeholder="Masukkan Golongan Orang Tua" 
                                            value="{{ old('golongan', @$mahasiswa->golongan) }}">

                                        @if ($errors->has('golongan'))
                                            <span class="text-danger">{{ $errors->first('golongan') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">
                                        Instansi Orang Tua<sup class="text-danger">*</sup>
                                    </label>

                                    <div class="col-sm-12">
                                        <input type="text" class="form-control @error('instansi')is-invalid @enderror"
                                            id="instansi" name="instansi" placeholder="Masukkan Instansi Orang Tua" 
                                            value="{{ old('instansi', @$mahasiswa->instansi) }}">

                                        @if ($errors->has('instansi'))
                                            <span class="text-danger">{{ $errors->first('instansi') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="image" class="col-sm-12 col-form-label">
                                        Foto Pribadi
                                    </label>
                                    <div class="col-sm-12">
                                        <input class="dropify @error('image') is-invalid @enderror" 
                                            data-height='250' type="file" name="image" id="image" 
                                            data-default-file="{{ @$mahasiswa->image_url }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label">
                                        Status<sup class="text-danger">*</sup>
                                    </label>

                                    <div class="col-sm-12">
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

                                <div class="form-group row">
                                    <div class="col-sm-12 ">
                                        <button type="submit" class="btn btn-primary" id="btnSubmit">
                                            {{ $aksi }}
                                            <span class="spinner-border ml-2 d-none" id="loader"
                                                style="width: 1rem; height: 1rem;" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </span>
                                        </button>
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

@section('script')
<script>
        $('#myForm').submit(function(e) {
            let form = this;
            e.preventDefault();

            confirmSubmit(form);
        });
        // Form
        function confirmSubmit(form, buttonId) {
            Swal.fire({
                icon: 'question',
                text: 'Apakah anda yakin ingin menyimpan data ini ?',
                showCancelButton: true,
                buttonsStyling: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    let button = 'btnSubmit';

                    if (buttonId) {
                        button = buttonId;
                    }

                    $('#' + button).attr('disabled', 'disabled');
                    $('#loader').removeClass('d-none');

                    form.submit();
                }
            });
        }

</script>
@endsection