@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
          <div class="section-header-back">
            <a href="{{route('riwayat-pengajuan-dispensasi')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
          </div>

          <h1>
              Detail Riwayat Pengajuan
          </h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                              <h4>
                                Detail Riwayat Pengajuan Surat Dispensasi
                              </h4>

                              <div class="d-flex">
                              <h4>
                                  Status Pengajuan
                              </h4>
                                  @if (@$dispensasi->status == 'Menunggu Konfirmasi')
                                      <span class="btn btn-warning">Menunggu Konfirmasi</span>
                                  @elseif (@$dispensasi->status == 'Konfirmasi')
                                      <span class="btn btn-primary">Dikonfirmasi</span>
                                  @elseif (@$dispensasi->status == 'Proses')
                                      <span class="btn btn-success">Diproses</span>
                                  @elseif (@$dispensasi->status == 'Tolak')
                                      <span class="btn btn-danger">Ditolak</span>
                                  @elseif (@$dispensasi->status == 'Kendala')
                                      <span class="btn btn-danger">Ada Kendala</span>
                                  @else
                                      <span class="btn btn-success">Selesai</span>
                                  @endif
                              </div>
                              
                          </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12">
                                  <div class="row">
                                    <div class="col-md-6">
                                      <address>
                                        <strong>
                                          Data Pengaju:
                                        </strong>
                                        <br>
                                          Nama: {{@$dispensasi->mahasiswa->user->name}}<br>
                                          NIM: {{@$dispensasi->mahasiswa->nim}}<br>
                                          Jurusan: {{@$dispensasi->mahasiswa->programStudi->jurusan->name}}<br>
                                          Prodi: {{@$dispensasi->mahasiswa->programStudi->name}}
                                      </address>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                      <address>
                                        <strong>
                                            Detail Kegiatan:
                                        </strong>
                                        <br>
                                        Nama Kegiatan: {{@$dispensasi->kegiatan}}<br>
                                        Tempat: {{@$dispensasi->nama_tempat}}<br>
                                      </address>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <address>
                                        <strong>
                                          Tanggal Dispensasi:
                                        </strong>
                                        <br>
                                        Tanggal Mulai: {{ Carbon\Carbon::parse(@$dispensasi->tgl_mulai)->translatedFormat('d F Y') }}<br>
                                        Tanggal Selesai: {{ Carbon\Carbon::parse(@$dispensasi->tgl_selesai)->translatedFormat('d F Y') }}
                                      </address>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                      <address>
                                        <strong>
                                          Tanggal Pengajuan:
                                        </strong>
                                        <br>
                                        {{ Carbon\Carbon::parse(@$dispensasi->created_at)->translatedFormat('d F Y H:i:s') }}<br><br>
                                      </address>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <address>
                                        <strong>
                                          Dokumen Pendukung Pengajuan: 
                                        </strong>
                                        <br>
                                            <a class="btn btn-primary" href="{{ asset('storage/public/dokumen/'. @$dispensasi->dokumen)}}" 
                                                    download="{{@$dispensasi->dokumen}}">
                                                        Download Dokumen
                                            </a>
                                      </address>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                      <address>
                                        <strong>
                                          Dokumen Permohonan: 
                                        </strong>
                                        <br>
                                        @if (@$dispensasi->dokumen_permohonan !== null)
                                            <a class="btn btn-primary" href="{{ asset('storage/public/dokumen/dokumen-permohonan/'. @$dispensasi->dokumen_permohonan)}}" 
                                                    download="{{@$dispensasi->dokumen_permohonan}}">
                                                        Download Dokumen
                                            </a>
                                        @else
                                            Belum Ada Dokumen Permohonan Dari Admin Jurusan
                                        @endif
                                      </address>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <hr>
                              <div class="row mt-4">
                                <div class="col-md-12">
                                  <div class="section-title">Nama Mahasiswa</div>
                                  <p class="section-lead">Mahasiswa Yang Akan Izin Dispensasi</p>
                                  <div class="table-responsive">
                                    <table class="table table-striped table-hover table-md">
                                      <tr>
                                        <th style="width: 10%">
                                          #
                                        </th>

                                        <th >
                                          Nama Mahasiswa
                                        </th>

                                        <th>
                                          NIM
                                        </th>

                                        <th>
                                          Jurusan
                                        </th>

                                        <th>
                                          Program Studi
                                        </th>
                                      </tr>
                                      @foreach ($data as $item)
                                        <tr>
                                          <td>
                                            {{$loop->iteration}}
                                          </td>

                                          <td>
                                            {{$item->user->name}}
                                          </td>

                                          <td>
                                            {{$item->nim}}
                                          </td>

                                          <td>
                                            {{$item->programStudi->jurusan->name}}
                                          </td>

                                          <td>
                                            {{$item->programStudi->name}}
                                          </td>
                                        </tr>
                                      @endforeach
                                    </table>
                                  </div>
                                </div>
                              </div>
                              <hr>
                              @role('bagian-akademik')
                                    <div class="form-group row">
                                        <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                            Nomor Surat<sup class="text-danger">*</sup>
                                        </label>
        
                                        <div class="col-sm-12 col-md-9">
                                            <input type="text" class="form-control @error('no_surat')is-invalid @enderror"
                                                id="no_surat" name="no_surat" placeholder="Masukkan Nomor Surat" 
                                                value="{{ old('no_surat', @$dispensasi->no_surat) }}" readonly disabled>
                                        </div>
                                    </div>
                              @endrole
                              <hr>
                                  <div class="text-md-right">
                                    <a href="{{ route('print-dispensasi', Crypt::encryptString($dispensasi->id)) }}" class="btn btn-warning btn-icon icon-left">
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