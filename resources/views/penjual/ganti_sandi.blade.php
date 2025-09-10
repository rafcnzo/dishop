@extends('penjual.dashboard_penjual')
@section('penjual')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Penjual</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Ganti Sandi</li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcrumb-->
<div class="container">
    <div class="main-body">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('update.sandi') }}" enctype="multipart/form-data">
                        @csrf

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Sandi Lama</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="password" name="sandi_lama" class="form-control @error('sandi_lama') is-invalid @enderror" id="sandi_lama" placeholder="Sandi Lama" />
                                @error('sandi_lama')
                                <span class="text-danger">{{ $message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Sandi Baru</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="password" name="sandi_baru" class="form-control @error('sandi_baru') is-invalid @enderror" id="sandi_baru" placeholder="Sandi Baru" />
                                @error('sandi_baru')
                                <span class="text-danger">{{ $message}}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Konfirmasi Sandi Baru</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <input type="password" name="sandi_baru_confirmation" class="form-control" id="sandi_baru_confirmation" placeholder="Ketik Ulang Sandi Baru" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9 text-secondary">
                                <input type="submit" class="btn btn-primary px-4" value="Save Changes" />
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
</script>

@endsection
