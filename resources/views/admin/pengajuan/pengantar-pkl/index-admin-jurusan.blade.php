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
                                        <a href="{{ url('menu-admin/detail-pengajuan-pkl', $item->kode_pkl) }}"
                                            class="btn btn-sm btn-outline-secondary" title="Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" width="16" height="16"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
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