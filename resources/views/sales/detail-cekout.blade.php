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
                <form id="checkout-form" method="POST" action="">
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
                        <div class="col-md-4">
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
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="metode_pembayaran">Metode Pembayaran:</label>
                                <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="cash">Cash</option>
                                    <option value="qris">QRIS</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <h4 class="text-success">Total Harga: <span id="total-price-display">Rp
                                    {{ number_format($totalPrice, 0, ',', '.') }}</span></h4>
                            <input type="hidden" name="total" id="total" value="{{ $totalPrice }}">
                            <h5 class="text-success">Total Bayar: <span id="discounted-total">Rp
                                    {{ number_format($totalPrice, 0, ',', '.') }}</span></h5>
                            <input type="hidden" name="subtotal" id="subtotal_input" value="{{ $totalPrice }}">
                        </div>
                    </div>

                    <div class="d-flex justify-content->center mt-4">
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
            // Dapatkan semua elemen yang dibutuhkan. Gunakan pengecekan null untuk keamanan.
            const confirmBtn = document.getElementById('confirm-payment-btn');
            const loading = document.getElementById('btn-loading');
            const amountFormatted = document.getElementById('amount_formatted');
            const amount = document.getElementById('amount');
            const changeDisplay = document.getElementById('change-display');
            const changeInput = document.getElementById('change-input');
            const totalElement = document.getElementById('total'); // Ambil elemennya dulu
            const discountedTotalInput = document.getElementById('subtotal_input');
            const discountedTotalDisplay = document.getElementById('discounted-total');
            const discountSelect = document.getElementById('discount_id');
            const metodePembayaran = document.getElementById('metode_pembayaran');

            // Pastikan elemen 'total' ada sebelum mengambil nilainya
            const total = totalElement ? parseInt(totalElement.value) : 0;

            let isSnapOpen = false; // 🛡️ Flag untuk cegah double snap

            // Fungsi untuk mengaktifkan/menonaktifkan tombol dan loading
            function setButtonState(disabled, showLoading) {
                if (confirmBtn) { // Pastikan confirmBtn ada
                    confirmBtn.disabled = disabled;
                    if (showLoading) {
                        loading.classList.remove('d-none');
                    } else {
                        loading.classList.add('d-none');
                    }
                }
            }

            // Auto generate kode transaksi & invoice
            const transactionNumberInput = document.getElementById('transaction_number');
            const orderNumberSpan = document.getElementById('order-number');
            const invoiceNumberInput = document.getElementById('invoice_number_input');
            const invoiceNumberSpan = document.getElementById('invoice-number');

            if (transactionNumberInput) {
                transactionNumberInput.value = generateRandom('TRX');
                if (orderNumberSpan) orderNumberSpan.innerText = transactionNumberInput.value;
            }
            if (invoiceNumberInput) {
                invoiceNumberInput.value = generateRandom('INV');
                if (invoiceNumberSpan) invoiceNumberSpan.innerText = invoiceNumberInput.value;
            }


            function generateRandom(prefix = '') {
                return prefix + '-' + Math.floor(100000 + Math.random() * 900000);
            }

            function formatRupiah(angka) {
                return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function updatePaymentDetails() {
                // Pastikan amountFormatted ada sebelum mengakses value
                const raw = amountFormatted ? (parseInt(amountFormatted.value.replace(/\D/g, '')) || 0) : 0;
                if (amount) amount.value = raw;

                const discountId = discountSelect ? discountSelect.value : '';
                let discountValue = 0;

                @foreach ($discounts ?? [] as $discount)
                    if (discountId == "{{ $discount->id }}") {
                        discountValue = {{ $discount->nilai }};
                    }
                @endforeach

                const afterDiscount = total - (total * discountValue / 100);
                if (discountedTotalInput) discountedTotalInput.value = afterDiscount;
                if (discountedTotalDisplay) discountedTotalDisplay.innerText = 'Rp ' + formatRupiah(afterDiscount);

                const change = raw - afterDiscount;
                if (changeInput) changeInput.value = change > 0 ? change : 0;
                if (changeDisplay) changeDisplay.innerText = 'Rp ' + formatRupiah(change > 0 ? change : 0);
            }

            // Tambahkan pengecekan null sebelum menambahkan event listener
            if (amountFormatted) {
                amountFormatted.addEventListener('input', updatePaymentDetails);
            }
            if (discountSelect) {
                discountSelect.addEventListener('change', updatePaymentDetails);
            }

            if (confirmBtn) { // Pastikan confirmBtn ada sebelum menambahkan event listener
                confirmBtn.addEventListener('click', function() {
                    const metode = metodePembayaran ? metodePembayaran.value : '';
                    const jumlahBayar = amount ? (parseInt(amount.value) || 0) : 0;
                    const subtotal = discountedTotalInput ? parseInt(discountedTotalInput.value) : 0;

                    if (!metode) {
                        Swal.fire('Metode pembayaran belum dipilih!', '', 'warning');
                        return;
                    }

                    if (metode === 'cash') {
                        if (!jumlahBayar || jumlahBayar < subtotal) {
                            Swal.fire('Jumlah Pembayaran harus mencukupi total!', '', 'warning');
                            return;
                        }
                    }

                    setButtonState(true, true); // Menonaktifkan tombol dan menampilkan loading

                    const formData = new FormData(document.getElementById('checkout-form'));
                    const payload = {};
                    formData.forEach((value, key) => {
                        if (key.includes('[')) {
                            const [main, index, field] = key.match(/([^\[\]]+)/g);
                            if (!payload[main]) payload[main] = [];
                            if (!payload[main][index]) payload[main][index] = {};
                            payload[main][index][field] = value;
                        } else {
                            payload[key] = value;
                        }
                    });

                    fetch("{{ route('process.payment') }}", {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .content,
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(payload)
                        })
                        .then(res => res.json())
                        .then(res => {
                            if (!res.success) {
                                Swal.fire('Gagal', res.message || 'Terjadi kesalahan', 'error');
                                setButtonState(false, false); // Mengaktifkan kembali tombol
                                return;
                            }

                            if (metode === 'qris') {
                                if (isSnapOpen) {
                                    console.warn(
                                        'Midtrans Snap popup sudah terbuka. Mengabaikan panggilan ganda.'
                                    );
                                    setButtonState(false, false); // Mengaktifkan kembali tombol
                                    return;
                                }
                                isSnapOpen = true; // Set flag menjadi true saat akan membuka Snap

                                try { // Tambahkan try-catch di sini
                                    console.log('Memanggil snap.pay dengan token:', res
                                        .snap_token); // Debugging
                                    snap.pay(res.snap_token, {
                                        onSuccess: function(result) {
                                            console.log('Pembayaran sukses:',
                                                result); // Debugging
                                            // Panggil endpoint backend untuk menyimpan data transaksi
                                            fetch("{{ route('store.sales.detail') }}", {
                                                    method: 'POST',
                                                    headers: {
                                                        'X-Requested-With': 'XMLHttpRequest',
                                                        'X-CSRF-TOKEN': document
                                                            .querySelector(
                                                                'meta[name="csrf-token"]'
                                                            ).content,
                                                        'Content-Type': 'application/json',
                                                    },
                                                    body: JSON.stringify(
                                                        payload
                                                    ) // Kirim payload yang sama
                                                })
                                                .then(storeRes => storeRes.json())
                                                .then(storeResData => {
                                                    if (storeResData.success) {
                                                        setButtonState(false,
                                                            false
                                                        ); // Mengaktifkan kembali tombol
                                                        isSnapOpen =
                                                            false; // Set flag menjadi false saat sukses
                                                        window.location.href =
                                                            "/print-receipt/" + res
                                                            .transaction_number;
                                                    } else {
                                                        Swal.fire('Gagal', storeResData
                                                            .message ||
                                                            'Gagal menyimpan detail transaksi setelah pembayaran sukses.',
                                                            'error');
                                                        setButtonState(false, false);
                                                        isSnapOpen = false;
                                                    }
                                                })
                                                .catch(storeErr => {
                                                    console.error(
                                                        'Kesalahan saat menyimpan detail transaksi:',
                                                        storeErr);
                                                    Swal.fire('Error',
                                                        'Terjadi kesalahan saat menyimpan detail transaksi. Silakan hubungi admin.',
                                                        'error');
                                                    setButtonState(false, false);
                                                    isSnapOpen = false;
                                                });
                                        },
                                        onPending: function(result) {
                                            console.log('Pembayaran tertunda:',
                                                result); // Debugging
                                            Swal.fire('Pembayaran tertunda',
                                                'Silakan selesaikan pembayaran.', 'info'
                                            );
                                            setButtonState(false,
                                                false); // Mengaktifkan kembali tombol
                                            isSnapOpen =
                                                false; // Set flag menjadi false saat pending
                                        },
                                        onError: function(result) {
                                            console.error('Kesalahan Midtrans Snap:',
                                                result); // Debugging
                                            Swal.fire('Gagal',
                                                'QRIS gagal ditampilkan. Silakan coba lagi.',
                                                'error');
                                            setButtonState(false,
                                                false); // Mengaktifkan kembali tombol
                                            isSnapOpen =
                                                false; // Set flag menjadi false saat error
                                        },
                                        onClose: function() {
                                            console.log(
                                                'Midtrans Snap popup ditutup oleh pengguna.'
                                            ); // Debugging
                                            setButtonState(false,
                                                false); // Mengaktifkan kembali tombol
                                            isSnapOpen =
                                                false; // Set flag menjadi false saat popup ditutup
                                        }
                                    });
                                } catch (snapError) { // Tangkap error dari snap.pay itu sendiri
                                    console.error('Error saat memanggil snap.pay:', snapError);
                                    Swal.fire('Error',
                                        'Terjadi kesalahan saat menampilkan pembayaran. Silakan coba lagi.',
                                        'error');
                                    setButtonState(false, false);
                                    isSnapOpen = false; // Pastikan flag direset
                                }
                            } else {
                                // CASH langsung redirect
                                window.location.href = res.transaction_url;
                            }
                        })
                        .catch(err => {
                            console.error('Kesalahan koneksi atau parsing JSON dari process.payment:',
                                err); // Debugging
                            Swal.fire('Error',
                                'Terjadi kesalahan koneksi atau server saat memproses pembayaran. Silakan coba lagi.',
                                'error');
                            setButtonState(false, false); // Mengaktifkan kembali tombol
                        });
                });
            }

            updatePaymentDetails(); // Panggil ini sekali saat DOM siap
        });
    </script>
    {{-- Pastikan ini dimuat setelah script Anda --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
    </script>
@endpush
