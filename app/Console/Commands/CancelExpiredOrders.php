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
        // Tentukan batas waktu (1 jam yang lalu)
        $expirationTime = Carbon::now()->subHour();
        
        // Cari pesanan yang statusnya 'pending' dan dibuat lebih dari 1 jam yang lalu
        $expiredOrders = DB::table('transaksi')
            ->where('keterangan', 'pending')
            ->where('waktu_transaksi', '<=', $expirationTime);

        // Hitung jumlah pesanan yang akan dibatalkan
        $count = $expiredOrders->count();

        if ($count > 0) {
            // Update status pesanan tersebut menjadi 'dibatalkan'
            $expiredOrders->update(['keterangan' => 'dibatalkan']);
            $this->info($count . ' pesanan kedaluwarsa berhasil dibatalkan.');
        } else {
            $this->info('Tidak ada pesanan kedaluwarsa yang ditemukan.');
        }
    }
}