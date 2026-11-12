@extends('pages.admin-new.layouts.report')

@section('title','Laporan Penjualan')

@section('content')
<p>
    Periode 
    <br>
    @if ($filter == "hari ini")
        {{Carbon\Carbon::parse($periode)->translatedFormat('d F Y')}}
    @elseif ($filter == "minggu ini")
        {{$periode}}
    @elseif ($filter == "bulan ini")
        {{$periode}}
    @elseif ($filter == "tahun ini")
        Tahun {{$periode}}
    @endif
</p>
<p>Detail Penjualan</p>

<hr>
<table border="1" style="border-collapse: collapse; font-size:11pt; margin-bottom: 10px" cellpadding=3px width="100%">
    <tr>
        <th>Nama Produk</th>
        <th>Ukuran</th>
        <th>Warna</th>
        <th>Sablon</th>
        <th>Jumlah</th>
        <th>Sub Total</th>
    </tr>
    @php
        $total = 0;
    @endphp
    @foreach ($purchases as $purchase)
        <tr>
            <td>{{$purchase->product->product_name}}</td>
            <td>{{$purchase->size->size_name}}</td>
            <td>{{$purchase->color->color_name}}</td>
            <td>{{$purchase->printingType->printing_name}}</td>
            <td>{{$purchase->quantity}}</td>
            <td style="text-align: right">Rp {{str_replace(',','.',number_format($purchase->total_order))}}</td>
        </tr>
        @php
            $total += $purchase->total_order;
        @endphp
        @endforeach
        <tr>
            <th colspan=5 style="text-align: right">Total Penjualan</th>
            <td style="text-align: right">Rp {{str_replace(',','.', (number_format($total)))}}</td>
        </tr>
</table>
<br>
<table width=100% cellpadding=4px>
    <tr>
        <td width=55%></td>
        <td width=45%>Purbalingga, {{ \Carbon\Carbon::now()->translatedFormat("j F Y") }} <br> Pemilik Firmos Store</td>
    </tr>
    <tr><td height="75px"></td></tr>
    <tr>
        <td></td>
        <td>Firman Anggara</td>
    </tr>
</table>
@endsection