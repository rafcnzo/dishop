<?php
namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\View;

class CustomerController extends Controller
{
    public function indexOrders()
    {
        $orders = DB::table('transaksi')
            ->leftJoin('pembayaran', 'transaksi.id', '=', 'pembayaran.transaksi_id')
            ->select('transaksi.*', 'pembayaran.keterangan as pembayaran_keterangan', 'pembayaran.status_pembayaran as status_pembayaran')
            ->where('pelanggan_id', auth()->id())
            ->orderBy('transaksi.waktu_transaksi', 'desc')
            ->paginate(5);

        foreach ($orders as $order) {
            $order->items = DB::table('transaksi_detail')
                ->join('products', 'transaksi_detail.barang_id', '=', 'products.id')
                ->where('transaksi_detail.transaksi_id', $order->id)
                ->select('transaksi_detail.*', 'products.nama_barang', 'products.image')
                ->get();

            foreach ($order->items as $item) {
                $item->image_url = $item->image
                    ? asset('upload/images_produk/' . $item->image)
                    : asset('images/no-image.png');
            }

            $currentStatus  = strtolower($order->keterangan);
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
                // case 'diproses':
                //     $timelineStatus = 'diproses';
                //     $statusText     = 'Diproses';
                //     break;
                // case 'diterima':
                //     $timelineStatus = 'diterima';
                //     $statusText     = 'Diterima';
                //     break;
                case 'selesai':
                    $timelineStatus = 'selesai';
                    $statusText     = 'Selesai';
                    break;
                case 'dibatalkan':
                    $timelineStatus = 'dibatalkan';
                    $statusText     = 'Pesanan Dibatalkan';
                    break;
            }

            $order->timeline_status = $timelineStatus;
            $order->status_text     = $statusText;
            $order->pembayaran_keterangan = $order->pembayaran_keterangan;
        }

        return view('pembeli.order', ['orders' => $orders]);
    }
}
