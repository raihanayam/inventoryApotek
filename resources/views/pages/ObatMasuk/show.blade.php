@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Detail Obat Masuk</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="/masuk">Obat Masuk</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Informasi Obat Masuk</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID Masuk</th>
                        <td>{{ $obat_masuks->Id_Masuk }}</td>
                    </tr>
                    <tr>
                        <th>Nama User</th>
                        <td>{{ $obat_masuks->user->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Masuk</th>
                        <td>{{ \Carbon\Carbon::parse($obat_masuks->Tanggal_Masuk)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <th>Total Harga</th>
                        <td>Rp {{ number_format($obat_masuks->detail_obat_masuk->sum(fn($d) => $d->Jumlah * $d->Harga_Beli), 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Detail Obat Masuk</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kode Obat</th>
                            <th>Nama Obat</th>
                            <th>Satuan</th>
                            <th>Jumlah</th>
                            <th>Harga Beli (Rp)</th>
                            <th>Tanggal Kadaluwarsa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($obat_masuks->detail_obat_masuk as $detail)
                            <tr>
                                <td>{{ $detail->product->sku ?? '-' }}</td>
                                <td>{{ $detail->product->name ?? '-' }}</td>
                                <td>{{ $detail->product->satuan->name ?? '-' }}<br></td>
                                <td>{{ $detail->Jumlah }}<br></td>
                                <td>Rp {{ number_format($detail->Harga_Beli, 0, ',', '.') }}</td>
                                <td>{{ \Carbon\Carbon::parse($detail->Tanggal_Kadaluwarsa)->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach

                        @if ($obat_masuks->detail_obat_masuk->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center text-muted">Tidak ada detail obat untuk transaksi ini.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3">
            <a href="/masuk" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
