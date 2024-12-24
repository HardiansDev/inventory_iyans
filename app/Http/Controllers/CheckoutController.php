<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Discount;

class CheckoutController extends Controller
{
    public function setWishlist(Request $request)
    {
        $request->session()->put('wishlist', $request->json()->all());
        return response()->json(['success' => true]);
    }

    public function showCheckout(Request $request)
    {
        $change = 0;
        // dd($request->session()->get('wishlist'));
        $wishlist = $request->session()->get('wishlist');
        if ($wishlist) {
            $wishlist = $wishlist; // Tidak perlu decode lagi karena sudah berupa array saat disimpan
        } else {
            $wishlist = [];
        }

        $discounts = Discount::all();
        return view('sales.detail-cekout', compact('wishlist', 'discounts', 'change'));
    }
}
