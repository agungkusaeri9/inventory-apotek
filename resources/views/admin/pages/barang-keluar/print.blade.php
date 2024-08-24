<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang Keluar</title>
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
        <h2 class="text-center">Laporan Barang Keluar</h2>
        <table class="report-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jenis</th>
                    <th>Satuan</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->created_at->translatedFormat('d-m-Y') }}</td>
                        <td>{{ $item->barang->nama }}</td>
                        <td>{{ $item->barang->jenis->nama }}</td>
                        <td>{{ $item->barang->satuan->nama }}</td>
                        <td>{{ $item->keterangan }}</td>
                        <td>{{ $item->jumlah }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="7">Tidak Ada Data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>
