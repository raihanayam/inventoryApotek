<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars"></i>
        </a>
      </li>
    </ul>

    <!-- Notifikasi -->
    <div class="nav-item dropdown ml-auto">
        <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
            🔔 Notifikasi
            @php
                $count = count($notifications['expired']) + count($notifications['stockOut']);
            @endphp
            @if ($count > 0)
                <span class="badge bg-danger">{{ $count }}</span>
            @endif
        </a>

        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            @if (count($notifications['expired']) > 0)
                <div class="dropdown-header text-danger"><strong>Obat Kedaluwarsa</strong></div>
                @foreach ($notifications['expired'] as $item)
                    <div class="dropdown-item text-danger">{{ $item->name }} sudah expired!</div>
                @endforeach
                <div class="dropdown-divider"></div>
            @endif
            @if (count($notifications['stockOut']) > 0)
                <div class="dropdown-header text-warning"><strong>Stok Habis</strong></div>
                @foreach ($notifications['stockOut'] as $item)
                    <div class="dropdown-item text-warning">{{ $item->name }} stok habis!</div>
                @endforeach
            @endif
            @if ($count == 0)
                <div class="dropdown-item text-muted">Tidak ada notifikasi</div>
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
