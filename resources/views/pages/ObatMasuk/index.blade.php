@extends('layouts.main')

@section('header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Obat Masuk</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Obat Masuk</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header text-right">
        <a href="/masuk/create" class="btn btn-sm btn-primary">
            + Obat Masuk
        </a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Masuk</th>
                    <th>User</th>
                    <th>Tanggal Masuk</th>
                    <th>Satuan</th>
                    <th>Jumlah Masuk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($obat_masuks as $item)
                <tr>
                    <td>{{ ($obat_masuks->currentPage()-1) * $obat_masuks->perPage() + $loop->iteration }}</td>
                    <td>{{ $item->Id_Masuk }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->Tanggal_Masuk }}</td>
                    <td>
                        @forelse ($item->detail_obat_masuk as $detail)
                            {{ $detail->product->satuan->name ?? '-' }} <br>
                        @empty
                            <span class="text-muted">Tidak ada detail</span>
                        @endforelse
                    </td>
                    <td>{{ $item->detail_obat_masuk->sum('Jumlah') }}</td>
                    <td>
                        <a href="/masuk/{{ $item->id }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i> Detail
                        </a>

                        <form action="/masuk/{{ $item->id }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus data ini?')"
                                class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        Belum ada data obat masuk
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{ $obat_masuks->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
