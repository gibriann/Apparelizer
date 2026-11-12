<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function purchase()
    {
        return $this->belongsTo('App\Models\Purchase');
    }
}
