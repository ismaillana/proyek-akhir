@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <div class="section-header-back">
          <a href="{{route('pengajuan-dispensasi.index')}}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>

        <h1>
            Detail Pengajuan
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
                            <h4>Detail Pengajuan Surat Dispensasi</h4>
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
                                          Jurusan: {{@$dispensasi->mahasiswa->jurusan->name}}<br>
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
                                            {{$item->jurusan->name}}
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
                            <div class="text-md-right">
                                <div class="float-lg-left mb-lg-0 mb-3">
                                    <button class="btn btn-primary btn-icon icon-left"><i class="fas fa-check"></i> Konfirmasi</button>
                                    <button class="btn btn-danger btn-icon icon-left"><i class="fas fa-times"></i> Tolak</button>
                                </div>
                                <button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button>
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