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
            return redirect('/')->with('error', 'Keranjang Anda kosong.');
        }

        DB::beginTransaction();
        try {
            $totalHarga = 0;
            foreach ($cart as $details) {
                $totalHarga += $details['price'] * $details['qty'];
            }

            // Generate id_transaksi dengan format TRXDDMMYYYY-0001
            $tanggal = Carbon::now()->format('dmY');
            $prefix = 'TRX' . $tanggal . '-';

            // Ambil nomor urut terakhir untuk hari ini
            $lastOrder = DB::table('transaksi')
                ->where('id', 'like', $prefix . '%')
                ->orderBy('id', 'desc')
                ->first();

            if ($lastOrder && preg_match('/^TRX\d{8}-(\d{4})$/', $lastOrder->id, $matches)) {
                $lastNumber = intval($matches[1]);
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }
            $nomorUrut = str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            $idTransaksi = $prefix . $nomorUrut;

            // Simpan transaksi dengan id_transaksi custom
            DB::table('transaksi')->insert([
                'id'    => $idTransaksi,
                'pelanggan_id'    => Auth::id(),
                'waktu_transaksi' => Carbon::now(),
                'total'           => $totalHarga,
                'keterangan'      => 'pending',
                'dtcrea'          => Carbon::now(),
            ]);

            $detailItems = [];
            foreach ($cart as $id => $details) {
                $detailItems[] = [
                    'transaksi_id' => $idTransaksi,
                    'barang_id'    => $id,
                    'qty'          => $details['qty'],
                    'harga'        => $details['price'],
                    'dtcrea'       => Carbon::now(),
                ];

                // Update stok produk
                $affected = DB::table('products')
                    ->where('id', $id)
                    ->decrement('stok', $details['qty']);

                // Jika stok tidak cukup, rollback dan tampilkan error
                if ($affected === 0) {
                    DB::rollBack();
                    $notification = [
                        'type'    => 'error',
                        'title'   => 'Stok Tidak Cukup!',
                        'message' => 'Stok produk tidak mencukupi untuk pesanan Anda.',
                    ];
                    return redirect()->route('checkout.show')->with('notification', $notification);
                }
            }
            DB::table('transaksi_detail')->insert($detailItems);

            Session::forget('cart');

            DB::commit();

            return redirect()->route('payment.confirmation', ['order' => $idTransaksi]);

        } catch (\Exception $e) {
            DB::rollBack();
            $notification = [
                'type'    => 'error',
                'title'   => 'Gagal!',
                'message' => 'Terjadi kesalahan saat membuat pesanan. Silakan coba lagi.',
            ];
            return redirect()->route('checkout.show')->with('notification', $notification);
        }
    }

    public function cancelOrder($id)
    {
        $userId = Auth::id();

        try {
            DB::beginTransaction();

            $order = DB::table('transaksi')
                ->where('id', $id)
                ->where('pelanggan_id', $userId)
                ->first();

            if (! $order) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak ditemukan.',
                ], 404); // 404 Not Found
            }

            if ($order->keterangan !== 'pending') {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Pesanan tidak dapat dibatalkan karena sudah diproses.',
                ], 422); // 422 Unprocessable Entity
            }

            $orderDetails = DB::table('transaksi_detail')
                ->where('transaksi_id', $id)
                ->get();

            foreach ($orderDetails as $item) {
                DB::table('products')
                    ->where('id', $item->barang_id)
                    ->increment('stok', $item->qty);
            }

            DB::table('transaksi')
                ->where('id', $id)
                ->update([
                    'keterangan' => 'dibatalkan',
                    'dtmodi'     => now(),
                ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibatalkan dan stok produk telah dikembalikan.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
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
            ->where('pelanggan_id', Auth::id())
            ->first();

        if (! $order) {
            abort(404, 'Pesanan tidak ditemukan.');
        }

        if ($order->keterangan !== 'pending') {
            $notification = [
                'type'    => 'info',
                'title'   => 'Info Pesanan',
                'message' => 'Pesanan ini tidak lagi menunggu pembayaran. Status saat ini: ' . ucfirst($order->keterangan),
            ];
            return redirect()->route('orders')->with('notification', $notification);
        }

        $expirationTime = Carbon::parse($order->waktu_transaksi)->addHour();

        if ($expirationTime->isPast()) {
            // Update status transaksi menjadi dibatalkan
            DB::table('transaksi')->where('id', $orderId)->update([
                'keterangan' => 'dibatalkan',
                'dtmodi'     => now(),
            ]);

            // Ambil semua item pesanan untuk mengembalikan stok
            $orderDetails = DB::table('transaksi_detail')
                ->where('transaksi_id', $orderId)
                ->get();

            foreach ($orderDetails as $item) {
                DB::table('products')
                    ->where('id', $item->barang_id)
                    ->increment('stok', $item->qty);
            }

            $notification = [
                'type'    => 'warning',
                'title'   => 'Waktu Habis',
                'message' => 'Waktu pembayaran untuk pesanan #' . $orderId . ' telah berakhir dan pesanan otomatis dibatalkan.',
            ];
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
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // Maksimal 5MB
            'keterangan'    => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $orderId = $request->input('order_id');
        $order   = DB::table('transaksi')->where('id', $orderId)->where('pelanggan_id', Auth::id())->first();

        if (! $order) {
            abort(404, 'Pesanan tidak ditemukan.');
        }

        $fileName = null;
        if ($request->hasFile('payment_proof')) {
            $file     = $request->file('payment_proof');
            $fileName = 'proof_' . $orderId . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/proofs', $fileName);
        }

        DB::table('pembayaran')->insert([
            'transaksi_id'   => $orderId,
            'bukti_transfer' => $fileName,
            'metode'         => $request->input('metode_pembayaran'),
            'waktu'          => Carbon::now(),
            'keterangan'     => $request->input('keterangan'),
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
