<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    public function purchase()
    {
        return $this->hasMany('App\Models\Purchase');
    }
}
