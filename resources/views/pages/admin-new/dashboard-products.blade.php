@extends('pages.admin-new.layouts.admin')

@section('title','Dashboard')
    
@section ('content')
    <!-- Begin Page Content -->
<div class="container-fluid">
    
    <!-- Page Heading -->

    <div class="text-dark mb-4">
        <div class="h3">Produk Firmos</div>
        <p>Kepuasan pelanggan adalah kunci</p>
    </div>

    <div class="mb-3">
        <a href="{{route('dashboard-product-add')}}" class="btn btn-success btn-icon-split btn-sm mb-1">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Tambah Produk</span>
        </a>

    </div>
    <!-- Content Row -->
    <div class="row mb-3">
        @foreach ($products as $product)
            <div class="col-xl-3 col-md-3 mb-3">
                <div class="card h-100 py-2 shadow">
                    <a href="/dashboard/products/{{ $product->id }}/details" class="text-center">
                        <img class="px-2 mt-3" height="150px !important" src="@productImage($product->product_image)" />
                    </a> 
                    <div class="card-body text-dark text-center">
                        <div class="h5">{{ $product->product_name }}</div>
                        <div class="small">Rp {{ number_format($product->product_price) }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="d-flex justify-content-center">
        {!! $products->links() !!}
    </div>
</div>
@endsection