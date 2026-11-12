<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchasedProduct extends Model
{
    protected $guarded = ['id'];

    public function purchase()
    {
        return $this->belongsTo('App\Models\Purchase');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function size()
    {
        return $this->belongsTo('App\Models\Size');
    }

    public function color()
    {
        return $this->belongsTo('App\Models\Color');
    }

    public function printingtype()
    {
        return $this->belongsTo('App\Models\PrintingType', 'printing_id');
    }
}
