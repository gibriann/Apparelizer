<ul class="navbar-nav sidebar sidebar-dark accordion border-right" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon">
            <img src="{{asset('images/firmos-logo.png')}}" height="150px">
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{Request::is('dashboard')?' active bg-light':''}}">
        <a class="nav-link text-gray-600" href="{{route('dashboard')}}">
            <span class="size-16">Dashboard</span>
        </a>
    </li>

    @if (auth()->user()->role_id == 2)
        <li class="nav-item {{Request::is('dashboard/admins*')?' active bg-light':''}}">
            <a class="nav-link text-gray-600" href="{{ route('dashboard-admins') }}">
                <span class="size-16">Admin</span>
            </a>
        </li>

        <li class="nav-item {{Request::is('dashboard/customers*')?' active bg-light':''}}">
            <a class="nav-link text-gray-600" href="{{ route('dashboard-customers') }}">
                <span class="size-16">Pelanggan</span>
            </a>
        </li>
    @endif

    <li class="nav-item {{Request::is('dashboard/products*')?' active bg-light':''}}">
        <a class="nav-link text-gray-600" href="{{route('dashboard-products')}}">
            <span class="size-16">Produk</span>
        </a>
    </li>

    <li class="nav-item {{Request::is('dashboard/transactions*')?' active bg-light':''}}">
        <a class="nav-link text-gray-600" href="{{route('dashboard-transactions')}}">
            <span class="size-16">Transaksi</span>
        </a>
    </li>

    @if (auth()->user()->role_id == 2)
        <li class="nav-item {{Request::is('dashboard/reports*')?' active bg-light':''}}">
            <a class="nav-link text-gray-600" href="{{ route('dashboard-reports') }}">
                <span class="size-16">Laporan</span>
            </a>
        </li>
    @endif

    

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>