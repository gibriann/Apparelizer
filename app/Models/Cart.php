<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id', 'product_id', 'color_id', 'printing_id', 'size_id', 'link_design', 'amount'];


    public function products()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function colors()
    {
        return $this->belongsTo('App\Models\Color', 'color_id');
    }

    public function sizes()
    {
        return $this->belongsTo('App\Models\Size', 'size_id');
    }

    public function prints()
    {
        return $this->belongsTo('App\Models\PrintingType', 'printing_id');
    }
}

