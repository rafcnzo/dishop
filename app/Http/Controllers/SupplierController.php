<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function SemuaSupplier(){
        $supplier = User::latest()
            ->where('role', 'supplier')
            ->where('status', 'active')
            ->get();

        // Ambil data stok rendah
        $stok_rendah = \DB::table('products')
            ->where('stok', '<', 2)
            ->select('id', 'nama_barang', 'stok')
            ->orderBy('stok', 'asc')
            ->get();

        // Ambil data order konfirmasi
        $order_konfirmasi = \DB::table('transaksi')
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

        return view('penjual.supplier.semua_supplier', compact('supplier', 'stok_rendah', 'order_konfirmasi'));
    }

    public function TambahSupplier() {
        return view('penjual.supplier.tambah_supplier');
    }

    public function EditSupplier($id) {
        $sup = User::where('id', $id)->first();

        return view('penjual.supplier.edit_supplier', compact('sup'));
    }

    public function SimpanSupplier(Request $request) {

        $sup = User::create([
            'nama' => $request->nama_supplier,
            'jenis_kelamin' => $request->jenis_kelamin,
            'phone' => $request->phone,
            'role' => 'supplier',
            'alamat' => $request->alamat,
        ]);

        return redirect('semua/supplier');
    }

    public function UpdateSupplier(Request $request) {
        $sup = User::where('id', $request->id)->first();
        $sup->nama = $request->nama_supplier;
        $sup->jenis_kelamin = $request->jenis_kelamin;
        $sup->phone = $request->phone;
        $sup->alamat = $request->alamat;
        $sup->update();

        return redirect('semua/supplier');
    }
}
