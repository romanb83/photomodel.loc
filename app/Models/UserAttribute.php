<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAttribute extends Model
{
    protected $fillable = ['id', 'user_id', 'gender', 'eye_color', 'hair_color', 'phone', 'age',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
