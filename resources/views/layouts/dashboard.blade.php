<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<meta name="description" content="" />
		<meta name="author" content="" />
		<link rel="icon" href="{{ asset('images/apparelizer-logo.png') }}" type="image/x-icon">


		<title>@yield('title')</title>
        
        @stack('prepend-style')
			<script src="https://kit.fontawesome.com/1fb5cee488.js" crossorigin="anonymous"></script>
            <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
            <link href="{{ asset('/style/main.css') }}" rel="stylesheet" />
        @stack('addon-style')
	</head>

	<body>
		<div class="page-dashboard">
			<div class="d-flex" id="wrapper" data-aos="fade-right">
				<!-- SIDEBAR -->
				<div class="border-right" id="sidebar-wrapper">
					<div class="sidebar-heading text-center">
						<a href="{{ url('/') }}" class="navbar-brand">
							<img src="/images/successlogo.png" class="mr-1 my-4" alt="Logo" />
						</a>
					</div>
					<div class="list-group list-group-flush">
						<a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action {{ Request::is('dashboard') ? 'bg-light text-dark':'' }}"> Dashboard </a>
						<a href="{{ route('dashboard-products') }}" class="list-group-item list-group-item-action {{ Request::is('dashboard/products*') ? 'bg-light text-dark':'' }}"> Produk </a>
						<a href="{{ route('dashboard-transactions') }}" class="list-group-item list-group-item-action {{ Request::is('dashboard/transactions*') ? 'bg-light text-dark':'' }}"> Transaksi </a>
						<a href="/dashboard-account.html" class="list-group-item list-group-item-action {{ Request::is('dashboard/reports*') ? 'bg-light text-dark':'' }}"> Laporan </a>
					</div>
				</div>

				<!-- PAGE CONTENT -->
				<div id="page-content-wrapper" class="d-flex flex-column">
					<nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top" data-aos="fade-down">
						<div class="container-fluid">
							<button class="btn btn-secondary d-md-none mr-auto mr-2" id="menu-toggle">Menu &raquo;</button>
							<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
								<span class="navbar-toggler-icon"></span>
							</button>
							<div class="collapse navbar-collapse" id="navbarSupportedContent">
								<!-- Desktop Device -->
								<ul class="navbar-nav d-none d-lg-flex ml-auto">
									<li class="nav-item dropdown">
										<a href="#" class="nav-link menu-drop px-0" id="navbarDropdown" role="button" data-toggle="dropdown">
											<img src="{{ Auth::user()->avatar_url }}" alt="Foto Profil" class="rounded-circle mr-2 profile-picture" />
											Hi, {{ Auth::user()->name }}!
											<i class="fa fa-angle-right" id="angle"></i>
										</a>
										<div class="dropdown-menu">
											<a href="{{ route('dashboard-account') }}" class="dropdown-item">Pengaturan</a>
											<div class="dropdown-divider"></div>
											<a href="/logout" class="dropdown-item">Keluar</a>
										</div>
									</li>
								</ul>

								<!-- Mobile Device -->
								<ul class="navbar-nav d-block d-lg-none">
									<li class="nav-item">
										<a href="#" class="nav-link"> Hi, {{ Auth::user()->name }}! </a>
									</li>
									<li class="nav-item">
										<a href="#" class="nav-link d-inline-block"> Keranjang </a>
									</li>
								</ul>
							</div>
						</div>
					</nav>

					{{-- Page Content --}}
                    @yield('content')

					{{-- Footer --}}
					

				</div>
			</div>
		</div>

		<!-- Bootstrap core JavaScript -->
		<script src="/vendor/jquery/jquery.slim.min.js"></script>
		<script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        @stack('prepend-script')
		<script>
			AOS.init();
		</script>
		<script>
			$(document).ready(function(){
				var angle = document.getElementById("angle");
				$('.menu-drop').click(function (e) {
					if (angle.className == 'fa fa-angle-right'){
						angle.classList.remove('fa-angle-right');
						angle.classList.add('fa-angle-down');
					} else {
						angle.classList.remove('fa-angle-down');
						angle.classList.add('fa-angle-right');
					}
				});
				$(document).click(function (e) {
					if (!$(e.target).closest('.menu-drow, #angle').length) {
						angle.classList.remove('fa-angle-down');
						angle.classList.add('fa-angle-right');
					}
				});


			});

		</script>
		<script>
			$("#menu-toggle").click(function (e) {
				e.preventDefault();
				$("#wrapper").toggleClass("toggled");
			});
		</script>
        @stack('addon-script')
		@include('sweetalert::alert')
	</body>
</html>
