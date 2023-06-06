@foreach ($legalisir as $legalisir)
  <div class="modal fade" tabindex="-1" role="dialog" id="edit{{$legalisir->id}}">
    <div class="modal-dialog" role="document">
        <form id="myForm" class="forms-sample" enctype="multipart/form-data" action="{{route('update-status-legalisir', $legalisir->id)}}" method="POST">
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

                                <option value="Menunggu Konfirmasi"
                                    {{ old('status', @$legalisir->status) == 'Menunggu Konfirmasi' ? 'selected' : '' }}>
                                        Menunggu Konfirmasi</option>
                                <option value="Diproses"
                                    {{ old('status', @$legalisir->status) == 'Diproses' ? 'selected' : '' }}>
                                        Diproses</option>
                                <option value="Selesai"
                                    {{ old('status', @$legalisir->status) == 'Selesai' ? 'selected' : '' }}>
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