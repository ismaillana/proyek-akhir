@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
          <div class="section-header-back">
            <a href="{{route('pengajuan-pengantar-pkl.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
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
                                Detail Pengajuan Surat Pengantar PKL
                              </h4>

                              <div class="d-flex">
                              <h4>
                                  Status Pengajuan
                              </h4>
                                @if (@$pengantarPkl->status == 'Menunggu Konfirmasi')
                                    <span class="btn btn-warning">Menunggu Konfirmasi</span>
                                @elseif (@$pengantarPkl->status == 'Konfirmasi')
                                    <span class="btn btn-primary">Dikonfirmasi</span>
                                @elseif (@$pengantarPkl->status == 'Proses')
                                    <span class="btn btn-success">Diproses</span>
                                @elseif (@$pengantarPkl->status == 'Tolak')
                                    <span class="btn btn-danger">Ditolak</span>
                                @elseif (@$pengantarPkl->status == 'Kendala')
                                    <span class="btn btn-danger">Ada Kendala</span>
                                @elseif (@$pengantarPkl->status == 'Review')
                                    <span class="btn btn-warning">Direview</span>
                                @elseif (@$pengantarPkl->status == 'Setuju')
                                    <span class="btn btn-primary">Disetujui Koor.Pkl</span>
                                @elseif (@$pengantarPkl->status == 'Diterima Perusahaan')
                                    <span class="btn btn-primary">Diterima Perusahaan</span>
                                @elseif (@$pengantarPkl->status == 'Ditolak Perusahaan')
                                    <span class="btn btn-primary">Ditolak Perusahaan</span>
                                @elseif (@$pengantarPkl->status == 'Selesai PKL')
                                    <span class="btn btn-success">Selesai PKL</span>
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
                                          Nama: {{@$pengantarPkl->mahasiswa->user->name}}<br>
                                          NIM: {{@$pengantarPkl->mahasiswa->nim}}<br>
                                          Jurusan: {{@$pengantarPkl->mahasiswa->programStudi->jurusan->name}}<br>
                                          Prodi: {{@$pengantarPkl->mahasiswa->programStudi->name}}
                                      </address>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                      <address>
                                        <strong>
                                          Tempat PKL:
                                        </strong>
                                        <br>
                                        Nama: {{@$pengantarPkl->tempatPkl->name}}<br>
                                        Alamat: {{@$pengantarPkl->tempatPkl->alamat}}<br>
                                        Link website: <a href="{{@$pengantarPkl->tempatPkl->web}}">{{@$pengantarPkl->tempatPkl->web}}</a><br>
                                        Telepon: {{@$pengantarPkl->tempatPkl->telepon}}<br>
                                        Ditujukan Kepada: {{@$pengantarPkl->tujuan_surat}}
                                      </address>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <address>
                                        <strong>
                                          Tanggal PKL:
                                        </strong>
                                        <br>
                                        Tanggal Mulai: {{ Carbon\Carbon::parse(@$pengantarPkl->tgl_mulai)->translatedFormat('d F Y') }} <br>
                                        Tanggal Selesai: {{ Carbon\Carbon::parse(@$pengantarPkl->tgl_selesai)->translatedFormat('d F Y') }}
                                      </address>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                      <address>
                                        <strong>
                                          Tanggal Pengajuan:
                                        </strong>
                                        <br>
                                        {{ Carbon\Carbon::parse(@$pengantarPkl->created_at)->translatedFormat('d F Y H:i:s') }}<br><br>
                                      </address>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <address>
                                        <strong>
                                          Dokumen Pendukung: 
                                        </strong>
                                        <br>
                                        @if (@$pengantarPkl->link_pendukung !== null)
                                            <a href="{{@$pengantarPkl->link_pendukung}}">
                                              {{@$pengantarPkl->link_pendukung}}
                                            </a>
                                        @else
                                            Tidak Ada Link Dokumen Pendukung
                                        @endif
                                      </address>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                      <address>
                                        <strong>
                                          Dokumen Permohonan Admin Jurusan: 
                                        </strong>
                                        <br>
                                        @if (@$pengantarPkl->dokumen_permohonan !== null)
                                            <a class="btn btn-primary" href="{{ asset('storage/public/dokumen/dokumen-permohonan/'. @$pengantarPkl->dokumen_permohonan)}}" 
                                                    download="{{@$pengantarPkl->dokumen_permohonan}}">
                                                        Download Dokumen
                                            </a>
                                        @else
                                            Belum Ada Dokumen Permohonan Dari Admin Jurusan
                                        @endif
                                      </address>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <address>
                                        <strong>
                                          Bukti Penolakan: 
                                        </strong>
                                        <br>
                                        @if (@$pengantarPkl->image !== null)
                                            <a class="btn btn-primary" href="{{ asset('storage/public/image/bukti-penolakan/'. @$pengantarPkl->image)}}" 
                                                    download="{{@$pengantarPkl->image}}">
                                                        Download Bukti
                                            </a>
                                        @else
                                            Tidak Ada Bukti Penolakan
                                        @endif
                                      </address>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                      <address>
                                        <strong>
                                          Bukti Selesai PKL: 
                                        </strong>
                                        <br>
                                        @if (@$pengantarPkl->bukti_selesai !== null)
                                            <a class="btn btn-primary" href="{{ asset('storage/public/image/bukti-selesai/'. @$pengantarPkl->bukti_selesai)}}" 
                                                    download="{{@$pengantarPkl->bukti_selesai}}">
                                                        Download Bukti
                                            </a>
                                        @else
                                            Belum Ada Bukti Selesai PKL
                                        @endif
                                      </address>
                                    </div>
                                  </div>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection