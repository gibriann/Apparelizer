@extends('layouts.app')

@section('title')
    Detail Transaksi 
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
								<h5 class="card-title-detail">Detail Transaksi</h5>
								<hr>
								<div class="row">
									<div class="col-sm-6">
										<div class="row mb-2">
											<div class="col-sm-3">
												Penerima
											</div>
											<div class="col-sm-1 d-none d-sm-inline">
												:
											</div>
											<div class="col-sm-8">
												{{$purchase->recipient}}
											</div>
										</div>
										<div class="row mb-2">
											<div class="col-sm-3">
												Telepon
											</div>
											<div class="col-sm-1 d-none d-sm-inline">
												:
											</div>
											<div class="col-sm-8">
												{{$purchase->recipient_number}}
											</div>
										</div>
										<div class="row mb-2">
											<div class="col-sm-3">
												Tanggal
											</div>
											<div class="col-sm-1 d-none d-sm-inline">
												:
											</div>
											<div class="col-sm-8">
												{{Carbon\Carbon::parse($purchase->created_at)->translatedFormat('d F Y')}}
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="row mb-2">
											<div class="col-sm-3">
												Status
											</div>
											<div class="col-sm-1 d-none d-sm-inline">
												:
											</div>
											<div class="col-sm-8">
												@if ($purchase->shipping_status_id == 1 AND $purchase->payment_status_id == 1)
													<span class="text-warning"> {{ $purchase->statusShipping->shipping_status_name }} </span>
												@elseif ($purchase->payment_status_id == 3)
													<span class="text-danger"> {{ $purchase->statusPayment->payment_status_name }} </span>
												@elseif ($purchase->shipping_status_id == 4 OR $purchase->shipping_status_id == 5)
													<span class="text-success"> {{ $purchase->statusShipping->shipping_status_name }} </span>
												@else
													<span class="text-secondary"> {{ $purchase->statusShipping->shipping_status_name }} </span>
												@endif
											</div>
										</div>
										<div class="row mb-2">
											<div class="col-sm-3">
												Resi
											</div>
											<div class="col-sm-1 d-none d-sm-inline">
												:
											</div>
											<div class="col-sm-8">
												{{ $purchase->shipment_receipt ?? 'Belum ada' }}
											</div>
										</div>
										<div class="row mb-2">
											<div class="col-sm-3">
												Ekspedisi
											</div>
											<div class="col-sm-1 d-none d-sm-inline">
												:
											</div>
											<div class="col-sm-8">
												{{ Str::upper($purchase->courier)}}, {{ $purchase->service }} ({{ $purchase->etd }})
											</div>
										</div>
									</div>
								</div>
								<div class="transaction-product-details mt-4">
									<h5 class="card-title-detail">Detail Produk</h5>
									<hr>

									@foreach ($purchase->purchased_product as $item)
										<div class="card mb-3">
											<div class="transaction-section-content">
												<div class="card-body">
													<div class="d-flex product-transaction-details mt-3">
														<div class="imeg mr-5">
															<img class="img-responsive" width="75px" src="@productImage($item->product->product_image)" alt="" />
														</div>
														<div class="my-auto bd-highlight transaction-detail-order1">
															<span class="transaction-product-title">{{$item->product->product_name}}</span> <br />
															<span class="transaction-colorqty"
																>{{$item->size->size_name}}, {{$item->color->color_name}}, {{$item->printingType->printing_name}}<br />
																{{$item->quantity}} pcs</span
															>
															<br>
															
														</div>
														<div class="poi-wrapper ml-auto bd-highlight">
															<span class="transaction-poi-header"
																>Total <span class="d-none d-sm-inline">Harga</span></span
															>
															<br />
															<b class="transaction-poi">Rp {{str_replace(',','.', (number_format($item->product->product_price * $item->quantity)))}}</b>
														</div>
													</div>
												</div>
											</div>
										</div>
									@endforeach
								</div>
								<div class="transaction-payment-details mt-4">
									<h5 class="card-title-detail">Detail Pembayaran</h5>
									<hr />
									<div class="row">
										<div class="col-sm-12">
											<div class="transaction-payment-content">
												<div class="row mb-2">
													<div class="col-sm-3">
														Total Pembelian
													</div>
													<div class="col-sm-8">
														<span class="col-sm-1 d-none d-sm-inline">
															:
														</span>
														Rp {{str_replace(',','.', (number_format($purchase->purchased_product->sum('total_order'))))}}
													</div>
												</div>
												<div class="row mb-2">
													<div class="col-sm-3">
														Biaya Pengiriman
													</div>
													<div class="col-sm-8">
														<span class="col-sm-1 d-none d-sm-inline">
															:
														</span>
														Rp {{ str_replace(',','.', (number_format($purchase->shipment_fee))) }}
													</div>
												</div>
												<div class="row mb-2">
													<div class="col-sm-3">
														Total Pembayaran
													</div>
													<div class="col-sm-8">
														<span class="col-sm-1 d-none d-sm-inline">
															:
														</span>
														<span style="color: #29a867; font-weight: 550">
															Rp {{ str_replace(',','.', (number_format($purchase->total_payment))) }}
														</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="transaction-shipping-details mt-4">
									<h5 class="card-title-detail">Detail Pengiriman</h5>
									<hr />
									<div class="row">
										<div class="col-12">
											<h6>Alamat</h6>
											<p>
												{{ $purchase->recipient_address}}
											</p>
										</div>
									</div>
									<br />
									<div class="row">
										<div class="col-12 col-lg-3">
											<h6>Provinsi</h6>
											<p>{{ $purchase->province }}</p>
										</div>
										<div class="col-12 col-lg-3">
											<h6>Kota</h6>
											<p>{{ $purchase->district }}</p>
										</div>
										<div class="col-12 col-lg-3">
											<h6>Kode POS</h6>
											<p>{{ $purchase->postal_code }}</p>
										</div>
									</div>
								</div>
								@if ($purchase->payment_status_id != 2)
									<div class="mt-3 text-right">
										<a href="{{ $purchase->payment_url }}" style="margin: 0 0 0 5px"  class="py-2 btn text-center btn-success text-white">
											Bayar
										</a>
									</div>
								@endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection