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
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">Tidak ada item di wishlist.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="amount_formatted" class="font-weight-bold">Jumlah Pembayaran:</label>
                                <input type="text" id="amount_formatted" class="form-control"
                                    placeholder="Masukkan jumlah pembayaran">
                                <input type="hidden" name="amount" id="amount" value="">
                            </div>
                            <h4 class="text-success">Kembalian: Rp <span id="change-display">0</span></h4>
                            <input type="hidden" id="change-input" name="change" value="0">
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
            // Generate no transaksi & invoice
            const transactionNumber = 'TRX' + Date.now();
            const invoiceNumber = 'INV-' + Date.now();

            document.getElementById('order-number').textContent = transactionNumber;
            document.getElementById('transaction_number').value = transactionNumber;
            document.getElementById('invoice-number').textContent = invoiceNumber;
            document.getElementById('invoice_number_input').value = invoiceNumber;

            const amountInputFormatted = document.getElementById('amount_formatted');
            const amountInputRaw = document.getElementById('amount');
            const changeDisplay = document.getElementById('change-display');
            const changeInput = document.getElementById('change-input');
            const subtotalInput = document.getElementById('subtotal_input');
            const discountSelect = document.getElementById('discount_id');
            const discountedTotalDisplay = document.getElementById('discounted-total');
            const totalInput = document.getElementById('total');
            const checkoutForm = document.getElementById('checkout-form');

            // Format input jumlah pembayaran
            amountInputFormatted.addEventListener('input', function() {
                let raw = this.value.replace(/[^\d]/g, '');
                this.value = new Intl.NumberFormat('id-ID').format(raw);
                amountInputRaw.value = raw;
                calculateChange();
            });

            // Hitung diskon saat diskon berubah
            discountSelect.addEventListener('change', calculateTotal);

            // Hitung total harga diskon
            function calculateTotal() {
                let totalPrice = parseFloat(totalInput.value) || 0;
                let discountId = parseInt(discountSelect.value) || 0;
                let discountPercent = 0;

                // Ambil diskon dari server-side via Blade
                @if (isset($discounts))
                    let discountMap = {
                        @foreach ($discounts as $d)
                            {{ $d->id }}: {{ $d->percentage }},
                        @endforeach
                    };
                    discountPercent = discountMap[discountId] || 0;
                @endif

                let discounted = totalPrice - (totalPrice * discountPercent / 100);
                discountedTotalDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(discounted);
                subtotalInput.value = discounted;

                calculateChange();
            }

            // Hitung kembalian
            function calculateChange() {
                const pay = parseInt(amountInputRaw.value) || 0;
                const subtotal = parseInt(subtotalInput.value) || 0;
                const change = pay - subtotal;
                changeDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(change);
                changeInput.value = change;
            }

            // Validasi submit form
            checkoutForm.addEventListener('submit', function(e) {
                const pay = parseInt(amountInputRaw.value || 0);
                const subtotal = parseInt(subtotalInput.value || 0);

                if (!pay || isNaN(pay)) {
                    alert('Jumlah pembayaran harus diisi!');
                    amountInputFormatted.focus();
                    e.preventDefault();
                    return;
                }

                if (pay < subtotal) {
                    alert('Jumlah pembayaran kurang dari total belanja!');
                    amountInputFormatted.focus();
                    e.preventDefault();
                    return;
                }
            });

            // Inisialisasi perhitungan pertama
            calculateTotal();
        });
    </script>

@endsection
