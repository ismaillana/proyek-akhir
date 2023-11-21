@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
            <a href="{{route('pengajuan-verifikasi-ijazah.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>

            <h1>
                Detail Pengajuan
            </h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <h4>
                                    Detail Pengajuan Verifikasi Ijazah
                                </h4>

                                <div class="d-flex">
                                <h4>
                                    Status Pengajuan
                                </h4>
                                    {{-- @if (@$verifikasiIjazah->status == 'Menunggu Konfirmasi')
                                        <span class="btn btn-warning">Menunggu Konfirmasi</span>
                                    @elseif (@$verifikasiIjazah->status == 'Konfirmasi')
                                        <span class="btn btn-primary">Dikonfirmasi</span>
                                    @elseif (@$verifikasiIjazah->status == 'Proses')
                                        <span class="btn btn-success">Diproses</span>
                                    @elseif (@$verifikasiIjazah->status == 'Tolak')
                                        <span class="btn btn-danger">Ditolak</span>
                                    @elseif (@$verifikasiIjazah->status == 'Kendala')
                                        <span class="btn btn-danger">Ada Kendala</span>
                                    @else
                                        <span class="btn btn-success">Selesai</span>
                                    @endif --}}
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <table class="table table-striped" id="myTable">
                                <thead>
                                  <tr>
                                    <th style="width: 10%">
                                        #
                                    </th>
            
                                    <th class="text-center">
                                        Nama Mahasiswa
                                    </th>
            
                                    <th>
                                        NIM
                                    </th>
            
                                    <th>
                                        Nomor Ijazah
                                    </th>
            
                                    <th class="text-center">
                                        Tahun Lulus
                                    </th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($verifikasiIjazah as $item)
                                        <tr>
                                            <td>
                                                {{$loop->iteration}}
                                            </td>
            
                                            <td>
                                                {{ $item->nama }}
                                            </td>
            
                                            <td>
                                                {{$item->nim}}
                                            </td>
            
                                            <td>
                                                {{$item->no_ijazah}}
                                            </td>
                                            
                                            <td class="text-center">
                                                {{$item->tahun_lulus}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr>
                            @role('bagian-akademik')
                            <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST"
                                action="{{ route('update-surat-verifikasi-ijazah', $item->kode_verifikasi) }}">
                                    @csrf

                                <div class="form-group row">
                                    <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                        Nomor Surat<sup class="text-danger">*</sup>
                                    </label>
    
                                    <div class="col-sm-12 col-md-9">
                                        <input type="text" class="form-control @error('no_surat')is-invalid @enderror"
                                            id="no_surat" name="no_surat" pattern="\d{4}/PL41\.R1/.+/\d{4}" placeholder="Masukkan Nomor Surat" 
                                            value="{{ old('no_surat', @$item->no_surat) }}">

                                            <span class="invalid-feedback" role="alert" id="no-surat-error">
                                                @error('no_surat')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12 col-md-9 offset-md-3">
                                        <button type="submit" class="btn btn-primary" id="btnSubmit">
                                            @if (@$item->no_surat == null)
                                                Tambah
                                            @else
                                                Update
                                            @endif
                                            <span class="spinner-border ml-2 d-none" id="loader"
                                                style="width: 1rem; height: 1rem;" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                            @endrole
                            <hr>
                            @php
                                $shownKodeVerifikasi = [];
                                $allMenungguKonfirmasi = true;
                                $allReview = true;
                                $allSetuju = true;
                            @endphp

                            @foreach ($verifikasiIjazah as $item)
                                @if (!in_array($item->kode_verifikasi, $shownKodeVerifikasi))
                                    @if ($item->status != 'Menunggu Konfirmasi')
                                        @php $allMenungguKonfirmasi = false; @endphp
                                    @endif

                                    @if ($item->status != 'Review')
                                        @php $allReview = false; @endphp
                                    @endif

                                    @if ($item->status != 'Setuju')
                                        @php $allSetuju = false; @endphp
                                    @endif

                                    @php $shownKodeVerifikasi[] = $item->kode_pkl; @endphp
                                @endif
                            @endforeach
                            
                            @if ($allMenungguKonfirmasi)
                                <div class="text-md-right">
                                    <div class="float-lg-left mb-lg-0 mb-3">
                                        <button class="btn btn-primary btn-icon icon-left" data-toggle="modal" data-target="#konfirmasi">
                                            <i class="fas fa-check"></i> 
                                            Konfirmasi
                                        </button>

                                        <button class="btn btn-danger btn-icon icon-left" data-toggle="modal" data-target="#tolak">
                                            <i class="fas fa-times"></i> 
                                            Tolak
                                        </button>
                                    </div>
                                </div>
                            @else
                                <div class="text-md-right">
                                    <a href="{{ route('print-verifikasi-ijazah', $item->kode_verifikasi) }}" target="_blank" class="btn btn-warning btn-icon icon-left">
                                        <i class="fas fa-print"></i> 
                                            Print
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@foreach ($verifikasiIjazah as $item)
    <div class="modal fade" tabindex="-1" role="dialog" id="konfirmasi">
        <div class="modal-dialog" role="document">
            <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{ route('konfirmasi-verifikasi-ijazah', $item->kode_verifikasi)}}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Konfirmasi Pengajuan
                        </h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p>
                            Setujui Pengajuan ?
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach

@foreach ($verifikasiIjazah as $item)
    <div class="modal fade" tabindex="-1" role="dialog" id="tolak">
        <div class="modal-dialog" role="document">
            <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{ route('tolak-verifikasi-ijazah', $item->kode_verifikasi)}}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Modal Catatan Penolakan
                        </h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group row" id="catatan">
                            <label for="name" class="col-sm-3 col-form-label">
                                Catatan Penolakan <sup class="text-danger">*</sup>
                            </label>

                            <div class="col-sm-9">
                                <textarea name="catatan" class="summernote-simple" id="catatan" cols="30" rows="10"
                                    placeholder="Masukan Catatan">{{ old('catatan', @$item->catatan) }}</textarea>
                                
                                @if ($errors->has('catatan'))
                                    <span class="text-danger">
                                        {{ $errors->first('catatan') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach

@endsection

@section('script')
<script>
    document.getElementById('no_surat').addEventListener('focus', function() {
        const inputElement = this;
        const pattern = /^\d{4}\/PL41\.R1\/.+\/\d{4}$/; 
        const errorMessage = 'Nomor surat harus sesuai format: 1300/PL41.R1/AL.02/2022';

        const isValidFormat = pattern.test(inputElement.value);

        const errorElement = document.getElementById('no-surat-error');
        if (!isValidFormat) {
            errorElement.textContent = errorMessage;
            inputElement.classList.add('is-invalid');
        } else {
            errorElement.textContent = '';
            inputElement.classList.remove('is-invalid');
        }
    });

    // Fungsi untuk mengisi tahun sekarang secara otomatis saat input difokuskan
    document.getElementById('no_surat').addEventListener('focus', function() {
        const inputElement = this;
        const currentYear = new Date().getFullYear();
        const regex = /\d{4}$/;
        if (!regex.test(inputElement.value)) {
            inputElement.value = inputElement.value + '/' + currentYear;
        }
    });
</script>
@endsection
