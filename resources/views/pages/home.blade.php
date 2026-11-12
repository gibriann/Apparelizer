@extends('layouts.app')

@section('title')
    Apparelizer - Beranda
@endsection

@push('owlcarousel')
    <link rel="stylesheet" href="{{ asset('vendor/OwlCarousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/OwlCarousel/owl.theme.default.min.css') }} ">
    
@endpush

@push('fontawesome')
    <script src="https://kit.fontawesome.com/1fb5cee488.js" crossorigin="anonymous"></script>
@endpush
@section('content')
<div class="page-content page-home">
    <!-- Carousel -->
    <section class="store-carousel">
        <div class="container">
            <div class="row">
                <div class="col-lg-12" data-aos="zoom-in">
                    <div id="storeCarousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li class="active" data-target="#storeCarousel" data-slide-to="0"></li>
                            <li data-target="#storeCarousel" data-slide-to="1"></li>
                            <li data-target="#storeCarousel" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="/images/banner1.jpg" alt="Carousel Img" class="d-block w-100" />
                            </div>
                            <div class="carousel-item">
                                <img src="/images/banner2.jpg" alt="Carousel Img" class="d-block w-100" />
                            </div>
                            <div class="carousel-item">
                                <img src="/images/banner3.jpg" alt="Carousel Img" class="d-block w-100" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kategori -->
    <section class="store-categories">
        <div class="container">
            <div class="row">
                <div class="col-6" data-aos="fade-up">
                    <h5 class="align-content-center">Produk</h5>
                </div>
                <div class="col-6 d-flex justify-content-end" data-aos="fade-up">
                    <a href="{{ route('products') }}" class="align-content-center" style="font-size: 14px; color: #FF7158">Lihat semua</a>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="owl-carousel owl-theme">
                        @foreach ($products as $product)
                        <div class="item mb-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="card">
                                <a href="/details/{{ $product->id }}/{{ $product->slug }}"> <img src="@productImage($product->product_image)" alt="" class="prod-img " /></a>
                                <div class="card-body">
                                    <div class="text-center products-title">{{ $product->product_name }}</div>
                                    <div class="products-price text-center">Rp {{ number_format($product->product_price) }}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why us -->
    <section class="why-us">
        <div class="container">
            <div class="y-us">
                <h2 class="y-us-header text-center">Mengapa Memilih <span class="y-us-subtext">Jasa</span> Kami</h2>
                <div class="y-us-subheader text-center px-5"> <span class="y-us-subtext">Pakaian adalah bagian dari identitas pemakainya.<br>Konveksi kami selalu mencoba mengerti selera dan kebutuhan pelanggan<br> </span>
                Kami berkomitmen menjaga kualitas dan kepuasan pelanggan dengan nilai-nilai :</div>
                <div class="p-4">
                    <div class="row justify-content-center px-sm-5 ">
                        <div class="col-sm-4 col-6 pb-4">
                            <div class="card bg-white text-center pt-5">
                                <div class="card-body-yus">
                                    <i class="fa fa-gauge-high fa-3x"></i>
                                    <p class="y-us-title mt-2">Pengerjaan Cepat</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6 pb-4">
                            <div class="card bg-white text-center pt-5">
                                <div class="card-body-yus">
                                    <i class="fa-solid fa-money-bill-1-wave fa-3x"></i>
                                    <p class="y-us-title mt-2">Harga Kompetitif</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6 pb-4">
                            <div class="card bg-white text-center pt-5">
                                <div class="card-body-yus">
                                    <i class="fa-solid fa-arrow-right-arrow-left fa-3x"></i>
                                    <p class="y-us-title mt-2">Ketentuan Return</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6 pb-4">
                            <div class="card bg-white text-center pt-5">
                                <div class="card-body-yus">
                                    <i class="fa-solid fa-business-time fa-3x"></i>
                                    <p class="y-us-title mt-2">Berpengalaman</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6 pb-4">
                            <div class="card bg-white text-center pt-5">
                                <div class="card-body-yus">
                                    <i class="fa-solid fa-eye fa-3x"></i>
                                    <p class="y-us-title mt-2">Transparansi Proses</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6 pb-4">
                            <div class="card bg-white text-center pt-5">
                                <div class="card-body-yus">
                                    <i class="fa-solid fa-headset fa-3x"></i>
                                    <p class="y-us-title mt-2">CS Responsif</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="find-us" class="find-us pt-4">
        <div class="container">
            <div class="location">
                <div class="y-us-header text-center pt-3 pb-1">Lokasi Kami</div>
                <div class="y-us-subheader text-center pb-3">Kamu bisa menemukan kami disini</div>
                <div class="map ">
                    <iframe class="" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1458.7864352564022!2d106.86543734929592!3d-6.200392244930795!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f48a028d24cf%3A0xe9a7c77b3c17570e!2sSekolah%20Dasar%20Negeri%20Utan%20Kayu%20Selatan%2021%20Pagi!5e0!3m2!1sid!2sid!4v1794525971291!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('owlcarouselfooter')
    <script src="{{ asset ("vendor/jquery/jquery.min.js") }}"></script>
    <script src="{{ asset("vendor/OwlCarousel/owl.carousel.min.js") }}" ></script>
    <script>


        var owl = $('.owl-carousel');
        owl.owlCarousel({
            items:4,
            loop:false,
            margin:10,
            dots: false,
            autoplay:true,
            autoplayTimeout:2000,
            autoplayHoverPause:true
        });
        
    </script>
    
@endpush

