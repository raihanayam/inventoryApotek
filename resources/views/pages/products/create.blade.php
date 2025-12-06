@extends('layouts.main')



@section('header')
    <div class="row mb-2">
          <div class="col-sm-6">
            <h1> Tambah Data Obat</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Data Obat</li>
            </ol>
          </div>
        </div>
@endsection

@section('content')
    <div class="row">
      <div class="col">
        <form action="/products/store" method="POST">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama Obat</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="category_id" class="form-control" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Satuan</label>
                        <select name="satuan_id" class="form-control" required>
                            <option value="">-- Pilih Satuan --</option>
                            @foreach ($satuans as $satuan)
                                <option value="{{ $satuan->id }}">{{ $satuan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="/products" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
      </div>
    </div>
@endsection