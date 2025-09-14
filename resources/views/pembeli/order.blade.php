@extends('layouts.app')

@section('title', 'Pesanan Saya - Toko Bintang Motor Batam')

@push('styles')
    <style>
        /* Color Variables - Enhanced Contrast */
        :root {
            --pakistan-green: #0d4a2c;
            --sage: #7a9a5a;
            --beige: #b8c5b8;
            --seasalt: #f5f7f5;
            --antiflash-white: #e8ebe8;
            --dark-text: #1a1a1a;
            --medium-text: #333333;
            --light-text: #555555;
        }

        .section-title::after {
            content: "";
            position: absolute;
            width: 100px;
            height: 4px;
            bottom: -15px;
            left: 0;
            transform: none;
            background: linear-gradient(90deg, var(--sage), white);
            border-radius: 3px;
            box-shadow: 0 2px 8px rgba(13, 74, 44, 0.3);
            animation: slideIn 0.8s ease-out;
        }

        @keyframes slideIn {
            0% {
                width: 0;
                opacity: 0;
            }
            100% {
                width: 100px;
                opacity: 1;
            }
        }

        /* Enhanced Page Styling */
        .orders-page {
            background: linear-gradient(135deg, var(--seasalt) 0%, #ffffff 50%, var(--antiflash-white) 100%);
            min-height: 100vh;
        }

        .page-header {
            background: linear-gradient(135deg, var(--pakistan-green) 0%, #1a5f3f 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            opacity: 0.4;
        }

        .page-header .container {
            position: relative;
            z-index: 2;
        }

        .section-badge {
            display: inline-block;
            margin-bottom: 1rem;
        }

        .section-badge .badge1 {
            background: var(--pakistan-green);
            color: var(--seasalt);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            backdrop-filter: blur(10px);
            border: 1px solid var(--beige);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            color: white;
        }

        .section-subtitle {
            font-size: 1.1rem;
            opacity: 0.95;
            max-width: 600px;
            color: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        /* Enhanced Order Cards */
        .order-card {
            background: var(--pakistan-green);
            border: 1px solid var(--sage);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(13, 74, 44, 0.25);
            transition: all 0.3s ease;
            overflow: hidden;
            color: var(--seasalt);
            margin-bottom: 2rem;
        }

        .order-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(13, 74, 44, 0.4);
            border-color: var(--beige);
        }

        .order-card-header {
            background: linear-gradient(135deg, var(--pakistan-green) 0%, var(--sage) 100%);
            padding: 1.5rem;
            border-bottom: 2px solid var(--beige);
        }

        .order-id {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--seasalt);
            margin-bottom: 0.5rem;
        }

        .order-date {
            color: #f5f5f5;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .order-status-badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid;
        }

        .status-pending {
            background: #fff8e1;
            color: #e65100;
            border-color: #ffcc02;
        }

        .status-processing {
            background: #e3f2fd;
            color: #0d47a1;
            border-color: #2196f3;
        }

        .status-shipped {
            background: #e8f5e8;
            color: #1b5e20;
            border-color: #4caf50;
        }

        .status-completed {
            background: #e0f2f1;
            color: #00695c;
            border-color: #009688;
        }

        .status-cancelled {
            background: #ffebee;
            color: #b71c1c;
            border-color: #f44336;
        }

        /* Enhanced Stepper */
        .order-stepper {
            padding: 2rem;
            background: #fafafa;
        }

        .stepper-wrapper {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 2rem 0;
        }

        .stepper-item {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            text-align: center;
        }

        .stepper-item::before {
            position: absolute;
            content: "";
            height: 3px;
            background: #d0d0d0;
            width: 100%;
            top: 25px;
            left: -50%;
            z-index: 1;
        }

        .stepper-item::after {
            position: absolute;
            content: "";
            height: 3px;
            background: linear-gradient(90deg, var(--pakistan-green), var(--sage));
            width: 100%;
            top: 25px;
            left: -50%;
            z-index: 2;
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.6s ease;
        }

        .stepper-item:first-child::before,
        .stepper-item:first-child::after {
            display: none;
        }

        .step-counter {
            position: relative;
            z-index: 3;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: white;
            border: 3px solid #d0d0d0;
            margin-bottom: 1rem;
            transition: all 0.4s ease;
            font-size: 1.2rem;
            color: #666;
        }

        .stepper-item.completed .step-counter {
            background: linear-gradient(135deg, var(--pakistan-green), var(--sage));
            border-color: var(--pakistan-green);
            color: white;
            transform: scale(1.1);
        }

        .stepper-item.active .step-counter {
            border-color: var(--pakistan-green);
            color: var(--pakistan-green);
            background: white;
            box-shadow: 0 0 0 4px rgba(13, 74, 44, 0.15);
            animation: pulse 2s infinite;
        }

        .stepper-item.completed::after {
            transform: scaleX(1);
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 4px rgba(13, 74, 44, 0.15);
            }

            50% {
                box-shadow: 0 0 0 8px rgba(13, 74, 44, 0.08);
            }

            100% {
                box-shadow: 0 0 0 4px rgba(13, 74, 44, 0.15);
            }
        }

        .step-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--medium-text);
            margin-bottom: 0.25rem;
        }

        .stepper-item.active .step-name {
            color: var(--pakistan-green);
        }

        .stepper-item.completed .step-name {
            color: var(--pakistan-green);
        }

        .step-description {
            font-size: 0.75rem;
            color: var(--light-text);
        }

        /* Order Info Section */
        .order-info-section {
            padding: 2rem;
            background: white;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-item {
            text-align: center;
            padding: 1rem;
            background: var(--seasalt);
            border-radius: 12px;
            border: 1px solid var(--beige);
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--pakistan-green), var(--sage));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.75rem;
            font-size: 1.1rem;
        }

        .info-label {
            font-size: 0.8rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--pakistan-green);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--pakistan-green), var(--sage));
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26, 95, 63, 0.3);
            color: white;
        }

        /* Custom Success Button */
        .btn-success-custom {
            background: linear-gradient(135deg, #28a745, #7a9a5a); /* Hijau sukses ke sage */
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-success-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.25);
            color: white;
        }

        .btn-outline-custom {
            background: transparent;
            border: 2px solid var(--pakistan-green);
            color: var(--pakistan-green);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-outline-custom:hover {
            background: var(--pakistan-green);
            color: white;
            transform: translateY(-2px);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(26, 95, 63, 0.08);
        }

        .empty-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--beige), var(--sage));
            color: var(--pakistan-green);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2.5rem;
        }

        /* Cancelled Order State */
        .cancelled-state {
            text-align: center;
            padding: 3rem 2rem;
            background: linear-gradient(135deg, #f8f9fa, #fff5f5);
            border-radius: 12px;
            border: 1px solid #f5c6cb;
        }

        .cancelled-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
        }

        /* Modal Enhancements */
        .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background: var(--pakistan-green);
            color: white;
            border-radius: 16px 16px 0 0;
            padding: 1.5rem;
        }

        .modal-title {
            font-weight: 700;
        }

        .btn-close {
            filter: invert(1);
        }

        .list-group-item {
            border: none;
            border-bottom: 1px solid var(--beige);
            padding: 1rem;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .section-title {
                font-size: 2rem;
            }

            .stepper-wrapper {
                flex-direction: column;
                gap: 1rem;
            }

            .stepper-item::before,
            .stepper-item::after {
                display: none;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
@endpush

@section('content')
    <div class="orders-page">
        <!-- Enhanced Page Header -->
        <div class="page-header">
            <div class="container">
                <div class="section-badge">
                    <span class="badge1 animate__animated animate__fadeInDown">
                        <i class="fas fa-receipt me-2"></i> Riwayat Transaksi
                    </span>
                </div>
                <h1 class="section-title animate__animated animate__fadeInUp">Pesanan Saya</h1>
                <p class="section-subtitle animate__animated animate__fadeInUp animate__delay-1s">
                    Lacak dan lihat detail semua pesanan yang pernah Anda buat di Toko Bintang Motor Batam.
                </p>
            </div>
        </div>

        <div class="container pb-5">
            <div class="orders-list-container">
                @forelse ($orders as $order)
                    @php
                        $steps = [
                            [
                                'status' => 'pending',
                                'name' => 'Pesanan Dibuat',
                                'icon' => 'fa-file-invoice-dollar',
                                'desc' => 'Pesanan telah dibuat',
                            ],
                            [
                                'status' => 'menunggu konfirmasi',
                                'name' => 'Menunggu Konfirmasi',
                                'icon' => 'fa-clock',
                                'desc' => 'Menunggu konfirmasi penjual',
                            ],
                            [
                                'status' => 'diproses',
                                'name' => 'Diproses',
                                'icon' => 'fa-box-open',
                                'desc' => 'Sedang dipersiapkan',
                            ],
                            [
                                'status' => 'diterima',
                                'name' => 'Diterima',
                                'icon' => 'fa-handshake',
                                'desc' => 'Pesanan diterima pembeli',
                            ],
                            [
                                'status' => 'selesai',
                                'name' => 'Selesai',
                                'icon' => 'fa-check-circle',
                                'desc' => 'Pesanan selesai',
                            ],
                        ];
                        $currentStatusIndex = array_search($order->timeline_status, array_column($steps, 'status'));
                    @endphp

                    <div class="order-card animate__animated animate__fadeInUp">
                        <!-- Order Header -->
                        <div class="order-card-header">
                            <div class="d-flex justify-content-between align-items-start flex-wrap">
                                <div>
                                    <div class="order-id">#{{ $order->id }}</div>
                                    <div class="order-date">
                                        <i class="fas fa-calendar-alt me-1"></i>
                                        {{ \Carbon\Carbon::parse($order->waktu_transaksi)->format('d M Y, H:i') }}
                                    </div>
                                </div>
                                <span class="order-status-badge status-{{ $order->timeline_status }}">
                                    {{ $order->status_text }}
                                </span>
                            </div>
                        </div>

                        <!-- Order Info Grid -->
                        <div class="order-info-section">
                            <div class="info-grid">
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-shopping-cart"></i>
                                    </div>
                                    <div class="info-label">Total Items</div>
                                    <div class="info-value">{{ $order->items->count() }} Produk</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-icon">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </div>
                                    <div class="info-label">Total Pembayaran</div>
                                    <div class="info-value">Rp {{ number_format($order->total, 0, ',', '.') }}</div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                <button type="button" class="btn-primary-custom" data-bs-toggle="modal"
                                    data-bs-target="#orderDetailsModal" data-order-id="{{ $order->id }}"
                                    data-order-items='@json($order->items)'
                                    data-order-total="Rp {{ number_format($order->total, 0, ',', '.') }}"
                                    data-invoice-url="#">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </button>
                                <a href="#" class="btn-outline-custom">
                                    <i class="fas fa-download"></i> Download Invoice
                                </a>
                                @if($order->timeline_status == 'pending')
                                    <a href="{{ route('payment.confirmation', $order->id) }}" class="btn btn-success-custom">
                                        <i class="fas fa-credit-card"></i> Lakukan Pembayaran
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Order Stepper -->
                        <div class="order-stepper">
                            <h6 class="text-muted small text-uppercase fw-bold mb-3">
                                <i class="fas fa-route me-2"></i>Lacak Pesanan
                            </h6>

                            @if ($order->timeline_status == 'cancelled')
                                <div class="cancelled-state">
                                    <div class="cancelled-icon">
                                        <i class="fas fa-times-circle"></i>
                                    </div>
                                    <h5 class="text-danger mb-2">Pesanan Dibatalkan</h5>
                                    <p class="text-muted mb-0">Pesanan ini telah dibatalkan dan tidak dapat diproses lebih lanjut.</p>
                                </div>
                            @else
                                <div class="stepper-wrapper">
                                    @foreach ($steps as $index => $step)
                                        <div
                                            class="stepper-item {{ $index <= $currentStatusIndex ? 'completed' : '' }} {{ $index == $currentStatusIndex ? 'active' : '' }}">
                                            <div class="step-counter">
                                                @if ($index < $currentStatusIndex)
                                                    <i class="fas fa-check"></i>
                                                @else
                                                    <i class="fas {{ $step['icon'] }}"></i>
                                                @endif
                                            </div>
                                            <div class="step-name">{{ $step['name'] }}</div>
                                            <div class="step-description">{{ $step['desc'] }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="empty-state animate__animated animate__fadeInUp">
                        <div class="empty-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h4 class="fw-bold text-primary mb-3">Anda Belum Memiliki Pesanan</h4>
                        <p class="text-muted mb-4">
                            Sepertinya Anda belum pernah melakukan transaksi.<br>
                            Ayo mulai belanja sekarang dan temukan produk terbaik kami!
                        </p>
                        <a href="{{ url('/') }}" class="btn-primary-custom">
                            <i class="fas fa-shopping-bag"></i> Mulai Belanja
                        </a>
                    </div>
                @endforelse

                <!-- Pagination -->
                @if ($orders->hasPages())
                    <div class="d-flex justify-content-center mt-5">
                        <nav aria-label="Navigasi halaman pesanan">
                            {{ $orders->onEachSide(1)->links() }}
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Enhanced Order Details Modal -->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailsModalLabel">
                        <i class="fas fa-receipt me-2"></i>Detail Pesanan
                        <span class="badge bg-light text-dark ms-2" id="modal-order-id"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 class="text-muted small text-uppercase fw-bold mb-3">
                        <i class="fas fa-list me-2"></i>Daftar Produk
                    </h6>
                    <div id="modal-order-items" class="list-group">
                        <!-- Items will be populated by JavaScript -->
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted">Total Pembayaran:</span>
                        <strong class="fs-5 ms-2" style="color: var(--pakistan-green);" id="modal-order-total"></strong>
                    </div>
                    <a href="#" id="modal-invoice-btn" class="btn-primary-custom" target="_blank">
                        <i class="fas fa-file-invoice"></i> Lihat Invoice
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS animations if available
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 800,
                    easing: 'ease-in-out',
                    once: true
                });
            }

            // Modal functionality
            var orderDetailsModal = document.getElementById('orderDetailsModal');
            orderDetailsModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;

                var orderId = button.getAttribute('data-order-id');
                var orderItems = JSON.parse(button.getAttribute('data-order-items'));
                var orderTotal = button.getAttribute('data-order-total');
                var invoiceUrl = button.getAttribute('data-invoice-url');

                var modalTitleId = orderDetailsModal.querySelector('#modal-order-id');
                var modalItemsContainer = orderDetailsModal.querySelector('#modal-order-items');
                var modalTotal = orderDetailsModal.querySelector('#modal-order-total');
                var modalInvoiceBtn = orderDetailsModal.querySelector('#modal-invoice-btn');

                modalItemsContainer.innerHTML = '';
                modalTitleId.textContent = '#' + orderId;
                modalTotal.textContent = orderTotal;
                modalInvoiceBtn.setAttribute('href', invoiceUrl);

                orderItems.forEach(function(item, index) {
                    var itemHtml = `
                        <div class="list-group-item d-flex align-items-center">
                            <img src="${item.image_url}" alt="${item.nama_barang}" 
                                 class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover; border: 2px solid var(--beige);">
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1" style="color: var(--pakistan-green);">${item.nama_barang}</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">Qty: ${item.qty}</small>
                                    <span class="fw-bold" style="color: var(--pakistan-green);">
                                        Rp ${new Intl.NumberFormat('id-ID').format(item.harga)}
                                    </span>
                                </div>
                            </div>
                        </div>
                    `;
                    modalItemsContainer.insertAdjacentHTML('beforeend', itemHtml);
                });
            });

            // Add smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });
    </script>
@endpush
