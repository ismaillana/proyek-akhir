@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
          <div class="section-header-back">
            <a href="{{route('riwayat-pengajuan-pengantar-pkl')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
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
                                    <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                @elseif (@$pengantarPkl->status == 'Konfirmasi')
                                    <span class="badge badge-primary">Dikonfirmasi</span>
                                @elseif (@$pengantarPkl->status == 'Proses')
                                    <span class="badge badge-success">Diproses</span>
                                @elseif (@$pengantarPkl->status == 'Tolak')
                                    <span class="badge badge-danger">Ditolak</span>
                                @elseif (@$pengantarPkl->status == 'Kendala')
                                    <span class="badge badge-danger">Ada Kendala</span>
                                @elseif (@$pengantarPkl->status == 'Review')
                                    <span class="badge badge-success">Direview</span>
                                @elseif (@$pengantarPkl->status == 'Setuju')
                                    <span class="badge badge-primary">Disetujui Koor.Pkl</span>
                                @elseif (@$pengantarPkl->status == 'Diterima Perusahaan')
                                    <span class="badge badge-primary">Diterima Perusahaan</span>
                                @elseif (@$pengantarPkl->status == 'Ditolak Perusahaan')
                                    <span class="badge badge-danger">Ditolak Perusahaan</span>
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
                                        Nama: {{@$pengantarPkl->tempatPkl->nama_perusahaan}}<br>
                                        Alamat: {{@$pengantarPkl->tempatPkl->alamat}}<br>
                                        Link website: {{@$pengantarPkl->tempatPkl->web}}<br>
                                        Telepon: {{@$pengantarPkl->tempatPkl->telepon}}<br>
                                        Ditujukan Kepada: {{@$pengantarPkl->kepada}}
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
                                        Tanggal Mulai: {{@$pengantarPkl->tgl_mulai}}<br>
                                        Tanggal Selesai: {{@$pengantarPkl->tgl_selesai}}
                                      </address>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                      <address>
                                        <strong>
                                          Tanggal Pengajuan:
                                        </strong>
                                        <br>
                                        {{@$pengantarPkl->created_at}}<br><br>
                                      </address>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-6">
                                      <address>
                                        <strong>
                                          Bukti Penolakan: 
                                          <a href="{{ asset('storage/public/image/bukti-penolakan/'. @$pengantarPkl->image)}}" download="{{@$pengantarPkl->image}}">
                                            File Pengajuan
                                          </a>
                                        </strong>
                                      </address>
                                    </div>
                                  </div>
                                </div>
                              </div>
              
                              <div class="row mt-4">
                                <div class="col-md-12">
                                  <div class="section-title">Nama Mahasiswa</div>
                                  <p class="section-lead">Mahasiswa Yang Akan Melaksanakan PKL</p>
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