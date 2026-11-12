@extends('layouts.app')

@section('title')
    Apparelizer - Semua Produk
@endsection

@section('content')
<div class="page-content page-home">
    <!-- Produk -->
    <section class="store-products">
        <div class="container">
            <div class="row">
                <div class="col-12" data-aos="fade-up">
                    <h5>Daftar Produk</h5>
                </div>
            </div>
            <div class="row mt-2">
                @foreach ($products as $product)
                <div class="col-6 col-md-4">
                    <div class="card mb-4 ">
                        <a href="/details/{{ $product->id }}/{{ $product->slug }}"> <img src="@productImage($product->product_image)" alt="" class="prod-img py-2" /></a>
                        <div class="card-body">
                            <div class="text-center products-text">{{ $product->product_name }}</div>
                            <div class="prod-price text-center">Rp {{ number_format($product->product_price) }}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
@endsection