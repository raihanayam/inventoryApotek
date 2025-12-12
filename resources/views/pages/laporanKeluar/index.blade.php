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

        <div class="card">
          <div class="card-header d-flex justify-content-end">
            <form action="/laporanKeluar" method="GET" class="form-inline mb-3">
                <label class="mr-2">Pilih Bulan</label>
                <input type="month" name="bulan" class="form-control" value="{{ request('bulan') }}">
                <button type="submit" class="btn btn-primary btn-sm ml-2 mr-2">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </form>

            <form action="{{ route('obatKeluar.exportPDF') }}" method="GET" class="form-inline mb-3">
                <label class="mr-2">Pilih Bulan</label>
                <input type="month" name="bulan" class="form-control" 
                      value="{{ request('bulan') }}">
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
                      <th>Tanggal Keluar</th>
                      <th>Id_Keluar</th>
                      <th>Nama Obat</th>
                      <th>Nama User</th>
                      <th>Satuan</th>
                      <th>Jumlah</th>
                      <th>Jenis Keluar</th>
                  </tr>
              </thead>

              <tbody>
                  @foreach ($obat_keluars as $keluar)
                      <tr>
                        <td>{{ ($obat_keluars->currentPage() - 1) * $obat_keluars->perPage() + $loop->index + 1 }}</td>
                        <td>{{ $keluar->Tanggal_Keluar }}</td>
                        <td>{{ $keluar->Id_Keluar }}</td>

                        <td>
                            @foreach ($keluar->detail_obat_keluar as $d)
                                {{ $d->product->name ?? '-' }} <br>
                            @endforeach
                        </td>

                        <td>{{ $keluar->user->name ?? '-' }}</td>

                        <td>
                            @foreach ($keluar->detail_obat_keluar as $d)
                                {{ $d->product->satuan->name ?? '-' }} <br>
                            @endforeach
                        </td>

                        <td>
                            @foreach ($keluar->detail_obat_keluar as $d)
                                {{ $d->Jumlah }} <br>
                            @endforeach
                        </td>

                        <td>{{ $keluar->Jenis_Keluar }}</td>
                      </tr>
                  @endforeach

                  @if ($obat_keluars->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center text-muted">Belum ada data obat keluar</td>
                    </tr>
                  @endif

              </tbody>

            </table>
          </div>

          <div class="card-footer">
            {{ $obat_keluars->appends(request()->query())->links('pagination::bootstrap-5') }}
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
                  borderWidth: 2,
                  borderColor: 'rgba(255, 99, 132, 1)',
                  backgroundColor: 'rgba(255, 99, 132, 0.2)',
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
