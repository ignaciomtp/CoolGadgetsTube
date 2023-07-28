<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'slug',
        'interlink_1',
        'interlink_2',
        'interlink_3',
        'interlink_4',
        'description_short',
        'description_long',
        'menu_id',
        'icon'
    ];


    public function products()
    {
        return $this->belongsToMany('App\Models\Product');
    }

    public function menus()
    {
        return $this->belongsToMany('App\Models\Menu');
    }

    public function tags()
    {
        return $this->hasMany('App\Models\Tag');
    }
}
