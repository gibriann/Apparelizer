@extends('layouts.app')

@section('title')
    Firmos - Pengiriman
@endsection

@push('fontawesome')
    <script src="https://kit.fontawesome.com/1fb5cee488.js" crossorigin="anonymous"></script>
@endpush

@push('addon-style')
    <link href="{{ asset('style/address-list.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="page-content page-cart">
        <section class="store-breadcrumbs" >
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/">Beranda</a>
                                </li>
                                <li class="breadcrumb-item active">Pengiriman</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <section class="store-cart">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 order-12 order-sm-1">
                        <div class="row" >
                            <div class="col-12">
                                <h2 class="mb-4">Detail Pengiriman</h2>
                            </div>
                        </div>
                        <!-- Pengiriman -->
                        <form action="{{ route('checkout') }}" method="POST" id="checkoutForm">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="user_name">Nama Penerima</label>
                                        <input type="text" class="form-control @error('user_name') is-invalid @enderror" id="user_name" name="user_name" value="{{ $customer->users['name'] }}" required />
                                        @error('user_name')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone_number">Nomor Telepon</label>
                                        <input type="tel" class="form-control" id="phone_number" name="phone_number" value="{{ $customer->phone_number }}" required />
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <div class="address-panel" data-address-panel>
                                        <div class="address-panel__head">
                                            <div>
                                                <label class="address-panel__title mb-0">Alamat Pengiriman</label>
                                                <p class="address-panel__sub">Pilih tujuan pengiriman untuk pesanan ini.</p>
                                            </div>
                                            <button type="button" class="address-panel__add" data-toggle="modal" data-target="#addressAddModal">
                                                <i class="fas fa-plus" aria-hidden="true"></i>
                                                Tambah Alamat
                                            </button>
                                        </div>

                                        <input type="hidden" name="address_id" id="address_id">

                                        <div class="address-panel__scroll">
                                            <div id="address-list" class="address-list">
                                                @if ($addresses->isEmpty())
                                                    <div class="address-empty">
                                                        <div class="address-empty__icon">
                                                            <i class="fas fa-map-marked-alt" aria-hidden="true"></i>
                                                        </div>
                                                        <p class="address-empty__title">Belum ada alamat tersimpan</p>
                                                        <p class="address-empty__text">Tambahkan alamat pengiriman terlebih dahulu.</p>
                                                    </div>
                                                @endif

                                                @foreach ($addresses as $address)
                                                    @include('pages.partials.address-card-account', ['address' => $address, 'selectable' => true])
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="courier_name">Kurir</label>
                                        <select name="kurir" id="courier_name" class="form-control" required>
                                            <option value="">Pilih Ekspedisi</option>
                                            <option value="jne">JNE</option>
                                            <option value="pos">POS Indonesia</option>
                                            <option value="tiki">TIKI</option>
                                            <option value="jnt">J&T Express</option>
                                            <option value="sicepat">SiCepat</option>
                                            <option value="anteraja">AnterAja</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="service_name">Layanan & Durasi</label>
                                        <select name="kurir_name" id="service_name" class="form-control" required disabled>
                                            <option value="">Pilih kurir terlebih dahulu</option>
                                        </select>
                                        <input type="hidden" name="ongkir" id="shipping_cost_value">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="notes">Catatan (Opsional)</label>
                                        <input type="text" class="form-control" id="notes" name="notes" placeholder="Catatan untuk kurir..."/>
                                    </div>
                                </div>
                            </div>

                            <div class="d-block d-sm-none">
                                <h2 class="mb-3">Informasi Pembayaran</h2>
                                <div class="row">
                                    <div class="col-8">
                                        <div class="product-subtitle">Subtotal Produk</div>
                                    </div>
                                    <div class="col-4">
                                        <div class="product-title text-right">Rp {{ number_format($total_order, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <div class="product-subtitle">Ongkos Kirim</div>
                                    </div>
                                    <div class="col-4">
                                        <div id="shipping_cost_mobile" class="product-title text-right">-</div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="product-subtitle font-weight-bold">Total Pembayaran</div>
                                    </div>
                                    <div class="col-6">
                                        <div id="total_payment_mobile" class="product-total text-success text-right font-weight-bold">Rp {{ number_format($total_order, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="subtotal" value="{{ $total_order }}">
                            <input type="hidden" name="totalnya" id="total_payment_value" value="{{ $total_order }}">

                            <div class="row mt-4">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success btn-block" id="checkout_button">
                                        <i class="fas fa-shopping-cart mr-2"></i> Lanjutkan Pembayaran
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-sm-6 splitter order-1 order-sm-12">
                        <div class="row">
                            <div class="col-12">
                                <h2 class="mb-4">Detail Pesanan</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-borderless table-cart">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Produk</th>
                                            <th class="text-center">Berat</th>
                                            <th class="text-right">Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($carts as $cart)
                                        <tr>
                                            <td style="width: 60px">
                                                <img style="height:50px; object-fit: cover;" 
                                                     src="@productImage($cart->products->product_image)" 
                                                     alt="{{ $cart->products->product_name }}"
                                                     class="img-fluid">
                                            </td>
                                            <td>
                                                <div class="product-title">{{ $cart->products->product_name }}</div>
                                                <div class="product-subtitle">{{ $cart->colors->color_name }}, {{ $cart->sizes->size_name }}</div>
                                                <div class="product-subtitle">Qty: {{ $cart->amount }}</div>
                                            </td>
                                            <td class="text-center">
                                                <div class="product-title">{{ number_format($cart->products->product_weight * $cart->amount, 0, ',', '.') }}g</div>
                                            </td>
                                            <td class="text-right">
                                                <div class="product-title">Rp {{ number_format($cart->products->product_price * $cart->amount, 0, ',', '.') }}</div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <hr>
                        <div class="d-none d-sm-block">
                            <h2 class="mb-3">Ringkasan Pembayaran</h2>
                            <div class="row mb-2">
                                <div class="col-8">
                                    <div class="product-subtitle">Subtotal Produk</div>
                                </div>
                                <div class="col-4">
                                    <div class="product-title text-right">Rp {{ number_format($total_order, 0, ',', '.') }}</div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-8">
                                    <div class="product-subtitle">Berat Total</div>
                                </div>
                                <div class="col-4">
                                    <div class="product-title text-right">{{ number_format($total_weight, 0, ',', '.') }} gram</div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-8">
                                    <div class="product-subtitle">Ongkos Kirim</div>
                                </div>
                                <div class="col-4">
                                    <div id="shipping_cost_desktop" class="product-title text-right">-</div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <div class="product-subtitle font-weight-bold">Total Pembayaran</div>
                                </div>
                                <div class="col-6">
                                    <div id="total_payment_desktop" class="product-total text-success text-right font-weight-bold">Rp {{ number_format($total_order, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

<div class="modal fade" id="addressAddModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('account-address-store') }}" method="POST" class="address-form">
                @csrf
                <input type="hidden" name="context" value="shipping">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Alamat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('pages.partials.address-form-fields', ['address' => null])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success text-white">Simpan &amp; Pilih</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('addon-script')
@include('pages.partials.address-script')
@include('pages.partials.address-panel-script')
<script>
$(document).ready(function() {
    const TOTAL_ORDER = {{ $total_order }};
    const TOTAL_WEIGHT = {{ $total_weight }};
    let selectedDestinationId = null;

    // Pick up saved address selection
    $('#address-list').on('change', '.address-radio', function() {
        const radio = $(this);

        selectedDestinationId = radio.data('destination') || null;
        $('#address_id').val(radio.val());
        $('#user_name').val(radio.data('recipient'));
        $('#phone_number').val(radio.data('phone'));

        $('.address-option').removeClass('is-selected');
        radio.closest('.address-option').addClass('is-selected');

        // Reset courier selection when address changes
        $('#service_name').prop('disabled', true).html('<option value="">Pilih kurir terlebih dahulu</option>');
        $('#courier_name').val('');
        updateShippingCost(0);
    });

    // Select default address, or the first shippable one
    let initialRadio = $('#address-list .address-radio:not(:disabled)').filter('[data-default="1"]').first();
    if (!initialRadio.length) {
        initialRadio = $('#address-list .address-radio:not(:disabled)').first();
    }
    initialRadio.prop('checked', true).trigger('change');

    // Add a new address from the checkout page, then select it
    $('#addressAddModal .address-form').on('submit', function(e) {
        e.preventDefault();

        const form = $(this);
        const errorBox = form.find('.address-error').addClass('d-none').text('');

        if (!form.find('.address-destination-id').val()) {
            errorBox.text('Silakan pilih kota/kecamatan tujuan dari daftar.').removeClass('d-none');
            return;
        }

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            headers: { 'Accept': 'application/json' },
            success: function(response) {
                $('#address-list').append(response.html);
                form[0].reset();
                form.find('.address-destination-id, .address-province, .address-city, .address-district, .address-subdistrict, .address-postal-code').val('');
                $('#addressAddModal').modal('hide');

                $('#address-list .address-radio[value="' + response.address.id + '"]')
                    .prop('checked', true)
                    .trigger('change');
            },
            error: function(xhr) {
                errorBox.text(addressFormErrors(xhr).join(' ')).removeClass('d-none');
            }
        });
    });

    // Calculate shipping cost when courier is selected
    $('#courier_name').on('change', function() {
        const courier = $(this).val();
        
        if (!courier) {
            $('#service_name').prop('disabled', true).html('<option value="">Pilih kurir terlebih dahulu</option>');
            return;
        }

        if (!selectedDestinationId) {
            alert('Silakan pilih tujuan pengiriman terlebih dahulu');
            $(this).val('');
            return;
        }

        $('#service_name').prop('disabled', true).html('<option value="">Loading...</option>');

        // Origin: Jati, Pulo Gadung, Jakarta Timur
        const originId = 17732;

        $.ajax({
            url: '/shipping/calculate-cost',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                origin: originId,
                destination: selectedDestinationId,
                weight: TOTAL_WEIGHT,
                courier: courier
            },
            success: function(response) {
                if (response.meta.status === 'success' && response.data.length > 0) {
                    let html = '<option value="">Pilih layanan</option>';
                    response.data.forEach(function(service) {
                        const serviceName = `${service.service} (${service.description})`;
                        const etd = service.etd || '-';
                        html += `<option value="${service.cost}" data-service="${service.service}" data-etd="${etd}">
                                    ${serviceName} - Rp ${formatNumber(service.cost)} (${etd} hari)
                                 </option>`;
                    });
                    $('#service_name').html(html).prop('disabled', false);
                } else {
                    $('#service_name').html('<option value="">Tidak ada layanan tersedia</option>');
                    alert('Kurir tidak tersedia untuk tujuan ini');
                }
            },
            error: function(xhr) {
                $('#service_name').html('<option value="">Error memuat layanan</option>');
                alert('Gagal menghitung ongkir. Silakan coba lagi.');
            }
        });
    });

    // Update total when service is selected
    $('#service_name').on('change', function() {
        const shippingCost = parseInt($(this).val()) || 0;
        const etd = $(this).find(':selected').data('etd') || '-';
        
        // Store ETD in hidden field
        $('<input>').attr({
            type: 'hidden',
            name: 'etd',
            value: etd
        }).appendTo('#checkoutForm');
        
        updateShippingCost(shippingCost);
    });

    function updateShippingCost(cost) {
        const total = TOTAL_ORDER + cost;
        
        $('#shipping_cost_value').val(cost);
        $('#total_payment_value').val(total);
        
        const costFormatted = cost > 0 ? 'Rp ' + formatNumber(cost) : '-';
        const totalFormatted = 'Rp ' + formatNumber(total);
        
        $('#shipping_cost_mobile, #shipping_cost_desktop').text(costFormatted);
        $('#total_payment_mobile, #total_payment_desktop').text(totalFormatted);
    }

    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Form validation before submit
    $('#checkoutForm').on('submit', function(e) {
        if (!selectedDestinationId || !$('#address_id').val()) {
            e.preventDefault();
            alert('Silakan pilih alamat pengiriman');
            return false;
        }

        if (!$('#service_name').val()) {
            e.preventDefault();
            alert('Silakan pilih layanan pengiriman');
            $('#service_name').focus();
            return false;
        }

        return true;
    });
});
</script>
@endpush
