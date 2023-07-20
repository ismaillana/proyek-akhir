@extends('layout.backend.base')
@section('content')
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>
            Tabel Data Pengajuan Verifikasi Ijazah
        </h1>
      </div>

      <div class="section-body">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="d-flex justify-content-between w-100">
                    <h4>
                        Data Pengajuan Verifikasi Ijazah
                    </h4>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="myTable">
                    <thead>
                      <tr>
                        <th style="width: 10%">
                            #
                        </th>

                        <th class="text-center">
                            Tanggal Pengajuan
                        </th>

                        <th>
                            Pengaju
                        </th>

                        <th>
                            Nama Mahasiswa
                        </th>

                        <th class="text-center">
                            Status
                        </th>

                        <th class="text-center">
                            Aksi
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($verifikasiIjazah as $item)
                            <tr>
                                <td>
                                    {{$loop->iteration}}
                                </td>

                                <td class="text-center">
                                    {{ Carbon\Carbon::parse(@$item->created_at)->translatedFormat('d F Y H:i:s') }}
                                </td>

                                <td>
                                    {{@$item->instansi->user->name}}
                                </td>

                                <td>
                                    {{$item->nama}}
                                </td>
                                
                                <td class="text-center">
                                    @if ($item->status == 'Menunggu Konfirmasi')
                                        <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                    @elseif ($item->status == 'Konfirmasi')
                                        <span class="badge badge-primary">Dikonfirmasi</span>
                                    @elseif ($item->status == 'Proses')
                                        <span class="badge badge-success">Diproses</span>
                                    @elseif ($item->status == 'Tolak')
                                        <span class="badge badge-danger">Ditolak</span>
                                    @elseif ($item->status == 'Kendala')
                                        <span class="badge badge-danger">Ada Kendala</span>
                                    @else
                                        <span class="badge badge-success">Selesai</span>
                                    @endif
                                </td>
                                
                                <td class="text-center">
                                    @if (@$item->status == 'Tolak' || @$item->status == 'Selesai' || @$item->status == 'Menunggu Konfirmasi')
                                        <a href="{{ route('pengajuan-verifikasi-ijazah.show',  Crypt::encryptString($item->id)) }}"
                                            class="btn btn-sm btn-outline-secondary" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                width="16" height="16" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </a>
                                    @else
                                        <a href="{{ route('pengajuan-verifikasi-ijazah.show',  Crypt::encryptString($item->id)) }}"
                                            class="btn btn-sm btn-outline-secondary" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                width="16" height="16" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </a>

                                        <a href="" class="btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#edit{{$item->id}}"
                                            title="update status">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                height="16" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M5 11l7-7 7 7M5 19l7-7 7 7" />
                                            </svg>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>  

@foreach ($verifikasiIjazah as $verifikasiIjazah)
  <div class="modal fade" tabindex="-1" role="dialog" id="edit{{$verifikasiIjazah->id}}">
    <div class="modal-dialog" role="document">
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{route('update-status-verifikasi-ijazah', $verifikasiIjazah->id)}}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Form Ubah Status Pengajuan
                    </h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="satatus" class="col-form-label">
                            Status<sup class="text-danger">*</sup>
                        </label>

                        <div class="input-group">
                            <select class="form-control @error('status')is-invalid @enderror" id="status" name="status" >
                                <option selected disabled value="">
                                    Pilih Status
                                </option>
                                {{-- <option value="Konfirmasi"
                                    {{ old('status', @$verifikasiIjazah->status) == 'Konfirmasi' ? 'selected' : '' }}>
                                        Dikonfirmasi</option>
                                <option value="Proses"
                                    {{ old('status', @$verifikasiIjazah->status) == 'Proses' ? 'selected' : '' }}>
                                        Diproses</option> --}}
                                <option value="Kendala"
                                    {{ old('status', @$verifikasiIjazah->status) == 'Kendala' ? 'selected' : '' }}>
                                        Ada Kendala</option>
                                <option value="Selesai"
                                    {{ old('status', @$verifikasiIjazah->status) == 'Selesai' ? 'selected' : '' }}>
                                        Selesai</option>
                            </select>

                            @if ($errors->has('status'))
                                <span class="text-danger">
                                    {{ $errors->first('status') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-2" id="dokumenHasil">
                        <label for="dokumen_hasil" class="col-form-label text-md-left col-12">
                            Dokumen Hasil
                        </label>
        
                        <div class="col-sm-12 col-md-12">
                            <div class="input-group">
                                <input class="dropify @error('dokumen_hasil') is-invalid @enderror" type="file" 
                                    name="dokumen_hasil" data-height='250' data-allowed-file-extensions="pdf doc docx" data-max-file-size="5M">
                            </div>
        
                            @if ($errors->has('dokumen_hasil'))
                                <span class="text-danger">
                                    {{ $errors->first('dokumen_hasil') }}
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
@endforeach
@endsection

@section('script')
    <script>
        $("#dokumenHasil").hide();
        $('#status').on('change', function(){
            var selectedVal = $(this).val();
            if (selectedVal == 'Selesai') {
                $('#dokumenHasil').show();
            } else {
                $("#dokumenHasil").hide();
            }
        })
    </script>
@endsection

