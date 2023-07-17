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
              <div class="alert alert-warning ml-4 col-auto">
                  <strong>Pemberitahuan:</strong> Terdapat {{ count($pengajuans) }} pengajuan yang belum dikonfirmasi lebih dari 1 hari.
              </div>
          @endif
        @endrole

        @role('admin-jurusan')
          @if(count($pengajuanJurusan) > 0)
              <div class="alert alert-warning ml-4 col-auto">
                  <strong>Pemberitahuan:</strong> Terdapat {{ count($pengajuanJurusan) }} pengajuan yang belum dikonfirmasi lebih dari 1 hari.
              </div>
          @endif
        @endrole

        @role('koor-pkl')
          @if(count($pengajuanPkls) > 0)
              <div class="alert alert-warning ml-4 col-auto">
                  <strong>Pemberitahuan:</strong> Terdapat {{ count($pengajuanPkls) }} pengajuan yang belum dikonfirmasi lebih dari 1 hari.
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
                  <h4>Total User</h4>
                </div>
                <div class="card-body">
                  {{$user}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-danger">
                <i class="far fa-newspaper"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Pengajuan Berlangsung</h4>
                </div>
                <div class="card-body">
                  {{$pengajuan}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-warning">
                <i class="far fa-file"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Riwayat Pengajuan</h4>
                </div>
                <div class="card-body">
                  {{$riwayat}}
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
              <div class="card-icon bg-warning">
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
                  Pengajuan Surat AKtif Kuliah Terbaru
                </h4>

                <div class="card-header-action">
                  <a href="{{route('pengajuan-aktif-kuliah.index')}}" class="btn btn-primary">
                    View All
                  </a>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
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
        </div>

        <div class="row">
          <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>
                  Pengajuan Surat Pengantar Pkl Terbaru
                </h4>

                <div class="card-header-action">
                  <a href="{{route('pengajuan-pengantar-pkl.index')}}" class="btn btn-primary">
                    View All
                  </a>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
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
        </div>

        <div class="row">
          <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>
                  Pengajuan Surat Izin Penelitian Terbaru
                </h4>

                <div class="card-header-action">
                  <a href="{{route('pengajuan-izin-penelitian.index')}}" class="btn btn-primary">
                    View All
                  </a>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
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
        </div>

        <div class="row">
          <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>
                  Pengajuan Surat Izin Dispensasi Terbaru
                </h4>

                <div class="card-header-action">
                  <a href="{{route('pengajuan-dispensasi.index')}}" class="btn btn-primary">
                    View All
                  </a>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
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
        </div>

        <div class="row">
          <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>
                  Pengajuan Legalisir Terbaru
                </h4>

                <div class="card-header-action">
                  <a href="{{route('pengajuan-legalisir.index')}}" class="btn btn-primary">
                    View All
                  </a>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
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
        </div>

        <div class="row">
          <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>
                  Pengajuan Verifikasi Ijazah Terbaru
                </h4>

                <div class="card-header-action">
                  <a href="{{route('pengajuan-verifikasi-ijazah.index')}}" class="btn btn-primary">
                    View All
                  </a>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
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
                  {{$pengajuanIzinPenelitian}}
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
                  {{$pengajuanIzinDispensasi}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-warning">
                <i class="far fa-file"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Pengantar PKL</h4>
                </div>
                <div class="card-body">
                  {{$pengajuanPengantarPkl}}
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
                  <a href="{{route('pengajuan-pengantar-pkl.index')}}" class="btn btn-primary">
                    View All
                  </a>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
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
        </div>

        <div class="row">
          <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>
                  Pengajuan Surat Izin Penelitian Terbaru
                </h4>

                <div class="card-header-action">
                  <a href="{{route('pengajuan-izin-penelitian.index')}}" class="btn btn-primary">
                    View All
                  </a>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
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
        </div>

        <div class="row">
          <div class="col-lg-12 col-md-12 col-12 col-sm-12">
            <div class="card">
              <div class="card-header">
                <h4>
                  Pengajuan Surat Izin Dispensasi Terbaru
                </h4>

                <div class="card-header-action">
                  <a href="{{route('pengajuan-dispensasi.index')}}" class="btn btn-primary">
                    View All
                  </a>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
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
        </div>
      @endrole

      @role('koor-pkl')
        <div class="row d-flex justify-content-between w-100">
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
              <div class="card-icon bg-danger">
                <i class="far fa-newspaper"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Pengajuan Berlangsung</h4>
                </div>
                <div class="card-body">
                  {{$pengajuan}}
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
              <div class="card-icon bg-warning">
                <i class="far fa-file"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Riwayat Pengajuan</h4>
                </div>
                <div class="card-body">
                  {{$riwayat}}
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
                  <a href="{{route('pengajuan-pengantar-pkl.index')}}" class="btn btn-primary">
                    View All
                  </a>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-striped mb-0">
                    <thead>
                      <tr>
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
        </div>
      @endrole
    </section>
</div>
@endsection