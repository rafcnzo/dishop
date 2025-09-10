<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ asset('backendpenjual/assets/images/favicon-32x32.png') }}" type="image/png" />
    <!--plugins-->
    <link href="{{ asset('backendpenjual/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />
    <link href="{{ asset('backendpenjual/assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('backendpenjual/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('backendpenjual/assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
    <!-- loader-->
    <link href="{{ asset('backendpenjual/assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('backendpenjual/assets/js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('backendpenjual/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backendpenjual/assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('backendpenjual/assets/css/icons.css') }}" rel="stylesheet">
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ asset('backendpenjual/assets/css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('backendpenjual/assets/css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ asset('backendpenjual/assets/css/header-colors.css') }}" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    <!-- DataTables CDN Style CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">

    <title>Toko Bintang Motor Batam</title>
    <style>
        /* Style untuk loading overlay */
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

        /* Glassmorphism Spinner */
        .glass-spinner {
            width: 60px;
            height: 60px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top: 3px solid #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        /* Loading Text */
        .loading-text {
            color: white;
            margin-top: 20px;
            font-size: 16px;
            font-weight: 300;
            letter-spacing: 2px;
            text-transform: uppercase;
            opacity: 0.8;
            animation: pulse-text 2s ease-in-out infinite;
        }

        /* Animations */
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes pulse-text {

            0%,
            100% {
                opacity: 0.8;
            }

            50% {
                opacity: 1;
            }
        }

        /* Hide loading */
        .hidden {
            opacity: 0;
            pointer-events: none;
        }
    </style>
</head>

<body>
    <!-- Loading Overlay -->
    <div id="loading-overlay" class="hidden">
        <div class="glass-spinner"></div>
        <div class="loading-text">Loading...</div>
    </div>
    <!--wrapper-->
    <div class="wrapper">
        <!--sidebar wrapper -->
        @include('penjual.layout.sidebar')
        <!--end sidebar wrapper -->
        <!--start header -->
        @include('penjual.layout.header')
        <!--end header -->
        <!--start page wrapper -->
        <div class="page-wrapper">
            @yield('penjual')
        </div>
        <!--end page wrapper -->


        <!--start overlay-->
        <div class="overlay toggle-icon"></div>
        <!--end overlay-->
        <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i
                class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->
        @include('penjual.layout.footer')
    </div>
    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="{{ asset('backendpenjual/assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('backendpenjual/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('backendpenjual/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backendpenjual/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('backendpenjual/assets/plugins/chartjs/js/Chart.min.js') }}"></script>
    <script src="{{ asset('backendpenjual/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('backendpenjual/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <script src="{{ asset('backendpenjual/assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
    <script src="{{ asset('backendpenjual/assets/plugins/sparkline-charts/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('backendpenjual/assets/plugins/jquery-knob/excanvas.js') }}"></script>
    <script src="{{ asset('backendpenjual/assets/plugins/jquery-knob/jquery.knob.js') }}"></script>
    <script>
        $(function() {
            $(".knob").knob();
        });
    </script>
    <script src="{{ asset('backendpenjual/assets/js/index.js') }}"></script>
    {{-- validate form --}}
    <script src="{{ asset('backendpenjual/assets/js/validate.min.js') }}"></script>
    {{-- DataTables CDN JS --}}
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>

    <!-- tinyMCE editor -->
    {{-- <script src='https://cdn.tiny.cloud/1/vdqx2klew412up5bcbpwivg1th6nrh3murc6maz8bukgos4v/tinymce/5/tinymce.min.js' referrerpolicy="origin"> --}}
    <script src="https://cdn.tiny.cloud/1/s9wgtdul2jhms926xeyvocanuq0wf1ok0f4p4ozkzob47bdb/tinymce/8/tinymce.min.js"
        referrerpolicy="origin" crossorigin="anonymous"></script>
    </script>
    <script>
        tinymce.init({
            selector: '#mytextarea'
        });
    </script>

    <!--app JS-->
    <script src="{{ asset('backendpenjual/assets/js/app.js') }}"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Tampilkan loading overlay hanya saat showLoading() dipanggil
        function showLoading() {
            const overlay = document.getElementById('loading-overlay');
            overlay.classList.remove('hidden');
        }

        // Sembunyikan loading overlay
        function hideLoading() {
            const overlay = document.getElementById('loading-overlay');
            overlay.classList.add('hidden');
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

    @yield('script')

</body>

</html>
