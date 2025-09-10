<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel transaksi, transaksi_detail, dan pembayaran.
     */
    public function run(): void
    {
        // Data dummy user (pelanggan) dengan id 1 dan 2 diasumsikan sudah ada

        // 1. Insert ke tabel transaksi
        // Kolom 'keterangan' diisi sebagai status transaksi: 'Menunggu Konfirmasi', 'Diterima', 'Selesai', dll.
        $transaksi = [
            [
                // 'id' dihapus karena auto increment
                'pelanggan_id'    => 1,
                'waktu_transaksi' => Carbon::now()->subDays(2),
                'total'           => 50000,
                'keterangan'      => 'Menunggu Konfirmasi',
                'dtcrea'          => Carbon::now()->subDays(2),
                'dtmodi'          => Carbon::now()->subDays(2),
            ],
            [
                // 'id' dihapus karena auto increment
                'pelanggan_id'    => 2,
                'waktu_transaksi' => Carbon::now()->subDay(),
                'total'           => 120000,
                'keterangan'      => 'Diterima',
                'dtcrea'          => Carbon::now()->subDay(),
                'dtmodi'          => Carbon::now()->subDay(),
            ],
            [
                // 'id' dihapus karena auto increment
                'pelanggan_id'    => 1,
                'waktu_transaksi' => Carbon::now()->subHours(5),
                'total'           => 75000,
                'keterangan'      => 'Selesai',
                'dtcrea'          => Carbon::now()->subHours(5),
                'dtmodi'          => Carbon::now()->subHours(5),
            ],
        ];
        DB::table('transaksi')->insert($transaksi);

        // 2. Insert ke tabel transaksi_detail
        $transaksi_detail = [
            [
                'transaksi_id' => 1,
                'barang_id'    => 1, // diasumsikan produk id 1 ada
                'qty'          => 2,
                'harga'        => 25000,
                'dtcrea'       => Carbon::now()->subDays(2),
                'dtmodi'       => Carbon::now()->subDays(2),
            ],
            [
                'transaksi_id' => 2,
                'barang_id'    => 2, // diasumsikan produk id 2 ada
                'qty'          => 3,
                'harga'        => 40000,
                'dtcrea'       => Carbon::now()->subDay(),
                'dtmodi'       => Carbon::now()->subDay(),
            ],
            [
                'transaksi_id' => 3,
                'barang_id'    => 1,
                'qty'          => 1,
                'harga'        => 75000,
                'dtcrea'       => Carbon::now()->subHours(5),
                'dtmodi'       => Carbon::now()->subHours(5),
            ],
        ];
        DB::table('transaksi_detail')->insert($transaksi_detail);

        // 3. Insert ke tabel pembayaran
        $pembayaran = [
            [
                'transaksi_id'      => 1,
                'bukti_transfer'    => 'bukti1.jpg',
                'status_pembayaran' => 'T',
                'keterangan'        => 'Pembayaran diterima',
                'waktu'             => Carbon::now()->subDays(1),
                'dtmodi'            => Carbon::now()->subDays(1),
            ],
            [
                'transaksi_id'      => 2,
                'bukti_transfer'    => 'bukti2.jpg',
                'status_pembayaran' => 'F',
                'keterangan'        => 'Pembayaran ditolak',
                'waktu'             => Carbon::now(),
                'dtmodi'            => Carbon::now(),
            ],
            [
                'transaksi_id'      => 3,
                'bukti_transfer'    => 'bukti3.jpg',
                'status_pembayaran' => 'T',
                'keterangan'        => 'Pembayaran diterima',
                'waktu'             => Carbon::now()->subHours(4),
                'dtmodi'            => Carbon::now()->subHours(4),
            ],
        ];
        DB::table('pembayaran')->insert($pembayaran);
    }
}
