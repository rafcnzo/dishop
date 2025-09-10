@extends('penjual.dashboard_penjual')
@section('penjual')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Supplier</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah Supplier</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <button type="button" class="btn btn-primary">Settings</button>
                <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
                    <a class="dropdown-item" href="javascript:;">Another action</a>
                    <a class="dropdown-item" href="javascript:;">Something else here</a>
                    <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
                </div>
            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <form id="myForm" method="POST" action="{{ route('simpan.supplier') }}" enctype="multipart/form-data">
            @csrf
        <div class="card-body p-4">
            <div class="form-body mt-4">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="border border-3 p-4 rounded">
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama_supplier" class="form-control" id="nama_supplier" placeholder="Ketik Nama Supplier">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-control">
                                    <option value="">-- Jenis Kelamin --</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Telpon</label>
                                <input type="text" name="phone" class="form-control" id="phone" placeholder="Ketik Nomor Telpon">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" class="form-control" id="alamat" rows="3" placeholder="Ketik Alamat"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Foto</label>
                                <input id="foto_profil" type="file" class="form-control" name="foto_profil" onchange="mainThamUrl(this)" accept="image/*">
                                <br/>
                                <img src="" id="mainThumb" />
                            </div>
                            <div class="col-12">
                            <div class="d-grid">
                                <input type="submit" class="btn btn-primary px-4" value="Simpan Supplier" />
                            </div>
                        </div>
                        </div>
                    </div>
                </div><!--end row-->
            </div>
        </div>
        </form>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function (){
        $('#myForm').validate({
            rules: {
                nama_supplier: { required : true },
                jenis_kelamin: { required : true },
                phone: { required : true },
                alamat: { required : true },
            },
            messages :{
                nama_supplier: { required : 'Silakan isi nama supplier!' },
                jenis_kelamin: { required : 'Silakan pilih jenis kelamin!' },
                phone: { required : 'Silakan isi nomor telpon!' },
                alamat: { required : 'Silakan isi alamat!' },
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
