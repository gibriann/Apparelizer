<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'label',
        'recipient_name',
        'phone_number',
        'address',
        'rajaongkir_destination_id',
        'province',
        'city',
        'district',
        'subdistrict',
        'postal_code',
        'is_default',
    ];

    protected $casts = [
        'rajaongkir_destination_id' => 'integer',
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Addresses that can actually be used for shipping (have a RajaOngkir destination).
     */
    public function scopeShippable($query)
    {
        return $query->whereNotNull('rajaongkir_destination_id');
    }

    /**
     * Human readable city/district line, matching the old `kota` format.
     */
    public function getLocationLineAttribute(): string
    {
        return collect([$this->subdistrict, $this->district, $this->city])
            ->filter()
            ->implode(', ');
    }
}
