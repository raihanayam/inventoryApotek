@extends('layouts.main')

@section('header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>Laporan Obat Keluar</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active">Laporan Obat Keluar</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col">

        {{-- Grafik --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Grafik Total Obat Keluar Per Bulan</h5>
            </div>
            <div class="card-body">
                <canvas id="grafikObatKeluar" height="100"></canvas>
            </div>
        </div>

        {{-- Tabel --}}
        <div class="card">
          <div class="card-header d-flex justify-content-end">
                @if (Route::has('laporanKeluar.exportPDF'))
                    <a href="{{ route('laporanKeluar.exportPDF') }}" class="btn btn-danger">
                        Export PDF
                    </a>
                @endif
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Keluar</th>
                            <th>Id Keluar</th>
                            <th>Nama Obat</th>
                            <th>Satuan</th>
                            <th>Jumlah</th>
                            <th>Jenis Keluar</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($details as $detail)
                        <tr>
                            <td>{{ ($details->currentPage() - 1) * $details->perPage() + $loop->iteration }}</td>
                            <td>
                                {{ optional($detail->obat_keluar)->Tanggal_Keluar
                                    ? \Carbon\Carbon::parse($detail->obat_keluar->Tanggal_Keluar)->format('d/m/Y')
                                    : '-' }}
                            </td>
                            <td>{{ $detail->obat_keluar->Id_Keluar }}</td>
                            <td>{{ $detail->product->name ?? '-' }}</td>
                            <td>{{ $detail->product->satuan->name ?? '-' }}</td>
                            <td>{{ $detail->Jumlah }}</td>
                            <td>{{ $detail->obat_keluar->Jenis_Keluar }}</td>
                            <td>{{ optional(optional($detail->obat_keluar)->user)->name ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                Belum ada data obat keluar
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                {{ $details->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('grafikObatKeluar').getContext('2d');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chart_labels) !!},
        datasets: [{
            label: 'Total Obat Keluar',
            data: {!! json_encode($chart_values) !!},
            // borderColor: 'rgba(220, 53, 69, 1)',      
            // backgroundColor: 'rgba(220, 53, 69, 0.2)',
            // pointBackgroundColor: 'rgba(220, 53, 69, 1)',
            // pointBorderColor: '#fff',
            borderWidth: 2,
            tension: 0.3,
            fill: true
        }]
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
