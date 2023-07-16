@extends('layout.backend.base')
@section('content')
  <div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Tabel Data Pengajuan Izin Penelitian</h1>
      </div>

      <div class="section-body">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="d-flex justify-content-between w-100">
                    <h4>
                        Data Pengajuan Izin Penelitian
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

                        <th>
                            Nama Mahasiswa
                        </th>

                        <th>
                            NIM
                        </th>

                        <th>
                            Tempat Penelitian
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
                        @foreach ($izinPenelitian as $item)
                            @if (@$item->mahasiswa->programStudi->jurusan->name == @$user->jurusan->name)
                                <tr>
                                    <td>
                                        {{$loop->iteration}}
                                    </td>

                                    <td>
                                        {{@$item->mahasiswa->user->name}}
                                    </td>

                                    <td>
                                        {{@$item->mahasiswa->nim}}
                                    </td>

                                    <td>
                                        {{$item->nama_tempat}}
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
                                        <a href="{{ route('pengajuan-izin-penelitian.show',  Crypt::encryptString($item->id)) }}"
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
@endsection