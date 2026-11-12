<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = [
        'size_name',
    ];

    public function carts()
    {
        return $this->hasMany('App\Models\Cart');
    }

    public function purchased_products()
    {
        return $this->hasMany('App\Models\PurchasedProduct');
    }
}


