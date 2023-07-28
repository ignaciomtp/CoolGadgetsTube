<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Product;
use App\Models\Post;
use App\Models\Menu;
use App\MyApp;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $items = Category::paginate(12);
        $totalCats = Category::count();
        return view('admin.admin', compact('items', 'totalCats'));
    }

    public function addSlugsToProducts() {
        $products = Product::all();

        foreach($products as $prod) {
            $prod->slug = Str::slug($prod->name, '-'); 
            $prod->save();
        }

        return redirect()->route('products');
    }

    public function menus() {
        $items = Menu::all();
        return view('admin.menus', compact('items'));
    }

    public function addMenu(){
        

        return view('admin.addmenu');
    }

    public function createMenu(Request $request) {
        $this->validate($request, [
            'name' => 'required|max:80',

        ]);     

        $menu = new Menu;  
       

        $menu->fill($request->all());

        $menu->save();
        

        return redirect()->route('menus');
    }

    public function editMenu($id){
        $menu = Menu::findOrFail($id);
        

        return view('admin.editmenu', compact('menu'));

    }

    public function updateMenu(Request $request, $id) {
         $this->validate($request, [
            'name' => 'max:80',
                        
        ]);

        $menu = Menu::findOrFail($id);

        $menu->fill($request->all());

        $menu->save();


        return redirect()->route('menus');
    }


    public function addCategory(){
        $menus = Menu::all();

        return view('admin.newCategory', compact('menus'));
    }

    public function createCategory(Request $request){
        $this->validate($request, [
            'name' => 'required|max:80',
            //'image'=> 'required|image|mimes:jpeg,webp,png,jpg,gif,svg|max:2048',
            'description_short' => 'required',
            'description_long' => 'required',
        ]);

        $category = new Category;

        $category->fill($request->all());

        $category->slug = Str::slug($request->name, '-'); 

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $nameImage = $image->getClientOriginalName();
            $image->move(app()->basePath('coolgadgetstube.com/img/categories'), $nameImage);
            $category->image = $nameImage;
        }


        //if($request->has('menu')) $category->menu = true;

        $category->save();

        return redirect()->route('admin');
    }

    public function editCategory($id){
        $category = Category::findOrFail($id);
        $allCategories = Category::all();
        $menus = Menu::all();

        return view('admin.editCategory', compact('category', 'allCategories', 'menus'));

    }

    public function updateCategory(Request $request, $id){
        $this->validate($request, [
            'name' => 'max:80',
            'image'=> 'image|mimes:jpeg,webp,png,jpg,gif,svg|max:2048',
            
        ]);

        $category = Category::findOrFail($id);

        $img = $category->image;

        $category->fill($request->all());

        if($request->has('name')) $category->slug = Str::slug($request->name, '-'); 

        if($request->hasFile('image')) {
            $oldImage = app()->basePath('coolgadgetstube.com/img/categories/').$img;
            File::delete($oldImage);

            $image = $request->file('image');
            $nameImage = $image->getClientOriginalName();
            $image->move(app()->basePath('coolgadgetstube.com/img/categories'), $nameImage);

            $category->image = $nameImage;
          
        } 

        if($request->has('menu')) {
            $category->menu = true;
        } else {
            $category->menu = false;
        }

        $category->save();

        return redirect()->route('admin');

    }


    public function products(){
        $totalItems = Product::count();
        $items = DB::table('products')->orderBy('id', 'DESC')->paginate(12);

        return view('admin.products', compact('items', 'totalItems'));
    }

    public function addProduct(){
        $allCategories = Category::all();
        $affiliates = MyApp::AFFILIATES;
        $allTags = Tag::all();

        return view('admin.newItem', compact('allCategories', 'allTags', 'affiliates'));
    }

    public function createProduct(Request $request){
        $this->validate($request, [
        /*    'name' => 'required|max:255',
            'image'=> 'image|mimes:jpeg,webp,png,jpg,gif,svg|max:2048',
            'link' => 'required|max:60',    */
            'affiliate' => 'required|max:20',
            'affiliate_code' => 'required|max:40',
        ]);

        $product = new Product;

        $product->name = $request->name;
        $product->slug = Str::slug($request->name, '-'); 
        $product->link = $request->link;
        $product->description_long = $request->description_long;

        if($request->has('price')) $product->price = $request->price;

        if($request->hasFile('image')){
            $image = $request->file('image');
            $nameImage = $image->getClientOriginalName();
            $image->move(app()->basePath('coolgadgetstube.com/img/products'), $nameImage);

            $product->image = $nameImage;
        } 

        if($request->hasFile('video')){
            $video = $request->file('video');
            $nameVideo = $video->getClientOriginalName();
            $video->move(app()->basePath('coolgadgetstube.com/vid/products'), $nameVideo);

            $product->video = $nameVideo;
        } 

        $product->affiliate = $request->affiliate;
        $product->affiliate_code = $request->affiliate_code;

        $product->save();

        $product->categories()->attach($request->categories);
        $product->tags()->attach($request->tags);

        return redirect()->route('products');

    }

    public function editProduct($id){
        $product = Product::findOrFail($id);
        $allCategories = Category::all();
        $affiliates = MyApp::AFFILIATES;
        $allTags = Tag::all()->sortBy('name');
        $currentCats = [];
        $currentTags = [];
        //$currentTags = $product->tags;


        foreach($product->categories as $cat){
            array_push($currentCats, $cat->id);
        }


        foreach($product->tags as $tag){
            array_push($currentTags, $tag->id);
        }



        return view('admin.editItem', compact('product', 'allCategories', 'currentCats', 'affiliates', 'allTags', 'currentTags'));

    }

    public function updateProduct(Request $request, $id){
        $this->validate($request, [
            'name' => 'max:255',
            'image'=> 'image|mimes:jpeg,webp,png,jpg,gif,svg|max:2048',
            'link' => 'max:160',
            
        ]);

        $product = Product::findOrFail($id);

        $product->fill($request->all());

        if($request->has('name')) $product->slug = Str::slug($request->name, '-'); 

        if($request->hasFile('image')){
            $image = $request->file('image');
            $nameImage = $image->getClientOriginalName();
            $image->move(app()->basePath('coolgadgetstube.com/img/products'), $nameImage);

            $product->image = $nameImage;
        } 


        if($request->hasFile('image2')){
            $image2 = $request->file('image2');
            $nameImage2 = $image2->getClientOriginalName();
            $image2->move(app()->basePath('coolgadgetstube.com/img/products'), $nameImage2);

            $product->image2 = $nameImage2;
        } 

        if($request->hasFile('video')){
            $video = $request->file('video');
            $nameVideo = $video->getClientOriginalName();
            //$video->move(public_path('coolgadgetstube.com/vid/products'), $nameVideo);

            $video->move(app()->basePath('coolgadgetstube.com/vid/products'), $nameVideo);

            $product->video = $nameVideo;
        } 

        $product->save();

        $product->categories()->detach();
        $product->categories()->attach($request->categories);

        $product->tags()->detach();
        $product->tags()->attach($request->tags);

        return redirect()->route('products');

    }

    public function deleteProduct(Request $request){
        $product = Product::findOrFail($request->id);

        DB::table('category_product')->where('product_id', $request->id)->delete();

        $product->delete();

        return redirect()->route('products');

    }


    public function deleteCategory(Request $request){
        $category = Category::findOrFail($request->id);

        DB::table('category_product')->where('category_id', $request->id)->delete();

        $category->delete();

        return redirect()->route('admin');
    }

    public function search(Request $request){
   
        $query = $request->busqueda;

        $items = Product::where('name', 'like', '%' . $query . '%')->get();

        if($items->count() == 0) $items = Product::where('affiliate_code', '=', $query)->get();

        return view('admin.busqueda', compact('items', 'query'));
    }

    public function search2($term){
        $html = '';
        
        $items = Product::where('name', 'like', '%' . $term . '%')->get();

        foreach($items as $item) {
            $html .= '<li><a href="#" onclick="addProduct('. $item->id .')">'. $item->name .'</a></li>';
        }

        return $html;
    }

    public function searchPosts(Request $request){
   
        $query = $request->busqueda;

        $items = Post::where('name', 'like', '%' . $query . '%')->get();

        $totalPosts = count($items);

        return view('admin.posts', compact('items', 'query', 'totalPosts'));
    }


    public function tags() {
        $items = Tag::paginate(12);
        $totalTags = Tag::count();
        return view('admin.tags', compact('items', 'totalTags'));
    }

    public function addTag() {
        $categories = Category::all();
        return view('admin.newTag', compact('categories'));
    }

    public function createTag(Request $request){
        $this->validate($request, [
            'name' => 'required|max:80',

        ]);

        $tag = new Tag;

        $tag->fill($request->all());

        $tag->slug = Str::slug($request->name, '-'); 

        $tag->save();

        return redirect()->route('tags');
    }

    public function editTag($id) {
        $tag = Tag::findOrFail($id);
        $allTags = Tag::all();
        $categories = Category::all();

        return view('admin.editTag', compact('tag', 'allTags', 'categories'));
    }

    public function updateTag(Request $request) {
        $this->validate($request, [
            'name' => 'max:80',
            
        ]);

        $tag = Tag::findOrFail($request->id);

    
        $tag->fill($request->all());

        if($request->has('name')) $tag->slug = Str::slug($request->name, '-'); 

        $tag->save();

        return redirect()->route('tags'); 
    }

    public function deleteTag(Request $request) {
        $tag = Tag::findOrFail($request->id);

        DB::table('product_tag')->where('tag_id', $request->id)->delete();

        $tag->delete();

        return redirect()->route('tags');
    }

    public function posts() {
        //$items = Post::paginate(12);
        $items = DB::table('posts')->orderBy('id', 'DESC')->paginate(12);
        $totalPosts = Post::count();
        return view('admin.posts', compact('items', 'totalPosts'));
    }

    public function addPost() {
        $allTags = Tag::all();

        return view('admin.newPost', compact('allTags'));

    }

    public function createPost(Request $request) {
        $this->validate($request, [
            'name' => 'required|max:180',
            'image'=> 'image|mimes:jpeg,webp,png,jpg,gif,svg|max:2048',
            
        ]);

        $post = new Post;

        $post->fill($request->all());

        $post->slug = Str::slug($request->name, '-'); 
        
        if($request->hasFile('image')){
            $image = $request->file('image');
            $nameImage = $image->getClientOriginalName();
            $image->move(app()->basePath('coolgadgetstube.com/img/posts'), $nameImage);
            //$image->move(public_path('img/posts'), $nameImage);
            $post->image = $nameImage;
        } 

        $post->text = $request->text;

        $post->save();

        $post->tags()->attach($request->tags);

        if($request->products) $post->products()->attach(explode(',', $request->products));

        return redirect()->route('posts');
    }

    public function editPost($id) {
        $post = Post::findOrFail($id);
        
        $allTags = Tag::all();
        
        $currentTags = [];

        foreach($post->tags as $tag) {
            array_push($currentTags, $tag->id);
        }

        $prodsIds = [];

        foreach($post->products as $prod) {
            array_push($prodsIds, $prod->id);
        }

        return view('admin.editPost', compact('post', 'allTags', 'currentTags', 'prodsIds'));
    }

    public function updatePost(Request $request, $id) {

        $post = Post::findOrFail($id);

        $post->fill($request->all());

        $post->slug = Str::slug($request->name, '-'); 

        if($request->hasFile('image')){
            $image = $request->file('image');
            $nameImage = $image->getClientOriginalName();
            $image->move(app()->basePath('coolgadgetstube.com/img/posts'), $nameImage);
            //$image->move(public_path('img/posts'), $nameImage);
            $post->image = $nameImage;
        } 

        $post->save();

        $post->tags()->detach();
        $post->tags()->attach($request->tags);

        if(isset($request->products)) {
            $post->products()->detach();
            $post->products()->attach(explode(',', $request->products));
        }
        

        return redirect()->route('posts');

    }

    public function deletePost(Request $request) {
        $post = Post::findOrFail($request->id);

        DB::table('post_tag')->where('post_id', $request->id)->delete();

        $post->delete();

        return redirect()->route('posts');
    }

}
