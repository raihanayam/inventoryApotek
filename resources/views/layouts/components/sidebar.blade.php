@php
    $menus = [
        (object) [
            "title" => "Dashboard",
            "path" => "dashboard",
            "icon" => "fas fa-home",
        ],
        (object) [
            "title" => "Kategori",
            "path" => "categories",
            "icon" => "fas fa-tags",
        ],
        (object) [
            "title" => "Satuan",
            "path" => "satuans",
            "icon" => "fas fa-weight-hanging",
        ],
        (object) [
            "title" => "Data Obat",
            "path" => "products",
            "icon" => "fas fa-pills",
        ],
        (object) [
          "title" => "Obat Masuk",
          "path" => "masuk",
          "icon" => "fas fa-arrow-up",
        ],
        (object) [
          "title" => "Obat Keluar",
          "path" => "keluar",
          "icon" => "fas fa-arrow-down",
        ],
        // (object) [
        //     "title" => "Transaksi",
        //     "icon" => "fas fa-exchange-alt",
        //     "children" => [
        //         (object)[ "title" => "Obat Masuk", "path" => "masuk", "icon" => "fas fa-arrow-down" ],
        //         (object)[ "title" => "Obat Keluar", "path" => "keluar", "icon" => "fas fa-arrow-up" ],
        //     ]
        // ],
        (object) [
            "title" => "User",
            "path" => "user",
            "icon" => "fas fa-user",
        ],
        (object) [
            "title" => "Laporan",
            "icon" => "fas fa-exchange-alt",
            "children" => [
                (object)[ "title" => "laporan Obat Masuk", "path" => "laporanMasuk", "icon" => "fas fa-stock" ],
                (object)[ "title" => "Laporan Obat Keluar", "path" => "laporanKeluar", "icon" => "fas fa-stock" ],
                (object)[ "title" => "Laporan Stok", "path" => "laporanStok", "icon" => "fas fa-stock" ],
            ]
        ],
    ];

    $user = Auth::user();
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="#" class="brand-link">
    <img src="{{ asset('images/apotek.jpg') }}" alt="Logo Apotek"
         class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Apotek Asy-Syifa</span>
  </a>

  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="info">
      @if($user)
        <span class="d-block text-white-50" style="font-size: 13px;">
          {{ ucfirst($user->role ?? 'User') }}
        </span>
        <span class="d-block text-white" style="font-size: 15px;">
          {{ $user->name }}
        </span>
      @else
        <span class="d-block text-muted" style="font-size: 15px;">
          User
        </span>
      @endif
    </div>
  </div>

  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        @foreach ($menus as $menu)
          @if (isset($menu->children))
            <li class="nav-item has-treeview {{ collect($menu->children)->contains(fn($child) => request()->is($child->path . '*')) ? 'menu-open' : '' }}">
              <a href="#" class="nav-link {{ collect($menu->children)->contains(fn($child) => request()->is($child->path . '*')) ? 'active' : '' }}">
                <i class="nav-icon {{ $menu->icon }}"></i>
                <p>
                  {{ $menu->title }}
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @foreach ($menu->children as $child)
                  <li class="nav-item">
                    <a href="/{{ $child->path }}" class="nav-link {{ request()->is($child->path . '*') ? 'active' : '' }}">
                      <i class="nav-icon {{ $child->icon }}"></i>
                      <p>{{ $child->title }}</p>
                    </a>
                  </li>
                @endforeach
              </ul>
            </li>
          @else
            <li class="nav-item">
              <a href="/{{ $menu->path }}" class="nav-link {{ request()->is($menu->path . '*') ? 'active' : '' }}">
                <i class="nav-icon {{ $menu->icon }}"></i>
                <p>{{ $menu->title }}</p>
              </a>
            </li>
          @endif
        @endforeach
      </ul>
    </nav>
  </div>
</aside>
