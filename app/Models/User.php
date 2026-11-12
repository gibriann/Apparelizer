<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'role_id', 'email', 'password', 'avatar','user_status_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Public URL for the user's avatar, falling back to the default image.
     */
    public function getAvatarUrlAttribute(): string
    {
        // uploaded: public/avatars/xxx.jpg stored on the public disk
        if ($this->avatar && str_starts_with($this->avatar, 'public/')) {
            return asset(str_replace('public/', 'storage/', $this->avatar));
        }

        // bundled image in public/images
        if ($this->avatar && file_exists(public_path('images/' . $this->avatar))) {
            return asset('images/' . $this->avatar);
        }

        return asset('images/default.png');
    }

    /**
     * Whether the user uploaded their own avatar (as opposed to a seeded default).
     */
    public function hasCustomAvatar(): bool
    {
        return (bool) ($this->avatar && str_starts_with($this->avatar, 'public/'));
    }

    public function carts()
    {
        return $this->hasMany('App\Models\Cart');
    }

    public function customers()
    {
        return $this->hasOne('App\Models\Customer', 'user_id');
    }

    public function purchase()
    {
        return $this->hasMany('App\Models\Purchase');
    }

    public function userStatus()
    {
        return $this->belongsTo('App\Models\UserStatus');
    }
}
