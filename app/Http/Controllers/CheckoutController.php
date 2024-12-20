<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function showCheckout(Request $request)
    {
        // Decode wishlist data from query string
        $wishlist = json_decode($request->get('wishlist', '[]'), true);

        // Check if wishlist is valid
        if (empty($wishlist)) {
            return redirect('/')->with('error', 'Wishlist kosong!');
        }

        // Pass wishlist data to the view
        return view('sales.detail-cekout', ['wishlist' => $wishlist]);
    }
}
