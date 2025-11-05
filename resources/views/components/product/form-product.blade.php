<div>
    <button type="button" class="btn {{ $id ? 'btn-default' : 'btn-primary' }}" data-toggle="modal"
        data-target="#formProduct{{ $id ?? '' }}">
        {{ $id ? 'Edit' : 'Produk Baru' }}
    </button>
    <div class="modal fade" id="formProduct{{ $id ?? '' }}">
        <form action="{{ route('master-data.product.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $id ?? '' }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ $id ? 'Forn Edit Product' : 'Form Product Baru' }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group my-1">
                            <label for="">Nama Product</label>
                            <input type="text" name="nama_product" id="nama_product" class="form-control"
                                value="{{ $id ? $nama_product : old('nama_product') }}">
                        </div>
                        <div class="form-group my-1">
                            <label for="">Harga</label>
                            <input type="number" name="harga" id="harga" class="form-control"
                                value="{{ $id ? $harga : old('harga') }}">
                        </div>
                        <div class="form-group my-1">
                            <label for="">Stok</label>
                            <input type="number" name="stok" id="stok" class="form-control"
                                value="{{ $id ? $stok : old('stok') }}">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </form>
    </div>
    <!-- /.modal -->

</div>
