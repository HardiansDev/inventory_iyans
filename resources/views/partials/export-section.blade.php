<style>
    @media print {
        body {
            -webkit-print-color-adjust: exact;
        }
    }
</style>


<div
    style="display: flex; flex-direction: row; justify-content: space-between; align-items: flex-start; gap: 10px; margin-bottom: 30px;">
    <!-- Tabel Penjualan -->
    <table border="1" cellpadding="5" cellspacing="0" style="width: 48%; font-size: 9px; border-collapse: collapse;">
        <thead style="background:#f2f2f2;">
            <tr>
                <th>Produk</th>
                @foreach ($labels as $label)
                    <th>{{ $label }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($values as $row)
                <tr>
                    <td>{{ $row['label'] }}</td>
                    @foreach ($row['data'] as $val)
                        <td style="text-align: center;">{{ $val }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Grafik Chart -->
    <div style="width: 48%; height: auto; display: flex; align-items: center; justify-content: center;">
        <canvas id="{{ $chartId }}" width="300" height="200" style="display:block;"></canvas>
    </div>
</div>
