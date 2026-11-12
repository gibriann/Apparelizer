<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>Customer_{{$purchase->recipient}}_{{$purchase->code}}</title>
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
			margin-right: 1cm;
			margin-left: 1cm
		}
		table.center {
			margin-left: 1cm;
		}
		table.center1 {
			margin-right: auto;
			margin-left: auto;
		}
	</style>
</head>
<body>
<div style="background-color: rgb(221, 221, 221)">
    <div class="container">
        <table width="100%" style="margin-top:10px; margin-bottom:10px; border-collapse: collapse">
            <thead>
                <tr>
                    <td width=100px>
                        <div>
                            <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('/images/firmos-logo.png'))) }}" height="75">
                        </div>
                    </td>
                    <td style="vertical-align: middle">
                        <font size=12pt><b>Firmos Store</b></font>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div class="container" style="margin-top: 10px">
    <table style="border-collapse: collapse; font-size:10pt; margin-bottom: 15px; font-size: 9pt" width="100%">
        <tr>=
            <td width=30%>Ekspedisi</td>
            <td width=30%>Kode</td>
            <td width=20%>Ongkir</td>
            <td width=20%>Berat</td>
        </tr>
        <tr>
            <td><b><span style="text-transform: uppercase">{{$purchase->courier}}</span> - {{$purchase->service}}</b></td>
            <td><b>{{$purchase->code}}</b></td>
            <td><b>Rp {{str_replace(',','.',number_format($purchase->shipment_fee))}}</b></td>
            <td><b>{{str_replace(',','.', number_format($purchase->total_weight / 1000))}} Kg</b></td>
        </tr>
    </table>
    <table style="border-collapse: collapse; font-size:10pt; margin-bottom: 10px; font-size: 9pt" width="100%">
        <tr>
            <td width="100px">Kepada</td>
            <td>
                <b>{{$purchase->recipient}}</b>
                <br>
                {{$purchase->recipient_address}}, {{$purchase->district}}, {{$purchase->province}}. {{$purchase->postal_code}}
                <br>
                {{$purchase->recipient_number}}
            </td>
        </tr>
    </table>
    <table style="border-collapse: collapse; font-size:10pt; margin-bottom: 10px; font-size: 9pt" width="100%">
        <tr>
            <td width="100px">Dari</td>
            <td>
                <b>Firmos Store</b>
                <br>
                Jl. Letkol Isdiman No.103, Bancar, Kec. Purbalingga, Kabupaten Purbalingga, Jawa Tengah 53316
            </td>
        </tr>
    </table>
    
</div>
<div style="border-top: dashed 1px; background-color: transparent;"></div>
<div class="container" style="margin-top: 10px">
    <table style="border-collapse: collapse; font-size:10pt; margin-bottom: 10px; font-size: 9pt">
        @foreach ($purchase->purchased_product as $item)
            <tr>
                <td width="75px">{{$item->quantity}} pcs</td>
                <td>{{$item->product->product_name}} ({{$item->size->size_name}}, {{$item->color->color_name}}, {{$item->printingType->printing_name}})</td>
            </tr>
        @endforeach
    </table>
</div>

</body>
</html>