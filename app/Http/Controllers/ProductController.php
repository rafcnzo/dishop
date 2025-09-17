<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Laravel\Facades\Image;

class ProductController extends Controller
{
    public function SemuaProduk(){
        // Ambil data produk
        $produk = DB::table('products AS p')
            ->join('users AS u', 'p.supplier_id', '=', 'u.id')
            ->get(['p.*', 'u.nama']);

        // Ambil data stok rendah
        $stok_rendah = DB::table('products')
            ->where('stok', '<', 2)
            ->select('id', 'nama_barang', 'stok')
            ->orderBy('stok', 'asc')
            ->get();

        // Ambil data order konfirmasi
        $order_konfirmasi = DB::table('transaksi')
            ->where('keterangan', 'menunggu konfirmasi')
            ->join('users', 'transaksi.pelanggan_id', '=', 'users.id')
            ->select(
                'transaksi.id',
                'users.username as nama_pelanggan',
                'transaksi.total',
                'transaksi.waktu_transaksi',
                'transaksi.keterangan'
            )
            ->orderBy('transaksi.waktu_transaksi', 'asc')
            ->get();

        return view('penjual.produk.semua_produk', compact('produk', 'stok_rendah', 'order_konfirmasi'));
    }

    public function TambahProduk() {
        $supplier = User::where('role', 'supplier')
            ->where('status', 'active')
            ->latest()
            ->get(['id','nama']);

        return view('penjual.produk.tambah_produk', compact('supplier'));
    }

    public function EditProduk($id) {
        $pro = Product::where('id', $id)->first();
        $supplier = User::latest()
            ->where('role', 'supplier')
            ->where('status', 'active')
            ->get();

        return view('penjual.produk.edit_product', compact('pro','supplier'));
    }

    public function SimpanProduk(Request $request) {
        // return $request->all();



        // @unlink(public_path('upload/images_produk/'.$data->photo));


        // Image::make($file)->resize(800,800)->save('upload/images_produk/'.$filename);
        // $save_url = 'upload/images_penjual/'.filename;


        // $data['photo'] = $filename;

        $file = $request->file('foto_produk');

        if($file) {
            $lastId = Product::latest()->first('kode_barang') ? : 0;
            if ($lastId === 0) {
                $kodeBarang = 'BRG' . sprintf("%05s", 1);
            }else{
                $urutan = (int) substr($lastId->kode_barang, 3, 5);
                $kodeBarang = 'BRG' . sprintf("%05s", $urutan + 1);
            }

            $filename = hexdec(uniqid()).'.'.$file->getClientOriginalName();
            $file->move(public_path('upload/images_produk'), $filename);

            $pro = new Product();

            $pro->kode_barang = $kodeBarang;
            $pro->nama_barang = $request->nama_produk;
            $pro->deskripsi = $request->deskripsi;
            $pro->harga = $request->harga;
            $pro->supplier_id = $request->supplier;
            $pro->stok = $request->stok;
            $pro->image = $filename;

            $pro = $pro->save();

            if($pro)
            {
                return redirect('semua/produk');
            }else {
                return 'gagal disimpan';
            }
        }else {
            $pro = new Product();

            $pro->kode_barang = 'P00001';
            $pro->nama_barang = $request->nama_produk;
            $pro->deskripsi = $request->deskripsi;
            $pro->harga = $request->harga;
            $pro->supplier_id = $request->supplier;
            $pro->stok = $request->stok;

            $pro = $pro->save();
        }
    }

    public function UpdateProduk(Request $request) {
        $pro = Product::where('id', $request->id)->first();
        $pro->nama_barang = $request->nama_produk;
        $pro->deskripsi = $request->deskripsi;
        $pro->harga = $request->harga;
        $pro->supplier_id = $request->supplier;
        $pro->stok = $request->stok;

        $file = $request->file('foto_produk');

        if ($file) {
            @unlink(public_path('upload/images_produk/'.$pro->image));
            $filename = hexdec(uniqid()).'.'.$file->getClientOriginalName();
            $file->move(public_path('upload/images_produk'), $filename);
            $pro->image = $filename;
        }

        $pro->update();

        return redirect('semua/produk');
    }
}
