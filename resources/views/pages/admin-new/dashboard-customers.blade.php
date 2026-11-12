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
        <div class="h3">Daftar Pelanggan</div>
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
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th width=80px>Aksi</th>
                                    </tr>
                                </thead>
        
                                <tbody>
                                    @foreach ($customers as $customer)
                                        <tr>
                                            <td>{{ $loop->iteration }}.</td>
                                            <td>{{ $customer->name }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ $customer->userStatus->status_user_name }}</td>
                                            <td>
                                                <form action="/dashboard/{{$customer->id}}/status" class="d-sm-inline-block" method="POST">
                                                    @csrf
                                                    @if ($customer->user_status_id == 1)
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Non-Aktifkan User"><i class="fa fa-times"></i></button>
                                                    @elseif ($customer->user_status_id == 2)
                                                        <button type="submit" class="btn btn-sm btn-success" title="Aktifkan User"><i class="fa fa-check"></i></button>
                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
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