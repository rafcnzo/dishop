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
    <title>Register</title>
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
                                        <h3 class="">Daftar Akun</h3>
                                    </div>
                                    <div class="form-body">
                                        <form class="row g-3" method="POST" action="{{ route('register') }}">
                                            @csrf

                                            <div class="col-12">
                                                <label for="nama" class="form-label">Nama Lengkap</label>
                                                <input type="text" name="nama"
                                                    class="form-control @error('nama') is-invalid @enderror"
                                                    id="nama" placeholder="Nama Lengkap"
                                                    value="{{ old('nama') }}" required autofocus>
                                                @error('nama')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="username" class="form-label">Username</label>
                                                <input type="text" name="username"
                                                    class="form-control @error('username') is-invalid @enderror"
                                                    id="username" placeholder="Username"
                                                    value="{{ old('username') }}">
                                                @error('username')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="email" class="form-label">Alamat Email</label>
                                                <input type="email" name="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    id="email" placeholder="Alamat Email"
                                                    value="{{ old('email') }}">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control"
                                                    required>
                                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                                    <option value="L"
                                                        {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki
                                                    </option>
                                                    <option value="P"
                                                        {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <label for="phone" class="form-label">No. Telepon</label>
                                                <input type="text" name="phone" class="form-control" id="phone"
                                                    placeholder="No. Telepon" value="{{ old('phone') }}">
                                            </div>
                                            <div class="col-12">
                                                <label for="alamat" class="form-label">Alamat (Opsional)</label>
                                                <textarea name="alamat" class="form-control" id="alamat" placeholder="Alamat">{{ old('alamat') }}</textarea>
                                            </div>
                                            <div class="col-12">
                                                <label for="password" class="form-label">Kata Sandi</label>
                                                <div class="input-group">
                                                    <input type="password" name="password"
                                                        class="form-control border-end-0 @error('password') is-invalid @enderror"
                                                        id="password" placeholder="Kata Sandi" required>
                                                    <a href="javascript:;" class="input-group-text bg-transparent"><i
                                                            class='bx bx-hide'></i></a>
                                                </div>
                                                @error('password')
                                                    <div class="text-danger mt-1" style="font-size: .875em;">
                                                        {{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12">
                                                <label for="password_confirmation" class="form-label">Konfirmasi Kata
                                                    Sandi</label>
                                                <div class="input-group" id="show_hide_password_confirm">
                                                    <input type="password" name="password_confirmation"
                                                        class="form-control border-end-0" id="password_confirmation"
                                                        placeholder="Konfirmasi Kata Sandi" required>
                                                    <a href="javascript:;" class="input-group-text bg-transparent"><i
                                                            class='bx bx-hide'></i></a>
                                                </div>
                                            </div>
                                            {{-- Role otomatis pembeli --}}
                                            <input type="hidden" name="role" value="pembeli">
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary"><i
                                                            class="bx bxs-user-plus"></i> Daftar</button>
                                                </div>
                                            </div>
                                            <div class="col-12 text-center">
                                                <p class="mb-0">Sudah punya akun? <a
                                                        href="{{ route('login') }}">Masuk di sini</a></p>
                                            </div>
                                        </form>
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
            $("#show_hide_password_confirm a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password_confirm input').attr("type") == "text") {
                    $('#show_hide_password_confirm input').attr('type', 'password');
                    $('#show_hide_password_confirm i').addClass("bx-hide");
                    $('#show_hide_password_confirm i').removeClass("bx-show");
                } else if ($('#show_hide_password_confirm input').attr("type") == "password") {
                    $('#show_hide_password_confirm input').attr('type', 'text');
                    $('#show_hide_password_confirm i').removeClass("bx-hide");
                    $('#show_hide_password_confirm i').addClass("bx-show");
                }
            });
        });
    </script>
    <!--app JS-->
    <script src="{{ asset('backendpenjual/assets/js/app.js') }}"></script>
</body>

</html>
