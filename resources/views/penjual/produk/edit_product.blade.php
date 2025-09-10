@extends('penjual.dashboard_penjual')
@section('penjual')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Produk</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Produk</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <a href="{{ route('semua.produk') }}" class="btn btn-primary">Semua Produk</a>
            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body p-4">
            <form id="myForm" method="POST" action="{{ route('update.produk') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-body mt-4">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="border border-3 p-4 rounded">
                                <div class="form-group mb-3">
                                    <input type="hidden" name="id" value="{{ $pro->id }}">
                                    <label class="form-label">Kode Produk</label>
                                    <input type="text" name="kode_barang" class="form-control" id="kode_barang" value="{{ $pro->kode_barang }}" placeholder="Kode Produk" disabled>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Nama Produk</label>
                                    <input type="text" name="nama_produk" class="form-control" id="nama_produk" value="{{ $pro->nama_barang }}" placeholder="Ketik Nama Produk">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" id="deskripsi" rows="3" placeholder="Ketik Deskripsi">{{ $pro->deskripsi }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Foto Produk</label>
                                    <input id="foto_produk" type="file" class="form-control" name="foto_produk" onchange="mainThamUrl(this)" accept="image/*" multiple>
                                </div>
                                <div class="mb-3">
                                    <img id="mainThumb" src="{{ (!empty($pro->image)) ?
                                    url('upload/images_produk/'.$pro->image):url('upload/no_image_jpg') }}" style="width: 100px; height: 100px;"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="border border-3 p-4 rounded">
                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label">Stok</label>
                                        <input type="text" name="stok" class="form-control" id="stok" value="{{ $pro->stok }}" placeholder="0">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Harga</label>
                                        <input type="text" name="harga" class="form-control" id="harga" value="{{ $pro->harga }}" placeholder="0">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Supplier</label>
                                        <select name="supplier" class="form-select" id="supplier">
                                            <option value="">-- Pilih Supplier --</option>
                                            @foreach ($supplier as $sup)
                                                <option value="{{ $sup->id }}" {{  $pro->supplier_id == $sup->id ? 'selected' : '' }}>{{ $sup->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <input type="submit" class="btn btn-primary px-4" value="Simpan Produk" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--end row-->
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                nama_produk: { required : true },
                deskripsi: { required : true },
                stok: { required : true },
                harga: { required : true },
                supplier: { required : true },
            },
            messages :{
                nama_produk: { required : 'Silakan isi nama produk!' },
                deskripsi: { required : 'Silakan isi deskripsi produk!' },
                stok: { required : 'Silakan isi jumlah stok!' },
                harga: { required : 'Silakan isi harga produk!' },
                supplier: { required : 'Silakan pilih supplier produk!' },
            },
            errorElement : 'span',
            errorReplacement: function (error,element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        });
    });

    function mainThamUrl(i) {
        if(i.files && i.files[0]) {
            var reader = new FileReader();
                reader.onload = function(e) {
                    $('#mainThumb').attr('src', e.target.result).width(80).height(80);
                };
                reader.readAsDataURL(i.files[0]);
        }
    }
</script>

@endsection()
