<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<meta name="description" content="" />
		<meta name="author" content="" />
		<link rel="icon" href="{{ asset('images/firmos-logo.png') }}" type="image/x-icon">


		<title>@yield('title')</title>

        {{-- Style --}}
        @stack('prepend-style')
		@include('includes.style')
        @stack('addon-style')
		
		@stack('fontawesome')
	</head>

	<body>
		{{-- Page Content --}}
		@yield('content')

        {{-- Footer --}}
		@include('includes.footer')

		<!-- Script -->
		@stack('prepend-script')
		@include('includes.script')
        @stack('addon-script')
		@include('sweetalert::alert')
	</body>
</html>
