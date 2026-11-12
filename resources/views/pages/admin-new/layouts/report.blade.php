<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>@yield('title')</title>
	<link rel="shortcut icon" type="image/png" href="{{url('images/firmos-logo.png')}}"/>
	<style>
		@page { margin: 0px; }
        body { margin: 0px; }
		body{
			font-family:"Poppins", sans-serif;
			font-size: 12pt;
		}
		th, td{
			vertical-align: top
		}
		.container {
			padding-right: .75rem;
			padding-left: .75rem;
			margin-right: 2.5cm;
			margin-left: 2.5cm
		}
		table.center {
			margin-left: 1cm;
		}
		table.center1 {
			margin-right: auto;
			margin-left: auto;
		}
	</style>
	@yield('style')
</head>
<body>
<div style="background-color: rgb(221, 221, 221)">
    <div class="container">
        <table width="100%" style="margin-top:30px; margin-bottom:30px; border-collapse: collapse">
            <thead>
                <tr>
                    <td width=100px>
                        <div style="margin-top: 10px">
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/images/firmos-logo.png'))) }}" height="75">
                        </div>
                    </td>
                    <td style="vertical-align: middle">
                        <font size=12pt><b>Firmos Store</b></font><br>
                        <font size=10pt> Jl. Jenderal Sudirman No.184, Purbalingga, Jawa Tengah</font><br>
                        <font size=10pt> Telp. (0281) 896232 Fax. (0281) 894381</font><br>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div class="container">
    @yield('content')
</div>

</body>
</html>