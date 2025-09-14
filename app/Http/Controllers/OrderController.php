<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $cart = Session::get('cart');
        if (! $cart || count($cart) == 0) {
            \Log::warning('Keranjang kosong saat mencoba placeOrder', [
                'user_id' => Auth::id(),
                'ip'      => $request->ip(),
            ]);
            return redirect('/')->with('error', 'Keranjang Anda kosong.');
        }

        DB::beginTransaction();
        try {
            $totalHarga = 0;
            foreach ($cart as $details) {
                $totalHarga += $details['price'] * $details['qty'];
            }

            $newOrderId = DB::table('transaksi')->insertGetId([
                'pelanggan_id'    => Auth::id(),
                'waktu_transaksi' => Carbon::now(),
                'total'           => $totalHarga,
                'keterangan'      => 'pending',
                'dtcrea'          => Carbon::now(),
            ]);

            $detailItems = [];
            foreach ($cart as $id => $details) {
                $detailItems[] = [
                    'transaksi_id' => $newOrderId,
                    'barang_id'    => $id,
                    'qty'          => $details['qty'],
                    'harga'        => $details['price'],
                    'dtcrea'       => Carbon::now(),
                ];
            }
            DB::table('transaksi_detail')->insert($detailItems);

            Session::forget('cart');

            DB::commit();

            \Log::info('Pesanan berhasil dibuat', [
                'user_id'  => Auth::id(),
                'order_id' => $newOrderId,
                'total'    => $totalHarga,
                'ip'       => $request->ip(),
            ]);

            return redirect()->route('payment.confirmation', ['order' => $newOrderId]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Gagal membuat pesanan', [
                'user_id' => Auth::id(),
                'error'   => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
                'ip'      => $request->ip(),
            ]);
            $notification = [
                'type'    => 'error',
                'title'   => 'Gagal!',
                'message' => 'Terjadi kesalahan saat membuat pesanan. Silakan coba lagi.',
            ];
            return redirect()->route('checkout.show')->with('notification', $notification);
        }
    }

    // Fungsi untuk membatalkan pesanan
    public function cancelOrder($id)
    {
        $userId = Auth::id();

        try {
            $order = DB::table('transaksi')
                ->where('id', $id)
                ->where('pelanggan_id', $userId)
                ->first();

            if (! $order) {
                // Kirim JSON error jika pesanan tidak ditemukan
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak ditemukan.',
                ], 404); // 404 Not Found
            }

            if ($order->keterangan !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak dapat dibatalkan karena sudah diproses.',
                ], 422); // 422 Unprocessable Entity
            }

            DB::table('transaksi')
                ->where('id', $id)
                ->update(['keterangan' => 'dibatalkan']);

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibatalkan.',
            ]);

        } catch (\Exception $e) {
            \Log::error('Gagal batalkan pesanan: ' . $e->getMessage()); // Log error untuk admin
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server.',
            ], 500);
        }
    }

    public function showConfirmationPage($orderId)
    {
        $order = DB::table('transaksi')
            ->where('id', $orderId)
            ->where('pelanggan_id', Auth::id()) // Keamanan: pastikan pesanan milik user
            ->first();

        if (! $order) {
            abort(404, 'Pesanan tidak ditemukan.');
        }

        $expirationTime = \Carbon\Carbon::parse($order->waktu_transaksi)->addHour();

        if ($order->keterangan !== 'pending') {
            $notification = [
                'type'    => 'info',
                'title'   => 'Info Pesanan',
                'message' => 'Pesanan ini tidak lagi menunggu pembayaran. Status saat ini: ' . ucfirst($order->keterangan),
            ];
            // Arahkan ke halaman daftar pesanan dengan notifikasi
            return redirect()->route('orders')->with('notification', $notification);
        }

        $orderItems = DB::table('transaksi_detail')
            ->join('products', 'transaksi_detail.barang_id', '=', 'products.id')
            ->where('transaksi_detail.transaksi_id', $orderId)
            ->select('products.nama_barang', 'products.image', 'transaksi_detail.qty', 'transaksi_detail.harga')
            ->get();

        return view('pembeli.confirmation', [
            'order'          => $order,
            'orderItems'     => $orderItems,
            'expirationTime' => $expirationTime,
        ]);
    }

    public function submitConfirmation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id'      => 'required|exists:transaksi,id',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // maks 5MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $orderId = $request->input('order_id');
        $order   = DB::table('transaksi')->where('id', $orderId)->where('pelanggan_id', Auth::id())->first();

        if (! $order) {
            abort(404);
        }

        $filePath = null;
        if ($request->hasFile('payment_proof')) {
            $file     = $request->file('payment_proof');
            $fileName = 'proof_' . $orderId . '_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('public/proofs', $fileName); // Simpan di storage/app/public/proofs
        }

        DB::table('pembayaran')->insert([
            'transaksi_id'   => $orderId,
            'bukti_transfer' => $fileName,
            'metode'         => $order->metode_pembayaran ?? 'Bank Transfer', // Ambil dari transaksi jika ada
            'waktu'          => Carbon::now(),
            'keterangan'     => $request->input('notes'),
        ]);

        DB::table('transaksi')->where('id', $orderId)->update([
            'keterangan' => 'menunggu konfirmasi',
        ]);

        $notification = [
            'type'    => 'success',
            'title'   => 'Terima Kasih!',
            'message' => 'Konfirmasi pembayaran Anda telah kami terima dan akan segera diverifikasi.',
        ];

        return redirect()->route('orders')->with('notification', $notification);
    }
}
