@extends('layouts.master')

@section('title')
    <title>Sistem Inventory Iyan | Detail Pesanan</title>
@endsection


@section('content')
    @php
        $transaction_number = $transaction_number ?? 'TRX-' . strtoupper(uniqid());
        $invoice_number = $invoice_number ?? 'INV-' . strtoupper(uniqid());
        $totalPrice = 0;
    @endphp

    <div class="mx-auto mt-6 max-w-6xl px-4">
        <div class="overflow-hidden rounded-lg bg-white shadow-lg dark:bg-gray-900">
            <!-- Header -->
            <div class="bg-teal-600 px-6 py-4 text-white dark:bg-teal-700">
                <h2 class="text-center text-xl font-bold">Detail Pesanan</h2>
            </div>

            <!-- Content -->
            <div class="px-6 py-6 text-gray-800 dark:text-gray-200">
                <form id="checkout-form">
                    @csrf

                    <!-- Info transaksi -->
                    <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div>
                            <p><strong>Tanggal Pesanan:</strong> {{ now()->format('d-m-Y H:i:s') }}</p>
                            <input type="hidden" name="date_order" value="{{ now()->format('Y-m-d') }}">
                            <p><strong>No Transaksi:</strong> {{ $transaction_number }}</p>
                            <input type="hidden" name="transaction_number" value="{{ $transaction_number }}">
                        </div>
                        <div class="text-right">
                            <p><strong>Nomor Invoice:</strong> {{ $invoice_number }}</p>
                            <input type="hidden" name="invoice_number" value="{{ $invoice_number }}">
                        </div>
                    </div>

                    <!-- Table produk -->
                    <div class="mb-6 overflow-x-auto">
                        <table class="w-full table-auto border border-gray-200 text-left dark:border-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-800">
                                <tr>
                                    <th class="border p-2 dark:border-gray-700">Produk</th>
                                    <th class="border p-2 dark:border-gray-700">Qty</th>
                                    <th class="border p-2 dark:border-gray-700">Harga</th>
                                    <th class="border p-2 dark:border-gray-700">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($wishlist ?? [] as $index => $item)
                                    @php
                                        $total = $item['price'] * $item['qty'];
                                        $totalPrice += $total;
                                    @endphp
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                        <td class="border p-2 dark:border-gray-700">{{ $item['name'] }}</td>
                                        <td class="border p-2 dark:border-gray-700">{{ $item['qty'] }}</td>
                                        <td class="border p-2 dark:border-gray-700">Rp
                                            {{ number_format($item['price'], 0, ',', '.') }}</td>
                                        <td class="border p-2 dark:border-gray-700">Rp
                                            {{ number_format($total, 0, ',', '.') }}</td>
                                    </tr>
                                    <input type="hidden" name="sales[]" value="{{ json_encode($item) }}">
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Input pembayaran -->
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <div>
                            <label class="block font-semibold">Jumlah Bayar:</label>
                            <input type="text" id="amount_formatted"
                                class="w-full rounded border px-3 py-2 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                placeholder="Masukkan jumlah pembayaran" required>
                            <input type="hidden" name="amount" id="amount">
                            <p class="mt-2 font-semibold text-green-600 dark:text-green-400" id="change-display">Kembalian:
                                Rp 0</p>
                            <input type="hidden" name="change" id="change-input">
                        </div>
                        <div id="change-warning" class="hidden text-sm font-semibold text-red-500">Uang kurang!</div>

                        <div>
                            <label class="block font-semibold">Diskon:</label>
                            <select name="discount_id" id="discount_id"
                                class="w-full rounded border px-3 py-2 dark:border-gray-700 dark:bg-gray-800 dark:text-white">
                                <option value="" data-percentage="0">Tanpa Diskon</option>
                                @foreach ($discounts as $diskon)
                                    <option value="{{ $diskon->id }}" data-percentage="{{ $diskon->nilai }}">
                                        {{ $diskon->name }} - {{ $diskon->nilai }}%
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold">Metode Pembayaran:</label>
                            <select name="metode_pembayaran" id="metode_pembayaran"
                                class="w-full rounded border px-3 py-2 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                                required>
                                <option value="">-- Pilih --</option>
                                <option value="cash" selected>Cash</option>
                                <option value="qris">QRIS</option>
                            </select>
                        </div>

                        <div>
                            <p class="font-semibold">Total Harga:</p>
                            <h3 class="text-lg font-bold text-green-600 dark:text-green-400" id="total-price-display">Rp
                                {{ number_format($totalPrice, 0, ',', '.') }}</h3>
                            <input type="hidden" name="subtotal" value="{{ $totalPrice }}">
                            <input type="hidden" name="total" id="total-value" value="{{ $totalPrice }}">
                            <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                        </div>

                        <div>
                            <p class="font-semibold">Diskon (Rp):</p>
                            <h3 id="discount-display" class="text-lg font-bold text-orange-500">Rp 0</h3>
                            <input type="hidden" id="discount-value" name="discount_value" value="0">
                        </div>
                    </div>

                    <!-- Action buttons -->
                    <div class="mt-6 text-center">
                        <a href="{{ route('sales.index') }}"
                            class="mr-2 inline-block rounded bg-gray-500 px-4 py-2 text-white hover:bg-gray-600 dark:hover:bg-gray-700">Batal</a>
                        <button type="submit" id="pay-btn"
                            class="inline-flex items-center rounded bg-green-600 px-6 py-2 font-semibold text-white hover:bg-green-700 disabled:opacity-50 dark:bg-green-700 dark:hover:bg-green-800">
                            <span id="btn-text">Bayar Sekarang</span>
                            <span id="btn-loading" class="spinner-border spinner-border-sm ml-2 hidden"
                                role="status"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection




