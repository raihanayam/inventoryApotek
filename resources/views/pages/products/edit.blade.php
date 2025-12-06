@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Data Obat</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/products">Data Obat</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="/products/{{ $product->id }}" method="POST">
                    @csrf
                    @method('PUT')

                        <div class="form-group">
                            <label for="name">Nama Obat</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="sku">Kode Obat</label>
                            <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="category_id">Kategori</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="satuan_id">Satuan</label>
                            <select name="satuan_id" class="form-control" required>
                                <option value="">-- Pilih Satuan --</option>
                                @foreach ($satuans as $satuan)
                                    <option value="{{ $satuan->id }}" 
                                        {{ $product->satuan_id == $satuan->id ? 'selected' : '' }}>
                                        {{ $satuan->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="/products/" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
