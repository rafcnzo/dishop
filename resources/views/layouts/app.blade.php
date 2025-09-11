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

        #search-results-container {
            z-index: 1050;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 0 0 .275rem .275rem;
            overflow: hidden;
        }

        .search-result-item {
            padding: 0.75rem 1rem;
        }

        .search-result-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: .25rem;
        }

        .search-no-result {
            padding: 1rem;
            background-color: #fff;
            color: #6c757d;
            border: 1px solid #dee2e6;
            border-top: none;
            border-radius: 0 0 .375rem .375rem;
        }
    </style>
</head>

<body>
    @include('layouts.partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('layouts.partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Custom JS -->
    <script>
        // Initialize animations on scroll
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
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000", // 3 detik
            };

            // --- FUNGSI UTAMA UNTUK ME-RENDER TAMPILAN KERANJANG ---
            function updateCartView(response) {
                let offcanvasBody = $('#cart-items-container');
                let cartTotalElement = $('#cart-total');
                let checkoutForm = $('#checkout-form-container');
                let cartBadge = $('#cart-count-badge');

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
                    if (checkoutForm.length) checkoutForm.show();
                } else {
                    offcanvasBody.html('<p class="text-center text-muted mt-5">Keranjang Anda masih kosong.</p>');
                    cartTotalElement.text('Rp 0');
                    if (checkoutForm.length) checkoutForm.hide();
                }

                if (cartBadge.length) {
                    cartBadge.text(response.cartCount > 0 ? response.cartCount : '');
                }
            }

            // --- FUNGSI UNTUK MENGIRIM REQUEST AJAX KERANJANG ---
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
                    },
                    error: function() {
                        // GANTI alert DENGAN toastr.error
                        toastr.error('Terjadi kesalahan. Silakan coba lagi.');
                    }
                });
            }

            // --- EVENT LISTENERS UNTUK KERANJANG ---
            $('#cart-toggle-btn').on('click', function() {
                sendCartRequest('{{ route('cart.items') }}', 'GET');
            });

            $(document).on('click', '.add-to-cart-btn', function(e) {
                e.preventDefault();
                let productId = $(this).data('product-id');
                sendCartRequest(`/cart/add/${productId}`, 'POST');
                toastr.success('Produk berhasil ditambahkan ke keranjang!');
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
                if (confirm('Anda yakin ingin menghapus item ini?')) {
                    let productId = $(this).data('product-id');
                    sendCartRequest(`/cart/remove/${productId}`, 'POST');
                }
            });


            // =================================================================
            // BAGIAN PENCARIAN PRODUK (SEARCH)
            // =================================================================

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
                                    let listItem = `
                                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center search-result-item">
                                    <img src="${product.image_url}" class="me-3 search-result-img" alt="${product.nama_barang}">
                                    <div>
                                        <div class="fw-bold">${product.nama_barang}</div>
                                        <small>${priceFormatted}</small>
                                    </div>
                                </a>`;
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
    </script>

    @stack('scripts')
</body>

</html>
