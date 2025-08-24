<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi Pegawai</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: center;
        }

        th {
            background: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">Laporan Absensi Pegawai</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>NIP</th>
                <th>Tanggal</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($attendances as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->employee->name }}</td>
                    <td>{{ $item->employee->employee_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                    <td>{{ $item->check_in ?? '-' }}</td>
                    <td>{{ $item->check_out ?? '-' }}</td>
                    <td>
                        @if ($item->check_in && !$item->check_out)
                            Hadir
                        @elseif ($item->check_in && $item->check_out)
                            Sudah Pulang
                        @else
                            Belum Absen
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
