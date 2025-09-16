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
    <style>
        .auth-card-custom {
            max-width: 720px;
            margin: 0 auto;
            box-shadow: 0 2px 16px 0 rgba(0, 0, 0, 0.08);
            border-radius: 18px;
            background: #fff;
        }

        .auth-logo {
            width: 140px;
        }

        /* Tab Navigation Styling */
        .nav-tabs-custom {
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 1.5rem;
        }

        .nav-tabs-custom .nav-link {
            border: none;
            padding: 12px 20px;
            font-weight: 500;
            color: #6c757d;
            border-radius: 0;
            position: relative;
        }

        .nav-tabs-custom .nav-link:hover {
            border: none;
            color: #0d6efd;
        }

        .nav-tabs-custom .nav-link.active {
            color: #0d6efd;
            background: none;
            border: none;
        }

        .nav-tabs-custom .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: #0d6efd;
        }

        /* Tab Content */
        .tab-content {
            min-height: 400px;
        }

        /* Navigation Buttons */
        .tab-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e9ecef;
        }

        /* Hilangkan border pada saat focus */
        .tab-navigation:focus,
        .tab-navigation button:focus,
        .tab-content:focus,
        .tab-content input:focus,
        .tab-content select:focus,
        .tab-content textarea:focus {
            outline: none !important;
            box-shadow: none !important;
            border: none !important;
        }

        .step-indicator {
            font-size: 0.875rem;
            color: #6c757d;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .auth-card-custom {
                max-width: 600px;
            }

            .auth-logo {
                width: 120px;
            }

            .section-authentication-signin {
                padding: 20px 0;
                min-height: 100vh;
            }

            .card-body {
                padding: 1.5rem;
            }

            .border.p-4 {
                padding: 1.5rem !important;
            }
        }

        @media (max-width: 767.98px) {
            .auth-card-custom {
                max-width: 100%;
                margin: 0 10px;
                border-radius: 12px;
            }

            .section-authentication-signin {
                min-height: 100vh;
                padding: 15px 0;
            }

            .auth-logo {
                width: 110px;
            }

            .border.p-4 {
                padding: 1.2rem !important;
            }

            .nav-tabs-custom .nav-link {
                padding: 10px 15px;
                font-size: 0.9rem;
            }

            .tab-navigation {
                flex-direction: column;
                gap: 10px;
            }
        }

        @media (max-width: 575.98px) {
            .auth-card-custom {
                margin: 0 5px;
                border-radius: 8px;
            }

            .border.p-4 {
                padding: 1rem !important;
            }
        }

        /* Validation styling */
        .was-validated .form-control:invalid,
        .was-validated .form-select:invalid {
            border-color: #dc3545;
        }

        .was-validated .form-control:valid,
        .was-validated .form-select:valid {
            border-color: #198754;
        }
    </style>
</head>

