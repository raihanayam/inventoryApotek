<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Obat Masuk</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2, h3 { margin: 0; padding: 0; }
        p { margin-top: 6px; font-size: 11px; }
        .right { text-align: right; }
        .total { font-weight: bold; background-color: #f9f9f9; }
    </style>
</head>
<body>

    <h2>Apotek Asy-Syifa Prambanan</h2>
    <h3 style="text-align: center;">Laporan Obat Masuk</h3>

    <p>
        Tanggal Cetak: {{ now()->format('d/m/Y') }} <br>
        Periode Laporan:
        @if(isset($start_date) && isset($end_date))
            {{ \Carbon\Carbon::parse($start_date)->format('d/m/Y') }}
            s/d
            {{ \Carbon\Carbon::parse($end_date)->format('d/m/Y') }}
        @else
            Semua Periode
        @endif
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

            @foreach ($obat_masuks as $obat)
                @foreach ($obat->detail_obat_masuk as $detail)
                    @php
                        $harga = $detail->Harga_Beli ?? $detail->product->price ?? 0;
                        $subtotal = $detail->Jumlah * $harga;
                        $grandTotal += $subtotal;
                    @endphp

                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ \Carbon\Carbon::parse($obat->Tanggal_Masuk)->format('d/m/Y') }}</td>
                        <td>{{ $obat->Id_Masuk }}</td>
                        <td>{{ $obat->user->name ?? '-' }}</td>
                        <td>{{ $detail->product->name ?? '-' }}</td>
                        <td>{{ $detail->product->satuan->name ?? '-' }}</td>
                        <td>{{ $detail->Jumlah }}</td>
                        <td class="right">{{ number_format($harga, 0, ',', '.') }}</td>
                        <td class="right">{{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($detail->Tanggal_Kadaluwarsa)->format('d/m/Y') }}</td>
                    </tr>

                @endforeach
            @endforeach

            <tr class="total">
                <td colspan="8" class="right">Total Keseluruhan</td>
                <td class="right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <br>
    <p style="text-align: right; font-style: italic;">
        Dicetak otomatis oleh Sistem Inventory Apotek
    </p>

</body>
</html>
