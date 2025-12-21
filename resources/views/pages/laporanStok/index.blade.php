@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Laporan Stok Obat</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan Stok</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col">

        {{-- GRAFIK --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Grafik Perubahan Stok Per Bulan</h5>
            </div>

            <div class="card-body">
                <canvas id="grafikStok" height="100"></canvas>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-end">
                <form action="{{ route('laporanStok.exportPDF') }}" method="GET" class="form-inline mb-3">
                    <button type="submit" class="btn btn-danger btn-sm ml-2">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </button>
                </form>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Obat</th>
                            <th>Nama Obat</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Stok Saat Ini (Satuan)</th>
                            <th>Masuk (Satuan)</th>
                            <th>Keluar (Satuan)</th>
                            <th>Stok Akhir (Satuan)</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($products as $stok)
                            <tr>
                                <td>{{ ($products->currentPage() - 1) * $products->perPage() + $loop->index + 1 }}</td>
                                <td>{{ $stok->sku }}</td>
                                <td>{{ $stok->name }}</td>
                                <td>{{ $stok->category->name ?? '-' }}</td>
                                <td>{{ $stok->satuan->name ?? '-' }}</td>
                                <td>{{ $stok->stok_akhir }}</td>
                                <td>{{ $stok->masuk }}</td>
                                <td>{{ $stok->keluar }}</td>
                                <td>{{ $stok->stok_akhir }}</td>
                            </tr>
                        @endforeach

                        @if ($products->isEmpty())
                            <tr>
                                <td colspan="9" class="text-center text-muted">Belum ada data stok</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>
</div>
@endsection


@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('grafikStok').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chart_labels) !!},
            datasets: [
                {
                    label: 'Obat Masuk',
                    data: {!! json_encode($chart_values_masuk) !!},
                    borderWidth: 2,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Obat Keluar',
                    data: {!! json_encode($chart_values_keluar) !!},
                    borderWidth: 2,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection
