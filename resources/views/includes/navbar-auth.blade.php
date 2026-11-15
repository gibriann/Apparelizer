<!-- Navigation bar -->
<nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top navbar-fixed-top" data-aos="fade-down">
    <div class="container">
        <a href="{{ url('/') }}" class="navbar-brand">
            <img src="/images/apparelizer-logo.png" alt="Logo" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link">Beranda</a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('products') }}" class="nav-link">Semua Produk</a>
                </li>

                <li class="nav-item">
                    <a href="/.#find-us" class="nav-link">Lokasi</a>
                </li>

                <li class="nav-item d-flex align-items-center ml-2">
                    <button class="theme-toggle" id="themeToggle" aria-label="Toggle dark mode" title="Toggle dark mode">
                        <span class="toggle-thumb">
                            <span class="toggle-icon" id="themeIcon">☀️</span>
                        </span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>
