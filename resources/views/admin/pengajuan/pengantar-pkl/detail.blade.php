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

      <form id="myForm" class="forms-sample" enctype="multipart/form-data">
        @method('put')
        {{ csrf_field() }}
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Detail Pengajuan Surat Pengantar PKL</h4>
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
                                          Jurusan: {{@$pengantarPkl->mahasiswa->jurusan->name}}<br>
                                          Prodi: {{@$pengantarPkl->mahasiswa->programStudi->name}}
                                      </address>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                      <address>
                                        <strong>
                                          Tempat PKL:
                                        </strong>
                                        <br>
                                        Nama: {{@$pengantarPkl->nama_perusahaan}}<br>
                                        Alamat: {{@$pengantarPkl->alamat}}<br>
                                        Link website: {{@$pengantarPkl->web}}<br>
                                        Telepon: {{@$pengantarPkl->telepon}}<br>
                                        Ditujukan Kepada: {{@$pengantarPkl->kepada}}
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
                                        Tanggal Mulai: {{@$pengantarPkl->mulai}}<br>
                                        Tanggal Selesai: {{@$pengantarPkl->selesai}}
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

                              <div class="row mt-4">
                                <div class="col-md-12">
                                  <div class="section-title">Konfirmasi Pengajuan</div>
                                  <p class="section-lead">Mahasiswa Yang Akan Melaksanakan PKL</p>
                                  @if (@$pengantarPkl->status == 'Menunggu Konfirmasi')
                                      
                                  <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category</label>
                                    <div class="col-sm-12 col-md-7">
                                      <select class="form-control selectric">
                                        <option>Tech</option>
                                        <option>News</option>
                                        <option>Political</option>
                                      </select>
                                    </div>
                                  </div>

                                  <div class="form-group row mb-4">
                                    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Content</label>
                                    <div class="col-sm-12 col-md-7">
                                      <textarea class="summernote-simple"></textarea>
                                    </div>
                                  </div>
                                  @else
                                      <h1>Sudah Dikonfirmasi</h1>
                                  @endif
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