@push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.clientKey') }}">
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('checkout-form');
            const metodeInput = document.getElementById('metode_pembayaran');
            const amountInputFormatted = document.getElementById('amount_formatted');
            const amountInput = document.getElementById('amount');
            const discountSelect = document.getElementById('discount_id');
            const discountDisplay = document.getElementById('discount-display');
            const discountValue = document.getElementById('discount-value');
            const totalPriceDisplay = document.getElementById('total-price-display');
            const totalHiddenInput = document.getElementById('total-value');
            const changeDisplay = document.getElementById('change-display');
            const changeInput = document.getElementById('change-input');
            const payBtn = document.getElementById('pay-btn');
            const btnText = document.getElementById('btn-text');
            const btnLoading = document.getElementById('btn-loading');

            let subtotal = parseInt(document.querySelector('input[name="subtotal"]').value);
            let total = subtotal;

            function updateTotalAndDiscount() {
                const selected = discountSelect.options[discountSelect.selectedIndex];
                const percentage = parseInt(selected.getAttribute('data-percentage')) || 0;
                const discountAmount = Math.floor(subtotal * (percentage / 100));
                total = subtotal - discountAmount;

                discountDisplay.textContent = 'Rp ' + discountAmount.toLocaleString();
                discountValue.value = discountAmount;
                totalPriceDisplay.textContent = 'Rp ' + total.toLocaleString();
                totalHiddenInput.value = total;

                updateChange();
            }

            function updateChange() {
                const metode = metodeInput.value;
                const bayar = parseInt(amountInputFormatted.value.replace(/\D/g, '')) || 0;

                amountInput.value = bayar;

                if (metode === 'qris') {
                    changeDisplay.textContent = 'Pembayaran via QRIS';
                    changeDisplay.classList.remove('text-red-600');
                    changeDisplay.classList.add('text-green-600');
                    changeInput.value = 0;
                } else {
                    if (bayar === 0) {
                        changeDisplay.textContent = 'Rp 0';
                        changeDisplay.classList.remove('text-red-600');
                        changeDisplay.classList.add('text-green-600');
                        changeInput.value = 0;
                    } else if (bayar < total) {
                        changeDisplay.textContent = 'Uang kurang!';
                        changeDisplay.classList.remove('text-green-600');
                        changeDisplay.classList.add('text-red-600');
                        changeInput.value = 0;
                    } else {
                        const kembali = bayar - total;
                        changeDisplay.textContent = 'Kembalian: Rp ' + kembali.toLocaleString();
                        changeDisplay.classList.remove('text-red-600');
                        changeDisplay.classList.add('text-green-600');
                        changeInput.value = kembali;
                    }
                }
            }

            // Trigger update saat input berubah
            amountInputFormatted.addEventListener('input', updateChange);
            discountSelect.addEventListener('change', updateTotalAndDiscount);
            metodeInput.addEventListener('change', function() {
                const metode = this.value;

                if (metode === 'qris') {
                    amountInputFormatted.disabled = true;
                    amountInputFormatted.value = '';
                    amountInput.value = 0;
                    updateChange();
                } else {
                    amountInputFormatted.disabled = false;
                    updateChange();
                }
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const metode = metodeInput.value;
                const bayar = parseInt(amountInputFormatted.value.replace(/\D/g, '')) || 0;

                // Validasi jika metode cash dan pembayaran kosong atau kurang dari total
                if (metode === 'cash') {
                    if (bayar === 0 || bayar < total) {
                        alert('Jumlah pembayaran cash kurang dari total!');
                        payBtn.disabled = false;
                        btnText.classList.remove('hidden');
                        btnLoading.classList.add('hidden');
                        return;
                    }
                }

                // Loading state
                payBtn.disabled = true;
                btnText.classList.add('hidden');
                btnLoading.classList.remove('hidden');

                const formData = new FormData(form);
                const data = {
                    sales: Array.from(document.querySelectorAll('input[name="sales[]"]')).map(input =>
                        JSON.parse(input.value)),
                    discount_id: formData.get('discount_id'),
                    metode_pembayaran: formData.get('metode_pembayaran'),
                    amount: formData.get('amount'),
                    subtotal: formData.get('subtotal'),
                    total: formData.get('total'),
                    change: formData.get('change'),
                    transaction_number: formData.get('transaction_number'),
                    invoice_number: formData.get('invoice_number'),
                    date_order: formData.get('date_order'),
                    created_by: formData.get('created_by'),
                };

                fetch("{{ route('process.payment') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(data)
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (!res.success) {
                            alert(res.message || 'Terjadi kesalahan.');
                            payBtn.disabled = false;
                            btnText.classList.remove('hidden');
                            btnLoading.classList.add('hidden');
                            return;
                        }

                        if (res.metode_pembayaran === 'qris') {
                            window.snap.pay(res.snap_token, {
                                onSuccess: function() {
                                    const newTab = window.open(res.transaction_url,
                                        '_blank');
                                    if (!newTab) {
                                        alert("Pop-up diblokir! Mohon aktifkan pop-up.");
                                    } else {
                                        window.location.href =
                                            "{{ route('sales.index') }}";
                                    }
                                },
                                onPending: function() {
                                    alert(
                                        "Pembayaran masih menunggu. Silakan selesaikan pembayaran QRIS."
                                    );
                                },
                                onError: function(result) {
                                    console.error(result);
                                    alert('Terjadi kesalahan saat pembayaran.');
                                },
                                onClose: function() {
                                    alert('Pembayaran QRIS dibatalkan.');
                                }
                            });
                        } else {
                            // Jika metode bukan qris (misalnya cash), langsung redirect
                            const newTab = window.open(res.transaction_url, '_blank');
                            if (!newTab) {
                                alert("Pop-up diblokir! Mohon aktifkan pop-up.");
                            } else {
                                window.location.href = "{{ route('sales.index') }}";
                            }
                        }
                    })

            });

            // Inisialisasi
            updateTotalAndDiscount();
            updateChange();
        });
    </script>
@endpush
