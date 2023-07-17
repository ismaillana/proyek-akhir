@extends('layout.backend.base')
@section('content')
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Tabel Data Riwayat Pengajuan Surat Pengantar Pkl</h1>
      </div>

      <div class="section-body">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="d-flex justify-content-between w-100">
                    <h4>
                        Data Riwayat Pengajuan Surat Pengantar Pkl
                    </h4>
                </div>
              </div>
              <div class="card-body">
                <form id="myForm" class="forms-sample" enctype="multipart/form-data" 
                    action="{{route('export-pengantar-pkl')}}" method="GET">
                    <div class="row align-items-center" style="margin-bottom: 10px;">
                        <div class="col-md-3 col-sm-12">
                            <label for="start_date" class="label-control">Tanggal Mulai</label>
                            <input type="date" id="start_date" name="start_date" class="form-control"
                                placeholder="Tanggal Mulai" value="{{ old('start_date', request('start_date')) }}">
                            
                            @if ($errors->has('start_date'))
                                <span class="text-danger">
                                    {{ $errors->first('start_date') }}
                                </span>
                            @endif
                        </div>

                        <div class="col-md-3 col-sm-12">
                            <label for="end_date" class="label-control">Tanggal Akhir</label>
                            <input type="date" id="end_date" name="end_date" class="form-control"
                                placeholder="Tanggal Akhir" value="{{ old('end_date', request('end_date')) }}">
                                
                            @if ($errors->has('end_date'))
                                <span class="text-danger">
                                    {{ $errors->first('end_date') }}
                                </span>
                            @endif
                        </div>

                        <div class="col-md-2 col-sm-12">
                            <label for="">&nbsp;</label>
                            <button id="btn-submit" type="submit"
                                class="btn btn-success btn-block">Export Excel</button>
                        </div>
                    </div>
                </form>
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

                        <th>
                            Nama Perusahaan
                        </th>

                        <th>
                            Jumlah Mahasiswa PKL
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
                        @foreach ($pengantarPkl as $item)
                            @if (@$item->mahasiswa->programStudi->jurusan->name == @$user->jurusan->name)

                                <tr>
                                    <td>
                                        {{$loop->iteration}}
                                    </td>

                                    <td class="text-center">
                                        {{ Carbon\Carbon::parse(@$item->created_at)->translatedFormat('d F Y H:i:s') }}
                                    </td>

                                    <td>
                                        {{@$item->mahasiswa->user->name}}
                                    </td>

                                    <td>
                                        {{$item->get_mahasiswa}}
                                    </td>

                                    <td>
                                        {{@$item->tempatPkl->name}}
                                    </td>

                                    <td>
                                        {{count(@$item->nama_mahasiswa)}}
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
                                        @elseif ($item->status == 'Review')
                                            <span class="badge badge-warning">Direview</span>
                                        @elseif ($item->status == 'Setuju')
                                            <span class="badge badge-primary">Disetujui Koor.Pkl</span>
                                        @elseif ($item->status == 'Diterima Perusahaan')
                                            <span class="badge badge-primary">Diterima Perusahaan</span>
                                        @elseif ($item->status == 'Ditolak Perusahaan')
                                            <span class="badge badge-primary">Ditolak Perusahaan</span>
                                        @elseif ($item->status == 'Selesai PKL')
                                            <span class="badge badge-success">Selesai PKL</span>
                                        @else
                                            <span class="badge badge-success">Selesai</span>
                                        @endif
                                    </td>
                                    
                                    <td class="text-center">
                                        <a href="{{ route('riwayat-pengajuan-pengantar-pkl-detail',  Crypt::encryptString($item->id)) }}"
                                            class="btn btn-sm btn-outline-secondary" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                width="16" height="16" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @else

                            @endif
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

@foreach ($pengantarPkl as $pengantarPkl)
  <div class="modal fade" tabindex="-1" role="dialog" id="edit{{$pengantarPkl->id}}">
    <div class="modal-dialog" role="document">
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{route('update-status-pengantar-pkl', $pengantarPkl->id)}}" method="POST">
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
                                <option value="Konfirmasi"
                                    {{ old('status', @$pengantarPkl->status) == 'Konfirmasi' ? 'selected' : '' }}>
                                        Dikonfirmasi</option>
                                <option value="Proses"
                                    {{ old('status', @$pengantarPkl->status) == 'Proses' ? 'selected' : '' }}>
                                        Diproses</option>
                                <option value="Kendala"
                                    {{ old('status', @$pengantarPkl->status) == 'Kendala' ? 'selected' : '' }}>
                                        Ada Kendala</option>
                                <option value="Selesai"
                                    {{ old('status', @$pengantarPkl->status) == 'Selesai' ? 'selected' : '' }}>
                                        Selesai</option>
                            </select>

                            @if ($errors->has('status'))
                                <span class="text-danger">
                                    {{ $errors->first('status') }}
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
@endforeach
@endsection