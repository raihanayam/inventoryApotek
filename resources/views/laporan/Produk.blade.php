<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Stok Obat</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #eaeaea; }
        h2, h3 { margin: 0; padding: 0; }
        .right { text-align: right; }
        .low-stock { color: red; font-weight: bold; }
    </style>
</head>
<body>

    <h2>Apotek Asy-Syifa Prambanan</h2>
    <h3 style="text-align: center;">Laporan Stok Obat</h3>

    <p>
        Tanggal Cetak: {{ now()->format('d/m/Y') }} <br>
        Periode: Semua Data
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Obat</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Harga Beli Terbaru (Rp)</th>
                <th>Total Masuk</th>
                <th>Total Keluar</th>
                <th>Stok Saat Ini</th>
                <th>Expired Terdekat</th>
            </tr>
        </thead>

        <tbody>
            @php $no = 1; @endphp

            @foreach ($products as $p)

                @php
                    // harga beli terbaru dari batch terakhir
                    $latestBatch = $p->detail_obat_masuk()->latest()->first();
                    $hargaBeli = $latestBatch->Harga_Beli ?? 0;

                    // expired terdekat
                    $expiredBatch = $p->detail_obat_masuk()
                        ->orderBy('Tanggal_Kadaluwarsa', 'asc')
                        ->first();
                    $expiredDate = $expiredBatch->Tanggal_Kadaluwarsa ?? null;

                    // total masuk
                    $totalMasuk = $p->detail_obat_masuk()->sum('Jumlah');

                    // total keluar
                    $totalKeluar = $p->detail_obat_keluar()->sum('Jumlah');

                    // stok saat ini
                    $stokSekarang = $totalMasuk - $totalKeluar;

                    // tanda obat hampir habis (≤ 10)
                    $lowClass = $stokSekarang <= 10 ? 'low-stock' : '';
                @endphp

                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $p->sku }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->category->name ?? '-' }}</td>
                    <td>{{ $p->satuan->name ?? '-' }}</td>

                    <td class="right">{{ number_format($hargaBeli, 0, ',', '.') }}</td>

                    <td class="right">{{ $totalMasuk }}</td>
                    <td class="right">{{ $totalKeluar }}</td>

                    <td class="right {{ $lowClass }}">
                        {{ $stokSekarang }}
                    </td>

                    <td>
                        {{ $expiredDate ? \Carbon\Carbon::parse($expiredDate)->format('d/m/Y') : '-' }}
                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>

    <br>
    <p style="text-align: right; font-style: italic;">
        Dicetak otomatis oleh Sistem Inventory Apotek
    </p>

</body>
</html>
