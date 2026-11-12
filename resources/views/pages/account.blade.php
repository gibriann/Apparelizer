@extends('layouts.app')

@section('title')
    Profil Saya
@endsection

@push('fontawesome')
    <script src="https://kit.fontawesome.com/1fb5cee488.js" crossorigin="anonymous"></script>
@endpush

@push('addon-style')
    <link href="{{ asset('style/avatar-picker.css') }}" rel="stylesheet" />
    <link href="{{ asset('style/address-list.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="page-content page-home">
        <section class="store-products">
            <div class="container">
                
                <div class="row justify-content-center mt-2">
                    <div class="col-md-10 mt-2 ">
                        <div class="row mb-3">
                            <div class="col-12" data-aos="fade-up">
                                <h5 >Akun Saya</h5>
                            </div>
                        </div>
                        <div class="card card-white shadow p-5 mb-2">
                            <div class="transaction-section-content">
                                <form action="{{ route('account') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row mb-2" data-aos="fade-up" data-aos-delay="200">
                                            <div class="col-12">
                                                <div class="media">
                                                    <div class="px-2">
                                                        @include('pages.partials.avatar-picker', ['user' => Auth::user()])
                                                    </div>
                                                    <div class="media-body ml-4">
                                                        <div class="form-group">
                                                            <label for="">Nama Lengkap</label>
                                                            <input type="text" value="{{ Auth::user()->name }}" name="name" class="form-control @error('name') is-invalid @enderror" autofocus />
                                                            @error('name')
                                                                <div class="invalid-feedback">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    
                                                        <div class="form-group">
                                                            <label for="">Email</label>
                                                            <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control @error('email') is-invalid @enderror"/>
                                                            @error('email')
                                                                <div class="invalid-feedback">
                                                                    {{$message}}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 text-right">
                                            <button type="submit" class="py-2 px-4 btn text-center btn-success text-white"> Simpan </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card card-white shadow p-5 mb-2" data-aos="fade-up">
                            <div class="address-panel" data-address-panel>
                                <div class="address-panel__head">
                                    <div>
                                        <h5 class="address-panel__title">
                                            Alamat
                                            @if ($addresses->isNotEmpty())
                                                <span class="address-panel__count">{{ $addresses->count() }}</span>
                                            @endif
                                        </h5>
                                        <p class="address-panel__sub">Alamat pengiriman yang tersimpan untuk pesanan Anda.</p>
                                    </div>
                                    <button type="button" class="address-panel__add" data-toggle="modal" data-target="#addressAddModal">
                                        <i class="fas fa-plus" aria-hidden="true"></i>
                                        Tambah Alamat
                                    </button>
                                </div>

                                <div class="address-panel__scroll">
                                    <div id="address-list" class="address-list">
                                        @if ($addresses->isEmpty())
                                            <div class="address-empty">
                                                <div class="address-empty__icon">
                                                    <i class="fas fa-map-marked-alt" aria-hidden="true"></i>
                                                </div>
                                                <p class="address-empty__title">Belum ada alamat tersimpan</p>
                                                <p class="address-empty__text">Tambahkan alamat pengiriman pertama Anda untuk mulai berbelanja.</p>
                                            </div>
                                        @endif

                                        @foreach ($addresses as $address)
                                            @include('pages.partials.address-card-account', ['address' => $address])
                                        @endforeach
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

<div class="modal fade" id="addressAddModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('account-address-store') }}" method="POST" class="address-form">
                @csrf
                <input type="hidden" name="context" value="account">
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
                    <button type="submit" class="btn btn-success text-white">Simpan Alamat</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addressEditModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="" method="POST" class="address-form">
                @csrf
                @method('PUT')
                <input type="hidden" name="context" value="account">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Alamat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('pages.partials.address-form-fields', ['address' => null])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success text-white">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('addon-script')
    @include('pages.partials.address-script')
    @include('pages.partials.address-panel-script')
    <script>
        $(function () {
            function submitAddressForm(form, modal, isEdit) {
                var errorBox = form.find('.address-error').addClass('d-none').text('');

                if (!form.find('.address-destination-id').val()) {
                    errorBox.text('Silakan pilih kota/kecamatan tujuan dari daftar.').removeClass('d-none');
                    return;
                }

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: form.serialize(),
                    headers: { 'Accept': 'application/json' },
                    success: function (response) {
                        // The empty state occupies the list until the first
                        // address exists, so it has to go before prepending.
                        $('#address-list .address-empty').remove();

                        if (isEdit) {
                            $('#address-card-' + response.address.id).replaceWith(response.html);
                        } else {
                            $('#address-list').prepend(response.html);
                        }

                        form[0].reset();
                        form.find('.address-destination-id, .address-province, .address-city, .address-district, .address-subdistrict, .address-postal-code').val('');
                        modal.modal('hide');

                        if (typeof refreshAddressPanel === 'function') {
                            refreshAddressPanel();
                        }
                    },
                    error: function (xhr) {
                        errorBox.text(addressFormErrors(xhr).join(' ')).removeClass('d-none');
                    }
                });
            }

            $('#addressAddModal .address-form').on('submit', function (e) {
                e.preventDefault();
                submitAddressForm($(this), $('#addressAddModal'), false);
            });

            $('#addressEditModal .address-form').on('submit', function (e) {
                e.preventDefault();
                submitAddressForm($(this), $('#addressEditModal'), true);
            });

            $(document).on('click', '.edit-address', function () {
                var data = this.dataset;
                var form = $('#addressEditModal .address-form');

                form.attr('action', data.action);
                form.find('[name="label"]').val(data.label);
                form.find('[name="recipient_name"]').val(data.recipient);
                form.find('[name="phone_number"]').val(data.phone);
                form.find('[name="address"]').val(data.address);
                form.find('.address-destination-search').val(data.destinationLabel);
                form.find('.address-destination-id').val(data.destinationId);
                form.find('.address-province').val(data.province);
                form.find('.address-city').val(data.city);
                form.find('.address-district').val(data.district);
                form.find('.address-subdistrict').val(data.subdistrict);
                form.find('.address-postal-code').val(data.postal);
                form.find('.address-error').addClass('d-none').text('');

                $('#addressEditModal').modal('show');
            });
        });
    </script>
    @include('pages.partials.avatar-picker-script')
@endpush