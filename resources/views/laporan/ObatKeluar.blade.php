<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Obat Keluar</title>
    <style>
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h2, h3 {
            margin: 0;
            padding: 0;
        }
        p {
            margin-top: 6px;
            font-size: 11px;
        }
    </style>
</head>
<body>

<h2>Apotek Asy-Syifa Prambanan</h2>
<h3 style="text-align: center;">Laporan Obat Keluar</h3>

<p>
    Tanggal Cetak: {{ now()->format('d/m/Y') }} <br>
    Periode Laporan: <b>Semua Data</b>
</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Keluar</th>
            <th>ID Keluar</th>
            <th>Jenis Keluar</th>
            <th>Nama User</th>
            <th>Nama Obat</th>
            <th>Satuan</th>
            <th>Jumlah</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($details as $no => $detail)
            <tr>
                <td>{{ $no + 1 }}</td>

                <td>
                    {{ optional($detail->obat_keluar)->Tanggal_Keluar
                        ? \Carbon\Carbon::parse($detail->obat_keluar->Tanggal_Keluar)->format('d/m/Y')
                        : '-' }}
                </td>

                <td>{{ optional($detail->obat_keluar)->Id_Keluar ?? '-' }}</td>
                <td>{{ optional($detail->obat_keluar)->Jenis_Keluar ?? '-' }}</td>
                <td>{{ optional(optional($detail->obat_keluar)->user)->name ?? '-' }}</td>
                <td>{{ $detail->product->name ?? '-' }}</td>
                <td>{{ optional($detail->product->satuan)->name ?? '-' }}</td>
                <td class="right">{{ $detail->Jumlah }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p style="text-align: right; font-style: italic;">
    Dicetak otomatis oleh Sistem Inventory Apotek
</p>

</body>
</html>
