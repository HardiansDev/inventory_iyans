@extends('layouts.master')

@section('content')
    <div class="container mt-5" style="font-family: Arial, sans-serif;">
        <h2 style="text-align: center; font-weight: bold; color: #333;">Detail Checkout</h2>
        <table class="table table-bordered mt-4"
            style="background-color: #f9f9f9; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
            <thead style="background-color: #4caf50; color: #fff; text-align: center;">
                <tr>
                    <th>Nama Produk</th>
                    <th>Qty</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody style="text-align: center;">
                @php $totalPrice = 0; @endphp
                @foreach ($wishlist as $item)
                    <tr>
                        <td style="padding: 12px; font-size: 16px;">{{ $item['name'] }}</td>
                        <td style="padding: 12px; font-size: 16px;">{{ $item['qty'] }}</td>
                        <td style="padding: 12px; font-size: 16px;">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td style="padding: 12px; font-size: 16px;">Rp
                            {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</td>
                    </tr>
                    @php $totalPrice += $item['price'] * $item['qty']; @endphp
                @endforeach
            </tbody>
        </table>
        <h3 class="mt-4" style="text-align: center; color: #555;">Total Harga: Rp <span
                id="total-price">{{ number_format($totalPrice, 0, ',', '.') }}</span></h3>

        <!-- Input amount and display change -->
        <div class="mt-4" style="max-width: 400px; margin: 0 auto;">
            <label for="amount" class="form-label" style="font-size: 18px; font-weight: bold; color: #333;">Masukkan
                Jumlah Pembayaran:</label>
            <input type="number" id="amount" class="form-control" placeholder="Masukkan jumlah pembayaran"
                style="padding: 10px; font-size: 16px; border-radius: 6px; border: 1px solid #ccc;"
                oninput="calculateChange()">
        </div>

        <div class="mt-3" style="text-align: center;">
            <h4 style="color: #4caf50; font-size: 20px;">Kembalian: Rp <span id="change">0</span></h4>
        </div>

        <div class="mt-4" style="text-align: center;">
            <a href="/" class="btn btn-secondary"
                style="background-color: #6c757d; color: white; padding: 10px 20px; font-size: 16px; border-radius: 5px; text-decoration: none;">Kembali</a>
            <button class="btn btn-success" onclick="confirmCheckout()"
                style="background-color: #4caf50; color: white; padding: 10px 20px; font-size: 16px; border-radius: 5px; border: none; cursor: pointer;">Konfirmasi
                Pembayaran</button>
        </div>
    </div>

    <script>
        // JavaScript to calculate change
        function calculateChange() {
            const totalPrice = {{ $totalPrice }};
            const amount = parseInt(document.getElementById('amount').value) || 0;

            // Calculate change
            const change = amount - totalPrice;

            // Update change display
            const changeElement = document.getElementById('change');
            changeElement.textContent = change >= 0 ? change.toLocaleString() : '0';
        }

        // Checkout confirmation
        function confirmCheckout() {
            const totalPrice = {{ $totalPrice }};
            const amount = parseInt(document.getElementById('amount').value) || 0;

            if (amount < totalPrice) {
                alert('Jumlah pembayaran tidak cukup!');
                return;
            }

            const change = amount - totalPrice;
            alert(`Checkout berhasil! Kembalian Anda: Rp ${change.toLocaleString()}`);
            window.location.href = '/'; // Redirect ke halaman utama
        }
    </script>
@endsection
