<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function processCheckout(Request $request)
    {
        if (! Session::has('cart') || count(Session::get('cart')) == 0) {
            return redirect('/')->with('error', 'Keranjang Anda kosong!');
        }

        return redirect()->route('checkout.show');
    }

    public function showPaymentPage()
    {
        if (! Session::has('cart') || count(Session::get('cart')) == 0) {
            return redirect('/');
        }

        $cart       = Session::get('cart');
        $cartItems  = [];
        $grandTotal = 0; // Ini akan menjadi total akhir

        foreach ($cart as $id => $details) {
            $cartItems[] = (object) [
                'id'       => $id,
                'name'     => $details['name'],
                'qty'      => $details['qty'],
                'price'    => $details['price'],
                'image'    => $details['image'],
                'subtotal' => $details['price'] * $details['qty'],
            ];
            $grandTotal += $details['price'] * $details['qty']; // Langsung hitung total akhir di sini
        }

        $user = Auth::user();

        return view('pembeli.checkout', [
            'cartItems'  => collect($cartItems),
            'user'       => $user,
            'grandTotal' => $grandTotal,
        ]);
    }
}
