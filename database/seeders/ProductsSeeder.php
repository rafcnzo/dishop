<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel products.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'kode_barang' => 'PRD001',
                'nama_barang' => 'Beras Premium 5kg',
                'deskripsi'   => 'Beras premium kualitas terbaik, kemasan 5kg.',
                'harga'       => 75000,
                'stok'        => 100,
                'supplier_id' => 1,
                'status'      => 1,
                'image'       => 'beras_premium_5kg.jpg',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'kode_barang' => 'PRD002',
                'nama_barang' => 'Minyak Goreng 2L',
                'deskripsi'   => 'Minyak goreng sawit kemasan 2 liter.',
                'harga'       => 32000,
                'stok'        => 50,
                'supplier_id' => 1,
                'status'      => 1,
                'image'       => 'minyak_goreng_2l.jpg',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'kode_barang' => 'PRD003',
                'nama_barang' => 'Gula Pasir 1kg',
                'deskripsi'   => 'Gula pasir putih kemasan 1kg.',
                'harga'       => 14000,
                'stok'        => 200,
                'supplier_id' => 2,
                'status'      => 1,
                'image'       => 'gula_pasir_1kg.jpg',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
