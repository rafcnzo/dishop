<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand">
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
            </div>
            {{-- <div class="search-bar flex-grow-1">
                <div class="position-relative search-bar-box">
                    <input type="text" class="form-control search-control" placeholder="Type to search..."> <span
                        class="position-absolute top-50 search-show translate-middle-y"><i
                            class='bx bx-search'></i></span>
                    <span class="position-absolute top-50 search-close translate-middle-y"><i
                            class='bx bx-x'></i></span>
                </div>
            </div> --}}
            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item mobile-search-icon">
                        <a class="nav-link" href="#"> <i class='bx bx-search'></i>
                        </a>
                    </li>
                    {{-- <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">	<i class='bx bx-category'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <div class="row row-cols-3 g-3 p-3">
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-cosmic text-white"><i class='bx bx-group'></i>
                                    </div>
                                    <div class="app-title">Teams</div>
                                </div>
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-burning text-white"><i class='bx bx-atom'></i>
                                    </div>
                                    <div class="app-title">Projects</div>
                                </div>
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-lush text-white"><i class='bx bx-shield'></i>
                                    </div>
                                    <div class="app-title">Tasks</div>
                                </div>
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-kyoto text-dark"><i class='bx bx-notification'></i>
                                    </div>
                                    <div class="app-title">Feeds</div>
                                </div>
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-blues text-dark"><i class='bx bx-file'></i>
                                    </div>
                                    <div class="app-title">Files</div>
                                </div>
                                <div class="col text-center">
                                    <div class="app-box mx-auto bg-gradient-moonlit text-white"><i class='bx bx-filter-alt'></i>
                                    </div>
                                    <div class="app-title">Alerts</div>
                                </div>
                            </div>
                        </div>
                    </li> --}}
                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @php
                                $jumlah_stok_rendah = isset($stok_rendah) && count($stok_rendah) > 0 ? count($stok_rendah) : 0;
                                $jumlah_order_konfirmasi = isset($order_konfirmasi) && count($order_konfirmasi) > 0 ? count($order_konfirmasi) : 0;
                                $jumlah_notifikasi = $jumlah_stok_rendah + $jumlah_order_konfirmasi;
                            @endphp
                            <span class="alert-count">
                                {{ $jumlah_notifikasi }}
                            </span>
                            <i class='bx bx-bell'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;">
                                <div class="msg-header">
                                    <p class="msg-header-title">Notifikasi</p>
                                    {{-- <p class="msg-header-clear ms-auto">Tandai semua sudah dibaca</p> --}}
                                </div>
                            </a>
                            <div class="header-notifications-list">
                                {{-- Notifikasi Stok Rendah --}}
                                @if (isset($stok_rendah) && count($stok_rendah) > 0)
                                    @foreach ($stok_rendah as $produk)
                                        <a class="dropdown-item" href="javascript:;">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-danger text-danger">
                                                    <i class="bx bx-error"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">
                                                        Stok Rendah: {{ $produk->nama_barang }}
                                                        <span class="msg-time float-end">Stok:
                                                            {{ $produk->stok }}</span>
                                                    </h6>
                                                    <p class="msg-info">
                                                        Segera lakukan restock produk ini.
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif

                                {{-- Notifikasi Order Butuh Konfirmasi --}}
                                @if (isset($order_konfirmasi) && count($order_konfirmasi) > 0)
                                    @foreach ($order_konfirmasi as $order)
                                        <a class="dropdown-item" href="{{ url('/transaksi/konfirmasi') }}">
                                            <div class="d-flex align-items-center">
                                                <div class="notify bg-light-warning text-warning">
                                                    <i class="bx bx-time-five"></i>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="msg-name">
                                                        Order Butuh Konfirmasi: {{ $order->nama_pelanggan ?? 'Guest' }}
                                                        <span class="msg-time float-end">
                                                            {{ \Carbon\Carbon::parse($order->waktu_transaksi)->format('d/m/Y H:i') }}
                                                        </span>
                                                    </h6>
                                                    <p class="msg-info">
                                                        Total: Rp {{ number_format($order->total, 0, ',', '.') }}
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif

                                @if (
                                    (!isset($stok_rendah) || count($stok_rendah) == 0) &&
                                    (!isset($order_konfirmasi) || count($order_konfirmasi) == 0)
                                )
                                    <div class="text-center text-muted py-3">
                                        Tidak ada notifikasi.
                                    </div>
                                @endif
                            </div>
                            <a href="javascript:;">
                                <div class="text-center msg-footer">Lihat Semua Notifikasi</div>
                            </a>
                        </div>
                    </li>
                    {{-- <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span
                                class="alert-count">8</span>
                            <i class='bx bx-comment'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;">
                                <div class="msg-header">
                                    <p class="msg-header-title">Messages</p>
                                    <p class="msg-header-clear ms-auto">Marks all as read</p>
                                </div>
                            </a>
                            <div class="header-message-list">
                                <a class="dropdown-item" href="javascript:;">
                                    <div class="d-flex align-items-center">
                                        <div class="user-online">
                                            <img src="{{ asset('backendpenjual/assets/images/avatars/avatar-1.png') }}"
                                                class="msg-avatar" alt="user avatar">
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name">Daisy Anderson <span class="msg-time float-end">5 sec
                                                    ago</span></h6>
                                            <p class="msg-info">The standard chunk of lorem</p>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="javascript:;">
                                    <div class="d-flex align-items-center">
                                        <div class="user-online">
                                            <img src="{{ asset('backendpenjual/assets/images/avatars/avatar-2.png') }}"
                                                class="msg-avatar" alt="user avatar">
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name">Althea Cabardo <span class="msg-time float-end">14
                                                    sec ago</span></h6>
                                            <p class="msg-info">Many desktop publishing packages</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <a href="javascript:;">
                                <div class="text-center msg-footer">View All Messages</div>
                            </a>
                        </div>
                    </li> --}}
                </ul>
            </div>
            @php
                $id = Auth::user()->id;
                $pData = App\Models\User::find($id);
            @endphp
            <div class="user-box dropdown">
                <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ !empty($pData->photo) ? url('upload/images_penjual/' . $pData->photo) : url('upload/no_image.jpg') }}"
                        class="user-img" alt="user avatar">
                    <div class="user-info ps-3">
                        <p class="user-name mb-0">{{ Auth::user()->nama }}</p>
                        <p class="designattion mb-0">{{ Auth::user()->email }}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('penjual.profil') }}">
                            <i class="bx bx-user"></i><span>Profil</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('penjual.ganti.sandi') }}">
                            <i class="bx bx-cog"></i><span>Ganti Sandi</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:;">
                            <i class='bx bx-home-circle'></i><span>Dashboard</span>
                        </a>
                    </li>
                    {{-- <li>
                        <a class="dropdown-item" href="javascript:;">
                            <i class='bx bx-dollar-circle'></i><span>Earnings</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:;">
                            <i class='bx bx-download'></i><span>Downloads</span>
                        </a>
                    </li> --}}
                    <li>
                        <div class="dropdown-divider mb-0"></div>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item"
                                style="border: none !important; outline: none !important; box-shadow: none !important; background: none; padding-left: 15px; width: 100%; text-align: left;">
                                <i class='bx bx-log-out-circle'></i><span>Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>
