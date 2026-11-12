@php
    $address = $address ?? null;
    $destinationLabel = $address
        ? collect([$address->subdistrict, $address->district, $address->city, $address->province])->filter()->implode(', ')
        : '';
@endphp

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Label Alamat</label>
            <input type="text" name="label" class="form-control" value="{{ old('label', $address->label ?? '') }}" placeholder="Rumah, Kantor, Kos..." required />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Nama Penerima</label>
            <input type="text" name="recipient_name" class="form-control" value="{{ old('recipient_name', $address->recipient_name ?? Auth::user()->name) }}" required />
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Nomor Telepon</label>
            <input type="tel" name="phone_number" class="form-control" value="{{ old('phone_number', $address->phone_number ?? '') }}" placeholder="08xxxxxxxxxx" required />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Kode POS</label>
            <input type="text" name="postal_code" class="form-control address-postal-code" value="{{ old('postal_code', $address->postal_code ?? '') }}" placeholder="Terisi otomatis" />
        </div>
    </div>
</div>

<div class="form-group position-relative">
    <label>Kota/Kecamatan Tujuan (RajaOngkir)</label>
    <input type="text"
           class="form-control address-destination-search"
           value="{{ old('destination_label', $destinationLabel) }}"
           placeholder="Ketik nama kota atau kecamatan..."
           autocomplete="off"
           required>
    <div class="list-group address-destination-results mt-2" style="position: absolute; z-index: 1000; max-height: 260px; overflow-y: auto; display: none; width: 100%;"></div>
    <input type="hidden" name="rajaongkir_destination_id" class="address-destination-id" value="{{ old('rajaongkir_destination_id', $address->rajaongkir_destination_id ?? '') }}">
    <input type="hidden" name="province" class="address-province" value="{{ old('province', $address->province ?? '') }}">
    <input type="hidden" name="city" class="address-city" value="{{ old('city', $address->city ?? '') }}">
    <input type="hidden" name="district" class="address-district" value="{{ old('district', $address->district ?? '') }}">
    <input type="hidden" name="subdistrict" class="address-subdistrict" value="{{ old('subdistrict', $address->subdistrict ?? '') }}">
    <small class="form-text text-muted">Wajib dipilih agar ongkir bisa dihitung. Contoh: Jakarta, Bandung, Surabaya.</small>
</div>

<div class="form-group">
    <label>Alamat Lengkap</label>
    <textarea name="address" class="form-control" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan..." required>{{ old('address', $address->address ?? '') }}</textarea>
</div>

<div class="alert alert-danger d-none address-error"></div>
