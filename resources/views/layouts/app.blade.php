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
    </script>

    @stack('scripts')
</body>

</html>
