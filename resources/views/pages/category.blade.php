@extends('layouts.app')

@section('title')
    Firmos - Beranda
@endsection

@section('content')
<div class="page-content page-home">
    <!-- Kategori -->
    <section class="store-categories">
        <div class="container">
            <div class="row">
                <div class="col-12" data-aos="fade-up">
                    <h5>Semua Kategori</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-md-3 col-lg-2" data-aos="fade-up" data-aos-delay="100">
                    <a href="#" class="component-categories d-block">
                        <div class="categories-image">
                            <img src="/images/kategori-tshirt.svg" alt="" class="w-100" />
                        </div>
                        <p class="categories-text">T-Shirt</p>
                    </a>
                </div>
                <div class="col-6 col-md-3 col-lg-2" data-aos="fade-up" data-aos-delay="200">
                    <a href="#" class="component-categories d-block">
                        <div class="categories-image">
                            <img src="/images/kategori-hoodie.svg" alt="" class="w-100" />
                        </div>
                        <p class="categories-text">Hoodie</p>
                    </a>
                </div>
                <div class="col-6 col-md-3 col-lg-2" data-aos="fade-up" data-aos-delay="300">
                    <a href="#" class="component-categories d-block">
                        <div class="categories-image">
                            <img src="/images/kategori-pdl.svg" alt="" class="w-100" />
                        </div>
                        <p class="categories-text">Jaket PDL</p>
                    </a>
                </div>
                <div class="col-6 col-md-3 col-lg-2" data-aos="fade-up" data-aos-delay="400">
                    <a href="#" class="component-categories d-block">
                        <div class="categories-image">
                            <img src="/images/kategori-sweatshirt.svg" alt="" class="w-100" />
                        </div>
                        <p class="categories-text">Sweatshirt</p>
                    </a>
                </div>
                <div class="col-6 col-md-3 col-lg-2" data-aos="fade-up" data-aos-delay="500">
                    <a href="#" class="component-categories d-block">
                        <div class="categories-image">
                            <img src="/images/kategori-kemeja.svg" alt="" class="w-100" />
                        </div>
                        <p class="categories-text">Kemeja</p>
                    </a>
                </div>
                <div class="col-6 col-md-3 col-lg-2" data-aos="fade-up" data-aos-delay="600">
                    <a href="#" class="component-categories d-block">
                        <div class="categories-image">
                            <img src="/images/kategori-topi.svg" alt="" class="w-100" />
                        </div>
                        <p class="categories-text">Topi</p>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Produk -->
    <section class="store-products">
        <div class="container">
            <div class="row">
                <div class="col-12" data-aos="fade-up">
                    <h5>Semua Produk</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <a href="/details.html" class="component-products d-block">
                        <div class="products-thumbnail">
                            <div
                                class="products-image"
                                style="background-image: url('/images/products-apple-watch.jpg')"
                            ></div>
                        </div>
                        <div class="products-text">Apple Watch 4</div>
                        <div class="products-price">$890</div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <a href="/details.html" class="component-products d-block">
                        <div class="products-thumbnail">
                            <div
                                class="products-image"
                                style="background-image: url('/images/products-orange-bogotta.jpg')"
                            ></div>
                        </div>
                        <div class="products-text">Orange Bogotta</div>
                        <div class="products-price">$22190</div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <a href="/details.html" class="component-products d-block">
                        <div class="products-thumbnail">
                            <div
                                class="products-image"
                                style="background-image: url('/images/products-sofa-ternyaman.jpg')"
                            ></div>
                        </div>
                        <div class="products-text">Comfy Sofa</div>
                        <div class="products-price">$9020</div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                    <a href="/details.html" class="component-products d-block">
                        <div class="products-thumbnail">
                            <div
                                class="products-image"
                                style="background-image: url('/images/products-bubuk-maketti.jpg')"
                            ></div>
                        </div>
                        <div class="products-text">Maketti Powder</div>
                        <div class="products-price">$225</div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="500">
                    <a href="/details.html" class="component-products d-block">
                        <div class="products-thumbnail">
                            <div
                                class="products-image"
                                style="background-image: url('/images/products-apple-watch.jpg')"
                            ></div>
                        </div>
                        <div class="products-text">Apple Watch 4</div>
                        <div class="products-price">$890</div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="600">
                    <a href="/details.html" class="component-products d-block">
                        <div class="products-thumbnail">
                            <div
                                class="products-image"
                                style="background-image: url('/images/products-apple-watch.jpg')"
                                `1`
                            ></div>
                        </div>
                        <div class="products-text">Orange Bogotta</div>
                        <div class="products-price">$22190</div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="700">
                    <a href="/details.html" class="component-products d-block">
                        <div class="products-thumbnail">
                            <div
                                class="products-image"
                                style="background-image: url('/images/products-apple-watch.jpg')"
                            ></div>
                        </div>
                        <div class="products-text">Comfy Sofa</div>
                        <div class="products-price">$9020</div>
                    </a>
                </div>
                <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="800">
                    <a href="/details.html" class="component-products d-block">
                        <div class="products-thumbnail">
                            <div
                                class="products-image"
                                style="background-image: url('/images/products-apple-watch.jpg')"
                            ></div>
                        </div>
                        <div class="products-text">Maketti Powder</div>
                        <div class="products-price">$225</div>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection