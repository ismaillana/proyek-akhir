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

                              <hr>
                              @role('bagian-akademik')
                                <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST"
                                    action="{{route('update-surat-aktif-kuliah', $pengantarPkl->id) }}">
                                        @csrf
    
                                    <div class="form-group row">
                                        <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                            Nomor Surat<sup class="text-danger">*</sup>
                                        </label>
        
                                        <div class="col-sm-12 col-md-9">
                                            <input type="text" class="form-control @error('no_surat')is-invalid @enderror"
                                                id="no_surat" name="no_surat" placeholder="Masukkan Nomor Surat" 
                                                value="{{ old('no_surat', @$pengantarPkl->no_surat) }}">
    
                                            @if ($errors->has('no_surat'))
                                                <span class="text-danger">{{ $errors->first('no_surat') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-9 offset-md-3">
                                            <button type="submit" class="btn btn-primary" id="btnSubmit">
                                                @if (@$pengantarPkl->no_surat == null)
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

                              <hr>
                              @if ($user->hasRole('admin-jurusan'))
                                @if (@$pengantarPkl->status == "Menunggu Konfirmasi")
                                  <div class="text-md-right">
                                    <div class="float-lg-left mb-lg-0 mb-3">
                                        <button class="btn btn-primary btn-icon icon-left" data-toggle="modal" data-target="#konfirmasi{{$pengantarPkl->id}}">
                                            <i class="fas fa-check"></i> 
                                            Konfirmasi
                                        </button>

                                        <button class="btn btn-warning btn-icon icon-left" data-toggle="modal" data-target="#review{{$pengantarPkl->id}}">
                                          <i class="fas fa-share"></i> 
                                          Review
                                        </button>

                                        <button class="btn btn-danger btn-icon icon-left" data-toggle="modal" data-target="#tolak{{$pengantarPkl->id}}">
                                            <i class="fas fa-times"></i> 
                                            Tolak
                                        </button>
                                    </div>
                                  </div>
                                @elseif (@$pengantarPkl->status == "Setuju")
                                  <div class="text-md-right">
                                    <div class="float-lg-left mb-lg-0 mb-3">
                                        <button class="btn btn-primary btn-icon icon-left" data-toggle="modal" data-target="#konfirmasi{{$pengantarPkl->id}}">
                                            <i class="fas fa-check"></i> 
                                            Konfirmasi
                                        </button>
                                    </div>
                                  </div>
                                @else

                                @endif
                                  
                              @elseif (@$pengantarPkl->status == "Review" && $user->hasRole('koor-pkl'))
                                <div class="text-md-right">
                                  <div class="float-lg-left mb-lg-0 mb-3">
                                      <button class="btn btn-primary btn-icon icon-left" data-toggle="modal" data-target="#setuju{{$pengantarPkl->id}}">
                                          <i class="fas fa-check"></i> 
                                          Setujui
                                      </button>

                                      <button class="btn btn-danger btn-icon icon-left" data-toggle="modal" data-target="#tolak{{$pengantarPkl->id}}">
                                          <i class="fas fa-times"></i> 
                                          Tolak
                                      </button>
                                  </div>
                                </div>
                              @else
                                <div class="text-md-right">
                                  <a href="{{ route('print-pengantar-pkl', Crypt::encryptString($pengantarPkl->id)) }}" class="btn btn-warning btn-icon icon-left">
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
                      Batal
                  </button>

                  <button type="submit" class="btn btn-primary">
                      Batal
                  </button>
              </div>
          </div>
      </form>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="review{{$pengantarPkl->id}}">
  <div class="modal-dialog" role="document">
      <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{ route('review-pengantar-pkl', $pengantarPkl->id)}}" method="POST">
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

<div class="modal fade" tabindex="-1" role="dialog" id="setuju{{$pengantarPkl->id}}">
  <div class="modal-dialog" role="document">
      <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{ route('setuju-pengantar-pkl', $pengantarPkl->id)}}" method="POST">
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
@endsection