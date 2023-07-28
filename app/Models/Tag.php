<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'description_long',
        'icon',
        'category_id'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function posts()
    {
        return $this->belongsToMany('App\Models\Post');
    }

}
