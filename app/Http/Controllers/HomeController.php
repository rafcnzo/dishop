<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    public function index()
    {
        $products = DB::table('products')->orderBy('created_at', 'desc')->limit(4)->get();

        $bestsellerId = DB::table('transaksi_detail as td')
            ->join('transaksi as t', 'td.transaksi_id', '=', 't.id')
            ->join('products as p', 'td.barang_id', '=', 'p.id')
            ->select('td.barang_id', DB::raw('SUM(td.qty) as total_qty'))
            ->groupBy('td.barang_id')
            ->orderByDesc('total_qty')
            ->limit(1)
            ->pluck('td.barang_id')
            ->first();

        $now           = now();
        $newProductIds = $products->filter(function ($item) use ($now) {
            return \Carbon\Carbon::parse($item->created_at)->diffInDays($now) < 7;
        })->pluck('id')->toArray();

        $products = $products->map(function ($item) use ($bestsellerId, $newProductIds) {
            return (object) [
                'id'            => $item->id,
                'name'          => $item->nama_barang,
                'description'   => $item->deskripsi,
                'price'         => $item->harga,
                'image'         => $item->image,
                'is_bestseller' => $item->id == $bestsellerId,
                'is_new'        => in_array($item->id, $newProductIds),
                'category'      => (object) [
                    'name' => 'Uncategorized',
                ],
            ];
        });

        return view('index', compact('products'));
    }

    public function loadMoreProducts(Request $request)
    {
        $page    = $request->get('page', 1);
        $perPage = 4;
        $offset  = ($page - 1) * $perPage;

        $products = DB::table('products')
            ->orderBy('created_at', 'desc')
            ->offset($offset)
            ->limit($perPage)
            ->get();

        $bestsellerId = DB::table('transaksi_detail as td')
            ->join('transaksi as t', 'td.transaksi_id', '=', 't.id')
            ->join('products as p', 'td.barang_id', '=', 'p.id')
            ->select('td.barang_id', DB::raw('SUM(td.qty) as total_qty'))
            ->groupBy('td.barang_id')
            ->orderByDesc('total_qty')
            ->limit(1)
            ->pluck('td.barang_id')
            ->first();

        $now           = now();
        $newProductIds = $products->filter(function ($item) use ($now) {
            return \Carbon\Carbon::parse($item->created_at)->diffInDays($now) < 7;
        })->pluck('id')->toArray();

        $products = $products->map(function ($item) use ($bestsellerId, $newProductIds) {
            return (object) [
                'id'            => $item->id,
                'name'          => $item->nama_barang,
                'description'   => $item->deskripsi,
                'price'         => $item->harga,
                'image'         => $item->image,
                'is_bestseller' => $item->id == $bestsellerId,
                'is_new'        => in_array($item->id, $newProductIds),
                'category'      => (object) [
                    'name' => 'Uncategorized',
                ],
            ];
        });

        $html = '';
        foreach ($products as $product) {
            $html .= view('layouts.partials._product_card', compact('product'))->render();
        }

        $totalProducts = DB::table('products')->count();
        $hasMore       = ($offset + $perPage) < $totalProducts;

        return response()->json(['html' => $html, 'hasMore' => $hasMore]);
    }

    public function searchProducts(Request $request)
    {
        // Hanya proses jika ada query
        if ($request->has('query')) {
            $query = $request->get('query');

            $products = DB::table('products')
                ->where('nama_barang', 'LIKE', "%{$query}%") // Cari berdasarkan nama barang
                                                         // ->orWhere('deskripsi', 'LIKE', "%{$query}%") // Opsional: cari di deskripsi juga
                ->select('nama_barang', 'harga', 'image')    // Ambil kolom yang dibutuhkan
                ->limit(5)                                   // Batasi hasilnya, misal 5 produk
                ->get();

            // Ubah path gambar menjadi URL lengkap
            $products->transform(function ($item) {
                $item->image_url = $item->image
                    ? asset('upload/images_produk/' . $item->image)
                    : asset('images/no-image.png');
                return $item;
            });

            return response()->json($products);
        }

        return response()->json([]); // Kembalikan array kosong jika tidak ada query
    }
}
