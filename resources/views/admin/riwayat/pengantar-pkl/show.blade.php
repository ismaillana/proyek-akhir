@extends('layout.backend.base')
@section('content')
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
            <a href="{{route('riwayat-pengajuan-pengantar-pkl')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>

        <h1>
            Tabel Data Riwayat Pengajuan Surat Pengantar Pkl
        </h1>
      </div>

      <div class="section-body">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="d-flex justify-content-between w-100">
                    <h4>
                        Data Riwayat Pengajuan Surat Pengantar Pkl
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
                                    <a href="{{ route('riwayat-pengajuan-pengantar-pkl-detail',  Crypt::encryptString($item->id)) }}"
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
                                        id="no_surat" name="no_surat" placeholder="Masukkan Nomor Surat" 
                                        value="{{ old('no_surat', @$item->no_surat) }}" disabled readonly>

                                    @if ($errors->has('no_surat'))
                                        <span class="text-danger">{{ $errors->first('no_surat') }}</span>
                                    @endif
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
                        <hr>
                        <div class="text-md-right">
                            <a href="{{ route('print-pengantar-pkl', $item->kode_pkl) }}" class="btn btn-warning btn-icon icon-left">
                                <i class="fas fa-print"></i> 
                                Print
                            </a>
                        </div>
                    @endrole
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection