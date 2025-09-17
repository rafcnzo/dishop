<style>
    /* Navbar Custom Styles */
    .custom-navbar {
        transition: all 0.3s ease;
    }

    .brand-hover:hover {
        transform: scale(1.05);
        transition: transform 0.2s ease;
    }

    .nav-link-hover:hover {
        color: #0d6efd !important;
        transform: translateY(-1px);
        transition: all 0.2s ease;
    }

    .search-input {
        border-radius: 25px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }

    .login-btn {
        border-radius: 25px;
        transition: all 0.3s ease;
    }

    .login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(13, 110, 253, 0.3);
    }

    .custom-dropdown {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border: none;
    }

    .dropdown-item-hover:hover {
        background: linear-gradient(45deg, #0d6efd, #6610f2);
        color: white;
        transform: translateX(5px);
        transition: all 0.2s ease;
    }

    /* Desktop Styles */
    @media (min-width: 992px) {
        .search-container {
            width: 300px;
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .cart-btn {
            min-width: auto;
            border-radius: 15%;
        }

        .user-dropdown {
            min-width: 150px;
        }
    }

    /* Tablet Styles */
    @media (min-width: 768px) and (max-width: 991.98px) {
        .search-container {
            width: 250px;
            margin-bottom: 1rem;
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            width: 100%;
        }

        .cart-btn {
            flex: 0 0 auto;
            border-radius: 10%;
        }

        .user-dropdown {
            flex: 1;
        }
    }

    /* Mobile Styles */
    @media (max-width: 767.98px) {
        .custom-navbar .navbar-brand img {
            width: 28px !important;
            height: 28px !important;
        }

        .custom-navbar .navbar-brand {
            font-size: 1.1rem;
        }

        .search-container {
            width: 100%;
            margin-bottom: 1rem;
            order: 1;
        }

        .main-nav {
            order: 2;
            margin-bottom: 1rem;
        }

        .user-actions {
            order: 3;
            width: 100%;
        }

        .navbar-collapse {
            padding-top: 1rem;
        }

        .user-actions .cart-btn {
            width: 100%;
            margin-bottom: 0.75rem;
        }

        .user-actions .dropdown {
            width: 100%;
        }

        .user-actions .dropdown-toggle {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .user-actions .dropdown-menu {
            width: 100%;
            margin-top: 0.5rem;
        }

        .login-btn {
            width: 100%;
        }

        .nav-link {
            padding: 0.75rem 0;
            border-bottom: 1px solid #f8f9fa;
        }

        .nav-link:last-child {
            border-bottom: none;
        }
    }

    /* Extra Small Mobile */
    @media (max-width: 575.98px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .search-input {
            font-size: 0.9rem;
            padding: 0.5rem 0.75rem 0.5rem 2.5rem;
        }

        .cart-btn {
            border-radius: 16px;
            width: 40px;
            height: 40px;
            font-size: 1.1rem;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.5rem;
        }

        .search-input::placeholder {
            font-size: 0.85rem;
        }

        .navbar-brand {
            font-size: 1rem;
        }
    }

    /* Search Results Container */
    #search-results-container {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        margin-top: 0.25rem;
        max-height: 300px;
        overflow-y: auto;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top custom-navbar">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand fw-bold text-primary brand-hover d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('backendpenjual/assets/images/favicon-32x32.png') }}" alt="Logo Toko" width="32"
                height="32" class="me-2">
            {{-- <span class="d-none d-sm-inline">TokoKu</span> --}}
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Main Navigation -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 main-nav">
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

            <!-- Right Side Actions -->
            <div class="navbar-nav ms-auto">
                <!-- Search Bar -->
                <div class="nav-item search-container position-relative me-3">
                    <form class="d-flex align-items-center" role="search" action="{{-- route('search.page') --}}"
                        method="GET">
                        <div class="position-relative w-100">
                            <span class="position-absolute"
                                style="left: 12px; top: 50%; transform: translateY(-50%); color: #adb5bd; z-index: 5;">
                                <i class="fas fa-search"></i>
                            </span>
                            <input class="form-control search-input ps-5" type="search" id="search-input"
                                placeholder="Cari helm, jaket, oli..." autocomplete="off">
                        </div>
                    </form>
                    <div class="position-absolute w-100" id="search-results-container" style="z-index: 999;"></div>
                </div>

                <!-- User Actions -->
                <div class="user-actions">
                    @guest
                        <!-- Guest Actions -->
                        <a href="{{ route('login') }}" class="btn btn-primary login-btn">
                            <i class="fas fa-user me-1"></i> Login
                        </a>
                    @else
                        <!-- Authenticated Actions -->
                        <!-- Cart Button -->
                        <button type="button" class="btn btn-outline-secondary cart-btn" id="cart-toggle-btn"
                            data-bs-toggle="offcanvas" data-bs-target="#shoppingCartOffcanvas">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="d-sm-none ms-2">Keranjang</span>
                        </button>

                        <!-- User Dropdown -->
                        <div class="dropdown user-dropdown">
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
    </div>
</nav>

@auth
    <!-- Shopping Cart Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="shoppingCartOffcanvas" aria-labelledby="shoppingCartLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="shoppingCartLabel">
                <i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <div id="cart-items-container" class="p-3">
                <!-- Cart items will be loaded here -->
            </div>
        </div>
        <div class="offcanvas-footer p-3 border-top bg-light">
            <div class="d-flex justify-content-between fw-bold fs-5 mb-3">
                <span>Total:</span>
                <span id="cart-total" class="text-primary">Rp 0</span>
            </div>
            <div class="d-grid">
                <form action="{{ route('checkout.process') }}" method="POST" class="d-grid">
                    @csrf
                    <button type="submit" id="checkout-btn" class="btn btn-primary fw-bold py-2" disabled>
                        <i class="fas fa-credit-card me-2"></i>Lanjutkan ke Checkout
                    </button>
                </form>
            </div>
        </div>
    </div>
@endauth

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
            link.addEventListener('click', (event) => {
                if (link.classList.contains('dropdown-toggle')) {
                    return;
                }

                const navbarCollapse = document.querySelector('.navbar-collapse');
                if (navbarCollapse && navbarCollapse.classList.contains('show')) {
                    const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                        toggle: false
                    });
                    bsCollapse.hide();
                }
            });
        });

        const searchInput = document.getElementById('search-input');
        const searchResults = document.getElementById('search-results-container');

        searchInput.addEventListener('focus', function() {
        });

        document.addEventListener('click', function(e) {
            const searchContainer = document.querySelector('.search-container');
            if (searchContainer && !searchContainer.contains(e.target)) {
                searchResults.style.display = 'none';
            }
        });
    });
</script>
