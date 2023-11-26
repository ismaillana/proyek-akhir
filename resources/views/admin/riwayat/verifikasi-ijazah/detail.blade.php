@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
            <a href="{{route('riwayat-pengajuan-verifikasi-ijazah')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
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
                                @php
                                    $statusDisplayed = false;
                                @endphp

                                @foreach ($verifikasiIjazah as $item)
                                    @if (!$statusDisplayed)
                                        @if ($item->status == 'Menunggu Konfirmasi')
                                            <span class="btn btn-warning">Menunggu Konfirmasi</span>
                                        @elseif ($item->status == 'Konfirmasi')
                                            <span class="btn btn-primary">Dikonfirmasi</span>
                                        @elseif ($item->status == 'Proses')
                                            <span class="btn btn-success">Diproses</span>
                                        @elseif ($item->status == 'Tolak')
                                            <span class="btn btn-danger">Ditolak</span>
                                        @elseif ($item->status == 'Kendala')
                                            <span class="btn btn-danger">Ada Kendala</span>
                                        @else
                                            <span class="btn btn-success">Selesai</span>
                                        @endif
                                        @php
                                            $statusDisplayed = true;
                                        @endphp
                                    @endif
                                @endforeach

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
                            @endrole
                            <hr>
                            @php
                                $shownKodeVerifikasi = [];
                                $allMenungguKonfirmasi = true;
                                $allReview = true;
                                $allSetuju = true;
                            @endphp
                            <div class="text-md-right">
                                <a href="{{ route('print-verifikasi-ijazah', $item->kode_verifikasi) }}" target="_blank" class="btn btn-warning btn-icon icon-left">
                                    <i class="fas fa-print"></i> 
                                        Print
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
