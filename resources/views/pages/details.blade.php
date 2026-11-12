@extends('layouts.app')

@section('title')
    Apparelizer - Detail Produk
@endsection

@section('content')
<div class="page-content page-details">
    <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ ('home') }}">Beranda</a>
                            </li>
                            <li class="breadcrumb-item active">Detail Produk</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- gallery -->
    <section class="main-content">
        <div class="container">
            <div class="row justify-content-lg-around">
                <div class="col-12 col-lg-7 text-center" data-aos="zoom-in">
                    <img src="@productImage($product->product_image)" class="main-image" alt="" />
                </div>

                <!-- user's product details form  -->
                <div class="col-lg-4 mt-lg-2 p-0">
                    <div class="row text-center">
                        <section class="col-12 col-lg-10" data-aos="zoom-in" data-aos-delay="100">
                            <h1>{{ $product->product_name }}</h1>
                        </section>
                    </div>

                    <div class="row text-center">
                        <div class="col-12 col-lg-10" data-aos="zoom-in" data-aos-delay="150">
                            <div class="price">Rp {{ number_format($product->product_price) }}</div>
                        </div>
                    </div>
                    <form action="/cart/{{ $product->id }}/{{ $product->slug }}" method="POST">
                    @csrf
                        <div class="form-group row">
                            <div class="col-12 col-lg-10" data-aos="zoom-in" data-aos-delay="200">
                                <select class="custom-select @error('color_id') is-invalid @enderror" name="color_id" required>
                                    <option value="">Warna *</option>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}" @if (old('color_id') == "$color->id") {{ 'selected' }} @endif>{{ $color->color_name }}</option>
                                    @endforeach
                                </select>
                                @error('color_id')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12 col-lg-10" data-aos="zoom-in" data-aos-delay="250">
                                <select class="custom-select @error('size_id') is-invalid @enderror" name="size_id" required>
                                    <option value="">Ukuran *</option>
                                    @foreach ($sizes as $size)
                                        <option value="{{ $size->id }}" @if (old('size_id') == "$size->id") {{ 'selected' }} @endif>{{ $size->size_name }}</option>
                                    @endforeach
                                </select>
                                @error('size_id')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12 col-lg-10" data-aos="zoom-in" data-aos-delay="300">
                                <select class="custom-select @error('printing_id') is-invalid @enderror" name="printing_id" required>
                                    <option value="">Jenis Sablon *</option>
                                    @foreach ($printings as $printing)
                                        <option value="{{ $printing->id }}" @if (old('printing_id') == "$printing->id") {{ 'selected' }} @endif>{{ $printing->printing_name }}</option>
                                    @endforeach
                                </select>
                                @error('printing_id')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-12 col-lg-10" data-aos="zoom-in" data-aos-delay="350">
                                <input type="url" name="link_design" class="form-control @error('link_design') is-invalid @enderror" id="url"  placeholder="https://drive.google.com/azxDSw3AS" pattern="https://drive.google.com/.*" 
                                oninvalid="let br =  this.setCustomValidity('Hanya menerima link dari google drive ')" oninput="this.setCustomValidity('')" required>
                                @error('link_design')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                                <small class="text-danger">*Wajib link Google Drive</small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="input-group col-8 col-lg-6" data-aos="zoom-in" data-aos-delay="400">
                                <span class="input-group-btn">
                                    <button class="valueBtn btn-minus" disabled="disabled" type="button">-</button>
                                </span>
                                <input
                                    type="number"
                                    name="amount"
                                    class="form-control amount text-center @error('amount') is-invalid @enderror"
                                    value="6"
                                    {{-- min="6" --}}
                                    id="valueInput"
                                    {{-- max="150" --}}
                                    required
                                />
                                <span class="input-group-btn">
                                    <button class="valueBtn btn-plus" type="button">+</button>
                                </span>
                                @error('amount')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="cart col-4 col-lg-4" data-aos="zoom-in" data-aos-delay="400">
                                <button type="submit" class="btn text-center btn-cart btn-block text-white">
                                    <img src="/images/cart.svg" alt="" />
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Description box -->
    <div class="store-details-container" data-aos="fade-up">
        <section class="store-description">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-11 mt-4 text-center text-lg-left">
                        <hr />
                        <div class="description-header">Deskripsi</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-11 text-center text-lg-left">
                        <div class="description">{!! $product->product_description !!}</div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Customer Review -->
        {{-- <section class="store-review">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-11 mt-4 mb-2 text-center text-lg-left">
                        <hr />
                        <div class="review-header">Ulasan(3)</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-11">
                        <ul class="list-unstyled">
                            <li class="media">
                                <img src="/images/icon-reviewer1.png" alt="" class="mr-3 rounded-circle" />
                                <div class="media-body">
                                    <div class="reviews mt-2 mb-1">Sabrina</div>
                                    I thought it was not good for living room. I really happy to decided buy this product last
                                    week now feels like homey. 
                                </div>
                            </li>

                            <li class="media">
                                <img src="/images/icon-reviewer2.png" alt="" class="mr-3 rounded-circle" />

                                <div class="media-body">
                                    <div class="reviews mt-2 mb-1">Teuku Gibrian</div>
                                    Color is great with the minimalist concept. Even I thought it was made by Cactus industry.
                                    I do really satisfied with this.
                                </div>
                            </li>

                            <li class="media">
                                <img src="/images/icon-reviewer3.png" alt="" class="mr-3 rounded-circle" />

                                <div class="media-body">
                                    <div class="reviews mt-2 mb-1">Bocil</div>
                                    When I saw at first, it was really awesome to have with. Just let me know if there is
                                    another upcoming product like this.
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section> --}}
    </div>
</div>
@endsection

@push('addon-script')
    <!-- cart increment/decrement value and its limits. -->
    <script>
        let $valueInput = $("#valueInput");
        let initialvalue = $valueInput.attr("min");
        let maxValue = $valueInput.attr("max");

        $valueInput.on("change", function () {
            if (Number($valueInput.val()) <= Number(initialvalue)) {
                $(".btn-minus").prop("disabled", true) && $valueInput.val(initialvalue);
            } else if (Number($valueInput.val()) >= Number(maxValue)) {
                $(".btn-plus").prop("disabled", true) && $valueInput.val(maxValue);
            } else {
                $(".btn-minus").prop("disabled", false) && $(".btn-plus").prop("disabled", false);
            }
        });

        $(".valueBtn").click(function () {
            if ($(this).hasClass("btn-plus")) {
                $valueInput.val(Number($valueInput.val()) + 1).trigger("change");
            }

            if ($(this).hasClass("btn-minus")) {
                $valueInput.val(Number($valueInput.val()) - 1).trigger("change");
            }
        });
    </script>
@endpush

