<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<meta name="description" content="" />
		<meta name="author" content="" />
		<link rel="icon" href="{{ asset('images/firmos-logo.png') }}" type="image/x-icon">

		<title>@yield('title')</title>

        {{-- Prevent flash of wrong theme --}}
        <script>
            (function(){
                var t = localStorage.getItem('theme') || 'light';
                document.documentElement.setAttribute('data-theme', t);
            })();
        </script>

        {{-- Style --}}
        @stack('prepend-style')
		@include('includes.style')
        @stack('addon-style')
		
		@stack('owlcarousel')
		@stack('fontawesome')
	</head>

	<body>
		{{-- Navigation bar --}}
		@guest
			@include('includes.navbar')
		@endguest

		@auth
			@include('includes.navbar-authenticated')
		@endauth

		{{-- Page Content --}}
		@yield('content')

        {{-- Footer --}}
		@include('includes.footer')

		<!-- Script -->
		
		@stack('owlcarouselfooter')
		@stack('prepend-script')
		@include('includes.script')
        @stack('addon-script')
		@include('sweetalert::alert')
	</body>
</html>
