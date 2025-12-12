@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tambah Obat Keluar</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/keluar">Obat Keluar</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="/keluar" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="user">User</label>
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="Tanggal_Keluar">Tanggal Keluar</label>
                            <input type="date" name="Tanggal_Keluar" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="Jenis_Keluar">Jenis Keluar</label>
                            <select name="Jenis_Keluar" class="form-control">
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Masuk kedalam etalase penjualan">Masuk kedalam etalase penjualan</option>
                                <option value="Kadaluarsa">Kadaluarsa</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                        </div>

                        <h5>Detail Obat Keluar</h5>
                        <div id="product-wrapper">
                            <div class="row mb-3 product-item">
                                <div class="col-md-6">
                                    <label>Pilih Obat</label>
                                    <select name="product_id[]" class="form-control">
                                        <option value="">-- Pilih Obat --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Jumlah</label>
                                    <input type="number" name="Jumlah[]" class="form-control @error('Jumlah') is-invalid @enderror" min="1">
                                </div>

                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove-item">Hapus</button>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="add-product" class="btn btn-sm btn-success mb-3">
                            + Tambah Baris Obat
                        </button>

                        <div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="/keluar" class="btn btn-sm btn-outline-secondary">Batal</a>
                        </div>
                    </form>

                    <script>
                        document.getElementById('add-product').addEventListener('click', function() {
                            const wrapper = document.getElementById('product-wrapper');
                            const newItem = wrapper.querySelector('.product-item').cloneNode(true);
                            newItem.querySelectorAll('input').forEach(input => input.value = '');
                            wrapper.appendChild(newItem);
                        });

                        document.addEventListener('click', function(e) {
                            if (e.target.classList.contains('remove-item')) {
                                const items = document.querySelectorAll('.product-item');
                                if (items.length > 1) e.target.closest('.product-item').remove();
                            }
                        });
                    </script>
@endsection
