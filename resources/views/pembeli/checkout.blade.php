@extends('layouts.app')

@section('title', 'Checkout - Payment')

@push('styles')
    <style>
        /* Color Variables */
        :root {
            --pakistan-green: #1a5f3f;
            --sage: #aabe7f;
            --beige: #c7d2cc;
            --seasalt: #f8f9fa;
            --antiflash-white: #f1f3f4;
        }

        /* Header Styles */
        .payment-header {
            background: linear-gradient(135deg, var(--pakistan-green) 0%, var(--sage) 100%);
            position: relative;
            overflow: hidden;
            padding: 4rem 0;
            margin-bottom: 2rem;
        }

        .payment-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                linear-gradient(45deg, rgba(255, 255, 255, 0.1) 25%, transparent 25%),
                linear-gradient(-45deg, rgba(255, 255, 255, 0.1) 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, rgba(255, 255, 255, 0.1) 75%),
                linear-gradient(-45deg, transparent 75%, rgba(255, 255, 255, 0.1) 75%);
            background-size: 30px 30px;
            background-position: 0 0, 0 15px, 15px -15px, -15px 0px;
            opacity: 0.3;
        }

        .payment-header .container {
            position: relative;
            z-index: 2;
        }

        .payment-header h1 {
            color: white;
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .payment-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        /* Payment Steps */
        .payment-steps {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(26, 95, 63, 0.1);
            margin-bottom: 2rem;
            border: 1px solid var(--beige);
        }

        .step-indicator {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .step-indicator::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--beige);
            z-index: 1;
            transform: translateY(-50%);
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            background: white;
            padding: 0 1rem;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }

        .step.active .step-number {
            background: var(--pakistan-green);
            color: white;
            box-shadow: 0 0 0 4px rgba(26, 95, 63, 0.2);
        }

        .step.completed .step-number {
            background: var(--sage);
            color: white;
        }

        .step.pending .step-number {
            background: var(--beige);
            color: var(--pakistan-green);
        }

        .step-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--pakistan-green);
            text-align: center;
        }

        /* Payment Cards */
        .payment-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(26, 95, 63, 0.1);
            border: 1px solid var(--beige);
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .payment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(26, 95, 63, 0.15);
        }

        .payment-card h3 {
            color: var(--pakistan-green);
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .payment-card h3 i {
            font-size: 1.2rem;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            color: var(--pakistan-green);
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            border: 2px solid var(--beige);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--seasalt);
        }

        .form-control:focus {
            border-color: var(--pakistan-green);
            box-shadow: 0 0 0 0.2rem rgba(26, 95, 63, 0.25);
            background: white;
        }

        .form-select {
            border: 2px solid var(--beige);
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--seasalt);
        }

        .form-select:focus {
            border-color: var(--pakistan-green);
            box-shadow: 0 0 0 0.2rem rgba(26, 95, 63, 0.25);
            background: white;
        }

        /* Payment Methods */
        .payment-method {
            border: 2px solid var(--beige);
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            background: var(--seasalt);
        }

        .payment-method:hover {
            border-color: var(--sage);
            background: white;
        }

        .payment-method.selected {
            border-color: var(--pakistan-green);
            background: rgba(26, 95, 63, 0.05);
        }

        .payment-method input[type="radio"] {
            margin-right: 0.75rem;
        }

        .payment-method-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .payment-method-icon {
            width: 40px;
            height: 40px;
            background: var(--pakistan-green);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        /* Order Summary */
        .order-summary {
            background: linear-gradient(135deg, var(--seasalt) 0%, white 100%);
            border-radius: 15px;
            padding: 2rem;
            border: 1px solid var(--beige);
            position: sticky;
            top: 2rem;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid var(--beige);
        }

        .order-item:last-child {
            border-bottom: none;
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--pakistan-green);
        }

        .order-item img {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 1rem;
        }

        /* Buttons */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--pakistan-green) 0%, var(--sage) 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(26, 95, 63, 0.3);
            color: white;
        }

        .btn-secondary-custom {
            background: transparent;
            border: 2px solid var(--beige);
            border-radius: 10px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            color: var(--pakistan-green);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-secondary-custom:hover {
            background: var(--beige);
            color: var(--pakistan-green);
            transform: translateY(-2px);
        }

        /* Security Badge */
        .security-badge {
            background: rgba(26, 95, 63, 0.1);
            border: 1px solid var(--sage);
            border-radius: 10px;
            padding: 1rem;
            text-align: center;
            margin-top: 1rem;
        }

        .security-badge i {
            color: var(--pakistan-green);
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .security-badge p {
            color: var(--pakistan-green);
            font-size: 0.9rem;
            margin: 0;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .payment-header h1 {
                font-size: 2rem;
            }

            .payment-card {
                padding: 1.5rem;
            }

            .step-indicator {
                flex-direction: column;
                gap: 1rem;
            }

            .step-indicator::before {
                display: none;
            }

            .order-summary {
                position: static;
                margin-top: 2rem;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate__fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate__delay-1s {
            animation-delay: 0.2s;
        }

        .animate__delay-2s {
            animation-delay: 0.4s;
        }
    </style>
@endpush

@section('content')
    <!-- Header Section -->
    <div class="payment-header">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h1 class="animate__animated animate__fadeInUp">Secure Checkout</h1>
                    <p class="animate__animated animate__fadeInUp animate__delay-1s">Complete your purchase safely and
                        securely</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Payment Steps -->
        <div class="payment-steps animate__animated animate__fadeInUp">
            <div class="step-indicator">
                <div class="step completed">
                    <div class="step-number">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="step-label">Cart Review</div>
                </div>
                <div class="step active">
                    <div class="step-number">2</div>
                    <div class="step-label">Payment Info</div>
                </div>
                <div class="step pending">
                    <div class="step-number">3</div>
                    <div class="step-label">Confirmation</div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Payment Form -->
            <div class="col-lg-12">
                <form id="paymentForm" action="{{ route('order.place') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="order-summary" style="display: flex; flex-direction: column;">
                                <h3 style="color: var(--pakistan-green); margin-bottom: 1.5rem;">
                                    <i class="fas fa-shopping-cart"></i> Daftar Produk
                                </h3>
                                <div style="flex: 1 1 auto;">
                                    @forelse ($cartItems as $item)
                                        <div class="order-item align-items-center mb-3"
                                            style="display: flex; justify-content: space-between; gap: 1rem;">
                                            <div class="d-flex align-items-center" style="gap: 1rem;">
                                                <img src="{{ $item->image }}" alt="{{ $item->name }}"
                                                    style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                                <div>
                                                    <div class="fw-bold">{{ $item->name }}</div>
                                                    <div class="text-muted small">Harga Satuan: Rp
                                                        {{ number_format($item->price, 0, ',', '.') }}</div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center" style="gap: 1rem;">
                                                <div>
                                                    <label for="qty_{{ $item->id }}" class="form-label mb-0"
                                                        style="font-size: 0.9rem;">Qty</label>
                                                    <div class="input-group input-group-sm" style="width: 100px;">
                                                        {{-- Tombol minus dan plus --}}
                                                        <button class="btn btn-outline-secondary qty-change" type="button"
                                                            data-product-id="{{ $item->id }}"
                                                            data-action="minus">-</button>
                                                        <input type="text" id="qty_{{ $item->id }}"
                                                            class="form-control text-center qty-input"
                                                            value="{{ $item->qty }}" readonly
                                                            data-price="{{ $item->price }}">
                                                        <button class="btn btn-outline-secondary qty-change" type="button"
                                                            data-product-id="{{ $item->id }}"
                                                            data-action="plus">+</button>
                                                    </div>
                                                </div>
                                                <div class="fw-bold subtotal-text"
                                                    style="min-width: 120px; text-align: right;">
                                                    Rp {{ number_format($item->price * $item->qty, 0, ',', '.') }}
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center text-muted" style="margin-top: 100px;">Keranjang kosong
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ringkasan Total & Tombol Lanjutkan Pembayaran -->
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="order-summary mb-3" style="margin: 0 auto;">
                                <div class="order-item d-flex justify-content-between align-items-center">
                                    <span><strong>Total Pembayaran</strong></span>
                                    <span><strong id="totalPembayaranText">Rp
                                            {{ number_format($grandTotal, 0, ',', '.') }}</strong></span>
                                </div>
                                <div class="d-grid gap-2 mt-3">
                                    <button type="submit" form="paymentForm" class="btn btn-primary-custom btn-lg">
                                        <i class="fas fa-lock me-2"></i>Lanjutkan Pembayaran
                                    </button>
                                    <a href="#" onclick="history.back(); return false;"
                                        class="btn btn-secondary-custom">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali
                                    </a>
                                </div>
                                <div class="security-badge mt-3">
                                    <i class="fas fa-shield-alt"></i>
                                    <p>Informasi pembayaran Anda terenkripsi &amp; aman</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // NAMA FUNGSI KITA STANDARKAN MENJADI updateCheckoutTotals
            function updateCheckoutTotals(response) {
                if (!response || !response.cartItems) return;

                const totalPembayaranText = document.getElementById('totalPembayaranText');

                // Loop melalui semua input di halaman
                document.querySelectorAll('.qty-input').forEach(input => {
                    const productId = input.id.split('_')[1];

                    // Cek data dari server
                    if (response.cartItems[productId]) {
                        const serverItem = response.cartItems[productId];
                        input.value = serverItem.qty; // Update Qty dari server

                        const price = parseFloat(input.getAttribute('data-price'));
                        const subtotal = price * serverItem.qty;
                        const subtotalElement = input.closest('.order-item').querySelector(
                        '.subtotal-text');
                        if (subtotalElement) {
                            subtotalElement.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
                        }
                    } else {
                        input.closest('.order-item').remove();
                    }
                });

                // Update Total Keseluruhan dari server
                if (totalPembayaranText) {
                    totalPembayaranText.textContent = 'Rp ' + response.cartTotal.toLocaleString('id-ID');
                }
            }

            // Event listener untuk tombol +/-
            document.querySelectorAll('.qty-change').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.stopImmediatePropagation(); // Mencegah script ganda

                    const productId = this.dataset.productId;
                    const action = this.dataset.action;
                    const input = this.parentElement.querySelector('.qty-input');
                    let currentQty = parseInt(input.value);
                    let newQty = (action === 'plus') ? currentQty + 1 : currentQty - 1;

                    let url = '';
                    let data = {};

                    if (newQty > 0) {
                        url = `/cart/update/${productId}`;
                        data = {
                            quantity: newQty
                        };
                    } else {
                        url = `/cart/remove/${productId}`;
                    }

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            ...data
                        },
                        success: function(response) {
                            // HANYA PANGGIL FUNGSI LOKAL UNTUK HALAMAN INI
                            updateCheckoutTotals(response);

                            // DAN PANGGIL FUNGSI GLOBAL UNTUK UPDATE BADGE KERANJANG
                            // (Kita asumsikan updateCartView sudah ada di app.blade.php)
                            if (typeof updateCartView === 'function') {
                                // Cukup update badge-nya saja, tidak perlu render ulang semua
                                const cartBadge = $('#cart-count-badge');
                                if (cartBadge.length) {
                                    cartBadge.text(response.cartCount > 0 ? response
                                        .cartCount : '');
                                }
                            }
                        },
                        error: function() {
                            toastr.error('Gagal memperbarui kuantitas.');
                        }
                    });
                });
            });

            updateCheckoutTotals({
                cartItems: @json($cartItems->keyBy('id')),
                cartTotal: @json($grandTotal)
            });
        });
    </script>
@endpush
