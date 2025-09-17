<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MotoGear - Toko Aksesoris Motor Terlengkap')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="{{ asset('backendpenjual/assets/css/pace.min.css') }}" rel="stylesheet" />

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;900&family=Open+Sans:wght@300;400;600&display=swap"
        rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        /* Updated color palette to use green-based colors from pasted-text.txt */
        :root {
            --pakistan-green: #143109;
            --sage: #aaae7f;
            --beige: #d0d6b3;
            --seasalt: #f7f7f7;
            --antiflash-white: #efefef;
            --primary-color: var(--pakistan-green);
            --secondary-color: var(--sage);
            --accent-color: var(--beige);
            --light-bg: var(--seasalt);
            --white-bg: var(--antiflash-white);
        }

        body {
            font-family: 'Open Sans', sans-serif;
            color: var(--pakistan-green);
            background-color: var(--seasalt);
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
        }

        html {
            scroll-behavior: smooth;
        }

        /* Updated button styles with new color palette */
        .btn-primary {
            background-color: var(--pakistan-green);
            border-color: var(--pakistan-green);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--sage);
            border-color: var(--sage);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(20, 49, 9, 0.3);
        }

        .btn-secondary {
            background-color: var(--sage);
            border-color: var(--sage);
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: var(--beige);
            border-color: var(--beige);
            color: var(--pakistan-green);
            transform: translateY(-2px);
        }

        .text-primary {
            color: var(--pakistan-green) !important;
        }

        .bg-light-custom {
            background-color: var(--light-bg);
        }

        /* Updated hero section with new gradient */
        .hero-section {
            background: linear-gradient(135deg, var(--pakistan-green) 0%, var(--sage) 100%);
            min-height: 70vh;
            position: relative;
            overflow: hidden;
        }

        .hero-card {
            background: rgba(247, 247, 247, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            padding: 2rem;
            margin: 1rem;
            transition: all 0.4s ease;
        }

        .hero-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 35px rgba(20, 49, 9, 0.2);
        }

        @media (max-width: 991.98px) {
            .hero-cards-container {
                display: none !important;
            }

            .hero-section {
                min-height: 65vh;
                /* Geser sedikit ke atas */
                padding-top: 2rem;
            }
        }

        .promotion-section {
            background: var(--beige);
            padding: 4rem 0;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: var(--pakistan-green);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
            transition: all 0.3s ease;
        }

        .feature-icon:hover {
            background: var(--sage);
            transform: scale(1.1) rotate(5deg);
        }

        /* Search Results Container */
        #search-results-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-top: 0.25rem;
            max-height: 400px;
            /* Sedikit lebih tinggi */
            overflow-y: auto;
        }

        .search-no-result {
            padding: 1rem;
            text-align: center;
            color: #6c757d;
        }

        .list-group-item {
            border-left: none;
            border-right: none;
        }

        .list-group-item:first-child {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            border-top: none;
        }

        .list-group-item:last-child {
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            border-bottom: none;
        }

        /* Modal backdrop dengan kontras tinggi
        .modal-backdrop.show {
            background: linear-gradient(135deg, rgba(20, 49, 9, 0.95), rgba(255, 255, 0, 0.5));
            backdrop-filter: blur(16px) saturate(200%);
            -webkit-backdrop-filter: blur(16px) saturate(200%);
        } */

        /* Modal dengan background gelap dan elemen terang */
        .modal-content {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: 0 32px 64px -12px rgba(20, 49, 9, 0.45);
            overflow: hidden;
            background: linear-gradient(145deg, #23272f 95%, #181a20 100%);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 2px solid var(--sage);
            position: relative;
        }

        .modal-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--sage) 40%, var(--sage) 60%, transparent);
            z-index: 1;
        }

        .modal-header {
            border: none;
            padding: 2rem 2rem 0;
            background: transparent;
            position: relative;
            z-index: 2;
        }

        .modal-body {
            padding: 1.5rem 2rem 2rem;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .modal-footer {
            border: none;
            padding: 0 2rem 2rem;
            justify-content: center;
            gap: 1rem;
            position: relative;
            z-index: 2;
        }

        /* Modal icon dengan kontras tinggi */
        .modal-icon {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            font-size: 2.5rem;
            position: relative;
            box-shadow: 0 16px 32px rgba(255, 224, 102, 0.25);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: #23272f;
            color: #ffe066;
        }

        .modal-icon::before {
            content: '';
            position: absolute;
            width: 120%;
            height: 120%;
            border-radius: 50%;
            opacity: 0.25;
            animation: ripple 3s infinite;
            z-index: -1;
            background: #ffe066;
        }

        .modal-icon::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.15), transparent);
            z-index: 1;
            pointer-events: none;
        }

        /* Icon sukses */
        .modal-icon-success {
            background: linear-gradient(135deg, #22c55e, #bbf7d0);
            color: #181a20;
            box-shadow: 0 16px 32px rgba(34, 197, 94, 0.3);
        }

        .modal-icon-success::before {
            background: #22c55e;
        }

        /* Icon danger */
        .modal-icon-danger {
            background: linear-gradient(135deg, #ef4444, #fee2e2);
            color: #181a20;
            box-shadow: 0 16px 32px rgba(239, 68, 68, 0.3);
        }

        .modal-icon-danger::before {
            background: #ef4444;
        }

        /* Icon warning (khusus konfirmasi, warna kuning) */
        .modal-icon-warning {
            background: linear-gradient(135deg, #ffe066, #ffd60a);
            color: #23272f;
            box-shadow: 0 16px 32px rgba(255, 224, 102, 0.5);
        }

        .modal-icon-warning::before {
            background: #ffe066;
        }

        /* Icon info */
        .modal-icon-info {
            background: linear-gradient(135deg, #38bdf8, #bae6fd);
            color: #181a20;
            box-shadow: 0 16px 32px rgba(56, 189, 248, 0.3);
        }

        .modal-icon-info::before {
            background: #38bdf8;
        }

        /* Button modern dengan kontras tinggi */
        .btn-modern {
            padding: 1rem 2.5rem;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            position: relative;
            overflow: hidden;
            min-width: 140px;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            font-size: 1rem;
            letter-spacing: 0.025em;
            box-shadow: 0 4px 12px rgba(255, 224, 102, 0.15);
            color: #23272f;
            background: #ffe066;
        }

        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, var(--sage) 60%, transparent);
            transition: left 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-modern:hover::before {
            left: 100%;
        }

        .btn-modern:active {
            transform: translateY(1px) scale(0.98);
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, #ffe066, #ffd60a);
            color: #23272f;
            box-shadow: 0 8px 24px rgba(255, 224, 102, 0.25);
        }

        .btn-primary-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(255, 224, 102, 0.35);
            background: linear-gradient(135deg, #ffd60a, #ffe066);
            color: #181a20;
        }

        .btn-success-modern {
            background: linear-gradient(135deg, #22c55e, #bbf7d0);
            color: #181a20;
            box-shadow: 0 8px 24px rgba(34, 197, 94, 0.2);
        }

        .btn-success-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(34, 197, 94, 0.25);
            background: linear-gradient(135deg, #bbf7d0, #22c55e);
            color: #181a20;
        }

        .btn-danger-modern {
            background: linear-gradient(135deg, #ef4444, #fee2e2);
            color: #181a20;
            box-shadow: 0 8px 24px rgba(239, 68, 68, 0.2);
        }

        .btn-danger-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(239, 68, 68, 0.25);
            background: linear-gradient(135deg, #fee2e2, #ef4444);
            color: #181a20;
        }

        .btn-warning-modern {
            background: linear-gradient(135deg, #ffe066, #ffd60a);
            color: #23272f;
            box-shadow: 0 8px 24px rgba(255, 224, 102, 0.2);
        }

        .btn-warning-modern:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(255, 224, 102, 0.25);
            background: linear-gradient(135deg, #ffd60a, #ffe066);
            color: #181a20;
        }

        .btn-outline-modern {
            background: transparent;
            border: 2px solid var(--sage);
            color: var(--sage);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .btn-outline-modern:hover {
            background: var(--sage);
            border-color: var(--sage);
            transform: translateY(-3px);
            color: #23272f;
            box-shadow: 0 12px 32px rgba(170, 174, 127, 0.25);
            /* rgba dari --sage */
        }

        @keyframes ripple {
            0% {
                transform: scale(1);
                opacity: 0.25;
            }

            50% {
                transform: scale(1.3);
                opacity: 0.08;
            }

            100% {
                transform: scale(1);
                opacity: 0.25;
            }
        }

        @keyframes fadeInScale {
            0% {
                opacity: 0;
                transform: scale(0.85) translateY(20px);
            }

            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        @keyframes slideInFromTop {
            0% {
                opacity: 0;
                transform: translateY(-30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal.show .modal-dialog {
            animation: fadeInScale 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Teks modal lebih kontras */
        .modal-title {
            font-weight: 800;
            font-size: 1.85rem;
            margin-bottom: 0.75rem;
            color: #ffe066;
            line-height: 1.3;
            animation: slideInFromTop 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.2s both;
            text-shadow: 0 2px 8px #181a20;
        }

        .modal-text {
            color: #fff;
            font-size: 1.15rem;
            line-height: 1.7;
            margin-bottom: 0;
            font-weight: 500;
            animation: slideInFromTop 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.3s both;
            text-shadow: 0 1px 4px #181a20;
        }

        @media (max-width: 576px) {
            .modal-dialog {
                margin: 1rem;
            }

            .modal-header {
                padding: 1.5rem 1.5rem 0;
            }

            .modal-body {
                padding: 1rem 1.5rem 1.5rem;
            }

            .modal-footer {
                padding: 0 1.5rem 1.5rem;
                flex-direction: column;
                gap: 0.75rem;
            }

            .btn-modern {
                width: 100%;
                padding: 1rem 2rem;
                font-size: 1rem;
            }

            .modal-icon {
                width: 80px;
                height: 80px;
                font-size: 2rem;
                margin-bottom: 1.5rem;
            }

            .modal-title {
                font-size: 1.3rem;
            }

            .modal-text {
                font-size: 1rem;
            }
        }

        .btn-modern.loading {
            pointer-events: none;
            position: relative;
            color: transparent !important;
        }

        .btn-modern.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top: 2px solid var(--sage);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            color: var(--sage);
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .btn-modern:focus {
            outline: none;
            box-shadow: 0 0 0 3px #ffe06699;
        }

        .btn-close:focus {
            outline: none;
            box-shadow: 0 0 0 3px var(--sage);
        }
    </style>

    @stack('styles')
</head>

<body>
    @include('layouts.partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('layouts.partials.footer')
    <x-dynamic-modal />

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('backendpenjual/assets/js/pace.min.js') }}"></script>

    <!-- Custom JS -->
    <script>
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate__animated');
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.animate-on-scroll').forEach(el => {
                observer.observe(el);
            });
        });

        $(document).ready(function() {

            toastr.options = {
                "closeButton": false,
                "progressBar": true,
                "positionClass": "toast-top-left",
                "timeOut": "2100",
            };

            function updateCartView(response) {
                let offcanvasBody = $('#cart-items-container');
                let cartTotalElement = $('#cart-total');
                let cartBadge = $('#cart-count-badge');
                let checkoutBtn = $('#checkout-btn');

                offcanvasBody.empty();

                if (response.cartItems && Object.keys(response.cartItems).length > 0) {
                    $.each(response.cartItems, function(id, item) {
                        let priceFormatted = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0
                        }).format(item.price);
                        let subtotalFormatted = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0
                        }).format(item.price * item.qty);

                        let cartItemHtml = `
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <img src="${item.image}" width="60" class="rounded me-3">
                    <div>
                        <h6 class="mb-0 small">${item.name}</h6>
                        <small class="text-muted">${priceFormatted}</small>
                        <div class="fw-bold mt-1">${subtotalFormatted}</div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <div class="input-group input-group-sm" style="width: 100px;">
                        <button class="btn btn-outline-secondary qty-change" type="button" data-product-id="${id}" data-action="minus">-</button>
                        <input type="text" class="form-control text-center qty-input" value="${item.qty}" readonly>
                        <button class="btn btn-outline-secondary qty-change" type="button" data-product-id="${id}" data-action="plus">+</button>
                    </div>
                    <button class="btn btn-sm btn-danger ms-2 remove-item-btn" data-product-id="${id}">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>`;
                        offcanvasBody.append(cartItemHtml);
                    });

                    let totalFormatted = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(response.cartTotal);
                    cartTotalElement.text(totalFormatted);

                    checkoutBtn.prop('disabled', false);

                } else {
                    offcanvasBody.html('<p class="text-center text-muted mt-5">Keranjang Anda masih kosong.</p>');
                    cartTotalElement.text('Rp 0');

                    checkoutBtn.prop('disabled', true);
                }

                if (cartBadge.length) {
                    cartBadge.text(response.cartCount > 0 ? response.cartCount : '');
                }
            }

            function sendCartRequest(url, method, data = {}) {
                $.ajax({
                    url: url,
                    method: method,
                    data: {
                        _token: '{{ csrf_token() }}',
                        ...data
                    },
                    success: function(response) {
                        updateCartView(response);
                        if (typeof updateCheckoutTotals === 'function') {
                            updateCheckoutTotals(response);
                        }
                        // Tampilkan notifikasi dari backend jika ada
                        if (response && typeof response.message !== 'undefined') {
                            if (response.success === false) {
                                toastr.error(response.message);
                            } else if (response.success === true) {
                                toastr.success(response.message);
                            }
                        }
                    },
                    error: function(xhr) {
                        // Jika backend mengirim pesan error, tampilkan
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            toastr.error(xhr.responseJSON.message);
                        } else {
                            toastr.error('Terjadi kesalahan. Silakan coba lagi.');
                        }
                    }
                });
            }

            $('#cart-toggle-btn').on('click', function() {
                sendCartRequest('{{ route('cart.items') }}', 'GET');
            });

            $(document).on('click', '.add-to-cart-btn', function(e) {
                e.preventDefault();
                let productId = $(this).data('product-id');
                sendCartRequest(`/cart/add/${productId}`, 'POST');
                toastr.success('Produk berhasil ditambahkan ke keranjang!');
                let offcanvas = document.getElementById('shoppingCartOffcanvas');
                if (offcanvas) {
                    let bsOffcanvas = bootstrap.Offcanvas.getOrCreateInstance(offcanvas);
                    bsOffcanvas.show();
                }
            });

            $(document).on('click', '.qty-change', function() {
                let productId = $(this).data('product-id');
                let action = $(this).data('action');
                let currentQty = parseInt($(this).closest('.input-group').find('.qty-input').val());
                let newQty = (action === 'plus') ? currentQty + 1 : currentQty - 1;

                if (newQty > 0) {
                    sendCartRequest(`/cart/update/${productId}`, 'POST', {
                        quantity: newQty
                    });
                } else {
                    sendCartRequest(`/cart/remove/${productId}`, 'POST');
                }
            });

            $(document).on('click', '.remove-item-btn', function() {
                let productId = $(this).data('product-id');


                showConfirmation(
                    'danger',
                    'Hapus Produk?',
                    'Anda yakin ingin menghapus produk ini dari keranjang?',
                    'Ya, Hapus',
                    'Batal',
                    function() {
                        sendCartRequest(`/cart/remove/${productId}`, 'POST');
                        toastr.info(
                            'Produk telah dihapus dari keranjang.');
                    }
                );
            });

            $(document).on('click', '.btn-cancel-order', function() {
                let productId = $(this).data('product-id');


                showConfirmation(
                    'danger',
                    'Batalkan Pesanan?',
                    'Anda yakin ingin membatalkan pesanan ini?',
                    'Ya, Batalkan',
                    'Batal',
                    function() {
                        $.post(`/order/cancel/${productId}`, {
                            _token: '{{ csrf_token() }}'
                        }, function(response) {
                            toastr.info('Pesanan berhasil dibatalkan.');
                            location.reload();
                        }).fail(function(xhr) {
                            toastr.error('Gagal membatalkan pesanan.');
                        });
                    }
                );
            });

            function debounce(func, delay) {
                let timeout;
                return function(...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), delay);
                };
            }

            $('#search-input').on('keyup', debounce(function() {
                let query = $(this).val();
                let resultsContainer = $('#search-results-container');

                if (query.length > 2) {
                    $.ajax({
                        url: '{{ route('products.search') }}',
                        type: 'GET',
                        data: {
                            'query': query
                        },
                        success: function(data) {
                            resultsContainer.empty().show();
                            if (data.length > 0) {
                                let resultsList = $('<ul class="list-group"></ul>');
                                $.each(data, function(index, product) {
                                    let priceFormatted = new Intl.NumberFormat(
                                        'id-ID', {
                                            style: 'currency',
                                            currency: 'IDR',
                                            minimumFractionDigits: 0
                                        }).format(product.harga);
                                    let actionButton = IS_LOGGED_IN ?
                                        `<button class="btn btn-sm btn-primary add-to-cart-btn" data-product-id="${product.id}">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>` :
                                        `<a href="${LOGIN_URL}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-cart-plus"></i>
                                        </a>`;

                                    let listItem = `
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <img src="${product.image_url}" width="50" class="rounded me-3" alt="${product.nama_barang}">
                                            <div>
                                                <div class="fw-bold">${product.nama_barang}</div>
                                                <small>${priceFormatted}</small>
                                            </div>
                                        </div>
                                        ${actionButton}
                                    </li>`;
                                    resultsList.append(listItem);
                                });
                                resultsContainer.html(resultsList);
                            } else {
                                resultsContainer.html(
                                    '<div class="search-no-result">Tidak ada produk ditemukan.</div>'
                                );
                            }
                        }
                    });
                } else {
                    resultsContainer.empty().hide();
                }
            }, 500));

            $(document).on('click', function(e) {
                if (!$(e.target).closest('#search-input, #search-results-container').length) {
                    $('#search-results-container').empty().hide();
                }
            });

        });

        const IS_LOGGED_IN = @json(Auth::check());
        const LOGIN_URL = "{{ route('login') }}"
    </script>

    @stack('scripts')

</body>

</html>
