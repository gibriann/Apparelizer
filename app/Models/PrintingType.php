<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrintingType extends Model
{
    protected $fillable = [
        'printing_name',
    ];


    public function carts()
    {
        return $this->hasMany('App\Models\Cart');
    }

    public function purchased_products()
    {
        return $this->hasMany('App\Models\PurchasedProduct', 'printing_id');
    }
}

