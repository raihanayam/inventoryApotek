@extends('layouts.main')



@section('header')
    <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
            {{-- @dd(auth()->check()) --}}
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            </ol>
          </div>
        </div>
@endsection

@section('content')
    <div class="row">
    <!-- Small Box 1 -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{ $productCount }}</h3>
            <p>Data Obat</p>
          </div>
          <div class="icon">
            <i class="fas fa-pills"></i>
          </div>
          <a href="/products" class="small-box-footer">
            Lihat Detail <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

    <!-- Small Box 2 -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{ $categoryCount }}</h3>
            <p>Kategori</p>
          </div>
          <div class="icon">
            <i class="fas fa-tags"></i>
          </div>
          <a href="/categories" class="small-box-footer">
            Lihat Detail <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <!-- Small Box 2 -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{ $satuanCount }}</h3>
            <p>Satuan</p>
          </div>
          <div class="icon">
            <i class="fas fa-weight-hanging"></i>
          </div>
          <a href="/satuans" class="small-box-footer">
            Lihat Detail <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

    <!-- Small Box 3 -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{ $obat_masukCount }}</h3>
            <p>Obat Masuk</p>
          </div>
          <div class="icon">
            <i class="fas fa-arrow-up"></i>
          </div>
          <a href="/masuk" class="small-box-footer">
            Lihat Detail <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

    <!-- Small Box 4 -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>{{ $obat_keluarCount }}</h3>
            <p>Obat Keluar</p>
          </div>
          <div class="icon">
            <i class="fas fa-arrow-down"></i>
          </div>
          <a href="/keluar" class="small-box-footer">
            Lihat Detail <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>  

    <!-- Small Box 5 -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
          <div class="inner">
            <h3>{{ $userCount }}</h3>
            <p>User</p>
          </div>
          <div class="icon">
            <i class="fas fa-users"></i>
          </div>
          <a href="/user" class="small-box-footer">
            Lihat Detail <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
    </div>

@endsection