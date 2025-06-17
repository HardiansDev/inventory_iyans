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
                            <h5><strong>Tanggal Pesanan:</strong> <span
                                    id="order-date">{{ now()->format('d-m-Y H:i:s') }}</span></h5>
                            <input type="hidden" name="date_order" value="{{ now()->format('Y-m-d H:i:s') }}">
                            <h6><strong>No Transaksi:</strong> <span id="order-number"></span></h6>
                            <input type="hidden" name="transaction_number" id="transaction_number">
                        </div>
                        <div class="col-md-6 text-end">
                            <h5><strong>Nomor Invoice:</strong> <span id="invoice-number"></span></h5>
                            <input type="hidden" name="invoice_number" id="invoice_number_input">
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
                                @foreach ($wishlist ?? [] as $index => $item)
                                    <tr>
                                        <td>{{ $item['name'] }}</td>
                                        <td>{{ $item['qty'] }}</td>
                                        <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</td>
                                    </tr>
                                    <input type="hidden" name="sales[{{ $index }}][id]" value="{{ $item['id'] }}">
                                    <input type="hidden" name="sales[{{ $index }}][qty]"
                                        value="{{ $item['qty'] }}">
                                    @php $totalPrice += $item['price'] * $item['qty']; @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="amount_formatted" class="font-weight-bold">Jumlah Pembayaran:</label>
                                <input type="text" id="amount_formatted" class="form-control"
                                    placeholder="Masukkan jumlah pembayaran">
                                <input type="hidden" name="amount" id="amount">
                            </div>
                            <h4 class="text-success">Kembalian: <span id="change-display">0</span></h4>
                            <input type="hidden" name="change" id="change-input">
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="discount_id" class="font-weight-bold">Pilih Diskon:</label>
                                <select id="discount_id" class="form-control" name="discount_id">
                                    <option value="">Tanpa Diskon</option>
                                    @foreach ($discounts ?? [] as $discount)
                                        <option value="{{ $discount->id }}">{{ $discount->name }}
                                            ({{ $discount->nilai }}%)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 text-end">
                            <h4 class="text-success">Total Harga: <span id="total-price-display">Rp
                                    {{ number_format($totalPrice, 0, ',', '.') }}</span></h4>
                            <input type="hidden" name="total" id="total" value="{{ $totalPrice }}">
                            <h5 class="text-success">Total Bayar: <span id="discounted-total">Rp
                                    {{ number_format($totalPrice, 0, ',', '.') }}</span></h5>
                            <input type="hidden" name="subtotal" id="subtotal_input" value="{{ $totalPrice }}">
                        </div>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <a href="{{ route('sales.index') }}" class="btn btn-secondary mx-3">Batal</a>
                        <button type="button" class="btn btn-success" id="confirm-payment-btn">
                            <span id="btn-text">Konfirmasi Pembayaran</span>
                            <span id="btn-loading" class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const transactionNumber = 'TRX' + Date.now();
            const invoiceNumber = 'INV-' + Date.now();

            document.getElementById('order-number').textContent = transactionNumber;
            document.getElementById('invoice-number').textContent = invoiceNumber;
            document.getElementById('transaction_number').value = transactionNumber;
            document.getElementById('invoice_number_input').value = invoiceNumber;

            const amountFormattedInput = document.getElementById('amount_formatted');
            const amountHiddenInput = document.getElementById('amount');
            const changeDisplay = document.getElementById('change-display');
            const changeInput = document.getElementById('change-input');
            const subtotalInput = document.getElementById('subtotal_input');
            const discountSelect = document.getElementById('discount_id');
            const discountedTotalDisplay = document.getElementById('discounted-total');
            const totalInput = document.getElementById('total');

            // Diskon map untuk lookup % dari ID
            const discountMap = {
                @foreach ($discounts ?? [] as $discount)
                    {{ $discount->id }}: {{ $discount->nilai }},
                @endforeach
            };

            function formatRupiah(number) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
            }

            function parseRupiah(str) {
                return parseInt(str.replace(/[^\d]/g, '')) || 0;
            }

            function calculateTotal() {
                const baseTotal = parseInt(totalInput.value) || 0;
                const selectedDiscountId = parseInt(discountSelect.value);
                const discountPercent = discountMap[selectedDiscountId] || 0;
                const discountedAmount = Math.floor(baseTotal - (baseTotal * discountPercent / 100));

                discountedTotalDisplay.textContent = formatRupiah(discountedAmount);
                subtotalInput.value = discountedAmount;

                calculateChange();
            }

            function calculateChange() {
                const amount = parseInt(amountHiddenInput.value) || 0;
                const subtotal = parseInt(subtotalInput.value) || 0;
                const change = amount - subtotal;

                changeDisplay.textContent = formatRupiah(change);
                changeInput.value = change;
            }

            // Format input pembayaran dengan titik
            amountFormattedInput.addEventListener('input', function() {
                let raw = this.value.replace(/[^\d]/g, '');
                this.value = new Intl.NumberFormat('id-ID').format(raw);
                amountHiddenInput.value = raw;
                calculateChange();
            });

            discountSelect.addEventListener('change', calculateTotal);
            calculateTotal();

            const btn = document.getElementById('confirm-payment-btn');
            const btnText = document.getElementById('btn-text');
            const btnLoading = document.getElementById('btn-loading');
            const form = document.getElementById('checkout-form');

            btn.addEventListener('click', function() {
                const amount = parseInt(amountHiddenInput.value) || 0;
                const subtotal = parseInt(subtotalInput.value) || 0;

                if (amount < subtotal) {
                    toastr.error('Jumlah pembayaran kurang dari total belanja.');
                    return;
                }

                btn.disabled = true;
                btnText.classList.add('d-none');
                btnLoading.classList.remove('d-none');

                const formData = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success && data.transaction_url) {
                            window.open(data.transaction_url, '_blank');
                            window.location.href = "{{ route('sales.index') }}";
                        } else {
                            toastr.error(data.message || 'Gagal memproses pembayaran.');
                        }
                    })
                    .catch(err => {
                        console.error('AJAX Error:', err);
                        toastr.error('Terjadi kesalahan saat menghubungi server.');
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btnText.classList.remove('d-none');
                        btnLoading.classList.add('d-none');
                    });
            });
        });
    </script>
@endpush
