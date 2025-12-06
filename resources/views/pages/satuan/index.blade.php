@extends('layouts.main')



@section('header')
    <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Satuan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Satuan</li>
            </ol>
          </div>
        </div>
@endsection

@section('content')
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header d-flex justify-content-end">
            <a href="/satuans/create" class="btn btn-sm btn-primary">
                + Satuan       
            </a>
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                  <tr>
                      <th>No</th>
                      <th>Nama Satuan</th>
                      <th>Aksi</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($satuans as $satuan)
                      <tr>
                            <td>{{ ($satuans->currentPage() - 1) * $satuans->perPage() + $loop->index + 1 }}</td>
                            <td>{{ $satuan->name }}</td>
                            <td>
                                <div class="d-flex">
                                <a href="/satuans/edit/{{ $satuan->id }}" class="btn btn-sm btn-warning mr-2 fas fa-edit">
                                  Edit
                                </a>
                                <form action="/satuans/{{ $satuan->id }}" method="POST">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Hapus
                                  </button>
                                </form>
                              </div>
                            </td>
                      </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
          <div class="card-footer">
            {{ $satuans->links('pagination::bootstrap-5') }}
          </div>
        </div>
      </div>
    </div>
@endsection