<body class="bg-login">
    <div class="mb-5 text-center" style="margin-top: 50px;">
        <img src="{{ asset('backendpenjual/assets/images/logo-img.png') }}" class="auth-logo" alt="Logo"
            style="max-width: 165px; width: 100%;" />
    </div>
    <!--wrapper-->
    <div class="wrapper">
        <div class="section-authentication-signin d-flex align-items-center justify-content-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                        <div class="card auth-card-custom" style="margin-bottom: 20px;">
                            <div class="card-body">
                                <div class="border p-4 rounded">
                                    <div class="text-center mb-3">
                                        <h3 class="mb-0">Daftar Akun</h3>
                                        <p class="text-muted small mt-2">Lengkapi informasi berikut untuk mendaftar</p>
                                    </div>

                                    <form id="registrationForm" method="POST" action="{{ route('register') }}"
                                        novalidate>
                                        @csrf

                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs nav-tabs-custom" id="registrationTabs" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="personal-tab" data-bs-toggle="tab"
                                                    data-bs-target="#personal" type="button" role="tab">
                                                    <i class="bx bx-user me-1"></i>Informasi Pribadi
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="account-tab" data-bs-toggle="tab"
                                                    data-bs-target="#account" type="button" role="tab">
                                                    <i class="bx bx-key me-1"></i>Informasi Akun
                                                </button>
                                            </li>
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content" id="registrationTabContent">
                                            <!-- Personal Information Tab -->
                                            <div class="tab-pane fade show active" id="personal" role="tabpanel">
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <label for="nama" class="form-label">Nama Lengkap <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="nama"
                                                            class="form-control @error('nama') is-invalid @enderror"
                                                            id="nama" placeholder="Masukkan nama lengkap"
                                                            value="{{ old('nama') }}" required>
                                                        @error('nama')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin
                                                            <span class="text-danger">*</span></label>
                                                        <select name="jenis_kelamin" id="jenis_kelamin"
                                                            class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                                            required>
                                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                                            <option value="L"
                                                                {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                                                                Laki-laki</option>
                                                            <option value="P"
                                                                {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                                                                Perempuan</option>
                                                        </select>
                                                        @error('jenis_kelamin')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="phone" class="form-label">No. Telepon</label>
                                                        <input type="text" name="phone"
                                                            class="form-control @error('phone') is-invalid @enderror"
                                                            id="phone" placeholder="Masukkan nomor telepon"
                                                            value="{{ old('phone') }}">
                                                        @error('phone')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="alamat" class="form-label">Alamat</label>
                                                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                                                            placeholder="Masukkan alamat lengkap" rows="3">{{ old('alamat') }}</textarea>
                                                        <div class="form-text">Opsional - untuk memudahkan pengiriman
                                                        </div>
                                                        @error('alamat')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="tab-navigation">
                                                    <div class="step-indicator">
                                                        Langkah 1 dari 2
                                                    </div>
                                                    <button type="button" class="btn btn-primary"
                                                        id="nextToAccount">
                                                        Selanjutnya <i class="bx bx-chevron-right"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Account Information Tab -->
                                            <div class="tab-pane fade" id="account" role="tabpanel">
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <label for="username" class="form-label">Username <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text" name="username"
                                                            class="form-control @error('username') is-invalid @enderror"
                                                            id="username" placeholder="Masukkan username"
                                                            value="{{ old('username') }}" required>
                                                        <div class="form-text">Username akan digunakan untuk login
                                                        </div>
                                                        @error('username')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="email" class="form-label">Alamat Email <span
                                                                class="text-danger">*</span></label>
                                                        <input type="email" name="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            id="email" placeholder="Masukkan alamat email"
                                                            value="{{ old('email') }}" required>
                                                        @error('email')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="password" class="form-label">Kata Sandi <span
                                                                class="text-danger">*</span></label>
                                                        <div class="input-group" id="show_hide_password">
                                                            <input type="password" name="password"
                                                                class="form-control border-end-0 @error('password') is-invalid @enderror"
                                                                id="password" placeholder="Masukkan kata sandi"
                                                                required>
                                                            <a href="javascript:;"
                                                                class="input-group-text bg-transparent"><i
                                                                    class='bx bx-hide'></i></a>
                                                        </div>
                                                        <div class="form-text">Minimal 8 karakter</div>
                                                        @error('password')
                                                            <div class="text-danger mt-1" style="font-size: .875em;">
                                                                {{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="col-12">
                                                        <label for="password_confirmation"
                                                            class="form-label">Konfirmasi Kata Sandi <span
                                                                class="text-danger">*</span></label>
                                                        <div class="input-group" id="show_hide_password_confirm">
                                                            <input type="password" name="password_confirmation"
                                                                class="form-control border-end-0"
                                                                id="password_confirmation"
                                                                placeholder="Ulangi kata sandi" required>
                                                            <a href="javascript:;"
                                                                class="input-group-text bg-transparent"><i
                                                                    class='bx bx-hide'></i></a>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- Role otomatis pembeli --}}
                                                <input type="hidden" name="role" value="pembeli">

                                                <div class="tab-navigation">
                                                    <button type="button" class="btn btn-outline-secondary"
                                                        id="backToPersonal">
                                                        <i class="bx bx-chevron-left"></i> Kembali
                                                    </button>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <div class="step-indicator">
                                                            Langkah 2 dari 2
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="bx bxs-user-plus"></i> Daftar Sekarang
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="text-center mt-3 pt-3 border-top">
                                        <p class="mb-0">Sudah punya akun? <a href="{{ route('login') }}"
                                                class="text-decoration-none">Masuk di sini</a></p>
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

    <script>
        $(document).ready(function() {
            // Password show/hide functionality
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

            // Tab navigation
            $('#nextToAccount').click(function() {
                // Validate personal info before proceeding
                var isValid = true;
                var personalTab = $('#personal');

                // Check required fields in personal tab
                personalTab.find('input[required], select[required]').each(function() {
                    if (!this.checkValidity()) {
                        isValid = false;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });

                if (isValid) {
                    // Switch to account tab
                    $('#account-tab').tab('show');
                    // Focus on first input in account tab
                    setTimeout(function() {
                        $('#username').focus();
                    }, 150);
                } else {
                    // Add validation feedback
                    personalTab.find('.form-control, .form-select').first().focus();
                }
            });

            $('#backToPersonal').click(function() {
                $('#personal-tab').tab('show');
            });

            // Form validation on submit
            $('#registrationForm').on('submit', function(e) {
                var form = this;
                if (!form.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();

                    // Check which tab has errors and switch to it
                    var personalHasErrors = $('#personal input[required], #personal select[required]').is(
                        ':invalid');
                    var accountHasErrors = $('#account input[required]').is(':invalid');

                    if (personalHasErrors) {
                        $('#personal-tab').tab('show');
                    } else if (accountHasErrors) {
                        $('#account-tab').tab('show');
                    }
                }
                $(form).addClass('was-validated');
            });

            // Real-time validation
            $('input[required], select[required]').on('blur', function() {
                if ($(this).val().trim() !== '') {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                } else {
                    $(this).removeClass('is-valid').addClass('is-invalid');
                }
            });

            // Password confirmation validation
            $('#password_confirmation').on('input', function() {
                var password = $('#password').val();
                var confirmation = $(this).val();

                if (confirmation !== '' && password !== confirmation) {
                    $(this).removeClass('is-valid').addClass('is-invalid');
                } else if (confirmation !== '' && password === confirmation) {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                }
            });
        });
    </script>

    <!--app JS-->
    <script src="{{ asset('backendpenjual/assets/js/app.js') }}"></script>
</body>

</html>
