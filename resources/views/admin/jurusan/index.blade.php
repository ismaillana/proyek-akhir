@extends('layout.backend.base')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
        <h1>Posts</h1>
        </div>
        <div class="section-body">
        <h2 class="section-title">Posts</h2>
        <p class="section-lead">
            You can manage all posts, such as editing, deleting and more.
        </p>

        <div class="row mt-4">
            <div class="col-12">
            <div class="card">
                <div class="card-header">
                <h4>Tabel Jurusan</h4>
                <div class="section-header-button">
                    <a href="{{route('jurusan.create')}}" class="btn btn-primary">Tambah +</a>
                </div>
                </div>
                <div class="card-body">
                <div class="float-left">
                    <select class="form-control selectric">
                    <option>Action For Selected</option>
                    <option>Move to Draft</option>
                    <option>Move to Pending</option>
                    <option>Delete Pemanently</option>
                    </select>
                </div>
                <div class="float-right">
                    <form>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search">
                        <div class="input-group-append">
                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                    </form>
                </div>

                <div class="clearfix mb-3"></div>

                <div class="table-responsive">
                    <table class="table table-striped">
                    <tr>
                        <th class="text-center pt-1">
                        #
                        </th>
                        <th class="text-center">Nama Jurusan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                    @foreach ($jurusan as $item)
                        <tr class="text-center">
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{$item->name}}
                            <td>
                                <a href="{{ route('jurusan.edit', $item->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <button value="{{ route('jurusan.destroy', $item->id) }}"
                                    class="btn btn-sm btn-outline-danger delete"> 
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </table>
                </div>
                <div class="float-right">
                    <nav>
                    <ul class="pagination">
                        <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                        </li>
                        <li class="page-item active">
                        <a class="page-link" href="#">1</a>
                        </li>
                        <li class="page-item">
                        <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item">
                        <a class="page-link" href="#">3</a>
                        </li>
                        <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                        </li>
                    </ul>
                    </nav>
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
                        text: "Setelah dihapus, Anda tidak dapat memulihkan Data ini lagi!",
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