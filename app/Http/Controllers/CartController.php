<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart($productId)
    {
        $product = DB::table('products')->where('id', $productId)->first();

        if (! $product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan!',
            ], 404);
        }

        if ($product->stok < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Stok produk habis!',
            ], 422);
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            if ($cart[$productId]['qty'] + 1 > $product->stok) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi! Hanya tersisa ' . $product->stok,
                ], 422);
            }
            $cart[$productId]['qty'] += 1;
        } else {
            $cart[$productId] = [
                "name"  => $product->nama_barang,
                "qty"   => 1,
                "price" => $product->harga,
                "image" => $product->image ? asset('upload/images_produk/' . $product->image) : asset('images/no-image.png'),
            ];
        }

        Session::put('cart', $cart);
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
        $product  = DB::table('products')->where('id', $productId)->first();

        if (! $product) {
            return response()->json([
                'success' => false,
                'message' => 'Produk tidak ditemukan!',
            ], 404);
        }

        if ($quantity > $product->stok) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak cukup! Stok tersedia hanya ' . $product->stok . ' item.',
            ], 422);
        }

        if (isset($cart[$productId]) && $quantity > 0) {
            $cart[$productId]['qty'] = $quantity;
            Session::put('cart', $cart);

            return $this->getCartDataForResponse();
        }

        if ($quantity <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Jumlah produk harus lebih dari 0.',
            ], 422);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal memperbarui keranjang. Produk tidak ditemukan di keranjang.',
        ]);
    }

    public function removeCartItem($productId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);

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
