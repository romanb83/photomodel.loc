<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function region()
    {
        return $this->hasMany(Region::class);
    }
}
