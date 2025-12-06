@extends('layouts.main')



@section('header')
    <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Kategori</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
              <li class="breadcrumb-item active">Kategori</li>
            </ol>
          </div>
        </div>
@endsection

@section('content')
    <div class="row">
      <div class="col">
        <div class="card">
          <div class="card-header d-flex justify-content-end">
            <a href="/categories/create" class="btn btn-sm btn-primary">
                + Kategori       
            </a>
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                  <tr>
                      <th>No</th>
                      <th>Nama Kategori</th>
                      <th>Aksi</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach ($categories as $category)
                      <tr>
                            <td>{{ ($categories->currentPage() - 1) * $categories->perPage() + $loop->index + 1 }}</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <div class="d-flex">
                                <a href="/categories/edit/{{ $category->id }}" class="btn btn-sm btn-warning mr-2 fas fa-edit">
                                  Edit
                                </a>
                                <form action="/categories/{{ $category->id }}" method="POST">
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
            {{ $categories->links('pagination::bootstrap-5') }}
          </div>
        </div>
      </div>
    </div>
@endsection