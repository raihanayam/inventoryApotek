<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Obat Keluar</title>
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
    <h3 style="text-align: center;">Laporan Obat Keluar</h3>

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
                <th>Tanggal Keluar</th>
                <th>ID Keluar</th>
                <th>Nama User</th>
                <th>Nama Obat</th>
                <th>Jumlah</th>
                <th>Jenis Keluar</th>
            </tr>
        </thead>

        <tbody>
            @php 
                $no = 1;
            @endphp

            @foreach ($obatKeluars as $keluar)
                @foreach ($keluar->detail_obat_keluar as $detail)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ \Carbon\Carbon::parse($keluar->Tanggal_Keluar)->format('d/m/Y') }}</td>
                        <td>{{ $keluar->Id_Keluar }}</td>
                        <td>{{ $keluar->user->name ?? '-' }}</td>
                        <td>{{ $detail->product->name ?? '-' }}</td>
                        <td>{{ $detail->Jumlah }}</td>
                        <td>{{ $keluar->Jenis_Keluar }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <br>
    <p style="text-align: right; font-style: italic;">
        Dicetak otomatis oleh Sistem Inventory Apotek
    </p>

</body>
</html>
