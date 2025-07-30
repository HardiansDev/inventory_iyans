<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Discount;

class CheckoutController extends Controller
{
    public function setWishlist(Request $request)
    {
        // Validasi data kasar, bisa ditambah kalau mau
        $wishlist = $request->json()->all();

        if (!is_array($wishlist)) {
            return response()->json(['success' => false, 'message' => 'Invalid wishlist data.'], 422);
        }

        // Simpan ke session
        $request->session()->put('wishlist', $wishlist);

        return response()->json(['success' => true]);
    }

    /**
     * Tampilkan halaman checkout, ambil data dari session.
     */
    public function showCheckout(Request $request)
    {
        $wishlist = $request->session()->get('wishlist', []);

        // Optional: validasi basic isi wishlist
        foreach ($wishlist as $item) {
            if (!isset($item['sales_id'], $item['qty'], $item['name'], $item['price'])) {
                return redirect()->route('sales.index')->with('error', 'Data produk di keranjang tidak lengkap.');
            }
        }

        $discounts = Discount::all();
        $change = 0;

        return view('sales.detail-cekout', compact('wishlist', 'discounts', 'change'));
    }
}
