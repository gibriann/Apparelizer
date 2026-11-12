<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{
    protected $fillable = [
        'status_user_name',
    ];

    public function user()
    {
        return $this->hasMany('App\Models\User');
    }
}
