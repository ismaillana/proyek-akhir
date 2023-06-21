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
                                      <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                  @elseif (@$dispensasi->status == 'Konfirmasi')
                                      <span class="badge badge-primary">Dikonfirmasi</span>
                                  @elseif (@$dispensasi->status == 'Proses')
                                      <span class="badge badge-success">Diproses</span>
                                  @elseif (@$dispensasi->status == 'Tolak')
                                      <span class="badge badge-danger">Ditolak</span>
                                  @elseif (@$dispensasi->status == 'Kendala')
                                      <span class="badge badge-danger">Ada Kendala</span>
                                  @else
                                      <span class="badge badge-success">Selesai</span>
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
                                        Tempat: {{@$dispensasi->tempat}}<br>
                                      </address>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <address>
                                        <strong>
                                          Data PKL:
                                        </strong>
                                        <br>
                                        Tanggal Mulai: {{@$dispensasi->mulai}}<br>
                                        Tanggal Selesai: {{@$dispensasi->selesai}}
                                      </address>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                      <address>
                                        <strong>
                                          Tanggal Pengajuan:
                                        </strong>
                                        <br>
                                        {{@$dispensasi->created_at}}<br><br>
                                      </address>
                                    </div>
                                  </div>
                                </div>
                              </div>
              
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
                            {{-- <hr>
                              <div class="text-md-right">
                                  <button class="btn btn-warning btn-icon icon-left">
                                      <i class="fas fa-print"></i> 
                                      Print
                                  </button>
                              </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection