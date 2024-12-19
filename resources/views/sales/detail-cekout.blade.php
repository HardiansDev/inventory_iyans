@extends('layouts.master')

@section('title')
    <title>Order Detail | Sistem Inventory Iyan</title>
@endsection

@section('content')
    <section class="content-header py-4 bg-light rounded">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <h1 class="mb-0 text-black">Order Detail</h1>
                </div>
                <div class="col-auto">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}" class="text-decoration-none text-secondary">
                                    <i class="fa fa-dashboard"></i> Dashboard
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Order Detail</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container mt-4" style="max-width: 1200px;">
            <!-- Order Table -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Qty</th>
                        <th>Harga</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Produk A</td>
                        <td>2</td>
                        <td>Rp 50.000</td>
                        <td>Rp 100.000</td>
                    </tr>
                    <tr>
                        <td>Produk B</td>
                        <td>1</td>
                        <td>Rp 75.000</td>
                        <td>Rp 75.000</td>
                    </tr>
                    <tr>
                        <td>Produk C</td>
                        <td>3</td>
                        <td>Rp 30.000</td>
                        <td>Rp 90.000</td>
                    </tr>
                </tbody>
            </table>

            <!-- Totals -->
            <div class="mb-4">
                <h5>Total Harga: <strong id="total-price">Rp 265.000</strong></h5>
            </div>

            <!-- Form Diskon dan Amount -->
            <form action="" method="POST">
                {{-- @csrf --}}
                <div class="mb-3">
                    <label for="discount">Diskon (%)</label>
                    <select name="discount" id="discount" class="form-control">
                        <option value="0">0%</option>
                        <option value="10">10%</option>
                        <option value="20">20%</option>
                        <option value="30">30%</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="amount">Amount</label>
                    <input type="number" name="amount" id="amount" class="form-control" required>
                </div>

                <!-- Subtotal dan Kembalian -->
                <div class="mb-3">
                    <label for="subtotal">Subtotal</label>
                    <input type="text" id="subtotal" class="form-control" readonly value="Rp 265.000">
                </div>

                <div class="mb-3">
                    <label for="change">Kembalian</label>
                    <input type="text" id="change" class="form-control" readonly value="Rp 0">
                </div>

                <button type="submit" class="btn btn-success w-100 mt-3">Checkout</button>
            </form>
        </div>
    </section>
@endsection
