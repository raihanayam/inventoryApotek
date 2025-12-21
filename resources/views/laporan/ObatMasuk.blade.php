<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Obat Masuk</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background-color: #f2f2f2; }
        h2, h3 { margin: 0; }
        p { margin-top: 6px; font-size: 11px; }
        .right { text-align: right; }
        .total { font-weight: bold; background-color: #f9f9f9; }
    </style>
</head>
<body>

    <h2>Apotek Asy-Syifa Prambanan</h2>
    <h3 style="text-align:center;">Laporan Obat Masuk</h3>

    <p>
        Tanggal Cetak: {{ now()->format('d/m/Y') }} <br>
        Periode Laporan: <b>Semua Data</b>
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Masuk</th>
                <th>ID Masuk</th>
                <th>Nama User</th>
                <th>Nama Obat</th>
                <th>Satuan</th>
                <th>Jumlah</th>
                <th>Harga Beli (Rp)</th>
                <th>Subtotal (Rp)</th>
                <th>Tanggal Kedaluwarsa</th>
            </tr>
        </thead>
        <tbody>

            @php
                $no = 1;
                $grandTotal = 0;
            @endphp

            @foreach ($details as $detail)
                @php
                    $harga = $detail->Harga_Beli ?? 0;
                    $subtotal = $detail->Jumlah * $harga;
                    $grandTotal += $subtotal;
                @endphp

                <tr>
                    <td>{{ $no++ }}</td>
                    <td>
                        {{ $detail->obat_masuk && $detail->obat_masuk->Tanggal_Masuk
                            ? \Carbon\Carbon::parse($detail->obat_masuk->Tanggal_Masuk)->format('d/m/Y')
                            : '-' }}
                    </td>
                    <td>{{ $detail->obat_masuk->Id_Masuk ?? '-' }}</td>
                    <td>{{ $detail->obat_masuk->user->name ?? '-' }}</td>
                    <td>{{ $detail->product->name ?? '-' }}</td>
                    <td>{{ $detail->product->satuan->name ?? '-' }}</td>
                    <td>{{ $detail->Jumlah }}</td>
                    <td class="right">{{ number_format($harga, 0, ',', '.') }}</td>
                    <td class="right">{{ number_format($subtotal, 0, ',', '.') }}</td>
                    <td>
                        {{ $detail->Tanggal_Kadaluwarsa
                            ? \Carbon\Carbon::parse($detail->Tanggal_Kadaluwarsa)->format('d/m/Y')
                            : '-' }}
                    </td>
                </tr>
            @endforeach

            <tr class="total">
                <td colspan="8" class="right">Total Keseluruhan</td>
                <td class="right">
                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                </td>
                <td></td>
            </tr>

        </tbody>
    </table>

    <br>
    <p style="text-align:right; font-style:italic;">
        Dicetak otomatis oleh Sistem Inventory Apotek
    </p>

</body>
</html>
