@extends('pages.admin-new.layouts.admin')

@section('title','Dashboard')
    
@section ('content')
    <!-- Begin Page Content -->
<div class="container-fluid">
    
    <!-- Page Heading -->

    <div class="text-dark mb-4">
        <div class="h3">Tambah Produk</div>
    </div>
    <!-- Content Row -->

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('dashboard-product-store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-4" data-aos="zoom-out">
                                <label for="">Nama Produk</label>
                                <input type="text" class="form-control @error('product_name') is-invalid @enderror @error('product_name') is-invalid @enderror" name="product_name" value="{{old('product_name')}}" autofocus />
                                @error('product_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4" data-aos="zoom-out">
                                <label for="">Harga</label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">Rp</div>
                                    </div>
                                    <input type="number" class="form-control @error('product_price') is-invalid @enderror" placeholder="0" name="product_price" value="{{old('product_price')}}">
                                    @error('product_price')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-4" data-aos="zoom-out">
                                <label for="">Berat (gr)</label>
                                <div class="input-group">
                                    <input type="number" class="form-control @error('product_weight') is-invalid @enderror" placeholder="0" name="product_weight" value="{{old('product_weight')}}">
                                    @error('product_weight')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group col-md-4" data-aos="zoom-out" data-aos-delay="200">
                                <label for="">Upload foto</label>
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
                            <div class="form-group col-md-12" data-aos="zoom-out" data-aos-delay="400">
                                <label for="" class="form-title">Deskripsi</label>
                                <textarea id="editor" rows="10" class="form-control @error('product_description') is-invalid @enderror" name="product_description" >{{old('product_description')}}</textarea>
                                @error('product_description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div data-aos="zoom-out" data-aos-delay="700">
                            <button type="submit" class="btn btn-success btn-block text-white">SUBMIT</button>
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