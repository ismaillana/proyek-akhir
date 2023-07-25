@extends('layout.backend.base')
@section('content')
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
            <a href="{{route('pengajuan-pengantar-pkl.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>

        <h1>
            Tabel Data Pengajuan Surat Pengantar Pkl
        </h1>
      </div>

      <div class="section-body">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="d-flex justify-content-between w-100">
                    <h4>
                        Data Pengajuan Surat Pengantar Pkl
                    </h4>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="myTable">
                    <thead>
                      <tr>
                        <th style="width: 10%">
                            #
                        </th>

                        <th class="text-center">
                            Tanggal Pengajuan
                        </th>
                        
                        <th>
                            Pengaju
                        </th>

                        <th>
                            Nama Perusahaan
                        </th>

                        <th class="text-center">
                            Status
                        </th>

                        <th class="text-center">
                            Aksi
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengantarPkl as $item)
                            <tr>
                                <td>
                                    {{$loop->iteration}}
                                </td>

                                <td class="text-center">
                                    {{ Carbon\Carbon::parse(@$item->created_at)->translatedFormat('d F Y H:i:s') }}
                                </td>

                                <td>
                                    {{@$item->mahasiswa->user->name}}
                                </td>

                                <td>
                                    {{@$item->tempatPkl->name}}
                                </td>
                                
                                <td class="text-center">
                                    @if ($item->status == 'Menunggu Konfirmasi')
                                        <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                    @elseif ($item->status == 'Konfirmasi')
                                        <span class="badge badge-primary">Dikonfirmasi</span>
                                    @elseif ($item->status == 'Proses')
                                        <span class="badge badge-success">Diproses</span>
                                    @elseif ($item->status == 'Tolak')
                                        <span class="badge badge-danger">Ditolak</span>
                                    @elseif ($item->status == 'Kendala')
                                        <span class="badge badge-danger">Ada Kendala</span>
                                    @elseif ($item->status == 'Review')
                                        <span class="badge badge-warning">Direview</span>
                                    @elseif ($item->status == 'Setuju')
                                        <span class="badge badge-primary">Disetujui Koor.Pkl</span>
                                    @elseif ($item->status == 'Diterima Perusahaan')
                                        <span class="badge badge-primary">Diterima Perusahaan</span>
                                    @elseif ($item->status == 'Ditolak Perusahaan')
                                        <span class="badge badge-primary">Ditolak Perusahaan</span>
                                    @elseif ($item->status == 'Selesai PKL')
                                        <span class="badge badge-success">Selesai PKL</span>
                                    @else
                                        <span class="badge badge-success">Selesai</span>
                                    @endif
                                </td>
                                
                                <td class="text-center">
                                    <a href="{{ route('pengajuan-pengantar-pkl.show',  Crypt::encryptString($item->id)) }}"
                                        class="btn btn-sm btn-outline-secondary" title="Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                            width="16" height="16" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>

                <hr>
                {{-- @if ($user->hasRole('admin-jurusan')) --}}
                    @php
                        $shownKodePkl = [];
                        $allMenungguKonfirmasi = true;
                        $allReview = true;
                        $allSetuju = true;
                    @endphp

                    @foreach ($pengantarPkl as $item)
                        @if (!in_array($item->kode_pkl, $shownKodePkl))
                            @if ($item->status != 'Menunggu Konfirmasi')
                                @php $allMenungguKonfirmasi = false; @endphp
                            @endif

                            @if ($item->status != 'Review')
                                @php $allReview = false; @endphp
                            @endif

                            @if ($item->status != 'Setuju')
                                @php $allSetuju = false; @endphp
                            @endif

                            @php $shownKodePkl[] = $item->kode_pkl; @endphp
                        @endif
                    @endforeach
                    
                    @role('bagian-akademik')
                        <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST"
                            action="{{ route('update-surat-pengantar-pkl', $item->kode_pkl) }}">
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

                    @if ($allMenungguKonfirmasi && $user->hasRole('admin-jurusan'))
                        <div class="text-md-right">
                            <div class="float-lg-left mb-lg-0 mb-3">
                                <button class="btn btn-primary btn-icon icon-left" data-toggle="modal" data-target="#konfirmasi">
                                    <i class="fas fa-check"></i> 
                                    Konfirmasi
                                </button>

                                <button class="btn btn-warning btn-icon icon-left" data-toggle="modal" data-target="#review">
                                    <i class="fas fa-share"></i> 
                                    Review
                                </button>
    
                                <button class="btn btn-danger btn-icon icon-left" data-toggle="modal" data-target="#tolak">
                                    <i class="fas fa-times"></i> 
                                    Tolak
                                </button>
                            </div>
                        </div>
                    @elseif ($allSetuju && $user->hasRole('admin-jurusan'))
                    <div class="text-md-right">
                        <div class="float-lg-left mb-lg-0 mb-3">
                            <button class="btn btn-primary btn-icon icon-left" data-toggle="modal" data-target="#konfirmasi">
                                <i class="fas fa-check"></i> 
                                Konfirmasi
                            </button>
                        </div>
                    </div>
                    @elseif ($allReview && $user->hasRole('koor-pkl'))
                    <div class="text-md-right">
                        <div class="float-lg-left mb-lg-0 mb-3">
                            <button class="btn btn-primary btn-icon icon-left" data-toggle="modal" data-target="#setuju">
                                <i class="fas fa-check"></i> 
                                Setujui
                            </button>

                            <button class="btn btn-danger btn-icon icon-left" data-toggle="modal" data-target="#tolak">
                                <i class="fas fa-times"></i> 
                                Tolak
                            </button>
                        </div>
                    </div>
                    @elseif($user->hasRole('bagian-akademik'))
                        <div class="text-md-right">
                            <a href="{{ route('print-pengantar-pkl', $item->kode_pkl) }}" class="btn btn-warning btn-icon icon-left">
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
  
  @foreach ($pengantarPkl as $item)
    <div class="modal fade" tabindex="-1" role="dialog" id="konfirmasi">
        <div class="modal-dialog" role="document">
            <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{ route('konfirmasi-pengantar-pkl', $item->kode_pkl)}}" method="POST">
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
                    <div class="form-group row mb-4">
                        <label for="image" class="col-form-label text-md-left col-12">
                            Dokumen Permohonan
                        </label>
    
                        <div class="col-sm-12 col-md-12">
                            <div class="input-group">
                                <input class="dropify @error('dokumen_permohonan') is-invalid @enderror" type="file" 
                                    name="dokumen_permohonan" data-height='250' data-allowed-file-extensions="pdf doc docx" data-max-file-size="5M">
                            </div>
    
                            @if ($errors->has('dokumen_permohonan'))
                                <span class="text-danger">
                                    {{ $errors->first('dokumen_permohonan') }}
                                </span>
                            @endif
                        </div>
                    </div>
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

  @foreach ($pengantarPkl as $item)
    <div class="modal fade" tabindex="-1" role="dialog" id="tolak">
        <div class="modal-dialog" role="document">
            <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{ route('tolak-pengantar-pkl', $item->kode_pkl)}}" method="POST">
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
                        <div class="form-group row mb-4" id="catatan">
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
  
  @foreach ($pengantarPkl as $item)
    <div class="modal fade" tabindex="-1" role="dialog" id="review">
        <div class="modal-dialog" role="document">
            <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{ route('review-pengantar-pkl', $item->kode_pkl)}}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            Ajukan Review Pengajuan
                        </h5>
    
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
    
                    <div class="modal-body">
                        <p>
                            Ajukan Review Pengajuan ?
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
  
  @foreach ($pengantarPkl as $item)
    <div class="modal fade" tabindex="-1" role="dialog" id="setuju">
        <div class="modal-dialog" role="document">
            <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{ route('setuju-pengantar-pkl', $item->kode_pkl)}}" method="POST">
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