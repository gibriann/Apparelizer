<!-- Navigation bar -->
<nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top navbar-fixed-top" data-aos="fade-down">
    <div class="container">
        <a href="{{ url('/') }}" class="navbar-brand">
            <img src="/images/firmos-logo.png" alt="Logo" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a href="{{ url('/') }}" class="nav-link">Beranda</a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('categories') }}" class="nav-link">Kategori</a>
                </li>
            </ul>
        </div>
    </div>
</nav>