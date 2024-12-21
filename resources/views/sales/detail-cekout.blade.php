@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Detail Pesanan</title>
@endsection

@section('content')
    <div class="container-fluid mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-teal text-white">
                <h2 class="text-center font-weight-bold mb-0">Detail Pesanan</h2>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5><strong>Tanggal Pesanan:</strong> <span id="order-date">{{ now()->format('d-m-Y H:i:s') }}</span>
                        </h5>
                    </div>
                    <div class="col-md-6 text-end">
                        <h5><strong>Nomor Invoice:</strong> <span
                                id="invoice-number">INV-{{ now()->format('YmdHis') }}</span></h5>
                    </div>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>Nama Produk</th>
                                <th>Qty</th>
                                <th>Harga Satuan</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalPrice = 0; @endphp
                            @foreach ($wishlist as $item)
                                <tr>
                                    <td>{{ $item['name'] }}</td>
                                    <td>{{ $item['qty'] }}</td>
                                    <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</td>
                                </tr>
                                @php $totalPrice += $item['price'] * $item['qty']; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="amount" class="font-weight-bold">Jumlah Pembayaran:</label>
                            <input type="text" id="amount" class="form-control" name="amount"
                                placeholder="Masukkan jumlah pembayaran" oninput="formatAmount()">
                        </div>
                        <h4 class="text-success">Kembalian: Rp <span id="change" name="change">0</span></h4>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="discount" class="font-weight-bold">Pilih Diskon:</label>
                            <select id="discount" class="form-control" onchange="calculateTotal()">
                                <option value="0">Tanpa Diskon</option>
                                <option value="10">10%</option>
                                <option value="20">20%</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 text-right">
                        <div class="mb-3">
                            <h4 class="text-success">Total Harga: <span id="total-price-display">Rp
                                    {{ number_format($totalPrice, 0, ',', '.') }}</span></h4>
                            <input type="hidden" id="total-price" value="{{ $totalPrice }}">
                        </div>
                        <div>
                            <h5 class="text-success">Total Bayar: <span id="discounted-total">Rp
                                    {{ number_format($totalPrice, 0, ',', '.') }}</span></h5>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <a href="/sales" class="btn btn-secondary mx-3">Batal</a> <!-- Menambahkan margin horizontal -->
                    <form id="checkout-form" method="POST" action="/proses-pembayaran">
                        @csrf
                        <button type="submit" class="btn btn-success">Konfirmasi Pembayaran</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <script>
        function calculateTotal() {
            const totalPrice = parseFloat(document.getElementById('total-price').value);
            const discount = parseInt(document.getElementById('discount').value) || 0;
            const discountedTotal = totalPrice - (totalPrice * discount / 100);

            document.getElementById('discounted-total').textContent = isNaN(discountedTotal) ? 0 : discountedTotal
                .toLocaleString('id-ID');
            calculateChange();
        }

        function formatAmount() {
            let amountInput = document.getElementById('amount');
            let amountValue = amountInput.value.replace(/\D/g, '');

            if (amountValue) {
                amountValue = parseInt(amountValue).toLocaleString('id-ID');
            }

            amountInput.value = amountValue;
            calculateChange();
        }

        function calculateChange() {
            const subtotalElement = document.getElementById('discounted-total');
            const amountElement = document.getElementById('amount');
            const changeElement = document.getElementById('change');

            if (!subtotalElement || !amountElement || !changeElement) {
                console.error("Salah satu elemen tidak ditemukan!");
                return;
            }

            let subtotalText = subtotalElement.textContent.replace(/\D/g, '');
            let subtotal = parseFloat(subtotalText) || 0;

            let amountText = amountElement.value.replace(/\D/g, '');
            let amount = parseFloat(amountText) || 0;

            let change = amount - subtotal;
            change = Math.max(0, change);

            changeElement.textContent = change.toLocaleString('id-ID');

            console.log("Subtotal:", subtotal);
            console.log("Amount:", amount);
            console.log("Change:", change);
        }

        function prepareForSubmit() {
            let amountInput = document.getElementById('amount');
            amountInput.value = amountInput.value.replace(/\D/g, '');
        }

        function confirmCheckout() {
            // ... validasi jumlah pembayaran

            prepareForSubmit();

            const totalPrice = parseFloat(document.getElementById('total-price').value);
            const discount = parseInt(document.getElementById('discount').value) || 0;
            const products = [];
            const productInputs = document.querySelectorAll('[name^="products"]');
            productInputs.forEach(input => {
                const parts = input.name.match(/products\[(\d+)\]\[(\w+)\]/);
                if (parts) {
                    const index = parts[1];
                    const key = parts[2];
                    products[index] = products[index] || {};
                    products[index][key] = input.value;
                }
            });
            console.log({
                subtotal,
                amount,
                change,
                total_price: totalPrice,
                discount,
                products,
            });

            fetch('/proses-pembayaran', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        subtotal: subtotal,
                        amount: amount,
                        change: change,
                        total_price: totalPrice,
                        discount: discount,
                        products: products,
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '/print-struk'; // Redirect
                    } else {
                        alert(data.message || 'Terjadi kesalahan.');
                    }
                })
                .catch(error => {
                    console.error("Error during fetch:", error);
                    alert("Terjadi kesalahan jaringan atau server.");
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            calculateTotal();

            const checkoutForm = document.getElementById('checkout-form');
            if (checkoutForm) {
                checkoutForm.addEventListener('submit', function(event) {
                    event.preventDefault();
                    console.log("Form submitted!");
                    confirmCheckout();
                });
            }
        });

        const amountInput = document.getElementById('amount');
        if (amountInput) {
            amountInput.addEventListener('input', formatAmount);
        }
    </script>
@endsection
