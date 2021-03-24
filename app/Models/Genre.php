<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public const PHOTOGRAFER_GENRES = ['portrait', 'beauty', 'fashion', 'boudoir', 'nude', 'nu-art', 'met-art',
        'advertising', 'landscape', 'street', 'wedding', 'family', 'children', 'reportage',
        'wild', 'bw', 'macro', 'travel', 'interior', 'night', 'astro', 'architecture', 'still',
        'shows'];
    public const MODEL_GENRES = ['portrait', 'beauty', 'fashion', 'boudoir', 'nude', 'nu-art', 'met-art',
        'advertising', 'street', 'wedding', 'family', 'children'];
    public const MAKEUP_GENRES = ['portrait', 'beauty', 'fashion', 'boudoir', 'nude', 'advertising', 'street',
        'wedding', 'family', 'children'];
    public const STYLIST_GENRES = ['portrait', 'beauty', 'fashion', 'boudoir', 'nude', 'advertising', 'street',
        'wedding', 'family', 'children'];

    protected $fillable = ['portrait', 'nude', 'reportage'];

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_genres', 'genre_id', 'user_id');
    }
}
