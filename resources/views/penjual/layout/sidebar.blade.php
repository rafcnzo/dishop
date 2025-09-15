<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('backendpenjual/assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Bintang Motor</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>

    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('penjual.dashboard') }}">
                <div class="parent-icon"><i class='bx bx-grid-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-user'></i>
                </div>
                <div class="menu-title">Supplier</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('semua.supplier') }}"><i class="bx bx-right-arrow-alt"></i>List Supplier</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class='bx bx-package'></i>
                </div>
                <div class="menu-title">Data Produk</div>
            </a>
            <ul>
                <li> <a href="{{ route('semua.produk') }}"><i class="bx bx-right-arrow-alt"></i>Daftar Produk</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bx bx-transfer"></i>
                </div>
                <div class="menu-title">Transaksi Penjualan</div>
            </a>
            <ul>
                <li> <a href="{{ route('transaksi.konfirmasi') }}"><i class="bx bx-right-arrow-alt"></i>Konfirmasi
                        Pembayaran</a>
                </li>
                <li> <a href="{{ route('transaksi.riwayat') }}"><i class="bx bx-right-arrow-alt"></i>Riwayat
                        Transaksi</a>
                </li>
            </ul>
        </li>

        <li class="menu-label">Lainnya</li>
        <li>
            <a href="{{ route('laporan.index') }}">
                <div class="parent-icon"><i class="bx bx-bar-chart"></i>
                </div>
                <div class="menu-title">Laporan Penjualan</div>
            </a>
        </li>
        <li>
            <a href="https://themeforest.net/user/codervent" target="_blank">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Bantuan</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>
