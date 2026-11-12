@extends('pages.admin-new.layouts.admin')

@section('title','Dashboard')

@section('style')
<link rel="stylesheet" href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section ('content')
    <!-- Begin Page Content -->
<div class="container-fluid">
    
    <!-- Page Heading -->

    <div class="text-dark mb-4">
        <div class="h3">Detail Pemesanan {{$purchase->code}}</div>
    </div>

    <!-- Content Row -->

    <div class="row mb-5">
        <div class="col">
            <div class="card shadow text-dark">
                <div class="card-body">
                    <form action="/dashboard/transactions/{{$purchase->id}}/detail" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="h5 size-16 mt-2"><b>Detail Transaksi</b></div>
                            </div>
                            <div class="col-6 text-right">
                                <button type="submit" class="py-2 btn text-center btn-sm btn-success text-white"> Simpan </button>
                            </div>
                        </div>
                        <hr>
                        <!-- Detail Transaksi -->
                        <div class="row">
                            <div class="col-lg-6 col-md-12">
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        Nama Customer
                                    </div>
                                    <div class="col-sm-1 d-none d-sm-inline">
                                        :
                                    </div>
                                    <div class="col-sm-7">
                                        {{$purchase->user->name}}
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-4">
                                        Telepon
                                    </div>
                                    <div class="col-sm-1 d-none d-sm-inline">
                                        :
                                    </div>
                                    <div class="col-sm-7">
                                        {{$purchase->recipient_number}}
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-sm-4">
                                        Tanggal
                                    </div>
                                    <div class="col-sm-1 d-none d-sm-inline">
                                        :
                                    </div>
                                    <div class="col-sm-7">
                                        {{Carbon\Carbon::parse($purchase->created_at)->translatedFormat('d F Y')}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12">
                                <div class="transaction-detail-content">
                                    <div class="row mb-2">
                                        <div class="col-sm-4">
                                            Status Pemesanan
                                        </div>
                                        <div class="col-sm-1 d-none d-sm-inline">
                                            :
                                        </div>
                                        <div class="col-sm-7">
                                            <select name="shipping_status_id" id="shipping_status" class="form-control" v-model="status">
                                                <option value="" disabled selected>Pilih Status</option>
                                                @foreach ($shippingStatus as $status)
                                                    <option value="{{ $status->id }}" {{$status->id == $purchase->shipping_status_id ? 'selected' : ''}}>{{ $status->shipping_status_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-sm-4">
                                            Resi
                                        </div>
                                        <div class="col-sm-1 d-none d-sm-inline">
                                            :
                                        </div>
                                        <div class="col-sm-7">
                                            {{$purchase->shipment_receipt ?? 'Belum diatur'}}
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-sm-4">
                                            Kurir
                                        </div>
                                        <div class="col-sm-1 d-none d-sm-inline">
                                            :
                                        </div>
                                        <div class="col-sm-7 text-uppercase">
                                            {{$purchase->courier}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="h5 size-16 mt-2"><b>Detail Produk</b></div>
                    <hr>
                    @foreach ($purchase->purchased_product as $item)
                        <div class="card bg-light text-dark px-4 @if(!$loop->last) mb-3 @else mb-4 @endif">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-2 align-self-center">
                                        <img src="@productImage($item->product->product_image)" height="100px">
                                    </div>
                                    <div class="col-8 align-self-center">
                                        <div class="h5"><b>{{$item->product->product_name}}</b></div>
                                        {{$item->size->size_name}}, {{$item->color->color_name}}, {{$item->printingType->printing_name}} <br>
                                        {{$item->quantity}} pcs <a target="blank" href="{{ $item->product_design }}">Link Design</a>
                                    </div>
                                    <div class="col-2 align-self-center text-right">
                                        Total <span class="d-none d-sm-inline">Harga</span>
                                        <div class="h5"><b>Rp {{str_replace(',','.', (number_format($item->product->product_price * $item->quantity)))}}</b></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="h5 size-16 mt-2"><b>Detail Pembayaran</b></div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6 col-md-12">
                            <div class="row mb-2">
                                <div class="col-sm-4">
                                    Total Pembelian
                                </div>
                                <div class="col-sm-1 d-none d-sm-inline">
                                    :
                                </div>
                                <div class="col-sm-7">
                                    Rp {{str_replace(',','.', (number_format($purchase->purchased_product->sum('total_order'))))}}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-4">
                                    Biaya Pengiriman
                                </div>
                                <div class="col-sm-1 d-none d-sm-inline">
                                    :
                                </div>
                                <div class="col-sm-7">
                                    Rp {{str_replace(',','.', (number_format($purchase->shipment_fee)))}}
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-sm-4">
                                    Total Pembayaran
                                </div>
                                <div class="col-sm-1 d-none d-sm-inline">
                                    :
                                </div>
                                <div class="col-sm-7 text-success">
                                    <b>Rp {{str_replace(',','.', (number_format($purchase->purchased_product->sum('total_order') + $purchase->shipment_fee)))}}</b>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="h5 size-16 mt-2"><b>Detail Pengiriman</b></div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h6>Alamat</h6>
                            <b>{{$purchase->recipient_address}}</b>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-4 col-lg-3">
                            <h6>Provinsi</h6>
                            <b>{{$purchase->province}}</b>
                        </div>
                        <div class="col-4 col-lg-3">
                            <h6>Kota</h6>
                            <b>{{$purchase->district}}</b>
                        </div>
                        <div class="col-4 col-lg-3">
                            <h6>Kode POS</h6>
                            <b>{{$purchase->postal_code}}</b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{url('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{url('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function (){
        $('#projecttable').DataTable({
            "lengthMenu": [[5,10,25,50,-1], [5,10,25,50,"All"]],
            "language": {
            "sEmptyTable":   "Tidak ada data",
            "sProcessing":   "Sedang memproses...",
            "sLengthMenu":   "Tampilkan _MENU_ data",
            "sZeroRecords":  "Tidak ditemukan data yang sesuai",
            "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 data",
            "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
            "sInfoPostFix":  "",
            "sSearch":       "Cari:",
            "sUrl":          "",
            "oPaginate": {
                "sFirst":    "Pertama",
                "sPrevious": "<",
                "sNext":     ">",
                "sLast":     "Terakhir"
            }
        }
        });
    });
</script>
@endsection