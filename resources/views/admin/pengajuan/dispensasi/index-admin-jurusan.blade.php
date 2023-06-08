@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Tabel Data Pengajuan Dispensasi</h1>
      </div>

      <div class="section-body">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="d-flex justify-content-between w-100">
                    <h4>
                        Data Pengajuan Dispensasi
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
                            Pengaju
                        </th>

                        <th>
                            Nama Mahasiswa
                        </th>

                        <th class="text-center">
                            Dokumen
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
                    @foreach ($dispensasi as $item)
                        @if (@$item->mahasiswa->jurusan->name == @$adminJurusan->jurusan->name)
                            
                        <tr>
                            <td>
                                {{$loop->iteration}}
                            </td>

                            <td>
                                {{@$item->mahasiswa->user->name}}
                            </td>

                            <td>
                                {{$item->get_mahasiswa}}
                            </td>

                            <td class="text-center">
                                <a href="{{ asset('storage/public/dokumen/dispensasi/'. $item->dokumen)}}" download="{{$item->dokumen}}">
                                    <button class="badge badge-primary" type="button">
                                        Download
                                    </button>
                                </a>
                            </td>

                            <td class="text-center">
                                @if ($item->status == 'Menunggu Konfirmasi')
                                    <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                @elseif ($item->status == 'Diproses')
                                    <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                @else
                                    <span class="badge badge-success">Selesai</span>
                                @endif
                            </td>
                            
                            <td class="text-center">

                                <a href="{{ route('pengajuan-dispensasi.show',  Crypt::encryptString($item->id)) }}"
                                    class="btn btn-sm btn-outline-secondary" title="Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                        width="16" height="16" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </a>

                                <a href="{{ route('pengajuan-dispensasi.edit', $item->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                <a href="{{ route('pengajuan-dispensasi.edit', $item->id) }}" class="btn btn-sm btn-outline-warning" title="update status">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                        height="16" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M5 11l7-7 7 7M5 19l7-7 7 7" />
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

@section('script')
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.delete', function() {
                let url = $(this).val();
                console.log(url);
                swal({
                        title: "Apakah anda yakin?",
                        text: "Setelah dihapus, Anda tidak dapat memulihkan Tag ini lagi!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: "DELETE",
                                url: url,
                                dataType: 'json',
                                success: function(response) {
                                    swal(response.status, {
                                            icon: "success",
                                        })
                                        .then((result) => {
                                            location.reload();
                                        });
                                }
                            });
                        }
                    })
            });
        });
    </script>
@endsection