<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $guarded = ['id'];

    public function purchased_product()
    {
        return $this->hasMany('App\Models\PurchasedProduct');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function statusPayment()
    {
        return $this->belongsTo('App\Models\PaymentStatus', 'payment_status_id');
    }

    public function statusShipping()
    {
        return $this->belongsTo('App\Models\ShippingStatus', 'shipping_status_id');
    }

}


