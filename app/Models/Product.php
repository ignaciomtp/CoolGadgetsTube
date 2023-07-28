<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description_long',
        'image',
        'image2',
        'video',
        'affiliate',
        'affiliate_code',
        'link',
        'price',
        'likes',
        'slug'
    ];


    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }

    public function posts()
    {
        return $this->belongsToMany('App\Models\Post');
    }
}
