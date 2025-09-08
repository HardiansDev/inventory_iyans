<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductIn;

class TrackingTreeController extends Controller
{
    public function index()
    {
        $productsIn = ProductIn::with('product')->get();
        return view('trackingtree.index', compact('productsIn'));
    }

    public function show($id)
    {
        $productIn = ProductIn::with('product')->findOrFail($id);
        return view('trackingtree.show', compact('productIn'));
    }
}
