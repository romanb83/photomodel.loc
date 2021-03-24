<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $role
 **/

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    public const STATUS_WAIT = 'wait';
    public const STATUS_ACTIVE = 'active';

    public const ROLE_ADMIN = 'admin';
    public const ROLE_MODERATOR = 'moderator';
    public const ROLE_USER = 'user ';
    public const ROLE_VIP = 'vip';
    public const ROLE_PREMIUM = 'premium';
    public const ROLE_PAID_USER = 'paid_user';

    protected $fillable = [
        'username', 'first_name', 'last_name', 'age', 'email', 'password',
        'group_id', 'city_id', 'verify_token', 'status', 'gender', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'profile_flag' => 'boolean',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'user_genres', 'user_id', 'genre_id');
    }

    public function userAttribute()
    {
        return $this->hasOne(UserAttribute::class, 'user_id');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'user_id');
    }

    public function getRole()
    {
        $result = $this->select(['role'])->first()->role;

        return $result;
    }

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isModerator()
    {
        return $this->role === self::ROLE_MODERATOR;
    }

    public function isUser()
    {
        return $this->role === self::ROLE_USER;
    }

    public function isPaidUser()
    {
        return $this->role === self::ROLE_PAID_USER;
    }

    public function isPremium()
    {
        return $this->role === self::ROLE_PREMIUM;
    }

    public function isVip()
    {
        return $this->role === self::ROLE_VIP;
    }


}
