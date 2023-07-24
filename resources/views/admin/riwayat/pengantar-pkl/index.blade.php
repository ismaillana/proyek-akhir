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
                                        <a href="{{ url('menu-admin/riwayat-detail-pengajuan-pkl', $item->kode_pkl) }}"
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
@endsection