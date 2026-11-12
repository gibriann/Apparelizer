{{--
    shared by /account, the /shipping picker and the ajax responses
--}}
@php
    $selectable = !empty($selectable);

    $editAttributes = [
        'data-id' => $address->id,
        'data-action' => route('account-address-update', $address->id),
        'data-label' => $address->label,
        'data-recipient' => $address->recipient_name,
        'data-phone' => $address->phone_number,
        'data-address' => $address->address,
        'data-destination-id' => $address->rajaongkir_destination_id,
        'data-destination-label' => collect([$address->subdistrict, $address->district, $address->city, $address->province])->filter()->implode(', '),
        'data-province' => $address->province,
        'data-city' => $address->city,
        'data-district' => $address->district,
        'data-subdistrict' => $address->subdistrict,
        'data-postal' => $address->postal_code,
    ];

    $editAttributesString = collect($editAttributes)
        ->map(fn ($value, $key) => $key . '="' . e($value) . '"')
        ->implode(' ');
@endphp

@if ($selectable)
    <label class="address-option{{ $address->rajaongkir_destination_id ? '' : ' is-disabled' }}"
           data-address-option="{{ $address->id }}">
@endif

<div class="address-card{{ $address->is_default ? ' address-card--default' : '' }}"
     id="address-card-{{ $address->id }}">

    @if ($selectable)
        <input type="radio"
               name="address_id"
               value="{{ $address->id }}"
               class="address-radio"
               aria-label="Kirim ke {{ $address->label }}"
               @checked($address->is_default && $address->rajaongkir_destination_id)
               @disabled(!$address->rajaongkir_destination_id)
               data-recipient="{{ $address->recipient_name }}"
               data-phone="{{ $address->phone_number }}"
               data-address="{{ $address->address }}"
               data-destination="{{ $address->rajaongkir_destination_id }}"
               data-province="{{ $address->province }}"
               data-city="{{ $address->city }}"
               data-district="{{ $address->district }}"
               data-subdistrict="{{ $address->subdistrict }}"
               data-postal="{{ $address->postal_code }}"
               data-default="{{ $address->is_default ? 1 : 0 }}">
    @else
        <div class="address-card__icon" aria-hidden="true">
            <i class="fas {{ $address->rajaongkir_destination_id ? 'fa-map-marker-alt' : 'fa-exclamation-circle' }}"></i>
        </div>
    @endif

    <div class="address-card__body">
        <div class="address-card__head">
            <span class="address-card__label">{{ $address->label }}</span>

            @if ($address->is_default)
                <span class="address-card__badge address-card__badge--primary">Utama</span>
            @endif

            @unless ($address->rajaongkir_destination_id)
                <span class="address-card__badge address-card__badge--warning">Tujuan belum diatur</span>
            @endunless
        </div>

        <div class="address-card__recipient">
            {{ $address->recipient_name }}
            <span class="address-card__sep">&middot;</span>
            <span class="address-card__phone">{{ $address->phone_number }}</span>
        </div>

        <div class="address-card__line">{{ $address->address }}</div>

        <div class="address-card__meta">
            <i class="fas fa-location-arrow" aria-hidden="true"></i>
            {{ $address->location_line ?: 'Lokasi belum diatur' }}
            @if ($address->postal_code)
                <span class="address-card__postcode">{{ $address->postal_code }}</span>
            @endif
        </div>

        @unless ($address->rajaongkir_destination_id)
            <div class="address-card__notice">
                Alamat ini belum bisa dipakai untuk pengiriman.
                @unless ($selectable)
                    <button type="button" class="address-card__notice-link edit-address" {!! $editAttributesString !!}>
                        Lengkapi sekarang
                    </button>
                @endunless
            </div>
        @endunless
    </div>

    @unless ($selectable)
        <div class="address-card__actions">
            <button type="button"
                    class="address-action edit-address"
                    title="Ubah alamat"
                    aria-label="Ubah alamat {{ $address->label }}"
                    {!! $editAttributesString !!}>
                <i class="fas fa-pen" aria-hidden="true"></i>
            </button>

            @unless ($address->is_default)
                <form action="{{ route('account-address-default', $address->id) }}" method="POST" class="address-action-form">
                    @csrf
                    <button type="submit" class="address-action" title="Jadikan alamat utama"
                            aria-label="Jadikan {{ $address->label }} alamat utama">
                        <i class="fas fa-star" aria-hidden="true"></i>
                    </button>
                </form>
            @endunless

            <form action="{{ route('account-address-delete', $address->id) }}" method="POST" class="address-action-form"
                  onsubmit='return confirm(@json("Hapus alamat " . $address->label . "?"))'>
                @csrf
                @method('DELETE')
                <button type="submit" class="address-action address-action--danger" title="Hapus alamat"
                        aria-label="Hapus alamat {{ $address->label }}">
                    <i class="fas fa-trash-alt" aria-hidden="true"></i>
                </button>
            </form>
        </div>
    @endunless
</div>

@if ($selectable)
    </label>
@endif
