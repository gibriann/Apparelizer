@extends('layouts.app')

@section('title')
    Apparelizer - Keranjang
@endsection

@push('fontawesome')
    <script src="https://kit.fontawesome.com/1fb5cee488.js" crossorigin="anonymous"></script>
@endpush

@section('content')
    <div class="page-content page-cart">
        <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/index.html">Beranda</a>
                                </li>
                                <li class="breadcrumb-item active">Keranjang</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <section class="store-cart">
            <div class="container">
                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-12 table-responsive pr-0">
                        <table class="table table-borderless table-cart">
                            <thead>
                                <tr>
                                    <td colspan="2">Detail Produk</td>
                                    {{-- <td>Berat Produk</td> --}}
                                    <td>Harga </td>
                                    <td class="text-center pr-0">Aksi</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($carts as $cart)
                                <tr>
                                    <td class="text-center" style="width: 10%">
                                        <img style="height:50px;" src=" @productImage($cart->products->product_image)" alt="">
                                    </td>
                                    <td style="width: 30%">
                                        <div class="product-title">{{ $cart->products->product_name }} <small>{{ $cart->colors->color_name }} </small> </div>
                                        <div class="product-subtitle"> {{ $cart->sizes->size_name }}, {{ $cart->prints->printing_name }}, <a href="{{ $cart->link_design }}">Link Design</a></div>
                                    </td>
                                    {{-- <td style="width: 30%">
                                        <div class="product-title">{{ $cart->products->product_weight * $cart->amount }}Gr</div>
                                        <div class="product-subtitle">({{ $cart->products->product_weight }}Gr/pcs)</div>
                                    </td> --}}
                                    <td style="width: 30%">
                                        <div class="product-title">Rp {{ str_replace(',', '.', number_format($cart->products->product_price * $cart->amount))   }}</div>
                                        <div class="product-subtitle">Qty : {{  $cart->amount }}</div>
                                    </td>
                                    <td class="text-center pr-0" style="width: 10%">
                                        <form action="/cart/delete/{{ $cart->id }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-remove-cart"><i class="fa fa-trash-can"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row" data-aos="fade-up" data-aos-delay="350">
                    <div class="col-12">
                        <hr />
                    </div>
                    <div class="col-6 col-md-2 mr-auto">
                        <div id="total_order" class="product-title text-success" style="padding">Rp {{ str_replace(',', '.', number_format($total_order))}}</div>
                        <div class="product-subtitle">Total Harga</div>
                    </div>
                    <div class="col-4 col-md-3 mt-1 ">
                        <a href="{{ route('buy') }}" class="py-2 btn text-center btn-success btn-block text-white" > Beli </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    
@endsection

@push('addon-script')
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <script>
        function durasichange() {
            var durasi = $("#nama_paket").find(":selected").val();
            var ongkir = formatRupiah(durasi, 'Rp ');
            $('#ongkir').html(ongkir);

            var totalOrder = {{ $total_order }};
            var totalPayment = parseInt(durasi) + totalOrder;
            var totalPaymentView = (formatRupiah(totalPayment.toString(), 'Rp '));
            $("#total_payment").html(totalPaymentView);
            $("input[name=totalnya]").val(totalPayment);
            console.log(totalPayment);


        }

        function formatRupiah(angka, prefix) {
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);

			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}

			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp ' + rupiah : '');
		}

        $(document).ready(function(){
            
            $.ajax({
                type:'post',
                url:'dataprovinsi.php',
                success:function(hasil_provinsi)
                {
                    let provinceOptionsHtml = `<option value=''>Pilih Provinsi</option>`
                    $("select[name=nama_provinsi]").html(hasil_provinsi);
                }
            });

            //Pilih provinsi
            $("select[name=nama_provinsi]").on("change",function(){
                var id_provinsi_terpilih = $("option:selected",this).attr("value");
                //Hit API local -> yang nge hit -> raja ongkir ambil districts 
                $.ajax({
                    type:'get',
                    url:'/rajaongkir/provinsi/' + id_provinsi_terpilih + '/distrik',
                    data:'id_provinsi='+id_provinsi_terpilih,
                    success:function(hasil_distrik)
                    {
                        //Ngerapihin data dari API
                        const dataDistriks = hasil_distrik.datadistrik;

                        let districtOptionsHtml = `<option value=''>Pilih Kabupaten/Kota</option>`
                        dataDistriks.forEach(dataDistrik => {
                            districtOptionsHtml += `<option value="${dataDistrik.city_id}">${dataDistrik.type} ${dataDistrik.city_name}</option>`
                        });

                        //Masukkin ke dropdown district
                        $("select[name=nama_distrik]").html(districtOptionsHtml);
                    }
                });
            });

            $.ajax({
                type:'post',
                url:'dataekspedisi.php',
                success:function(hasil_ekspedisi)
                {
                    $("select[name=nama_ekspedisi]").html(hasil_ekspedisi);
                }
            });

            // Pilih ekspedisi
            $("select[name=nama_ekspedisi]").on("change",function(){
                // mendapatkan ekspedisi yang dipilih
                var ekspedisi_terpilih = $("select[name=nama_ekspedisi]").val();

                // mendapatkan id_distrik yang dilipih pengguna
                var distrik_terpilih = $("option:selected","select[name=nama_distrik]").attr("value");

                // mendapatkan total berat dari inputan
                var total_berat = $("input[name=total_berat]").val();
                $.ajax({
                    type:'get',
                    url:'/rajaongkir/ekspedisi/' + ekspedisi_terpilih + '/distrik/' + distrik_terpilih + '/berat/' + total_berat,
                    data: 'ekspedisi='+ekspedisi_terpilih+'&distrik='+distrik_terpilih+'&berat='+total_berat,
                    success:function(hasil_paket)
                    {
                        const dataPakets = hasil_paket.paket;
                        
                        let paketOptionsHtml = `<option value=''> Pilih Paket </option>`
                        dataPakets.forEach(dataPaket => {
                            paketOptionsHtml += `<option value="${dataPaket["cost"]["0"]["value"]}" etd="${dataPaket["cost"]["0"]["etd"]}" paket="${dataPaket.service}"> ${dataPaket.service}  (${dataPaket["cost"]["0"]["etd"]}) </option>`
                        });
                        $("select[name=nama_paket]").html(paketOptionsHtml);
                        $("input[name=ekspedisi]").val(ekspedisi_terpilih);
                    }
                });
            });
            
            $("select[name=nama_distrik]").on("change",function(){
                var prov = $("#province option:selected").text();
                var dist = $("#district option:selected").text();
                
                $("input[name=provinsi]").val(prov);
                $("input[name=distrik]").val(dist);
            });

            $("#postalCode").on("input", function(){
                if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);

                var postalCode = $("#postalCode").val();
                $("input[name=kodepos]").val(postalCode);
            });

            $("select[name=nama_paket]").on("change",function(){
                var paket = $("option:selected", this).attr("paket");
                var etd = $("option:selected", this).attr("etd");
                var durasi = $("#nama_paket").find(":selected").val();
                
                $("input[name=paket]").val(paket);
                $("input[name=estimasi]").val(etd);
                $("input[name=ongkir]").val(durasi);
            })
        });
    </script>
@endpush
