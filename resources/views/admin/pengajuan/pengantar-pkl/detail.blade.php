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
                                      <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                  @elseif (@$pengantarPkl->status == 'Konfirmasi')
                                      <span class="badge badge-primary">Dikonfirmasi</span>
                                  @elseif (@$pengantarPkl->status == 'Proses')
                                      <span class="badge badge-success">Diproses</span>
                                  @elseif (@$pengantarPkl->status == 'Tolak')
                                      <span class="badge badge-danger">Ditolak</span>
                                  @elseif (@$pengantarPkl->status == 'Kendala')
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

                              {{-- <div class="row mt-4">
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
                              </div> --}}
                            <hr>
                            <div class="text-md-right">
                                @if (@$pengantarPkl->status == "Menunggu Konfirmasi")
                                    <div class="text-md-right">
                                        <div class="float-lg-left mb-lg-0 mb-3">
                                            <button class="btn btn-primary btn-icon icon-left" data-toggle="modal" data-target="#konfirmasi{{$pengantarPkl->id}}">
                                                <i class="fas fa-check"></i> 
                                                Konfirmasi
                                            </button>

                                            <button class="btn btn-danger btn-icon icon-left" data-toggle="modal" data-target="#tolak{{$pengantarPkl->id}}">
                                                <i class="fas fa-times"></i> 
                                                Tolak
                                            </button>
                                        </div>

                                        <button class="btn btn-warning btn-icon icon-left">
                                            <i class="fas fa-print"></i> 
                                            Print
                                        </button>
                                    </div>
                                @else
                                    <div class="text-md-right">
                                        <button class="btn btn-warning btn-icon icon-left">
                                            <i class="fas fa-print"></i> 
                                            Print
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="konfirmasi{{$pengantarPkl->id}}">
  <div class="modal-dialog" role="document">
      <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{ route('konfirmasi-pengantar-pkl', $pengantarPkl->id)}}" method="POST">
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
                      Close
                  </button>

                  <button type="submit" class="btn btn-primary">
                      Save changes
                  </button>
              </div>
          </div>
      </form>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="tolak{{$pengantarPkl->id}}">
  <div class="modal-dialog" role="document">
      <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{ route('tolak-pengantar-pkl', $pengantarPkl->id)}}" method="POST">
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
                              placeholder="Masukan Catatan">{{ old('catatan', @$pengantarPkl->catatan) }}</textarea>
                          
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
                      Close
                  </button>

                  <button type="submit" class="btn btn-primary">
                      Save changes
                  </button>
              </div>
          </div>
      </form>
  </div>
</div>
@endsection