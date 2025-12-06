@extends('layouts.main')

@section('header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Detail Obat Keluar</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="/keluar">Obat Keluar</a></li>
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
                <h3 class="card-title">Informasi Obat Keluar</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>ID Keluar</th>
                        <td>{{ $obat_keluar->Id_Keluar }}</td>
                    </tr>
                    <tr>
                        <th>Nama User</th>
                        <td>{{ $obat_keluar->user->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Keluar</th>
                        <td>{{ $obat_keluar->Tanggal_Keluar }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Keluar</th>
                        <td>{{ $obat_keluar->Jenis_Keluar }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">Detail Obat Keluar</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Obat</th>
                            <th>Nama Obat</th>
                            <th>Satuan</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($obat_keluar->detail_obat_keluar as $detail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $detail->product->sku ?? '-' }}</td>
                                <td>{{ $detail->product->name ?? '-' }}</td>
                                <td>{{ $detail->product->satuan->name ?? '-' }}<br></td>
                                <td>{{ $detail->Jumlah }}<br></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <a href="/keluar" class="btn btn-secondary mt-3">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
