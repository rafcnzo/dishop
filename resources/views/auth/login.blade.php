<!doctype html>
<html lang="id">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="{{ asset('backendpenjual/assets/images/favicon-32x32.png') }}" type="image/png" />
    <!--plugins-->
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
    <title>Login</title>
</head>

<body class="bg-login">
    <!--wrapper-->
    <div class="wrapper">
        <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
            <div class="container-fluid">
                <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                    <div class="col mx-auto">
                        <div class="mb-4 text-center">
                            <img src="{{ asset('backendpenjual/assets/images/logo-img.png') }}" width="180"
                                alt="" />
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="border p-4 rounded">
                                    <div class="text-center">
                                        <h3 class="">Masuk</h3>
                                    </div>
                                    @if (session('error'))
                                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                            {{ session('error') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <div class="form-body">
                                        <form class="row g-3" method="POST" action="{{ route('login') }}">
                                            @csrf

                                            <div class="col-12">
                                                <label for="email" class="form-label">Alamat Email</label>
                                                <input type="email" name="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    id="email" placeholder="Masukkan alamat email"
                                                    value="{{ old('email') }}">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="password" class="form-label">Kata Sandi</label>
                                                <div class="input-group" id="show_hide_password">
                                                    <input type="password" name="password"
                                                        class="form-control border-end-0 @error('password') is-invalid @enderror"
                                                        id="password" value="" placeholder="Masukkan kata sandi">
                                                    <a href="javascript:;" class="input-group-text bg-transparent"><i
                                                            class='bx bx-hide'></i></a>
                                                </div>
                                                @error('password')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="flexSwitchCheckChecked" name="remember"
                                                        {{ old('remember') ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Ingat
                                                        Saya</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <a href="{{ route('password.request') }}">Lupa Kata Sandi?</a>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary"><i
                                                            class="bx bxs-lock-open"></i>Masuk</button>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="mt-3 text-center">
                                            <span>Belum punya akun? <a href="{{ route('register') }}">Daftar
                                                    disini</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end row-->
            </div>
        </div>
    </div>
    <!--end wrapper-->
    <!-- Bootstrap JS -->
    <script src="{{ asset('backendpenjual/assets/js/bootstrap.bundle.min.js') }}"></script>
    <!--plugins-->
    <script src="{{ asset('backendpenjual/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('backendpenjual/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('backendpenjual/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backendpenjual/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
    <!--Password show & hide js -->
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("bx-hide");
                    $('#show_hide_password i').removeClass("bx-show");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("bx-hide");
                    $('#show_hide_password i').addClass("bx-show");
                }
            });
        });
    </script>
    <!--app JS-->
    <script src="{{ asset('backendpenjual/assets/js/app.js') }}"></script>
</body>

</html>
