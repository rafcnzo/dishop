<?php
namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\View;

class CustomerController extends Controller
{
    public function indexOrders()
    {
        $orders = DB::table('transaksi')
            ->select('transaksi.*')
            // ->where('pelanggan_id', auth()->id())
            ->orderBy('transaksi.waktu_transaksi', 'desc')
            ->paginate(5);

        // Loop untuk setiap pesanan dan siapkan data untuk view
        foreach ($orders as $order) {
            // Ambil detail item untuk setiap pesanan
            $order->items = DB::table('transaksi_detail')
                ->join('products', 'transaksi_detail.barang_id', '=', 'products.id')
                ->where('transaksi_detail.transaksi_id', $order->id)
                ->select('transaksi_detail.*', 'products.nama_barang', 'products.image')
                ->get();

            // Tambahkan URL gambar lengkap untuk setiap item
            foreach ($order->items as $item) {
                $item->image_url = $item->image
                    ? asset('upload/images_produk/' . $item->image)
                    : asset('images/no-image.png');
            }

            $currentStatus = strtolower($order->keterangan);

                                         // Tentukan status untuk timeline di view
            $timelineStatus = 'pending'; // default
            $statusText     = 'Status Tidak Dikenal';

            switch ($currentStatus) {
                case 'pending':
                    $timelineStatus = 'pending';
                    $statusText     = 'Pesanan Dibuat';
                    break;
                case 'menunggu konfirmasi':
                    $timelineStatus = 'menunggu konfirmasi';
                    $statusText     = 'Menunggu Konfirmasi';
                    break;
                case 'diproses':
                    $timelineStatus = 'diproses';
                    $statusText     = 'Diproses';
                    break;
                case 'diterima':
                    $timelineStatus = 'diterima';
                    $statusText     = 'Diterima';
                    break;
                case 'selesai':
                    $timelineStatus = 'selesai';
                    $statusText     = 'Selesai';
                    break;
                case 'cancelled':
                    $timelineStatus = 'cancelled';
                    $statusText     = 'Pesanan Dibatalkan';
                    break;
            }

            // Tambahkan properti baru ke objek $order untuk digunakan di view
            $order->timeline_status = $timelineStatus;
            $order->status_text     = $statusText;
        }

        // Kirim data ke view
        return view('pembeli.order', ['orders' => $orders]);
    }
}
