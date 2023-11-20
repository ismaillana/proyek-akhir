@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
      
      <div class="section-header d-flex justify-content-between w-100">
        <h1>
          Dashboard
        </h1>
        @role('bagian-akademik')
          @if(count($pengajuans) > 0)
              <div class="alert alert-warning ml-4">
                  <strong>Pemberitahuan:</strong> Terdapat {{ count($pengajuans) }} pengajuan (Surat Keterangan Aktif Kuliah, Cek Keaslian Ijazah, dan Legalisir) yang belum dikonfirmasi lebih dari 1 hari.
              </div>
          @endif
        @endrole

        @role('admin-jurusan')
            @if($total > 0)
                <div class="alert alert-warning ml-4">
                    <strong>Pemberitahuan:</strong> Terdapat {{ $total }} pengajuan (Surat Izin Penelitian, Surat Izin Dispensasi, dan Surat Pengantar PKL) yang belum dikonfirmasi lebih dari 1 hari.
                </div>
            @endif
        @endrole

        @role('koor-pkl')
          @if(count($pengantarPkllll) > 0)
              <div class="alert alert-warning ml-4">
                  <strong>Pemberitahuan:</strong> Terdapat {{ count($pengantarPkllll) }} pengajuan pembuatan surat pengantar PKL yang belum disetujui lebih dari 1 hari.
              </div>
          @endif
        @endrole
      </div>

      @role('super-admin')
        <div class="row d-flex justify-content-between w-100">
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-primary">
                <i class="far fa-user"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Total Bagian Akademik</h4>
                </div>
                <div class="card-body">
                  {{count($bagianAkademik)}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-warning">
                <i class="far fa-user"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Total Admin Jurusan</h4>
                </div>
                <div class="card-body">
                  {{count($adminJurusan)}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-success">
                <i class="far fa-newspaper"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Total Pengajuan</h4>
                </div>
                <div class="card-body">
                  {{$pengajuan}}
                </div>
              </div>
            </div>
          </div>
        </div>
      @endrole

      @role('bagian-akademik')
        <div class="row d-flex justify-content-between w-100">
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-primary">
                <i class="far fa-user"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Total Mahasiswa</h4>
                </div>
                <div class="card-body">
                  {{$mahasiswa}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-success">
                <i class="far fa-user"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Total Alumni</h4>
                </div>
                <div class="card-body">
                  {{$alumni}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-secondary">
                <i class="far fa-user"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Total Instansi</h4>
                </div>
                <div class="card-body">
                  {{$instansi}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-info">
                <i class="far fa-file"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Total Pengajuan</h4>
                </div>
                <div class="card-body">
                  {{$pengajuan}}
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>
                  Pengajuan Surat Aktif Kuliah Terbaru
                </h4>

                <div class="card-header-action">
                  <a href="{{route('pengajuan-aktif-kuliah.index')}}" class="btn btn-outline-primary">
                    Lihat Semua >>
                  </a>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
                        <th>
                          Tanggal Pengajuan
                        </th>

                        <th>
                          Nama Pengaju
                        </th>

                        <th>
                          Jurusan
                        </th>

                        <th class="text-center">
                          Status
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($aktifKuliah as $item)
                        <tr>
                          <td>
                            {{$item->created_at}}
                          </td>

                          <td>
                            {{@$item->mahasiswa->user->name}}
                          </td>

                          <td>
                            {{(@$item->mahasiswa->programStudi->jurusan->name)}}
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
                                <span class="badge badge-success">Direview</span>
                            @elseif ($item->status == 'Setuju')
                                <span class="badge badge-primary">Disetujui Koor.Pkl</span>
                            @else
                                <span class="badge badge-success">Selesai</span>
                            @endif
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="4" class="text-center">
                            Data Kosong!
                          </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>
                  Pengajuan Surat Pengantar Pkl Terbaru
                </h4>

                <div class="card-header-action">
                  <a href="{{route('pengajuan-pengantar-pkl.index')}}" class="btn btn-outline-primary">
                    Lihat Semua >>
                  </a>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
                        <th>
                          Tanggal Pengajuan
                        </th>

                        <th>
                          Nama Pengaju
                        </th>

                        <th>
                          Jurusan
                        </th>

                        <th class="text-center">
                          Status
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($pengantarPkl as $item)
                        <tr>
                          <td>
                            {{$item->created_at}}
                          </td>

                          <td>
                            {{@$item->mahasiswa->user->name}}
                          </td>

                          <td>
                            {{(@$item->mahasiswa->programStudi->jurusan->name)}}
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
                                <span class="badge badge-success">Direview</span>
                            @elseif ($item->status == 'Setuju')
                                <span class="badge badge-primary">Disetujui Koor.Pkl</span>
                            @else
                                <span class="badge badge-success">Selesai</span>
                            @endif
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="4" class="text-center">
                            Data Kosong!
                          </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>
                  Pengajuan Surat Izin Penelitian Terbaru
                </h4>

                <div class="card-header-action">
                  <a href="{{route('pengajuan-izin-penelitian.index')}}" class="btn btn-outline-primary">
                    Lihat Semua >>
                  </a>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
                        <th>
                          Tanggal Pengajuan
                        </th>

                        <th>
                          Nama Pengaju
                        </th>

                        <th>
                          Jurusan
                        </th>

                        <th class="text-center">
                          Status
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($izinPenelitian as $item)
                        <tr>
                          <td>
                            {{$item->created_at}}
                          </td>

                          <td>
                            {{@$item->mahasiswa->user->name}}
                          </td>

                          <td>
                            {{(@$item->mahasiswa->programStudi->jurusan->name)}}
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
                                <span class="badge badge-success">Direview</span>
                            @elseif ($item->status == 'Setuju')
                                <span class="badge badge-primary">Disetujui Koor.Pkl</span>
                            @else
                                <span class="badge badge-success">Selesai</span>
                            @endif
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="4" class="text-center">
                            Data Kosong!
                          </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>
                  Pengajuan Surat Izin Dispensasi Terbaru
                </h4>

                <div class="card-header-action">
                  <a href="{{route('pengajuan-dispensasi.index')}}" class="btn btn-outline-primary">
                    Lihat Semua >>
                  </a>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
                        <th>
                          Tanggal Pengajuan
                        </th>

                        <th>
                          Nama Pengaju
                        </th>

                        <th>
                          Jurusan
                        </th>

                        <th class="text-center">
                          Status
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($dispensasi as $item)
                        <tr>
                          <td>
                            {{$item->created_at}}
                          </td>

                          <td>
                            {{@$item->mahasiswa->user->name}}
                          </td>

                          <td>
                            {{(@$item->mahasiswa->programStudi->jurusan->name)}}
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
                                <span class="badge badge-success">Direview</span>
                            @elseif ($item->status == 'Setuju')
                                <span class="badge badge-primary">Disetujui Koor.Pkl</span>
                            @else
                                <span class="badge badge-success">Selesai</span>
                            @endif
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="4" class="text-center">
                            Data Kosong!
                          </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>
                  Pengajuan Legalisir Terbaru
                </h4>

                <div class="card-header-action">
                  <a href="{{route('pengajuan-legalisir.index')}}" class="btn btn-outline-primary">
                    Lihat Semua >>
                  </a>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
                        <th>
                          Tanggal Pengajuan
                        </th>

                        <th>
                          Nama Pengaju
                        </th>

                        <th>
                          Jurusan
                        </th>

                        <th class="text-center">
                          Status
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($legalisir as $item)
                        <tr>
                          <td>
                            {{$item->created_at}}
                          </td>

                          <td>
                            {{@$item->mahasiswa->user->name}}
                          </td>

                          <td>
                            {{(@$item->mahasiswa->programStudi->jurusan->name)}}
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
                                <span class="badge badge-success">Direview</span>
                            @elseif ($item->status == 'Setuju')
                                <span class="badge badge-primary">Disetujui Koor.Pkl</span>
                            @else
                                <span class="badge badge-success">Selesai</span>
                            @endif
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="4" class="text-center">
                            Data Kosong!
                          </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>
                  Pengajuan Verifikasi Ijazah Terbaru
                </h4>

                <div class="card-header-action">
                  <a href="{{route('pengajuan-verifikasi-ijazah.index')}}" class="btn btn-outline-primary">
                    Lihat Semua >>
                  </a>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
                        <th>
                          Tanggal Pengajuan
                        </th>

                        <th>
                          Nama Pengaju
                        </th>

                        <th>
                          Email
                        </th>

                        <th class="text-center">
                          Status
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($verifikasiIjazah as $item)
                        <tr>
                          <td>
                            {{$item->created_at}}
                          </td>

                          <td>
                            {{$item->instansi->nama_perusahaan}}
                          </td>

                          <td>
                            {{(@$item->instansi->user->email)}}
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
                                <span class="badge badge-success">Direview</span>
                            @elseif ($item->status == 'Setuju')
                                <span class="badge badge-primary">Disetujui Koor.Pkl</span>
                            @else
                                <span class="badge badge-success">Selesai</span>
                            @endif
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <td colspan="4" class="text-center">
                            Data Kosong!
                          </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endrole

      @role('admin-jurusan')
        <div class="row d-flex justify-content-between w-100">
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-primary">
                <i class="far fa-file"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Izin Penelitian</h4>
                </div>
                <div class="card-body">
                  {{count($izinPenelitiann)}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-success">
                <i class="far fa-newspaper"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Izin Dispensasi</h4>
                </div>
                <div class="card-body">
                  {{count($dispensasii)}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-info">
                <i class="far fa-file"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Pengantar PKL</h4>
                </div>
                <div class="card-body">
                  {{count($pengantarPkll)}}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>
                  Pengajuan Surat Pengantar Pkl Terbaru
                </h4>

                <div class="card-header-action">
                  <a href="{{route('pengajuan-pengantar-pkl.index')}}" class="btn btn-outline-primary">
                    Lihat Semua >>
                  </a>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
                        <th>
                          Tanggal Pengajuan
                        </th>

                        <th>
                          Nama Pengaju
                        </th>

                        <th>
                          Jurusan
                        </th>

                        <th class="text-center">
                          Status
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($pengantarPkl as $item)
                          <tr>
                            <td>
                              {{$item->created_at}}
                            </td>

                            <td>
                              {{@$item->mahasiswa->user->name}}
                            </td>

                            <td>
                              {{(@$item->mahasiswa->programStudi->jurusan->name)}}
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
                              @else
                                  <span class="badge badge-success">Selesai</span>
                              @endif
                            </td>
                          </tr>
                      @empty
                        <tr>
                          <td colspan="4" class="text-center">
                            Data Kosong!
                          </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>
                  Pengajuan Surat Izin Penelitian Terbaru
                </h4>

                <div class="card-header-action">
                  <a href="{{route('pengajuan-izin-penelitian.index')}}" class="btn btn-outline-primary">
                    Lihat Semua >>
                  </a>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
                        <th>
                          Tanggal Pengajuan
                        </th>

                        <th>
                          Nama Pengaju
                        </th>

                        <th>
                          Jurusan
                        </th>

                        <th class="text-center">
                          Status
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($izinPenelitian as $item)
                        @if (@$item->mahasiswa->programStudi->jurusan->name == @$akun->jurusan->name)
                          <tr>
                            <td>
                              {{$item->created_at}}
                            </td>

                            <td>
                              {{@$item->mahasiswa->user->name}}
                            </td>

                            <td>
                              {{(@$item->mahasiswa->programStudi->jurusan->name)}}
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
                                  <span class="badge badge-success">Direview</span>
                              @elseif ($item->status == 'Setuju')
                                  <span class="badge badge-primary">Disetujui Koor.Pkl</span>
                              @else
                                  <span class="badge badge-success">Selesai</span>
                              @endif
                            </td>
                          </tr>
                        @else

                        @endif
                      @empty
                        <tr>
                          <td colspan="4" class="text-center">
                            Data Kosong!
                          </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>
                  Pengajuan Surat Izin Dispensasi Terbaru
                </h4>

                <div class="card-header-action">
                  <a href="{{route('pengajuan-dispensasi.index')}}" class="btn btn-outline-primary">
                    Lihat Semua >>
                  </a>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
                        <th>
                          Tanggal Pengajuan
                        </th>

                        <th>
                          Nama Pengaju
                        </th>

                        <th>
                          Jurusan
                        </th>

                        <th class="text-center">
                          Status
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($dispensasi as $item)
                        @if (@$item->mahasiswa->programStudi->jurusan->name == @$akun->jurusan->name)
                          <tr>
                            <td>
                              {{$item->created_at}}
                            </td>
                            
                            <td>
                              {{@$item->mahasiswa->user->name}}
                            </td>

                            <td>
                              {{(@$item->mahasiswa->programStudi->jurusan->name)}}
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
                                  <span class="badge badge-success">Direview</span>
                              @elseif ($item->status == 'Setuju')
                                  <span class="badge badge-primary">Disetujui Koor.Pkl</span>
                              @else
                                  <span class="badge badge-success">Selesai</span>
                              @endif
                            </td>
                          </tr>
                        @else

                        @endif

                        @empty
                        <tr>
                          <td colspan="4" class="text-center">
                            Data Kosong!
                          </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endrole

      @role('koor-pkl')
        <div class="row d-flex justify-content-center w-100">
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-primary">
                <i class="fas fa-columns"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Total Tempat PKL</h4>
                </div>
                <div class="card-body">
                  {{$tempatPkl}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-success">
                <i class="far fa-newspaper"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Total Pengajuan PKL</h4>
                </div>
                <div class="card-body">
                  {{count($pengantarPkll)}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-info">
                <i class="far fa-file"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Total Pengajuan (Direview)</h4>
                </div>
                <div class="card-body">
                  {{count($pengantarPkllll)}}
                </div>
              </div>
            </div>
          </div>
        </div>
        {{-- <div class="row">
          <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>
                  Pengajuan Surat Pengantar Pkl Terbaru
                </h4>

                <div class="card-header-action">
                  <a href="{{route('pengajuan-pengantar-pkl.index')}}" class="btn btn-outline-primary">
                    Lihat Semua >>
                  </a>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
                        <th>
                          Tanggal Pengajuan
                        </th>

                        <th>
                          Nama Pengaju
                        </th>

                        <th>
                          Jurusan
                        </th>

                        <th class="text-center">
                          Status
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($pengantarPkl as $item)
                      @if (@$item->mahasiswa->programStudi->jurusan->name == @$akun->jurusan->name)
                        <tr>
                          <td>
                            {{$item->created_at}}
                          </td>

                          <td>
                            {{@$item->mahasiswa->user->name}}
                          </td>

                          <td>
                            {{(@$item->mahasiswa->programStudi->jurusan->name)}}
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
                                <span class="badge badge-success">Direview</span>
                            @elseif ($item->status == 'Setuju')
                                <span class="badge badge-primary">Disetujui Koor.Pkl</span>
                            @else
                                <span class="badge badge-success">Selesai</span>
                            @endif
                          </td>
                        </tr>
                      @else

                      @endif
                      @empty
                        <tr>
                          <td colspan="3" class="text-center">
                            Data Kosong!
                          </td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div> --}}

        <div class="row">
          <div class="col-lg-12 col-md-12 col-12 col-sm-12">
              <div class="card">
                  <div class="card-header">
                      <h4>
                          Tempat PKL
                      </h4>
                      {{-- <div class="card-header-action">
                          <a href="{{ route('pengajuan-pengantar-pkl.index') }}" class="btn btn-outline-primary">
                              Lihat Semua >>
                          </a>
                      </div> --}}
                  </div>
                  <div class="card-body p-0">
                    <div class="col-md-4 mb-3">
                      <label for="tahun_pengajuan">Tahun Pengajuan:</label>
                      <select name="tahun_pengajuan" id="tahun_pengajuan" class="form-control">
                          @php
                              // Ambil tahun saat ini
                              $currentYear = date('Y');
                          @endphp
                          @for ($year = $currentYear; $year >= 2020; $year--)
                              <option value="{{ $year }}" @if(request('tahun_pengajuan', $currentYear) == $year) selected @endif>{{ $year }}</option>
                          @endfor
                      </select>
                  </div>
                      <div class="table-responsive">
                          <table id="tabelPengajuan" class="table table-striped mb-0">
                              <thead>
                                  <tr>
                                      <th class="text-center">Tanggal Pengajuan</th>
                                      <th class="text-center">Nama Tempat PKL</th>
                                      <th class="text-center">Nama Mahasiswa</th>
                                      <th class="text-center">Status</th>
                                      <th class="text-center">Jumlah Mahasiswa</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @forelse ($jumlahTempatPkl as $item)
                                      @php
                                          $pengajuans = $namaNempatPkl->where('kode_pkl', $item->kode_pkl);
                                          $jumlahPengaju = $namaNempatPkl->where('kode_pkl', $item->kode_pkl)->where('status', 'Diterima Perusahaan')->count();
                                      @endphp
                                      <tr data-tahun="{{ Carbon\Carbon::parse($item->created_at)->year }}">
                                          <td>{{ Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y H:i:s') }}</td>
                                          <td>{{ @$item->tempatPkl->name }}</td>
                                          <td>
                                            @foreach ($pengajuans as $pengaju)
                                                  {{ @$pengaju->mahasiswa->user->name }}-{{ @$pengaju->mahasiswa->nim }}
                                                  <br>
                                            @endforeach
                                          </td>
                                          <td class="text-center">
                                            @foreach ($pengajuans as $pengaju)
                                                @if ($pengaju->status == 'Menunggu Konfirmasi')
                                                    <span class="badge badge-warning mb-1">Menunggu Konfirmasi</span>
                                                @elseif ($pengaju->status == 'Konfirmasi')
                                                    <span class="badge badge-primary mb-1">Dikonfirmasi</span>
                                                @elseif ($pengaju->status == 'Proses')
                                                    <span class="badge badge-success mb-1">Diproses</span>
                                                @elseif ($pengaju->status == 'Tolak')
                                                    <span class="badge badge-danger mb-1">Ditolak</span>
                                                @elseif ($pengaju->status == 'Kendala')
                                                    <span class="badge badge-danger mb-1">Ada Kendala</span>
                                                @elseif ($pengaju->status == 'Review')
                                                    <span class="badge badge-warning mb-1">Direview</span>
                                                @elseif ($pengaju->status == 'Setuju')
                                                    <span class="badge badge-primary mb-1">Disetujui Koor.Pkl</span>
                                                @elseif ($pengaju->status == 'Diterima Perusahaan')
                                                    <span class="badge badge-primary mb-1">Diterima Perusahaan</span>
                                                @elseif ($pengaju->status == 'Ditolak Perusahaan')
                                                    <span class="badge badge-primary mb-1">Ditolak Perusahaan</span>
                                                @elseif ($pengaju->status == 'Selesai PKL')
                                                    <span class="badge badge-success mb-1">Selesai PKL</span>
                                                @else
                                                    <span class="badge badge-success mb-1">Selesai</span>
                                                @endif
                                                <br>
                                            @endforeach
                                          </td>
                                          <td class="text-center">
                                              @if ($jumlahPengaju > 0)
                                                  {{ $jumlahPengaju }} Mahasiswa
                                              @else
                                                  <span>Belum Ada Yang Diterima</span>
                                              @endif
                                          </td>
                                      </tr>
                                  @empty
                                      <tr>
                                          <td colspan="5" class="text-center">
                                              Data Kosong!
                                          </td>
                                      </tr>
                                  @endforelse
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      @endrole
    </section>
</div>
@endsection

@section('script')
<script>
    // Ambil elemen select tahun pengajuan
    const selectTahunPengajuan = document.getElementById('tahun_pengajuan');
    const tabelPengajuan = document.getElementById('tabelPengajuan');

    // Tambahkan event onchange untuk melakukan filter saat tahun pengajuan berubah
    selectTahunPengajuan.addEventListener('change', function () {
        // Ambil nilai tahun pengajuan yang dipilih
        const tahunPengajuan = selectTahunPengajuan.value;

        // Ambil semua baris tabel
        const rows = tabelPengajuan.getElementsByTagName('tr');

        // Lakukan filter berdasarkan tahun pengajuan
        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const tahunRow = row.getAttribute('data-tahun');
            if (tahunRow === tahunPengajuan) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        }
    });
</script>
@endsection