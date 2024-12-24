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
                <form id="checkout-form" method="POST" action="{{ route('process.payment') }}">
                    @csrf

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>
                                <strong>Tanggal Pesanan:</strong>
                                <span id="order-date">{{ now()->format('d-m-Y H:i:s') }}</span>
                                <input type="hidden" name="date_order" value="{{ now()->format('Y-m-d H:i:s') }}">
                            </h5>
                            <h6>
                                <strong>No Transaksi:</strong>
                                <span id="order-number"></span>
                                <input type="hidden" name="transaction_number" id="transaction_number" value="">
                            </h6>
                        </div>
                        <div class="col-md-6 text-end">
                            <h5>
                                <strong>Nomor Invoice:</strong>
                                <span id="invoice-number"></span>
                                <input type="hidden" name="invoice_number" id="invoice_number_input" value="">
                            </h5>
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
                                @if ($wishlist && is_array($wishlist) && count($wishlist) > 0)
                                    @foreach ($wishlist as $index => $item)
                                        @if (isset($item['id']) && isset($item['name']) && isset($item['price']) && isset($item['qty']))
                                            <tr>
                                                <td>{{ $item['name'] }}</td>
                                                <td>{{ $item['qty'] }}</td>
                                                <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                                <td>Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</td>
                                            </tr>
                                            <input type="hidden" name="sales[{{ $index }}][id]"
                                                value="{{ $item['id'] }}">
                                            <input type="hidden" name="sales[{{ $index }}][qty]"
                                                value="{{ $item['qty'] }}">
                                            @php $totalPrice += $item['price'] * $item['qty']; @endphp
                                        @else
                                            {{-- Debugging: Tampilkan item yang bermasalah --}}
                                            <tr>
                                                <td colspan="4" style="color: red;">Error: Item wishlist tidak valid:
                                                    {{ json_encode($item) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">Tidak ada item di wishlist.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- Subtotal --}}
                    {{-- <div class="form-group">
                        <label for="subtotal">Subtotal</label>
                        <input type="number" class="form-control" id="subtotal" name="subtotal"
                            value="{{ $totalPrice ?? 0 }}" readonly required>
                    </div> --}}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="amount" class="font-weight-bold">Jumlah Pembayaran:</label>
                                <input type="text" id="amount" class="form-control" name="amount"
                                    placeholder="Masukkan jumlah pembayaran">
                            </div>
                            <h4 class="text-success">Kembalian: Rp <span id="change-display">0</span></h4>
                            <input type="hidden" id="change-input" name="change"
                                value="{{ old('change', $change ?? 0) }}">
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="discount_id" class="font-weight-bold">Pilih Diskon:</label>
                                <select id="discount_id" class="form-control" name="discount_id">
                                    <option value="">Tanpa Diskon</option>
                                    @if (isset($discounts))
                                        @foreach ($discounts as $discount)
                                            <option value="{{ $discount->id }}">{{ $discount->name }}
                                                ({{ $discount->percentage }}%)
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 text-right">
                            <h4 class="text-success">Total Harga:
                                <span id="total-price-display">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </h4>
                            <input type="hidden" id="total" name="total" value="{{ $totalPrice }}">
                            <h5 class="text-success">Total Bayar:
                                <span id="discounted-total">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </h5>
                            <input type="hidden" id="subtotal_input" name="subtotal" value="{{ $totalPrice }}">
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <a href="/sales" class="btn btn-secondary mx-3">Batal</a>
                        <button type="submit" class="btn btn-success">Konfirmasi Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const transactionNumberSpan = document.getElementById('order-number');
            const transactionNumberInput = document.getElementById('transaction_number');
            const invoiceNumberSpan = document.getElementById('invoice-number');
            const invoiceNumberInput = document.getElementById('invoice_number_input');
            const amountInput = document.getElementById('amount');
            const changeSpan = document.getElementById('change');
            const totalInput = document.getElementById('total');
            const discountedTotalDisplay = document.getElementById('discounted-total');
            const discountSelect = document.getElementById('discount_id');
            const subtotalInput = document.getElementById('subtotal_input');
            const checkoutForm = document.getElementById('checkout-form'); // Simpan referensi form

            const timestamp = new Date().getTime();
            const random = Math.floor(Math.random() * 1000);

            const transactionNumber = 'TRX' + timestamp + random;
            const invoiceNumber = 'INV-' + timestamp;

            transactionNumberSpan.textContent = transactionNumber;
            transactionNumberInput.value = transactionNumber;
            invoiceNumberSpan.textContent = invoiceNumber;
            invoiceNumberInput.value = invoiceNumber;

            function calculateTotal() {
                let totalPrice = parseFloat(totalInput.value) || 0;
                let discount = parseFloat(discountSelect.value) || 0;
                let discountedTotal = totalPrice;

                if (discount > 0) {
                    discountedTotal = totalPrice - (totalPrice * (discount / 100));
                }

                discountedTotalDisplay.innerText = new Intl.NumberFormat('id-ID').format(discountedTotal);
                subtotalInput.value = discountedTotal;
            }

            function calculateChange() {
                const amount = parseFloat(amountInput.value.replace(/\D/g, '')) || 0;
                const total = parseFloat(subtotalInput.value) || 0; // Menggunakan subtotal yang sudah didiskon
                const change = amount - total;
                // Perbarui tampilan kembalian
                const changeDisplay = document.getElementById('change-display');
                changeDisplay.textContent = new Intl.NumberFormat('id-ID').format(change);

                // Perbarui nilai input hidden
                const changeInput = document.getElementById('change-input');
                changeInput.value = change; // Simpan nilai kembalian tanpa format
            }

            discountSelect.addEventListener('change', calculateTotal);

            amountInput.addEventListener('input', function() {
                this.value = new Intl.NumberFormat('id-ID').format(this.value.replace(/\D/g, ''));
                calculateChange();
            });

            calculateTotal(); // Panggil saat DOMContentLoaded untuk inisialisasi

            checkoutForm.addEventListener('submit', function(event) { // Event listener di form
                let sales = [];
                let hasError = false;

                document.querySelectorAll('.sale-item').forEach(item => {
                    let qtyInput = item.querySelector('.qty-input');
                    let qty = parseInt(qtyInput.value) || 0;

                    if (qty <= 0) {
                        alert("Kuantitas harus lebih dari 0 untuk " + item.dataset.productName);
                        qtyInput.focus();
                        hasError = true;
                        event.preventDefault(); // Prevent default form submission
                        return; // Exit forEach loop
                    }

                    sales.push({
                        id: parseInt(item.dataset.saleId),
                        qty: qty
                    });
                });

                if (hasError) {
                    return; // Stop processing if there are quantity errors
                }

                const amount = parseFloat(amountInput.value.replace(/\D/g, '')) || 0;
                const discountedTotal = parseFloat(subtotalInput.value) || 0;

                if (amount < discountedTotal) {
                    alert("Jumlah pembayaran kurang! Silakan masukkan jumlah yang cukup.");
                    amountInput.focus();
                    event.preventDefault(); // Prevent default form submission
                    return;
                }
                const amountInputHidden = document.createElement('input');
                amountInputHidden.type = 'hidden';
                amountInputHidden.name = 'amount'; // Sesuaikan dengan nama field yang diinginkan
                amountInputHidden.value = amount; // Nilai integer
                checkoutForm.appendChild(amountInputHidden);

                document.getElementById('sales').value = JSON.stringify(sales);
            });
        });
    </script>
@endsection
