<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toko Bintang Motor Batam</title>
    <link rel="icon" href="{{ asset('backendpenjual/assets/images/favicon-32x32.png') }}" type="image/png" />
    <link href="{{ asset('backendpenjual/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <link href="{{ asset('backendpenjual/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('backendpenjual/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('backendpenjual/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backendpenjual/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('backendpenjual/assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('backendpenjual/assets/js/pace.min.js') }}"></script>
    <link href="{{ asset('backendpenjual/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backendpenjual/assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('backendpenjual/assets/css/icons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backendpenjual/assets/css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('backendpenjual/assets/css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('backendpenjual/assets/css/header-colors.css') }}" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    <style>
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            z-index: 9999;
            transition: opacity 0.3s ease;
        }

        .glass-spinner {
            width: 60px;
            height: 60px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top: 3px solid #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        .loading-text {
            color: white;
            margin-top: 20px;
            font-size: 16px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .hidden {
            opacity: 0;
            pointer-events: none;
        }
    </style>
</head>

<body>
    <div id="loading-overlay" class="hidden">
        <div class="glass-spinner"></div>
        <div class="loading-text">Loading...</div>
    </div>

    <div class="wrapper">
        @include('penjual.layout.sidebar')
        @include('penjual.layout.header')

        <div class="page-wrapper">
            @yield('penjual')
        </div>

        <div class="overlay toggle-icon"></div>
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        @include('penjual.layout.footer')
    </div>
    <script src="{{ asset('backendpenjual/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backendpenjual/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('backendpenjual/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('backendpenjual/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backendpenjual/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('backendpenjual/assets/plugins/chartjs/js/Chart.min.js') }}"></script>
    <script src="{{ asset('backendpenjual/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backendpenjual/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
    <script src="{{ asset('backendpenjual/assets/js/index.js') }}"></script>
    <script src="{{ asset('backendpenjual/assets/js/app.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        function showLoading() {
            document.getElementById('loading-overlay').classList.remove('hidden');
        }

        function hideLoading() {
            document.getElementById('loading-overlay').classList.add('hidden');
        }
    </script>

    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;
                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;
                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;
                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>

    <script>
        $(document).ready(function() {
            // Inisialisasi ulang MetisMenu untuk memastikan ia berjalan
            if ($.fn.metisMenu) {
                $('#menu').metisMenu();
            }
        });
    </script>

    @yield('script')
</body>

</html>
