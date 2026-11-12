@extends('layouts.app')

@section('title')
    Detail Transaksi 
@endsection

@section('content')
<div class="page-content page-home">
	<section class="store-products">
		<div class="container">
			<div id="page-content-wrapper">
				<!-- Section Content -->
				<div class="section-content section-dashboard-home" data-aos="fade-up">
					<div class="container-fluid">
						<br />
						<div class="dashboard-transaction-detail">
							<h2 class="dashboard-title">Detail Pemesanan</h2>
						</div>

						<div class="row">
							<div class="col-md-12 col-lg-12 mt-2 pr-5">
								<div class="card mb-2">
									<div class="transaction-section-content">
										<div class="card-body">
											<h5 class="card-title-detail">Detail Transaksi</h5>
											<hr />
											<!-- Detail Transaksi -->
											<div class="row">
												<div class="col-lg-6 col-md-12">
													<div class="transaction-detail-content">
														<ul>
															<li><b>Penerima</b>: {{$purchase->recipient}}</li>
															<li><b>Telepon</b>: {{$purchase->recipient_number}}</li>
															<li><b>Tanggal</b>: {{Carbon\Carbon::parse($purchase->created_at)->translatedFormat('d F Y')}}</li>
														</ul>
													</div>
												</div>
												<div class="col-lg-6 col-md-12">
													<div class="transaction-detail-content">
														<ul>
															@if ($purchase->shipping_status_id == 1 AND $purchase->payment_status_id == 1)
																<li><b>Status</b>: <span class="text-warning"> {{ $purchase->statusShipping->shipping_status_name }} </span></li>
															@elseif ($purchase->payment_status_id == 3)
																<li><b>Status</b>: <span class="text-danger"> {{ $purchase->statusPayment->payment_status_name }} </span></li>
															@elseif ($purchase->shipping_status_id == 4 OR $purchase->shipping_status_id == 5)
																<li><b>Status</b>: <span class="text-success"> {{ $purchase->statusShipping->shipping_status_name }} </span></li>
															@else
															<li><b>Status</b>: <span class="text-secondary"> {{ $purchase->statusShipping->shipping_status_name }} </span></li>
															@endif
															<li><b>Resi</b>: {{ $purchase->shipment_receipt ?? 'Belum ada' }}</li>
															<li><b>Ekspedisi</b>: {{ Str::upper($purchase->courier)}}, {{ $purchase->service }} ({{ $purchase->etd }})</li>
														</ul>
													</div>
												</div>
											</div>

											<!-- Detail Produk -->
											<div class="transaction-product-details">
												<h5 class="card-title-detail">Detail Produk</h5>
												<hr />
												@foreach ($purchase->purchased_product as $item)
													<div class="d-flex product-transaction-details">
														<div class="imeg">
															<img class="img-responsive" src="@productImage($item->product->product_image)" alt="" />
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
												@endforeach

											

											<div class="transaction-payment-details">
												<h5 class="card-title-detail">Detail Pembayaran</h5>
												<hr />
												<div class="row">
													<div class="col-lg-12 col-md-12">
														<div class="transaction-payment-content">
															<ul>
																<li><b>Total Pembelian</b>: Rp {{str_replace(',','.', (number_format($purchase->purchased_product->sum('total_order'))))}}</li>
																
																<li><b>Biaya Pengiriman</b>: Rp {{ str_replace(',','.', (number_format($purchase->shipment_fee))) }}</li>
																<li>
																	<b>Total Pembayaran</b>:
																	<span style="color: #29a867; font-weight: 550"
																		>Rp {{ str_replace(',','.', (number_format($purchase->total_payment))) }}</span
																	>
																</li>
															</ul>
														</div>
													</div>
												</div>
											</div>

											<!-- Detail Shipping -->
											<div class="transaction-shipping-details">
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
													<div class="col-4 col-lg-3">
														<h6>Provinsi</h6>
														<p>{{ $purchase->province }}</p>
													</div>
													<div class="col-4 col-lg-3">
														<h6>Kota</h6>
														<p>{{ $purchase->district }}</p>
													</div>
													<div class="col-4 col-lg-3">
														<h6>Kode POS</h6>
														<p>{{ $purchase->postal_code }}</p>
													</div>
												</div>
											</div>
											<br />
											<hr />

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
				</div>
			</div>
		</div>
	</section>
</div>
@endsection