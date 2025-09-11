<div class="col-lg-3 col-md-6 animate-on-scroll animate__fadeInUp">
    <div class="product-card-enhanced d-flex flex-column h-100">
        
        @if ($product->is_bestseller ?? false)
            <div class="product-badge"><span class="badge bg-danger">Best Seller</span></div>
        @elseif ($product->is_new ?? false)
            <div class="product-badge"><span class="badge bg-success">New Arrival</span></div>
        @endif

        <div class="product-image-container">
            <img src="{{ $product->image ? asset('upload/images_produk/' . $product->image) : asset('images/no-image.png') }}"
                 alt="{{ $product->name }}"
                 class="product-image">
            <div class="product-overlay">
            </div>
        </div>

        <div class="product-content d-flex flex-column flex-grow-1">
            <h6 class="product-title">{{ $product->name }}</h6>
            <p class="product-description">{{ Str::limit($product->description, 50) }}</p>
            
            <div class="product-price-section">
                <div class="price-container">
                    <span class="current-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="mt-auto">
                <button class="btn btn-primary product-btn w-100 add-to-cart-btn" data-product-id="{{ $product->id }}">
                    <i class="fas fa-cart-plus me-2"></i> Pesan Sekarang
                </button>
            </div>
        </div>
    </div>
</div>