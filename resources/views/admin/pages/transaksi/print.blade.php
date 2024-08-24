<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Masuk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            font-size: 12px;
        }

        .report-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #dddddd;
            text-align: left;
        }

        .report-table th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: bold;
            text-align: center;
        }

        .report-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .report-table tr:hover {
            background-color: #e2e2e2;
        }

        .report-table td {
            text-align: center;
        }

        .text-center {
            text-align: center
        }
    </style>
</head>

<body>
    <div class="report-container">
        <h2 class="text-center">Laporan Transaksi</h2>
        <table class="report-table">
            <thead>
                <tr>
                    <th class="main">No.</th>
                    <th class="main">Tanggal</th>
                    <th class="main">Invoice</th>
                    <th class="main">Sub Total</th>
                    <th class="main">Diskon</th>
                    <th class="main">Total</th>
                    <th class="main">Tunai</th>
                    <th class="main">Kembalian</th>
                    <th class="main">Created</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item->created_at->translatedFormat('d/m/Y H:i:s') }}</td>
                        <td>{{ $item->invoice }}</td>
                        <td>Rp {{ number_format($item->sub_total, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->diskon, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->tunai, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($item->kembalian, 0, ',', '.') }}</td>
                        <td>{{ $item->user->name }}</td>
                    </tr>

                @empty
                    <tr>
                        <td class="text-center" colspan="7">Tidak Ada Data</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-center"><b>Total</b></th>
                    <td colspan="4">
                        <b>Rp {{ $data ? number_format($data->sum('total_harga')) : '0' }}</b>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
