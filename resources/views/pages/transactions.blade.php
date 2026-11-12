@extends('layouts.app')

@section('title')
    Transaksi
@endsection

@section('content')
	<div class="page-content page-home">
        <section class="store-products">
            <div class="container">
                
                <div class="row justify-content-center mt-2">
                    <div class="col-12 mt-2 ">
                        <div class="card card-white shadow p-4 mb-2">
                            <div class="transaction-section-content">
                                
								<div class="card-body">
									<div class="dashboard-content">
										<h2 class="dashboard-title ml-2 ">Daftar Transaksi</h2>
										@if (count($purchases) > 0)
											<p class="dashboard-subtitle ml-2 mb-3">Pesanan-pesanan yang sudah kamu lakukan sejauh ini</p>
											@foreach ($purchases as $purchase)
											
											<div class="row">
												<div class="col-12 mt-2">
													<a href="/transactions/{{$purchase->id}}/details" class="card card-list d-block">
														<div class="card-body">
															<div class="row mb-3">
																<div class="col-12 col-sm-6">
																	<small>{{ \Carbon\Carbon::parse($purchase->created_at)->translatedFormat('d F Y') }}</small>
																</div>
																<div class="col-12 col-sm-6 text-sm-right">
																	@if ($purchase->shipping_status_id == 1)
																		@if ($purchase->payment_status_id == 1)
																			<span class="badge badge-dark">{{ $purchase->statusPayment->payment_status_name }}</span>
																		@elseif ($purchase->payment_status_id == 3)
																			<span class="badge badge-danger">{{ $purchase->statusPayment->payment_status_name }}</span>
																		@endif
																	@elseif ($purchase->shipping_status_id == 2 OR $purchase->shipping_status_id == 3)
																		<span class="badge badge-secondary">{{ $purchase->statusShipping->shipping_status_name }}</span>
																	@elseif ($purchase->shipping_status_id == 4)
																		<span class="badge badge-info">{{ $purchase->statusShipping->shipping_status_name }}</span>
																	@elseif ($purchase->shipping_status_id == 5)
																		<span class="badge badge-success">{{ $purchase->statusShipping->shipping_status_name }}</span>
																	@elseif ($purchase->shipping_status_id == 6)
																		<span class="badge badge-danger">{{ $purchase->statusShipping->shipping_status_name }}</span>
																	@endif
																</div>
															</div>

															<div class="row">
																<div class="col-md-8 ">
																	@php
																		$count = count($purchase->purchased_product);
																	@endphp
																	@foreach ($purchase->purchased_product as $key => $item)
																		<div class="row">
																			<div class="col-md-2">
																				@if ($loop->first)
																					<img height="75px" src="@productImage($item->product->product_image)" alt="">
																				@endif
																			</div>
																			<div class="col-md-10 align-self-center">
																				@if ($loop->first)
																				<h5 style="margin-bottom: 0px;">
																					{{ $item->product->product_name }}
																					<small>{{ $item->color->color_name }}, {{ $item->size->size_name }}, {{ $item->printingtype->printing_name }}</small>
																				</h5>
																				@if ($count != 1)
																					<small class="text-secondary">+{{ $count - 1 }} produk lainnya</small>
																				@endif
																				@endif
																			</div>
																		</div>
																	@endforeach
																</div>
																<div class="col-md-3 border-left align-self-center">
																	Rp {{ number_format($purchase->total_payment)}}
																</div>
																<div class="col-md-1 d-none d-md-block text-right align-self-center">
																	<img src="/images/dashboard-arrow-right.svg" alt="" />
																</div>
															</div> 
														</div>
													</a>
												</div>
											</div>
											@endforeach
										@else 
											<p class="dashboard-subtitle ml-2 mb-3">Riwayat anda kosong, silahkan belanja</p>
											<div class="text-right">
												<a href="/products" class="btn btn-success ml-2 mb-3">Belanja</a></div> 
										@endif
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>		
@endsection
