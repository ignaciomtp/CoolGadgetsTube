<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Product;


class SitemapController extends Controller
{
    public function index(Request $r)
    {
       
        $posts = Post::orderBy('id','desc')->get();

        $categories = Category::all();

        $allTags = Tag::all()->sortBy('name');

        $products = Product::all();

        return response()->view('sitemap', compact('posts', 'categories', 'products'))
          ->header('Content-Type', 'text/xml');

    }
}
