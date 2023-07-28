<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'slug',
        'description',
        'text',
        'likes',
        'icon',
        'related_1',
        'related_2',
        'related_3',
        'related_4',
    ];

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }

}
