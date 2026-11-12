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
        <div class="h3">Daftar Transaksi</div>
        <p>Pesanan-pesanan yang sudah kamu lakukan sejauh ini</p>
    </div>

    <!-- Content Row -->

    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <div class="mt-2 p-2">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-sm text-dark nowrap" width="100%" cellspacing="0" id="projecttable">
                                <thead class="thead">
                                    <tr>
                                        <th width=25px>No.</th>
                                        <th>Kode Pembelian</th>
                                        <th>Nama</th>
                                        <th>Tanggal</th>
                                        <th>Status Pembayaran</th>
                                        <th>Status Pengiriman</th>
                                        <th width=53px>Aksi</th>
                                        
                                    </tr>
                                </thead>
        
                                <tbody>
                                    @foreach ($purchases as $purchase)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $purchase->code }}</td>
                                            <td>{{ $purchase->user->name }}</td>
                                            <td>{{Carbon\Carbon::parse($purchase->created_at)->translatedFormat('d-M-Y')}}</td>
                                            <td>{{ $purchase->statusPayment->payment_status_name }}</td>
                                            <td>{{ $purchase->statusShipping->shipping_status_name }}</td>
                                            <td>
                                                @if ($purchase->shipping_status_id == 4 && $purchase->shipment_receipt == null)
                                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#inputResi{{$purchase->id}}" title="Input Resi">Input Resi</button>
                                                @else
                                                    <a href="/dashboard/transactions/{{$purchase->id}}/detail" class="btn btn-sm btn-info" title="Ubah Data"><i class="fa fa-pencil-alt"></i></a>
                                                @endif
                                                <a href="/dashboard/transactions/{{$purchase->id}}/customer" class="btn btn-sm btn-secondary" title="Cetak Info Customer" target="blank"><i class="fa fa-print"></i></a>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="inputResi{{$purchase->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            Masukan Nomor Resi {{$purchase->code}}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="/dashboard/transactions/{{$purchase->id}}/resi" method="POST">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <input type="text" name="resi" placeholder="Nomor resi" class="form-control" autofocus>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
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