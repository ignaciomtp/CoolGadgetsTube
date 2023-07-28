<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\SitemapController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();


Route::prefix('admin')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('admin');
    Route::get('/category', [HomeController::class, 'addCategory'])->name('addCategory');
    Route::post('/category', [HomeController::class, 'createCategory'])->name('createcategory');
    Route::get('/category/edit/{id}', [HomeController::class, 'editCategory'])->name('editcategory');
    Route::post('/category/update/{id}', [HomeController::class, 'updateCategory'])->name('updatecategory');
    Route::post('/category/delete', [HomeController::class, 'deleteCategory'])->name('deletecategory');

    Route::get('/tag', [HomeController::class, 'tags'])->name('tags');
    Route::get('/tag/add', [HomeController::class, 'addTag'])->name('addTag');
    Route::post('/tag', [HomeController::class, 'createTag'])->name('createtag');
    Route::get('/tag/edit/{id}', [HomeController::class, 'editTag'])->name('edittag');
    Route::post('/tag/update/{id}', [HomeController::class, 'updateTag'])->name('updatetag');
    Route::post('/tag/delete', [HomeController::class, 'deleteTag'])->name('deletetag');

    Route::get('/product', [HomeController::class, 'products'])->name('products');
    Route::get('/product/add', [HomeController::class, 'addProduct'])->name('addproduct');
    Route::post('/product', [HomeController::class, 'createProduct'])->name('createproduct');
    Route::get('/product/edit/{id}', [HomeController::class, 'editProduct'])->name('editproduct');
    Route::post('/product/update/{id}', [HomeController::class, 'updateProduct'])->name('updateproduct');
    Route::post('/product/delete', [HomeController::class, 'deleteProduct'])->name('deleteproduct');
    Route::get('/product/search', [HomeController::class, 'search'])->name('buscar');
    Route::get('/product/search2/{term}', [HomeController::class, 'search2'])->name('buscar2');
    Route::get('/product/searchposts', [HomeController::class, 'searchPosts'])->name('buscarposts');
    Route::get('/product/addslugs', [HomeController::class, 'addSlugsToProducts'])->name('addslugs');

    Route::get('/menu', [HomeController::class, 'menus'])->name('menus');
    Route::get('/menu/add', [HomeController::class, 'addMenu'])->name('addmenu');
    Route::post('/menu', [HomeController::class, 'createMenu'])->name('createmenu');
    Route::get('/menu/edit/{id}', [HomeController::class, 'editMenu'])->name('editmenu');
    Route::post('/menu/update/{id}', [HomeController::class, 'updateMenu'])->name('updatemenu');

    Route::get('/post', [HomeController::class, 'posts'])->name('posts');
    Route::get('/post/add', [HomeController::class, 'addPost'])->name('addpost');
    Route::post('/post', [HomeController::class, 'createPost'])->name('createpost');
    Route::get('/post/edit/{id}', [HomeController::class, 'editPost'])->name('editpost');
    Route::post('/post/update/{id}', [HomeController::class, 'updatePost'])->name('updatepost');
    Route::post('/post/delete', [HomeController::class, 'deletePost'])->name('deletepost');

});


Route::get('/', [PublicController::class, 'index'])->name('inicio');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::get('/p/{slug}', [PublicController::class, 'productPage'])->name('productPage');

Route::get('/random', [PublicController::class, 'random'])->name('random');

Route::get('/search', [PublicController::class, 'search'])->name('search');
Route::get('/searching/{term}/{batch?}', [PublicController::class, 'searching'])->name('searching');

Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::post('/contact', [PublicController::class, 'sendMessage'])->name('sendMessage');

Route::get('/terms', [PublicController::class, 'terms'])->name('terms');

Route::get('/most-popular', [PublicController::class, 'morePopular'])->name('popular');

Route::get('/latest', [PublicController::class, 'latestGadgets'])->name('latest');

Route::get('/youtube', [PublicController::class, 'ytTheme'])->name('youtube');

Route::get('/most-popular-test/{items?}', [PublicController::class, 'popTest'])->name('populartest');

Route::get('/blog', [PublicController::class, 'blog'])->name('blog');
Route::get('/blog/tag/{tagslug}', [PublicController::class, 'blogTag'])->name('blogtag');
Route::get('/blog/search/', [PublicController::class, 'blogSearch'])->name('blogsearch');
Route::get('/blog/{slug}', [PublicController::class, 'blogPost'])->name('blogpost');
Route::get('/blog1/{slug}', [PublicController::class, 'blogPost2'])->name('blogpost2');
Route::get('/blog3/{slug}', [PublicController::class, 'blogPost3'])->name('blogpost3');

Route::get('/{category}', [PublicController::class, 'category'])->name('categoria');
Route::get('/tag/{tagslug}', [PublicController::class, 'tag'])->name('tag');

Route::get('/likeproduct/{id}', [PublicController::class, 'likeProduct'])->name('like');

Route::get('/loadmore/{pag}', [PublicController::class, 'reloadItems'])->name('loadmore');

Route::get('/categoryloadmore/{category}/{nItems}', [PublicController::class, 'categoryReload'])->name('categoryloadmore');

Route::get('/postloadmore/{tagslugs}/{nItems}', [PublicController::class, 'blogPostReload'])->name('postloadmore');

Route::get('/tagloadmore/{tag}/{nItems}', [PublicController::class, 'tagReload'])->name('tagloadmore');

