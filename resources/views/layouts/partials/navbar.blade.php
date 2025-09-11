<!-- Added hover effects and updated styling for navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top custom-navbar">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary brand-hover" href="{{ url('/') }}">
            <img src="{{ asset('backendpenjual/assets/images/favicon-32x32.png') }}" alt="Logo Toko Bintang Motor Batam"
                width="32" height="32" class="me-2 align-text-top">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link fw-semibold nav-link-hover" href="{{ url('/') }}">Beranda</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold nav-link-hover" href="#" role="button"
                        data-bs-toggle="dropdown">
                        Kategori
                    </a>
                    <ul class="dropdown-menu custom-dropdown">
                        <li><a class="dropdown-item dropdown-item-hover" href="#">Helm</a></li>
                        <li><a class="dropdown-item dropdown-item-hover" href="#">Jaket & Pelindung</a></li>
                        <li><a class="dropdown-item dropdown-item-hover" href="#">Aksesoris Motor</a></li>
                        <li><a class="dropdown-item dropdown-item-hover" href="#">Spare Part</a></li>
                        <li><a class="dropdown-item dropdown-item-hover" href="#">Oli & Perawatan</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold nav-link-hover" href="#">Promo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fw-semibold nav-link-hover" href="#">Tentang Kami</a>
                </li>
            </ul>

            <div class="d-flex align-items-center">
                <form class="d-flex me-3" role="search">
                    <input class="form-control me-2 search-input" type="search" placeholder="Cari produk..."
                        style="width: 250px;">
                    <button class="btn btn-outline-primary search-btn" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                @guest
                    {{-- Tampilkan jika pengguna adalah tamu (belum login) --}}
                    <a href="{{ route('login') }}" class="btn btn-primary login-btn">
                        <i class="fas fa-user me-1"></i>
                        Masuk
                    </a>
                @else
                    {{-- Tampilkan jika pengguna sudah login --}}
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-semibold d-flex align-items-center" href="#"
                            role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-2 fs-5"></i>
                            {{ Auth::user()->username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end custom-dropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i> Keluar
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
