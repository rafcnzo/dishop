<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function processCheckout(Request $request)
    {
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk melakukan checkout.');
        }

        // Ambil keranjang dari session
        $cart = Session::get('cart');

        // Pastikan keranjang tidak kosong
        if (!$cart || empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang belanja Anda kosong.');
        }
        
        // Gunakan DB Transaction untuk memastikan semua query berhasil atau tidak sama sekali
        DB::beginTransaction();

        try {
            // Hitung total harga dari server-side untuk keamanan
            $totalHarga = 0;
            foreach ($cart as $id => $details) {
                $totalHarga += $details['price'] * $details['qty'];
            }

            // 1. Simpan ke tabel 'transaksi'
            $transaksiId = DB::table('transaksi')->insertGetId([
                'pelanggan_id'    => Auth::id(),
                'waktu_transaksi' => now(),
                'total'           => $totalHarga,
                'keterangan'      => 'Pesanan Baru', // Atau dari form
                'dtcrea'          => now(),
            ]);

            // 2. Simpan setiap item ke 'transaksi_detail'
            foreach ($cart as $productId => $details) {
                DB::table('transaksi_detail')->insert([
                    'transaksi_id' => $transaksiId,
                    'barang_id'    => $productId,
                    'qty'          => $details['qty'],
                    'harga'        => $details['price'],
                    'dtcrea'       => now(),
                ]);
            }
            
            // 3. (Opsional) Buat entri di tabel 'pembayaran' dengan status awal
            DB::table('pembayaran')->insert([
                'transaksi_id' => $transaksiId,
                'status_pembayaran' => null, // Menunggu pembayaran
                'waktu' => now()
            ]);

            // Jika semua berhasil, commit transaksi
            DB::commit();

            // Kosongkan keranjang setelah checkout berhasil
            Session::forget('cart');
            
            // Redirect ke halaman "Pesanan Saya" atau halaman sukses
            return redirect()->route('pesanan.index')->with('success', 'Checkout berhasil! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            // Jika ada kesalahan, rollback semua query
            DB::rollBack();
            
            // Redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat proses checkout. Silakan coba lagi.');
        }
    }
}
