@extends('layouts.app')

@section('title', 'Toko Bintang Motor Batam - Toko Aksesoris Motor Terlengkap')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section position-relative overflow-hidden">
        <!-- Added background pattern and improved layout structure -->
        <div class="hero-bg-pattern"></div>
        <div class="container position-relative">
            <div class="row align-items-center min-vh-100 py-5">
                <div class="col-lg-6 order-2 order-lg-1">
                    <div class="hero-content animate__animated animate__fadeInLeft">
                        <div class="hero-badge mb-4">
                            <span class="badge bg-secondary px-3 py-2 rounded-pill">
                                <i class="fas fa-star me-2"></i>
                                Pilihan Favorit Semua Kalangan
                            </span>
                        </div>
                        <h1 class="hero-title mb-4">
                            Aksesoris & Sparepart Motor
                            <span class="text-primary position-relative">
                                Terlengkap
                                <svg class="hero-underline" viewBox="0 0 200 12" fill="none">
                                    <path d="M2 10C50 2 100 2 198 10" stroke="currentColor" stroke-width="3"
                                        stroke-linecap="round" />
                                </svg>
                            </span>
                        </h1>
                        <p class="hero-subtitle mb-5">
                            Temukan berbagai aksesoris motor serta produk sparepart motor berkualitas untuk menunjang
                            kenyamanan dan tampilan motor Anda. Belanja mudah, harga bersaing, dan produk original hanya di
                            <b>Toko Bintang Motor Batam</b>!
                        </p>
                        <div class="hero-actions d-flex flex-wrap gap-3">
                            <a href="#products" class="btn btn-primary btn-lg hero-btn-primary">
                                <i class="fas fa-shopping-bag me-2"></i>
                                Belanja Sekarang
                                <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                            {{-- <a href="#promotion" class="btn btn-outline-light btn-lg hero-btn-secondary">
                                <i class="fas fa-gift me-2"></i>
                                Lihat Promo
                            </a> --}}
                        </div>

                        <!-- Trust indicators -->
                        <div class="hero-stats mt-5 pt-4 border-top border-light border-opacity-25">
                            <div class="row text-center text-lg-start">
                                <div class="col-4">
                                    <div class="stat-item">
                                        <h4 class="text-white mb-1">10K+</h4>
                                        <small class="text-light opacity-75">Pelanggan Puas</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-item">
                                        <h4 class="text-white mb-1">1.000+</h4>
                                        <small class="text-light opacity-75">Produk Otomotif</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-item">
                                        <h4 class="text-white mb-1">24/7</h4>
                                        <small class="text-light opacity-75">Layanan Bantuan</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 order-1 order-lg-2 mb-5 mb-lg-0">
                    <!-- Hero cards untuk aksesoris & sparepart motor -->
                    <div class="hero-cards-container position-relative">
                        <div class="hero-main-card animate__animated animate__fadeInRight">
                            <div class="card hero-featured-card border-0 shadow-lg">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="feature-icon-sm text-white rounded-circle me-3">
                                            <i class="fas fa-helmet-safety text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Helm & Riding Gear</h6>
                                            <small class="text-muted">Standar SNI & Internasional</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="hero-floating-cards">
                            <div
                                class="floating-card floating-card-1 animate__animated animate__fadeInUp animate__delay-1s">
                                <div class="card border-0 shadow">
                                    <div class="card-body text-center p-3">
                                        <i class="fas fa-cogs text-primary fs-4 mb-2"></i>
                                        <h6 class="mb-1">Sparepart Motor</h6>
                                        <small class="text-muted">Asli & Bergaransi</small>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="floating-card floating-card-2 animate__animated animate__fadeInUp animate__delay-2s">
                                <div class="card border-0 shadow">
                                    <div class="card-body text-center p-3">
                                        <i class="fas fa-tools text-primary fs-4 mb-2"></i>
                                        <h6 class="mb-1">Aksesoris Motor</h6>
                                        <small class="text-muted">Lengkap & Stylish</small>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="floating-card floating-card-3 animate__animated animate__fadeInUp animate__delay-3s">
                                <div class="card border-0 shadow">
                                    <div class="card-body text-center p-3">
                                        <i class="fas fa-oil-can text-primary fs-4 mb-2"></i>
                                        <h6 class="mb-1">Oli & Perawatan</h6>
                                        <small class="text-muted">Performa Maksimal</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Added scroll indicator -->
        <div class="scroll-indicator">
            <a href="#products" class="scroll-down">
                <span></span>
                <span></span>
                <span></span>
            </a>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="products-section py-5">
        <div class="container">
            <!-- Header bagian produk kami -->
            <div class="section-header text-center mb-5">
                <div class="section-badge animate-on-scroll animate__fadeInUp">
                    <span class="badge bg-light text-primary px-3 py-2 rounded-pill">
                        <i class="fas fa-box-open me-2"></i>
                        Produk Kami
                    </span>
                </div>
                <h2 class="section-title animate-on-scroll animate__fadeInUp animate__delay-1s">
                    Katalog <span class="text-primary">Produk</span>
                </h2>
                <p class="section-subtitle animate-on-scroll animate__fadeInUp animate__delay-2s">
                    Temukan berbagai produk berkualitas untuk kebutuhan motor Anda hanya di <b>Toko Bintang Motor Batam</b>
                </p>
            </div>

            <!-- Grid produk -->
            <div class="products-grid">
                <div class="row g-4">
                    <!-- Product 1 -->
                    <div class="col-lg-3 col-md-6 animate-on-scroll animate__fadeInUp">
                        <div class="product-card-enhanced">
                            <div class="product-badge">
                                <span class="badge bg-danger">Best Seller</span>
                            </div>
                            <div class="product-image-container">
                                <img src="https://via.placeholder.com/300x240/1a5f3f/ffffff?text=AGV+Helmet" alt="Helm AGV"
                                    class="product-image">
                                <div class="product-overlay">
                                    <div class="product-actions">
                                        <button class="btn btn-light btn-sm rounded-circle">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                        <button class="btn btn-light btn-sm rounded-circle">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="product-category">
                                    <small class="text-muted">Helmet</small>
                                </div>
                                <h6 class="product-title">Helm AGV K1 Solid</h6>
                                <p class="product-description">
                                    Helm full face dengan standar keamanan internasional DOT & SNI
                                </p>
                                <div class="product-price-section">
                                    <div class="price-container">
                                        <span class="current-price">Rp 1.250.000</span>
                                        <span class="original-price">Rp 1.450.000</span>
                                    </div>
                                    <div class="discount-badge">
                                        -14%
                                    </div>
                                </div>
                                <button class="btn btn-primary product-btn w-100">
                                    <i class="fas fa-cart-plus me-2"></i>
                                    Pesan Sekarang !!!
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 2 -->
                    <div class="col-lg-3 col-md-6 animate-on-scroll animate__fadeInUp animate__delay-1s">
                        <div class="product-card-enhanced">
                            <div class="product-badge">
                                <span class="badge bg-success">New Arrival</span>
                            </div>
                            <div class="product-image-container">
                                <img src="https://via.placeholder.com/300x240/87a96b/ffffff?text=Respiro+Jacket"
                                    alt="Jaket Touring" class="product-image">
                                <div class="product-overlay">
                                    <div class="product-actions">
                                        <button class="btn btn-light btn-sm rounded-circle">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                        <button class="btn btn-light btn-sm rounded-circle">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="product-category">
                                    <small class="text-muted">Jacket</small>
                                </div>
                                <h6 class="product-title">Jaket Touring Respiro</h6>
                                <p class="product-description">
                                    Jaket anti angin dengan protector lengkap dan ventilasi udara
                                </p>
                                <div class="product-price-section">
                                    <div class="price-container">
                                        <span class="current-price">Rp 850.000</span>
                                    </div>
                                </div>
                                <button class="btn btn-primary product-btn w-100">
                                    <i class="fas fa-cart-plus me-2"></i>
                                    Pesan Sekarang !!!
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 3 -->
                    <div class="col-lg-3 col-md-6 animate-on-scroll animate__fadeInUp animate__delay-2s">
                        <div class="product-card-enhanced">
                            <div class="product-image-container">
                                <img src="https://via.placeholder.com/300x240/c7d2cc/ffffff?text=Taichi+Gloves"
                                    alt="Sarung Tangan" class="product-image">
                                <div class="product-overlay">
                                    <div class="product-actions">
                                        <button class="btn btn-light btn-sm rounded-circle">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                        <button class="btn btn-light btn-sm rounded-circle">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="product-category">
                                    <small class="text-muted">Gloves</small>
                                </div>
                                <h6 class="product-title">Sarung Tangan Taichi</h6>
                                <p class="product-description">
                                    Sarung tangan kulit premium dengan protector knuckle carbon
                                </p>
                                <div class="product-price-section">
                                    <div class="price-container">
                                        <span class="current-price">Rp 320.000</span>
                                        <span class="original-price">Rp 380.000</span>
                                    </div>
                                    <div class="discount-badge">
                                        -16%
                                    </div>
                                </div>
                                <button class="btn btn-primary product-btn w-100">
                                    <i class="fas fa-cart-plus me-2"></i>
                                    Pesan Sekarang !!!
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Product 4 -->
                    <div class="col-lg-3 col-md-6 animate-on-scroll animate__fadeInUp animate__delay-3s">
                        <div class="product-card-enhanced">
                            <div class="product-badge">
                                <span class="badge bg-warning text-dark">Limited</span>
                            </div>
                            <div class="product-image-container">
                                <img src="https://via.placeholder.com/300x240/f8f9fa/1a5f3f?text=Alpinestars+Boots"
                                    alt="Sepatu Boots" class="product-image">
                                <div class="product-overlay">
                                    <div class="product-actions">
                                        <button class="btn btn-light btn-sm rounded-circle">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                        <button class="btn btn-light btn-sm rounded-circle">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <div class="product-category">
                                    <small class="text-muted">Boots</small>
                                </div>
                                <h6 class="product-title">Sepatu Boots Alpinestars</h6>
                                <p class="product-description">
                                    Sepatu touring waterproof dengan proteksi ankle dan toe
                                </p>
                                <div class="product-price-section">
                                    <div class="price-container">
                                        <span class="current-price">Rp 1.150.000</span>
                                    </div>
                                </div>
                                <button class="btn btn-primary product-btn w-100">
                                    <i class="fas fa-cart-plus me-2"></i>
                                    Pesan Sekarang !!!
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA produk -->
            <div class="products-cta text-center mt-5 pt-4">
                <div class="animate-on-scroll animate__fadeInUp">
                    <p class="mb-4 text-muted">Lihat koleksi lengkap kami dengan lebih dari 500+ produk berkualitas di
                        <b>Toko Bintang Motor Batam</b>
                    </p>
                    <a href="#" class="btn btn-outline-primary btn-lg px-5 cta-btn">
                        <i class="fas fa-th-large me-2"></i>
                        Jelajahi Semua Produk
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Promotion Section -->
    <section id="promotion" class="promotion-section">
        <div class="container">
            <div class="text-center mb-5 animate-on-scroll animate__fadeInUp">
                <h2 class="display-5 fw-bold text-primary mb-3">Mengapa Pilih Toko Bintang Motor Batam?</h2>
                <p class="lead text-muted">Kepercayaan ribuan bikers di seluruh Indonesia</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6 text-center animate-on-scroll animate__fadeInUp">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h5 class="fw-semibold mb-3">Produk Original</h5>
                    <p class="text-muted">
                        Semua produk dijamin 100% original dari distributor resmi.
                        Garansi resmi dan sertifikat keaslian tersedia.
                    </p>
                </div>

                <div class="col-lg-4 col-md-6 text-center animate-on-scroll animate__fadeInUp animate__delay-1s">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h5 class="fw-semibold mb-3">Pengiriman Cepat</h5>
                    <p class="text-muted">
                        Pengiriman ke seluruh Indonesia dengan jaminan aman.
                        Same day delivery untuk area Batam dan sekitarnya.
                    </p>
                </div>

                <div class="col-lg-4 col-md-6 text-center animate-on-scroll animate__fadeInUp animate__delay-2s">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h5 class="fw-semibold mb-3">Customer Service 24/7</h5>
                    <p class="text-muted">
                        Tim customer service yang siap membantu Anda kapan saja.
                        Konsultasi gratis untuk pemilihan produk yang tepat.
                    </p>
                </div>

                <div class="col-lg-4 col-md-6 text-center animate-on-scroll animate__fadeInUp animate__delay-3s">
                    <div class="feature-icon">
                        <i class="fas fa-medal"></i>
                    </div>
                    <h5 class="fw-semibold mb-3">Kualitas Terjamin</h5>
                    <p class="text-muted">
                        Produk telah melewati quality control ketat dan memiliki
                        standar keamanan internasional untuk perlindungan maksimal.
                    </p>
                </div>

                <div class="col-lg-4 col-md-6 text-center animate-on-scroll animate__fadeInUp animate__delay-4s">
                    <div class="feature-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h5 class="fw-semibold mb-3">Pembayaran Mudah</h5>
                    <p class="text-muted">
                        Berbagai pilihan metode pembayaran: transfer bank, e-wallet,
                        kartu kredit, hingga cicilan 0% untuk pembelian tertentu.
                    </p>
                </div>

                <div class="col-lg-4 col-md-6 text-center animate-on-scroll animate__fadeInUp animate__delay-5s">
                    <div class="feature-icon">
                        <i class="fas fa-undo-alt"></i>
                    </div>
                    <h5 class="fw-semibold mb-3">Garansi Pengembalian</h5>
                    <p class="text-muted">
                        Tidak puas? Kembalikan dalam 7 hari dengan kondisi barang
                        masih baik. Proses refund cepat dan mudah.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
