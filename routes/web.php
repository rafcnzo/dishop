<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PenjualController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/load-more-products', [HomeController::class, 'loadMoreProducts'])->name('products.load_more');
Route::get('/search-products', [HomeController::class, 'searchProducts'])->name('products.search');

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'role:penjual'])->group(function () {
    Route::get('/penjual/dashboard', [PenjualController::class, 'DashboardPenjual'])->name('penjual.dashboard');
    Route::get('/penjual/profil', [PenjualController::class, 'ProfilPenjual'])->name('penjual.profil');
    Route::post('/penjual/profil/store', [PenjualController::class, 'ProfilPenjualStore'])->name('penjual.profil.store');
    Route::get('/penjual/ganti/sandi', [PenjualController::class, 'GantiSandiPenjual'])->name('penjual.ganti.sandi');
    Route::post('/update/sandi', [PenjualController::class, 'PenjualUpdateSandi'])->name('update.sandi');

    Route::get('/penjual/logout', [PenjualController::class, 'LogoutPenjual'])->name('penjual.logout');
});

Route::middleware(['auth', 'role:pembeli'])->group(function () {
    Route::get('/pembeli/dashboard', [PenjualController::class, 'DashboardPembeli'])->name('pembeli.dashboard');
});

// Semua Produk
Route::controller(ProductController::class)->group(function () {
    Route::get('semua/produk', 'SemuaProduk')->name('semua.produk');
    Route::get('tambah/produk', 'TambahProduk')->name('tambah.produk');
    Route::post('simpan/produk', 'SimpanProduk')->name('simpan.produk');
    Route::get('edit/produk/{id}', 'EditProduk')->name('edit.produk');
    Route::post('update/produk', 'UpdateProduk')->name('update.produk');
});

Route::controller(SupplierController::class)->group(function () {
    Route::get('semua/supplier', 'SemuaSupplier')->name('semua.supplier');
    Route::get('tambah/supplier', 'TambahSupplier')->name('tambah.supplier');
    Route::post('simpan/supplier', 'SimpanSupplier')->name('simpan.supplier');
    Route::get('edit/supplier/{id}', 'EditSupplier')->name('edit.supplier');
    Route::post('update/supplier', 'UpdateSupplier')->name('update.supplier');
});

Route::get('/penjual/login', [PenjualController::class, 'LoginPenjual'])->name('penjual.login');

Route::controller(TransaksiController::class)->prefix('transaksi')->group(function () {
    Route::get('konfirmasi', 'konfirmasiTransaksi')->name('transaksi.konfirmasi');
    Route::get('detail/{id}', 'getDetailTransaksi')->name('transaksi.detail');
    Route::post('setujui/{id}', 'setujuiTransaksi')->name('transaksi.setujui');
    Route::post('tolak/{id}', 'tolakTransaksi')->name('transaksi.tolak');
    Route::get('riwayat', 'riwayatTransaksi')->name('transaksi.riwayat');

});

Route::get('/force-logout', function () {
    Auth::logout();
    return redirect('/login');
});

Route::controller(PenjualController::class)->prefix('laporan')->group(function () {
    Route::get('/', 'laporanIndex')->name('laporan.index');
    Route::get('/data', 'laporanData')->name('laporan.data');
    Route::get('/chart-penjualan', 'chartPenjualan')->name('laporan.chart-penjualan');
    Route::get('/chart-status', 'chartStatus')->name('laporan.chart-status');
    Route::get('/produk-terlaris', 'produkTerlaris')->name('laporan.produk-terlaris');
    Route::get('/export-detail/{tgl_awal}/{tgl_akhir}/{status}', 'exportDetail')->name('laporan.export-detail');
    Route::get('/invoice/{id}', 'invoice')->name('laporan.invoice');
});

// routes untuk customer (pembeli)
Route::middleware(['auth', 'role:pembeli'])->group(function () {
    Route::post('/cart/add/{productId}', [App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart/items', [App\Http\Controllers\CartController::class, 'getCartItems'])->name('cart.items');
    Route::post('/cart/update/{productId}', [App\Http\Controllers\CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove/{productId}', [App\Http\Controllers\CartController::class, 'removeCartItem'])->name('cart.remove');
    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'processCheckout'])->name('checkout.process');
});
