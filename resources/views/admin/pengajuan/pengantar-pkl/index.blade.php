@extends('layout.backend.base')
@section('content')
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Tabel Data Pengajuan Surat Pengantar Pkl</h1>
      </div>

      <div class="section-body">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="d-flex justify-content-between w-100">
                    <h4>
                        Data Pengajuan Surat Pengantar Pkl
                    </h4>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="myTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Nama Perusahaan</th>
                            <th>Nama Pengaju</th>
                            <th>Jumlah Pengaju</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengantarPkl as $item)
                            @php
                                $pengajuans = $pengantar->where('kode_pkl', $item->kode_pkl);
                                $jumlahPengaju = $pengajuans->count();
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y H:i:s') }}</td>
                                <td>{{ @$item->tempatPkl->name }}</td>
                                <td>
                                    @foreach ($pengajuans as $pengaju)
                                        {{ @$pengaju->mahasiswa->user->name }}-{{ @$pengaju->mahasiswa->nim }}
                                        <br>
                                    @endforeach
                                </td>
                                <td>{{ $jumlahPengaju }}</td>

                                <td>{{ $item->status }}</td>
                                <td class="text-center">
                                    @if (@$item->status == 'Tolak' || @$item->status == 'Selesai' || @$item->status == 'Menunggu Konfirmasi' || @$item->status == 'Review')
                                        <a href="{{ url('menu-admin/detail-pengajuan-pkl', $item->kode_pkl) }}) }}"
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
                                        <a href="{{ url('menu-admin/detail-pengajuan-pkl', $item->kode_pkl) }}"
                                            class="btn btn-sm btn-outline-secondary" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                width="16" height="16" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </a>

                                        <a href="" class="btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#edit{{ $item->kode_pkl }}"
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

@foreach ($pengantarPkl as $item)
  <div class="modal fade" tabindex="-1" role="dialog" id="edit{{ $item->kode_pkl }}">
    <div class="modal-dialog" role="document">
        <form id="myForm-{{ $item->kode_pkl }}" class="forms-sample" enctype="multipart/form-data" action="{{url('menu-admin/update-status-pengantar-pkl', $item->kode_pkl)}}" method="POST">
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
                                    {{ old('status', @$item->status) == 'Konfirmasi' ? 'selected' : '' }}>
                                        Dikonfirmasi</option>
                                <option value="Proses"
                                    {{ old('status', @$item->status) == 'Proses' ? 'selected' : '' }}>
                                        Diproses</option> --}}
                                <option value="Kendala"
                                    {{ old('status', @$item->status) == 'Kendala' ? 'selected' : '' }}>
                                        Ada Kendala</option>
                                <option value="Selesai"
                                    {{ old('status', @$item->status) == 'Selesai' ? 'selected' : '' }}>
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