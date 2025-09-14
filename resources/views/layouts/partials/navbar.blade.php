<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top custom-navbar">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary brand-hover" href="{{ url('/') }}">
            <img src="{{ asset('backendpenjual/assets/images/favicon-32x32.png') }}" alt="Logo Toko" width="32"
                height="32" class="me-2 align-text-top">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link fw-semibold nav-link-hover" href="{{ url('/') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold nav-link-hover" href="{{ url('/#products') }}">Produk</a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link fw-semibold nav-link-hover" href="{{ route('orders') }}">Pesanan Saya</a>
                    </li>
                @endauth
            </ul>

            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item me-2 position-relative" style="width: 350px;">
                    <form class="d-flex align-items-center" role="search" action="{{-- route('search.page') --}}"
                        method="GET">
                        <span class="position-absolute"
                            style="left: 12px; top: 50%; transform: translateY(-50%); color: #adb5bd;">
                            <i class="fas fa-search"></i>
                        </span>
                        <input class="form-control search-input ps-5" type="search" id="search-input"
                            placeholder="Cari helm, jaket, oli..." style="width: 100%;" autocomplete="off">
                    </form>
                    <div class="position-absolute w-100" id="search-results-container" style="z-index: 999;"></div>
                </li>

                @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-primary login-btn">
                            <i class="fas fa-user me-1"></i> Login
                        </a>
                    </li>
                @else
                    <li class="nav-item d-flex align-items-center">
                        <button type="button" class="btn btn-outline-secondary me-3" id="cart-toggle-btn"
                            data-bs-toggle="offcanvas" data-bs-target="#shoppingCartOffcanvas">
                            <i class="fas fa-shopping-cart"></i>
                        </button>

                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#"
                                role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2 fs-5"></i>
                                {{ Auth::user()->username }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end custom-dropdown">
                                <li>
                                    <a class="dropdown-item dropdown-item-hover" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> Keluar
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf</form>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

@auth
    <div class="offcanvas offcanvas-end" tabindex="-1" id="shoppingCartOffcanvas" aria-labelledby="shoppingCartLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="shoppingCartLabel">Keranjang Belanja</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div id="cart-items-container">
            </div>
        </div>

        <div class="offcanvas-footer p-3 border-top">
            <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
                <span>Total:</span>
                <span id="cart-total">Rp 0</span>
            </div>

            <div class="d-grid">
                <form action="{{ route('checkout.process') }}" method="POST" class="d-grid">
                    @csrf
                    <button type="submit" id="checkout-btn" class="btn btn-primary fw-bold" disabled>
                        Lanjutkan ke Checkout
                    </button>
                </form>
            </div>
        </div>
    </div>
@endauth
