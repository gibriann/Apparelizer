<nav
    class="navbar navbar-expand-lg navbar-light navbar-store fixed-top navbar-fixed-top"
    data-aos="fade-down"
>
    <div class="container">
        <a href="/" class="navbar-brand">
            <img src="/images/apparelizer-logo.png" alt="Logo" />
        </a>
        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarResponsive"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{ Request::is('/') ? 'active':'' }}">
                    <a href="{{ url('/') }}" class="nav-link">Beranda</a>
                </li>

                <li class="nav-item {{ Request::is('products*') ? 'active':'' }}">
                    <a href="{{ route('products') }}" class="nav-link">Produk</a>
                </li>

                <li class="nav-item {{ Request::is('history') ? 'active':'' }}">
                    <a href="{{ route('history') }}" class="nav-link">Riwayat Pemesanan</a>
                </li>
            </ul>

            <!-- Desktop Device -->
            <ul class="navbar-nav d-none d-lg-flex">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link px-0" id="navbarDropdown" role="button" data-toggle="dropdown">
                        <img class="rounded-circle mr-2 profile-picture" src="{{ auth()->user()->avatar_url }}" alt="Foto Profil" />
                        Hi, {{ auth()->user()->name }} <i class="fa fa-angle-down"></i>
                    </a>
                    <div class="dropdown-menu">
                        <a href="{{ route('account') }}" class="dropdown-item"
                            >Akun Saya</a
                        >
                        <div class="dropdown-divider"></div>
                        <a href="/logout" class="dropdown-item">Keluar</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a
                        href="{{ route('cart') }}"
                        class="nav-link px-0 d-inline-block mt-2"
                    >

                        <img src="{{ asset('images/icon-cart-empty.svg') }}" alt="" />
                        <?php 
                        use App\Models\Cart;
                        $carts = Cart::where('user_id', auth()->user()->id)->get();
                        $amount = [];
                        foreach ($carts as $cart) {
                            array_push($amount, $cart->amount);
                        }
                        $total_cart = array_sum($amount)
                        ?> 
                        <div class="cart-badge">{{ $total_cart }}</div>
                    </a>
                </li>

                <li class="nav-item d-flex align-items-center ml-2">
                    <button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode" title="Toggle dark mode">
                        <span class="toggle-thumb">
                            <span class="toggle-icon" id="themeIcon">☀️</span>
                        </span>
                    </button>
                </li>
            </ul>

            <!-- Mobile Device -->
            <ul class="navbar-nav d-block d-lg-none">
                <li class="nav-item">
                    <a href="#" class="nav-link"> Hi, {{ auth()->user()->name }}! </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link d-inline-block">
                        Keranjang
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>