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
                                class="floating-card floating-card-1 animate__animated animate__fadeInLeft animate__delay-1s">
                                <div class="card border-0 shadow">
                                    <div class="card-body text-center p-3">
                                        <i class="fas fa-cogs text-primary fs-4 mb-2"></i>
                                        <h6 class="mb-1">Sparepart Motor</h6>
                                        <small class="text-muted">Asli & Bergaransi</small>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="floating-card floating-card-2 animate__animated animate__fadeInLeft animate__delay-2s">
                                <div class="card border-0 shadow">
                                    <div class="card-body text-center p-3">
                                        <i class="fas fa-tools text-primary fs-4 mb-2"></i>
                                        <h6 class="mb-1">Aksesoris Motor</h6>
                                        <small class="text-muted">Lengkap & Stylish</small>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="floating-card floating-card-3 animate__animated animate__fadeInLeft animate__delay-3s">
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
                {{-- Beri ID pada row ini agar mudah ditarget oleh JavaScript --}}
                <div class="row g-4" id="product-grid">
                    @foreach ($products as $product)
                        @include('layouts.partials._product_card', ['product' => $product])
                    @endforeach
                </div>
            </div>

            <!-- CTA produk -->
            <div class="products-cta text-center mt-5 pt-4">
                <div class="animate-on-scroll animate__fadeInUp">
                    <p class="mb-4 text-muted">Lihat koleksi lengkap kami dengan lebih dari 500+ produk berkualitas di
                        <b>Toko Bintang Motor Batam</b>
                    </p>
                    <button id="load-more-btn" class="btn btn-outline-primary btn-lg px-5 cta-btn" data-page="2">
                        <i class="fas fa-th-large me-2"></i>
                        <span>Jelajahi Lebih Banyak</span>
                        <i class="fas fa-arrow-right ms-2"></i>
                    </button>
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
@push('scripts') {{-- Jika Anda menggunakan stack 'scripts' di layout --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#load-more-btn').on('click', function() {
        const btn = $(this);
        let page = btn.data('page');
        const originalText = btn.find('span').text();

        $.ajax({
            url: '{{ route("products.load_more") }}',
            type: 'GET',
            data: { 
                page: page 
            },
            beforeSend: function() {
                // Tampilkan status loading
                btn.prop('disabled', true);
                btn.find('span').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memuat...');
            },
            success: function(response) {
                if (response.html.trim() !== '') {
                    $('#product-grid').append(response.html);
                    btn.data('page', page + 1);

                    if (!response.hasMore) {
                        btn.hide();
                    }
                } else {
                    btn.hide();
                }
            },
            error: function(xhr, status, error) {
                console.error("Terjadi kesalahan: ", error);
                alert('Gagal memuat produk. Silakan coba lagi.');
            },
            complete: function() {
                btn.prop('disabled', false);
                btn.find('span').text(originalText);
            }
        });
    });
});
</script>
@endpush
