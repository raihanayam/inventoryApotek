@extends('layouts.main')

@section('header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Tambah Obat Masuk</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/masuk">Obat Masuk</a></li>
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

                <form action="/masuk" method="POST">
                    @csrf

                    <div class="form-group">
                        <label>User</label>
                        <input type="hidden" name="Id_User" value="{{ $user->id }}">
                        <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Masuk</label>
                        <input type="date" name="Tanggal_Masuk" class="form-control" required>
                    </div>

                    <h5>Detail Obat Masuk</h5>

                    <div id="product-wrapper">

                        <div class="row mb-3 product-item">

                            <div class="col-md-4">
                                <label>Pilih Obat</label>
                                <select name="items[0][product_id]" class="form-control">
                                    <option value="">-- Pilih Obat --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label>Jumlah (Satuan)</label>
                                <input type="number" name="items[0][Jumlah]" class="form-control" min="1" required>
                            </div>

                            <div class="col-md-3">
                                <label>Harga Beli</label>
                                <input type="number" name="items[0][Harga_Beli]" class="form-control" min="0" required>
                            </div>

                            <div class="col-md-3">
                                <label>Tanggal Kadaluwarsa</label>
                                <input type="date" name="items[0][Tanggal_Kadaluwarsa]" class="form-control" required>
                            </div>

                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-item">Hapus</button>
                            </div>

                        </div> 

                    </div>

                    <button type="button" id="add-product" class="btn btn-success mb-3">
                        + Tambah Baris Obat
                    </button>

                    <div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="/masuk" class="btn btn-outline-secondary">Batal</a>
                    </div>

                </form>

                <script>
                    let index = 1;

                    document.getElementById('add-product').addEventListener('click', function() {
                        const wrapper = document.getElementById('product-wrapper');
                        const firstItem = wrapper.querySelector('.product-item');
                        const newItem = firstItem.cloneNode(true);

                        newItem.querySelectorAll('input, select').forEach(el => {
                            el.value = '';
                            const name = el.getAttribute('name');
                            if (name) {
                                const newName = name.replace(/\[\d+\]/, '[' + index + ']');
                                el.setAttribute('name', newName);
                            }
                        });

                        wrapper.appendChild(newItem);
                        index++;
                    });

                    document.addEventListener('click', function(e) {
                        if (e.target.classList.contains('remove-item')) {
                            const items = document.querySelectorAll('.product-item');
                            if (items.length > 1) {
                                e.target.closest('.product-item').remove();
                            }
                        }
                    });
                </script>
@endsection
