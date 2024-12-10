<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        // Tambahkan logika untuk menampilkan data customer
        return view('customer.index'); // Sesuaikan dengan nama file view
    }
}
