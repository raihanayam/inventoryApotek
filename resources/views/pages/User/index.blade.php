@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>User</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">User</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header d-flex justify-content-end">
                    <a href="/user/create" class="btn btn-sm btn-primary">
                        + User
                    </a>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama User</th>
                                <th>Email</th>
                                <th>Jabatan</th>
                                <th>No WhatsApp</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $user->role)) }}</td>
                                    <td>{{ $user->No_Wa ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <a href="/user/edit/{{ $user->id }}" class="btn btn-sm btn-warning mr-2">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="/user/{{ $user->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
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

                    @if ($users->isEmpty())
                        <p class="text-center text-muted mt-3">Belum ada data user.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
