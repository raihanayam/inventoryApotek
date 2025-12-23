<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    {{-- <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars"></i>
        </a>
      </li>
    </ul> --}}

    <!-- Notifikasi -->
    <div class="nav-item dropdown ml-auto">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
            Notifikasi

            @php
                $count =
                    $notifications['lowStock']->count()
                    + $notifications['stockOut']->count();
            @endphp

            @php
                $badgeClass = 'bg-success';

                if ($notifications['stockOut']->count() > 0) {
                    $badgeClass = 'bg-danger';
                } elseif ($notifications['lowStock']->count() > 0) {
                    $badgeClass = 'bg-warning';
                }
            @endphp

            @if ($count > 0)
                <span class="badge {{ $badgeClass }}">
                    {{ $count }}
                </span>
            @endif
        </a>

        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            
            {{-- STOK HABIS --}}
            @if ($notifications['stockOut']->count())
                <div class="dropdown-header text-danger">
                    <strong>Stok Habis</strong>
                </div>
                @foreach ($notifications['stockOut'] as $item)
                    <div class="dropdown-item text-danger">
                        {{ $item->name }} stok habis
                    </div>
                @endforeach
                <div class="dropdown-divider"></div>
            @endif

            {{-- STOK MENIPIS --}}
            @if ($notifications['lowStock']->count())
                <div class="dropdown-header text-warning">
                    <strong>Stok Menipis</strong>
                </div>
                @foreach ($notifications['lowStock'] as $item)
                    <div class="dropdown-item text-warning">
                        {{ $item->name }} (sisa {{ $item->stock }})
                    </div>
                @endforeach
            @endif

            {{-- TIDAK ADA --}}
            @if (
                $notifications['stockOut']->count() == 0 &&
                $notifications['lowStock']->count() == 0
            )
                <div class="dropdown-item text-muted">
                    Tidak ada notifikasi
                </div>
            @endif
        </ul>
    </div>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <form action="/logout" method="post">
        @csrf
        <button type="submit" class="btn btn-outline-danger btn-sm">
          Log Out
        </button>
      </form>
    </ul>
</nav>
