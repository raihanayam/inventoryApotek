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
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header d-flex justify-content-end">
            <a href="/masuk/create" class="btn btn-sm btn-primary">
                + Obat Masuk         
            </a>
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                  <tr>
                      <th>No</th>
                      <th>Id_Masuk</th>
                      <th>Nama User</th>
                      <th>Tanggal Masuk</th>
                      <th>Satuan</th>
                      <th>Jumlah</th>
                      <th>Aksi</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($obat_masuks as $obat_masuk)
                      <tr>
                        <td>{{ ($obat_masuks->currentPage() - 1) * $obat_masuks->perPage() + $loop->index + 1 }}</td>
                        <td>{{ $obat_masuk->Id_Masuk }}</td>
                        <td>{{ $obat_masuk->user->name ?? '-' }}</td>
                        <td>{{ $obat_masuk->Tanggal_Masuk }}</td>
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
                        <td>
                            <div class="d-flex">
                                <a href="/masuk/{{ $obat_masuk->id }}" class="btn btn-sm btn-info mr-2 fas fa-eye">
                                    Detail
                                </a>
                                <form action="/masuk/{{ $obat_masuk->id }}" method="POST">
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
                  @if ($obat_masuks->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center text-muted">Belum ada data obat masuk</td>
                            </tr>
                        @endif
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            {{ $obat_masuks->links('pagination::bootstrap-5') }}
          </div>
        </div>
      </div>
    </div>
@endsection