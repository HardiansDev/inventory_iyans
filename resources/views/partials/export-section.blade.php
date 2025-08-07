<style>
    @page {
        size: A4 landscape;
        margin: 20mm;
    }

    body {
        font-family: Arial, sans-serif;
        font-size: 11px;
        color: #000;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    table th,
    table td {
        border: 1px solid #ccc;
        padding: 6px 8px;
        text-align: left;
    }

    table th {
        background-color: #f5f5f5;
        font-weight: bold;
    }

    h2,
    h4 {
        text-align: left;
        margin: 20px 0 10px;
        font-weight: bold;
    }

    .section-row {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 30px;
    }

    .table-container {
        width: 55%;
    }

    .chart-container {
        width: 42%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    canvas {
        max-width: 100%;
        height: auto;
    }
</style>

<div
    style="
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 30px;
    ">
    <!-- Tabel Penjualan -->
    <div class="section-row">
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($values as $row)
                        <tr>
                            <td>{{ $row['label'] }}</td>
                            @foreach ($row['data'] as $val)
                                <td style="text-align: center">{{ $val }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="chart-container">
            <canvas id="{{ $chartId }}" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- Grafik Chart -->
    <div
        style="
            width: 48%;
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
        ">
        <canvas id="{{ $chartId }}" width="300" height="200" style="display: block"></canvas>
    </div>
</div>
