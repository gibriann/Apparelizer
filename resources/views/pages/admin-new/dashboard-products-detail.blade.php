@extends('pages.admin-new.layouts.admin')

@section('title','Dashboard Produk')
    
@section ('content')
    <!-- Begin Page Content -->
<div class="container-fluid">
    
    <!-- Page Heading -->
    <div class="text-dark mb-4">
        <div class="h3">Ubah Detail Produk</div>
    </div>
    <!-- Content Row -->
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <form action="/dashboard/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-4" data-aos="zoom-out">
                                <label for="">Nama Produk</label>
                                <input type="text" class="form-control @error('product_name') is-invalid @enderror @error('product_name') is-invalid @enderror" name="product_name" value="{{$product->product_name}}" autofocus />
                                @error('product_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4" data-aos="zoom-out" data-aos-delay="150">
                                <label for="">Harga</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                    </div>
                                    <input type="number" class="form-control @error('product_price') is-invalid @enderror" placeholder="0" name="product_price" value="{{$product->product_price}}">
                                    @error('product_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-4" data-aos="zoom-out" data-aos-delay="300">
                                <label for="">Berat (gr)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('product_weight') is-invalid @enderror" placeholder="0" name="product_weight" value="{{$product->product_weight}}">
                                    @error('product_weight')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8" data-aos="zoom-out" data-aos-delay="450">
                                <div class="form-group">
                                    <label for="" class="form-title">Deskripsi</label>
                                    <textarea id="editor" rows="10" class="form-control @error('product_description') is-invalid @enderror" name="product_description" >{{$product->product_description}}</textarea>
                                    @error('product_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="row mb-3" data-aos="zoom-out" data-aos-delay="600">
                                    <div class="col">
                                        <label for="" class="form-title">Upload foto</label>
                                        <label class="buttonlabel" for="upload" id="upload-btn">
                                            <img class="buttonimg" src="/images/cloud.svg" alt="" />
                                            <span id="text">Pilih foto</span>
                                        </label>
                                        <input type="file" name="product_image" id="upload" accept=".png" class="file-upload @error('product_image') is-invalid @enderror"/>
                                        @error('product_image')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row" data-aos="zoom-out" data-aos-delay="750">
                                    <div class="col text-center">
                                        <img src="@productImage($product->product_image)" height="250px"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-2 mt-3 mt-md-0 order-4 order-md-3">
                                    <a
                                        href="/dashboard/products/{{ $product->id }}/hapus"
                                        class="py-2 btn text-center btn-danger btn-block text-white"
                                    >
                                        Hapus 
                                    </a>
                            </div>
                            <div class="col-12 col-md-10 mt-3 mt-md-0 order-3 order-md-4">
                                <button
                                    type="submit"
                                    class="py-2 btn text-center btn-success btn-block text-white order-12"
                                >
                                    SIMPAN
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.ckeditor.com/4.25.2-lts/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace("editor");
</script>

<script>
    const input = document.getElementById("upload");
    const text = document.getElementById("text");
    const btn = document.getElementById("upload-btn");

    input.addEventListener("change", () => {
        const path = input.value.split("\\");
        const filename = path[path.length - 1];

        text.innerText = filename ? filename : "Pilih foto";

        if (filename) btn.classList.add("chosen");
        else btn.classList.add("chosen");
    });
</script>
@endsection