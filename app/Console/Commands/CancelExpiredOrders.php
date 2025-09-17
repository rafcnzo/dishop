<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CancelExpiredOrders extends Command
{
    /**
     * Nama dan signature dari console command.
     */
    protected $signature = 'orders:cancel-expired';

    /**
     * Deskripsi console command.
     */
    protected $description = 'Membatalkan pesanan yang belum dibayar dan sudah kedaluwarsa (lebih dari 1 jam)';

    /**
     * Jalankan console command.
     */
    public function handle()
    {
        // Tentukan batas waktu (1 menit yang lalu) untuk keperluan test
        $expirationTime = Carbon::now()->subHour();

        // Ambil semua pesanan yang statusnya 'pending' dan dibuat lebih dari 1 jam yang lalu
        $expiredOrders = DB::table('transaksi')
            ->where('keterangan', 'pending')
            ->where('waktu_transaksi', '<=', $expirationTime)
            ->get();

        $count = $expiredOrders->count();

        if ($count > 0) {
            foreach ($expiredOrders as $order) {
                // Update status transaksi menjadi dibatalkan dan update dtmodi
                DB::table('transaksi')
                    ->where('id', $order->id)
                    ->update([
                        'keterangan' => 'dibatalkan',
                        'dtmodi' => now(),
                    ]);

                // Ambil semua item pesanan untuk mengembalikan stok
                $orderDetails = DB::table('transaksi_detail')
                    ->where('transaksi_id', $order->id)
                    ->get();

                foreach ($orderDetails as $item) {
                    DB::table('products')
                        ->where('id', $item->barang_id)
                        ->increment('stok', $item->qty);
                }
            }
            $this->info($count . ' pesanan kedaluwarsa berhasil dibatalkan dan stok produk telah dikembalikan.');
        } else {
            $this->info('Tidak ada pesanan kedaluwarsa yang ditemukan.');
        }
    }
}