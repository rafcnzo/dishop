<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [
        'kode_barang',
        'nama_barang',
        'deskripsi',
        'harga',
        'stok',
        'supplier_id',
        'image',
    ];
}
