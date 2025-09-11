<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;


class CartController extends Controller
{
    public function addToCart($productId)
    {
        $product = DB::table('products')->where('id', $productId)->first();

        if (! $product) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan!']);
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['qty']++;
        } else {
            $cart[$productId] = [
                "name"  => $product->nama_barang,
                "qty"   => 1,
                "price" => $product->harga,
                "image" => $product->image ? asset('upload/images_produk/' . $product->image) : asset('images/no-image.png'),
            ];
        }

        Session::put('cart', $cart);

        // Panggil helper method untuk mengembalikan data keranjang lengkap
        return $this->getCartDataForResponse();
    }

    public function getCartItems()
    {
        return $this->getCartDataForResponse();
    }

    public function updateCart(Request $request, $productId)
    {
        $cart     = Session::get('cart', []);
        $quantity = $request->input('quantity');

        // Validasi: pastikan kuantitas valid dan produk ada di keranjang
        if (isset($cart[$productId]) && $quantity > 0) {
            $cart[$productId]['qty'] = $quantity;
            Session::put('cart', $cart);

            // Setelah update, kirim kembali seluruh data keranjang yang sudah diperbarui
            return $this->getCartDataForResponse();
        }

        return response()->json(['success' => false, 'message' => 'Gagal memperbarui keranjang.']);
    }

    public function removeCartItem($productId)
    {
        $cart = Session::get('cart', []);

        // Cek apakah produk ada di keranjang, lalu hapus
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);

            // Kirim kembali data keranjang yang sudah diperbarui
            return $this->getCartDataForResponse();
        }

        return response()->json(['success' => false, 'message' => 'Gagal menghapus item.']);
    }

    private function getCartDataForResponse()
    {
        $cart       = Session::get('cart', []);
        $totalHarga = 0;
        foreach ($cart as $id => $details) {
            $totalHarga += $details['price'] * $details['qty'];
        }

        return response()->json([
            'success'   => true,
            'cartItems' => $cart,
            'cartTotal' => $totalHarga,
            'cartCount' => count($cart),
        ]);
    }
}
