@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Detail Obat</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="/products">Data Obat</a></li>
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
                <h3 class="card-title">Informasi Obat</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Kode Obat</th>
                        <td>{{ $product->sku ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th width="35%">Nama Obat</th>
                        <td>{{ $product->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $product->category->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Satuan</th>
                        <td>{{ $product->satuan->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Harga Beli Terakhir</th>
                        <td>Rp {{ number_format($hargaBeli, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td>{{ $stokSekarang }}</td>
                    </tr>
                    <tr>
                        <th>Histori Batch Obat Masuk</th>
                        <td>
                            <small class="text-warning d-block mb-2">
                                <i class="fas fa-exclamation-triangle"></i>
                                Data ini merupakan histori obat masuk dan tidak mempengaruhi perhitungan stok saat ini
                            </small>

                            <table class="table table-sm table-bordered mt-2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Harga Beli</th>
                                        <th>Jumlah Masuk</th>
                                        <th>Tanggal Kadaluwarsa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($batchHistories->isEmpty())
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">
                                                Belum ada data obat masuk
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($batchHistories as $batch)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>Rp {{ number_format($batch->Harga_Beli, 0, ',', '.') }}</td>
                                                <td>{{ $batch->Jumlah }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($batch->Tanggal_Kadaluwarsa)->format('d M Y') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-3">
            <a href="/products" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
