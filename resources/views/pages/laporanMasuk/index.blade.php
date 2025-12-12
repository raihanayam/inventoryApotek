@extends('layouts.main')

{{-- {{ dd($chart_labels, $chart_values) }} --}}

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
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Grafik Total Obat Masuk Per Bulan</h5>
            </div>
            <div class="card-body">
                <canvas id="grafikObatMasuk" height="100"></canvas>
            </div>
        </div>
        <div class="card">
          <div class="card-header d-flex justify-content-end">
            <form action="{{ route('obatMasuk.exportPDF') }}" method="GET" class="form-inline mb-3">
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
                      <th>Tanggal Masuk</th>
                      <th>Id_Masuk</th>
                      <th>Nama Obat</th>
                      <th>Nama User</th>
                      <th>Satuan</th>
                      <th>Jumlah</th>
                      <th>Harga Beli (Rp)</th>
                      <th>Subtotal (Rp)</th>
                      <th>Tanggal Kadaluwarsa</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($obat_masuks as $obat_masuk)
                      <tr>
                        <td>{{ ($obat_masuks->currentPage() - 1) * $obat_masuks->perPage() + $loop->index + 1 }}</td>
                        <td>{{ $obat_masuk->Tanggal_Masuk }}</td>
                        <td>{{ $obat_masuk->Id_Masuk }}</td>
                        <td>
                            @foreach ($obat_masuk->detail_obat_masuk as $detail)
                                {{ $detail->product->name ?? '-' }}<br>
                            @endforeach
                        </td>
                        <td>{{ $obat_masuk->user->name ?? '-' }}</td>
                        <td>
                            @foreach ($obat_masuk->detail_obat_masuk as $detail)
                                {{ $detail->product->satuan->name ?? '-' }}<br>
                            @endforeach
                        </td>

                        <td>
                            @foreach ($obat_masuk->detail_obat_masuk as $detail)
                                {{ $detail->Jumlah }}<br>
                            @endforeach
                        </td>
                        <td>Rp {{ number_format($detail->Harga_Beli, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($obat_masuk->detail_obat_masuk->sum(fn($d) => $d->Jumlah * $d->Harga_Beli), 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($detail->Tanggal_Kadaluwarsa)->format('d/m/Y') }}</td>
                      </tr>
                  @endforeach
                  @if ($obat_masuks->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada data obat masuk</td>
                            </tr>
                        @endif
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            {{ $obat_masuks->appends(request()->query())->links('pagination::bootstrap-5') }}
          </div>
        </div>
      </div>
    </div>
@endsection

@section('script')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
      const ctx = document.getElementById('grafikObatMasuk').getContext('2d');

      new Chart(ctx, {
          type: 'line',
          data: {
              labels: {!! json_encode($chart_labels) !!},
              datasets: [{
                  label: 'Total Obat Masuk',
                  data: {!! json_encode($chart_values) !!},
                  borderWidth: 2,
                  borderColor: 'rgba(75, 192, 192, 1)',
                  backgroundColor: 'rgba(75, 192, 192, 0.2)',
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
