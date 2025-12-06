@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Obat Keluar</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Obat Keluar</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <a href="/keluar/create" class="btn btn-sm btn-primary">
                        + Obat Keluar
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Id_Keluar</th>
                                <th>Nama User</th>
                                <th>Tanggal Keluar</th>
                                <th>Jenis Keluar</th>
                                <th>Satuan</th>
                                <th>Jumlah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($obat_keluars as $obat_keluar)
                                <tr>
                                    <td>{{ ($obat_keluars->currentPage() - 1) * $obat_keluars->perPage() + $loop->index + 1 }}</td>
                                    <td>{{ $obat_keluar->Id_Keluar }}</td>
                                    <td>{{ $obat_keluar->user->name ?? '-' }}</td>
                                    <td>{{ $obat_keluar->Tanggal_Keluar }}</td>
                                    <td>{{ $obat_keluar->Jenis_Keluar }}</td>
                                    <td>
                                        @foreach ($obat_keluar->detail_obat_keluar as $detail)
                                            {{ $detail->product->satuan->name ?? '-' }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($obat_keluar->detail_obat_keluar as $detail)
                                            {{ $detail->Jumlah }}<br>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="/keluar/{{ $obat_keluar->id }}" class="btn btn-sm btn-info mr-2 fas fa-eye">
                                                Detail
                                            </a>
                                            <form action="/keluar/{{ $obat_keluar->id }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if ($obat_keluars->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        Belum ada data obat keluar
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $obat_keluars->links('pagination::bootstrap-5')}}
                </div>
            </div>
        </div>
    </div>
@endsection
