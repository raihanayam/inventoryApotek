@extends('layouts.main')

@section('header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Laporan Obat Masuk</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Laporan Obat Masuk</li>
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
            <h5 class="mb-0">Grafik Total Obat Masuk Per Bulan</h5>
        </div>
        <div class="card-body">
            <canvas id="grafikObatMasuk" height="100"></canvas>
        </div>
    </div>

    {{-- TABEL --}}
    <div class="card">
        <div class="card-header text-right">
            <form action="{{ route('obatMasuk.exportPDF') }}" method="GET">
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </button>
            </form>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Masuk</th>
                    <th>ID Masuk</th>
                    <th>Nama Obat</th>
                    <th>User</th>
                    <th>Satuan</th>
                    <th>Jumlah</th>
                    <th>Harga Beli</th>
                    <th>Subtotal</th>
                    <th>Tanggal Kadalwuarsa</th>
                </tr>
                </thead>
                <tbody>
                @php $no = ($details->currentPage()-1)*$details->perPage()+1; @endphp

                @forelse ($details as $detail)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $detail->obat_masuk->Tanggal_Masuk }}</td>
                    <td>{{ $detail->obat_masuk->Id_Masuk }}</td>
                    <td>{{ $detail->product->name ?? '-' }}</td>
                    <td>{{ $detail->obat_masuk->user->name ?? '-' }}</td>
                    <td>{{ $detail->product->satuan->name ?? '-' }}</td>
                    <td>{{ $detail->Jumlah }}</td>
                    <td>Rp {{ number_format($detail->Harga_Beli, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($detail->Jumlah * $detail->Harga_Beli, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($detail->Tanggal_Kadaluwarsa)->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center text-muted">
                        Belum ada data obat masuk
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $details->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>

</div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('grafikObatMasuk'), {
    type: 'line',
    data: {
        labels: {!! json_encode($chart_labels) !!},
        datasets: [{
            label: 'Total Obat Masuk',
            data: {!! json_encode($chart_values) !!},
            borderWidth: 2,
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true } }
    }
});
</script>
@endsection
