@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Data Obat</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Data Obat</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <a href="/products/create" class="btn btn-sm btn-primary">
                        + Data Obat
                    </a>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="text">
                            <tr>
                                <th>No</th>
                                <th>Kode Obat</th>
                                <th>Nama Obat</th>
                                <th>Kategori</th>
                                <th>Satuan</th>
                                <th>Stok</th>
                                <th>Tanggal Kadaluwarsa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td class="text-center">
                                        {{ ($products->currentPage() - 1) * $products->perPage() + $loop->index + 1 }}
                                    </td>
                                    <td>{{ $product->sku }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name ?? '-' }}</td>
                                    <td>{{ $product->satuan->name ?? '-' }}</td>
                                    <td class="text-center">{{ $product->stock ?? 0 }}</td>
                                    <td>{{ $product->expiredSoonest() ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="/products/{{ $product->id }}" class="btn btn-info btn-sm mr-2">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            <a href="/products/edit/{{ $product->id }}" class="btn btn-sm btn-warning mr-2">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="/products/{{ $product->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
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
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Belum ada data obat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
