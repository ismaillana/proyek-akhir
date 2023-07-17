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

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                              <h4>
                                Detail Pengajuan Surat Dispensasi
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
                                <form id="myForm" class="forms-sample" enctype="multipart/form-data" method="POST"
                                    action="{{route('update-surat-aktif-kuliah', $dispensasi->id) }}">
                                        @csrf

                                    <div class="form-group row">
                                        <label class="col-form-label text-md-left col-12 col-md-3 col-lg-3">
                                            Nomor Surat<sup class="text-danger">*</sup>
                                        </label>
        
                                        <div class="col-sm-12 col-md-9">
                                            <input type="text" class="form-control @error('no_surat')is-invalid @enderror"
                                                id="no_surat" name="no_surat" placeholder="Masukkan Nomor Surat" 
                                                value="{{ old('no_surat', @$dispensasi->no_surat) }}">

                                            @if ($errors->has('no_surat'))
                                                <span class="text-danger">{{ $errors->first('no_surat') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 col-md-7 offset-md-3">
                                            <button type="submit" class="btn btn-primary" id="btnSubmit">
                                                @if (@$dispensasi->no_surat == null)
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
                                @if (@$dispensasi->status == "Menunggu Konfirmasi")
                                  <div class="text-md-right">
                                      <div class="float-lg-left mb-lg-0 mb-3">
                                          <button class="btn btn-primary btn-icon icon-left" data-toggle="modal" data-target="#konfirmasi{{$dispensasi->id}}">
                                              <i class="fas fa-check"></i> 
                                              Konfirmasi
                                          </button>

                                          <button class="btn btn-danger btn-icon icon-left" data-toggle="modal" data-target="#tolak{{$dispensasi->id}}">
                                              <i class="fas fa-times"></i> 
                                              Tolak
                                          </button>
                                      </div>
                                  </div>
                                @else

                                @endif
                              @else
                                  <div class="text-md-right">
                                    <a href="{{ route('print-dispensasi', Crypt::encryptString($dispensasi->id)) }}" class="btn btn-warning btn-icon icon-left">
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

<div class="modal fade" tabindex="-1" role="dialog" id="konfirmasi{{$dispensasi->id}}">
  <div class="modal-dialog" role="document">
      <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{ route('konfirmasi-dispensasi', $dispensasi->id)}}" method="POST">
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

<div class="modal fade" tabindex="-1" role="dialog" id="tolak{{$dispensasi->id}}">
  <div class="modal-dialog" role="document">
      <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{ route('tolak-dispensasi', $dispensasi->id)}}" method="POST">
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
                              placeholder="Masukan Catatan">{{ old('catatan', @$dispensasi->catatan) }}</textarea>
                          
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
                      Simpan
                  </button>
              </div>
          </div>
      </form>
  </div>
</div>
@endsection