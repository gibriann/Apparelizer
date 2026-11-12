@extends('pages.admin-new.layouts.admin')

@section('title','Dashboard')
    
@section ('content')
    <!-- Begin Page Content -->
<div class="container-fluid">
    
    <!-- Page Heading -->

    <div class="text-dark mb-4">
        <div class="h3">Dashboard</div>
        <p>Hasil yang telah kita raih sejauh ini.</p>
    </div>
    <!-- Content Row -->

    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-xl-4 col-md-4 mb-4">
                    <div class="card h-100 py-2 shadow">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Pelanggan</div>
                                    <div class="h3 mb-0 font-weight-bold text-gray-800">{{$customer}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4 mb-4">
                    <div class="card h-100 py-2 shadow">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Transaksi</div>
                                    <div class="h3 mb-0 font-weight-bold text-gray-800">{{$purchaseCount}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-4 mb-4">
                    <div class="card h-100 py-2 shadow">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Penghasilan</div>
                                    <div class="h3 mb-0 font-weight-bold text-gray-800">Rp {{str_replace(',','.', (number_format($totalIncome)))}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row text-dark">
        <div class="col">
            <h5>Transaksi Terbaru</h5>
            @foreach ($purchases as $purchase)
                <a href="/dashboard/transactions/{{$purchase->id}}/detail" class="card mb-3 text-decoration-none text-dark shadow">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 align-self-center">{{$purchase->code}}</div>
                            <div class="col-md-3 align-self-center">{{$purchase->user->name}}</div>
                            <div class="col-md-2 align-self-center">{{$purchase->statusPayment->payment_status_name}}</div>
                            <div class="col-md-3 align-self-center">{{Carbon\Carbon::parse($purchase->created_at)->translatedFormat('d F Y')}}</div>
                            <div class="col-md-1 d-none d-md-block text-right">
                                <img src="/images/dashboard-arrow-right.svg" alt="" />
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endsection