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
<div class="card">
    <div class="card-header text-right">
        <a href="/keluar/create" class="btn btn-sm btn-primary">
            + Obat Keluar
        </a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Keluar</th>
                    <th>User</th>
                    <th>Tanggal Keluar</th>
                    <th>Jenis Keluar</th>
                    <th>Satuan</th>
                    <th>Jumlah Keluar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($obat_keluars as $item)
                <tr>
                    <td>{{ ($obat_keluars->currentPage()-1)*$obat_keluars->perPage() + $loop->iteration }}</td>
                    <td>{{ $item->Id_Keluar }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->Tanggal_Keluar }}</td>
                    <td>{{ $item->Jenis_Keluar }}</td>
                    <td>{{
                            $item->detail_obat_keluar
                                ->map(fn($d) => $d->product->satuan->name ?? '-')
                                ->unique()
                                ->implode(', ')
                        }}
                    </td>
                    <td>{{ $item->detail_obat_keluar->sum('Jumlah') }}</td>
                    <td>
                        <a href="/keluar/{{ $item->id }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i> Detail
                        </a>

                        <form action="/keluar/{{ $item->id }}" method="POST" class="d-inline">
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
                    <td colspan="7" class="text-center text-muted">
                        Belum ada data obat keluar
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{ $obat_keluars->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
