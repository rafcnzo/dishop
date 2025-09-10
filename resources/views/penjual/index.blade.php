@extends('penjual.dashboard_penjual')
@section('penjual')
<div class="page-content">
    <div class="row mb-3">
        <div class="col">
            <div class="card radius-10 bg-gradient-deepblue">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 text-white">{{ $produk }}</h5>
                        <div class="ms-auto">
                            <i class='bx bx-package fs-3 text-white'></i>
                        </div>
                    </div>
                    <div class="progress my-3 bg-light-transparent" style="height:3px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex align-items-center text-white">
                        <p class="mb-0">Total Produk</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 bg-gradient-ohhappiness">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 text-white">{{ $users }}</h5>
                        <div class="ms-auto">
                            <i class='bx bx-group fs-3 text-white'></i>
                        </div>
                    </div>
                    <div class="progress my-3 bg-light-transparent" style="height:3px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex align-items-center text-white">
                        <p class="mb-0">Total Users</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10 bg-gradient-deepblue">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h5 class="mb-0 text-white">{{ $transaksi }}</h5>
                        <div class="ms-auto">
                            <i class='bx bx-cart fs-3 text-white'></i>
                        </div>
                    </div>
                    <div class="progress my-3 bg-light-transparent" style="height:3px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width: 55%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex align-items-center text-white">
                        <p class="mb-0">Total Orders</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="card radius-10 bg-gradient-deepblue">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0 text-white">30 Hari Terakhir</h6>
                        <div class="ms-auto">
                            <i class='bx bx-calendar fs-3 text-white'></i>
                        </div>
                    </div>
                    <div class="mt-3 mb-2">
                        <span class="text-white fw-bold" style="font-size: 2rem;">
                            {{ is_numeric($total30hari) ? 'Rp ' . number_format($total30hari, 0, ',', '.') : $total30hari }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="card radius-10 bg-gradient-orange">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0 text-white">Total Pesanan</h6>
                        <div class="ms-auto">
                            <i class='bx bx-dollar fs-3 text-white'></i>
                        </div>
                    </div>
                    <div class="mt-3 mb-2">
                        <span class="text-white fw-bold" style="font-size: 2rem;">
                            {{ is_numeric($totalorders) ? 'Rp ' . number_format($totalorders, 0, ',', '.') : $totalorders }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="card radius-10 bg-gradient-ohhappiness">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0 text-white">Pesanan Hari Ini</h6>
                        <div class="ms-auto">
                            <i class='bx bx-box fs-3 text-white'></i>
                        </div>
                    </div>
                    <div class="mt-3 mb-2">
                        <span class="text-white fw-bold" style="font-size: 2rem;">
                            {{ is_numeric($totaltoday) ? 'Rp ' . number_format($totaltoday, 0, ',', '.') : $totaltoday }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
