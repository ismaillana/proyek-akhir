@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
      <div class="section-header">
        <h1>Tabel Data Pengajuan Verifikasi Ijazah</h1>
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

                    {{-- <a href="{{ route('prodi.create') }}"
                        class="btn btn-outline-success btn-lg d-flex align-items-center ">
                        <i class="fa fa-plus pr-2"></i>
                        Tambah
                    </a> --}}
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped" id="myTable">
                    <thead>
                      <tr>
                        <th class="text-center">
                            #
                        </th>
                        <th class="text-center">
                            Pengaju
                        </th>
                        <th class="text-center">
                            Nama Mahasiswa
                        </th>
                        <th class="text-center">
                            NIM
                        </th>
                        <th class="text-center">
                            Nomor Ijazah
                        </th>
                        <th class="text-center">
                            Tahun Lulus
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
                    @foreach ($verifikasiIjazah as $item)
                        <tr class="text-center">
                            <td>
                                {{$loop->iteration}}
                            </td>
                            <td>
                                {{@$item->instansi->user->name}}
                            </td>
                            <td>
                                {{$item->name}}
                            </td>
                            <td>
                                {{$item->nim}}
                            </td>
                            <td>
                                {{$item->no_ijazah}}
                            </td>
                            <td>
                                {{$item->tahun_lulus}}
                            </td>
                            <td>
                                <a href="{{ asset('storage/public/dokumen/verifikasi-ijazah/'. $item->dokumen)}}" download="{{$item->dokumen}}">
                                    <button class="badge badge-primary" type="button">
                                        Download
                                    </button>
                                </a>
                            </td>
                            <td>
                                @if ($item->status == 'Menunggu Konfirmasi')
                                    <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                @elseif ($item->status == 'Diproses')
                                    <span class="badge badge-warning">Menunggu Konfirmasi</span>
                                @else
                                    <span class="badge badge-success">Selesai</span>
                                @endif
                            </td>
                            
                            <td>
                                <a href="{{ route('pengajuan-aktif-kuliah.edit', $item->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <button value="{{ route('pengajuan-aktif-kuliah.destroy', $item->id) }}"
                                    class="btn btn-sm btn-outline-danger delete"> 
                                    <i class="fas fa-trash"></i>
                                </button>
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