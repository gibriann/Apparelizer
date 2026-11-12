<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $fillable = [
        'color_name',
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
