<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Menu;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Error;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactEmail;

class PublicController extends Controller
{
    
    public function processedProducts($allProducts) {
        $asins = [];
        $ids = [];
        $images = [];
        $videos = [];
        $likes = [];
        $descs = [];
        $names = [];

        $products = [];
        $productsA = [];
        $productsNA = [];

        $errors = [];

        // Separar los artículos de Amazon de los demás
        foreach($allProducts as $prod){
            if($prod->affiliate == 'Amazon') {
                array_push($asins, $prod->affiliate_code);
                $ids[$prod->affiliate_code] = $prod->id;
                $images[$prod->affiliate_code] = $prod->image;
            //    $images[$prod->affiliate_code] = null;
                $images2[$prod->affiliate_code] = $prod->image2;
                $videos[$prod->affiliate_code] = $prod->video;
                $likes[$prod->affiliate_code] = $prod->likes;
                $descs[$prod->affiliate_code] = $prod->description_long;
                $names[$prod->affiliate_code] = $prod->name;
                $slugs[$prod->affiliate_code] = $prod->slug;
                $links[$prod->affiliate_code] = $prod->link;
            } else {
                $nwItem = (object)[
                    'price' => '',
                    'name' => $prod->name,
                    'nameShow' => substr($prod->name, 0, 80),
                    'slug' => $prod->slug,
                    'image' => $prod->image,
                    'image2' => $prod->image2,
                    'link' => $prod->link,
                    'description' => $prod->description_long,
                    'id' => $prod->id,
                    'video' => $prod->video,
                    'affiliate' => $prod->affiliate,
                    'affiliate_code' => $prod->affiliate_code,
                    'likes' => $prod->likes,
                    'created' => $prod->created_at
                ];
                array_push($productsNA, $nwItem);
            }
            
        }
    

        if(count($asins) > 0) {
            // Coger los artículos de Amazon de la API
/*
            $results = json_decode(getItemsByAsinFromApi($asins), true);
            

            if(isset($results['Errors'])) {
                $errors = $results['Errors'];
            }

            $items = $results['ItemsResult']['Items'];

            foreach($items as $res){
                $newItem = (object)[
                    'price' => isset($res['Offers']['Listings'][0]['Price']['DisplayAmount']) ? $res['Offers']['Listings'][0]['Price']['DisplayAmount'] : 'N/A', 
                    'name' => $res['ItemInfo']['Title']['DisplayValue'],
                    'nameShow' => $names[$res['ASIN']],
                    //'nameShow' => substr($res['ItemInfo']['Title']['DisplayValue'], 0, 80) . '...',
                    'image' => $images[$res['ASIN']] ? request()->getSchemeAndHttpHost()."/img/products/".$images[$res['ASIN']] : $res['Images']['Primary']['Large']['URL'],
                    'link' => $res['DetailPageURL'],
                    'slug' => $slugs[$res['ASIN']],
                    'description' => $descs[$res['ASIN']],
                    'id' => $ids[$res['ASIN']],
                    'video' => $videos[$res['ASIN']],
                    'affiliate' => 'Amazon',
                    'affiliate_code' => $res['ASIN'],
                    'likes' => $likes[$res['ASIN']],
                    'created' => $prod->created_at,
                    'features' => isset($res['ItemInfo']['Features']) ? $res['ItemInfo']['Features']['DisplayValues'] : '',
                ];

                array_push($productsA, $newItem);
            }
*/

            foreach($asins as $asin) {
                $newItem = (object)[
                    'price' => null, 
                    'name' => $names[$asin],
                    'nameShow' => $names[$asin],
                    'image' =>  request()->getSchemeAndHttpHost()."/img/products/".$images[$asin],
                    'image2' =>  $images2[$asin] ? request()->getSchemeAndHttpHost()."/img/products/".$images2[$asin] : null,
                    'link' => $links[$asin],
                    'slug' => $slugs[$asin],
                    'description' => $descs[$asin],
                    'id' => $ids[$asin],
                    'video' => $videos[$asin],
                    'affiliate' => 'Amazon',
                    'affiliate_code' => $asin,
                    'likes' => $likes[$asin],                    
                    'features' => '',
                ];

                array_push($productsA, $newItem);               
            }

        }    


        foreach($allProducts as $product) {
            $p = $product->affiliate == 'Amazon' ? $this->findInArray($productsA, $product->affiliate_code) : $this->findInArray($productsNA, $product->affiliate_code);

            if($p) array_push($products, $p);
        }


        if(count($errors) > 0) $this->processErrors($errors);

        return $products;
    }

    public function processErrors($errors) {

        foreach($errors as $error) {

            $oldError = DB::table('errors')->where('message',$error['Message'])->first();

            if ($oldError == null) {
                $newError = new Error();
                $newError->message = $error['Message'];
                $newError->save();

                $this->alertError($error);
            }

        }

    }

    public function alertError($error) {
        $text = "Error API Amazon: ".$error['Code'].', '.$error['Message'];

        $headers = 'From: info@nowineedthat.store'. "\r\n" .
            'Reply-To: info@nowineedthat.store'. "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail('ignaciomtp@gmail.com', 'Error CGT Amazon' , $text , $headers);        
    }

    public function findInArray($array, $needle) {
        $result = null;
        for($i = 0; $i < count($array); $i++) {
            if($array[$i]->affiliate_code == $needle) {
                $result = $array[$i];
                break;
            }
        }

        return $result;
    }

    public function indexOld() {
        $allProducts = Product::orderBy('created_at', 'desc')->take(6)->get();

        $products = $this->processedProducts($allProducts);

        $categories = Category::all();

        $allTags = Tag::all()->sortBy('name');
        $tags = [];

        foreach($allTags as $tag) {
            if($tag->products->count() > 0) array_push($tags, $tag);
        }

        $menuItems = Menu::all();
        

        $tProducts = [];

        $canon = '';

        $posts = Post::orderBy('created_at', 'desc')->take(5)->get();
/*
        $topProducts = Product::orderBy('likes', 'desc')->orderBy('id', 'ASC')->take(6)->get();

        $tProducts = $this->processedProducts($topProducts);



        if (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
          $canon = '<link rel="canonical" href="https://coolgadgetstube.com/" />';
        }
*/
        return view('index', compact('tags', 'canon', 'categories', 'menuItems', 'products', 'posts'));
    }


    public function index() {
        $categories = Category::all();

        $allTags = Tag::all()->sortBy('name');
        $tags = [];

        foreach($allTags as $tag) {
            if($tag->products->count() > 0) array_push($tags, $tag);
        }

        $menuItems = Menu::all();

        $allProducts = Product::orderBy('created_at', 'desc')->take(9)->get();

        $products = $this->processedProducts($allProducts);

        $canon = '';


/*
        if (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
          $canon = '<link rel="canonical" href="https://nowineedthat.store/" />';
        }
*/
        return view('latest', compact('tags', 'canon', 'categories', 'menuItems', 'products'));       
    }


    public function latestGadgets() {
        $categories = Category::all();

        $allTags = Tag::all()->sortBy('name');
        $tags = [];

        foreach($allTags as $tag) {
            if($tag->products->count() > 0) array_push($tags, $tag);
        }

        $menuItems = Menu::all();

        $allProducts = Product::orderBy('created_at', 'desc')->take(9)->get();

        $products = $this->processedProducts($allProducts);

        $canon = '';


/*
        if (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
          $canon = '<link rel="canonical" href="https://nowineedthat.store/" />';
        }
*/
        return view('latest', compact('tags', 'canon', 'categories', 'menuItems', 'products'));       
    }


    public function ytTheme() {
        $categories = Category::all();

        $allTags = Tag::all()->sortBy('name');
        $tags = [];

        foreach($allTags as $tag) {
            if($tag->products->count() > 0) array_push($tags, $tag);
        }

        $menuItems = Menu::all();

        $allProducts = Product::orderBy('created_at', 'desc')->take(9)->get();

        $products = $this->processedProducts($allProducts);

        $canon = '';


/*
        if (isset($_SERVER['HTTPS']) &&
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
          $canon = '<link rel="canonical" href="https://nowineedthat.store/" />';
        }
*/
        return view('youtube', compact('tags', 'canon', 'categories', 'menuItems', 'products'));       
    }

    public function random() {
        $categories = Category::all();
        $allTags = Tag::all()->sortBy('name');
        $tags = [];

        foreach($allTags as $tag) {
            if($tag->products->count() > 0) array_push($tags, $tag);
        }

        $menuItems = Menu::all();

        $allProducts = Product::inRandomOrder()->limit(9)->get();

        $products = $this->processedProducts($allProducts);

        $title = 'Random cool things we have';

        $description = 'Click for a random collection of cool things you can buy online. Tech gadgets, funny gifts, useful gizmos and geeky products, you’ll decide you need them all.';


        return view('random', compact('tags', 'categories', 'menuItems', 'products', 'title', 'description'));
    }

    public function search() {
        $allTags = Tag::all()->sortBy('name');
        $tags = [];

        foreach($allTags as $tag) {
            if($tag->products->count() > 0) array_push($tags, $tag);
        }

        $menuItems = Menu::all();

        $title = 'Search our store';

        $description = 'Looking for something specific? Search our extensive collection of tech gadgets, funny gifts, useful gizmos and geeky products..';

        return view('search', compact('tags', 'menuItems', 'title', 'description'));
    }

    public function searching($term, $batch = 0) {

        $products = [];
        $nProds = '';

        $html = '';

        $items = Product::where('name', 'like', '%' . $term . '%')->orderBy('created_at', 'asc')->get();

        $nProds = $items->all();

        $total = count($nProds);

        $newArray = array_slice($nProds, $batch, 9);

        if(count($newArray) > 0) {
            $products = $this->processedProducts($newArray);
            $html = $this->parseResults($products);
        }

        $result = [
            'total' => $total,
            'html' => $html
        ];

        return json_encode($result);

    }

    public function reloadItems($pag) {
        $maxItems = $pag * 9;

        $products = [];

        $allProducts = Product::orderBy('created_at', 'desc')->take($maxItems)->get();

        $nProds = $allProducts->slice(($pag - 1) * 9);

        if($nProds->count() > 0) $products = $this->processedProducts($nProds->all());

        return $this->parseResults($products);

    } 

    public function parseResults($products) {

        $html = '';

        foreach ($products as $prod) {
            $html .=        '<div class="col-sm-12 col-md-6 col-lg-4">';
            $html .=          '<div class="card mb-4 sombra">';
            $html .=           '<div class="card-body">';

            if($prod->video) {
                $html .=        '<div class="itemImg mb-3" onmouseover="showVideo(' . $prod->id . ')" ';
                $html .=            'onclick="loadVideoBig('. $prod->id . ')" ';
                $html .=            'onmouseout="hideVideo('. $prod->id . ')" >';
                $html .=                '<div class=" " id="vid-' . $prod->id . '">';
                $html .=                  '<video id="video' . $prod->id . '" src="'. asset('vid/products/' . $prod->video) .'" muted="muted" preload="none" width="320" poster="'. $prod->image.'"></video>';
                $html .=                '</div>';
                $html .=                '<div class="fav-btn" id="likes-' . $prod->id . '" onclick="likeProduct(event, ' . $prod->id . ')" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="I love it!" data-bs-custom-class="custom-tooltip" >' . $prod->likes . '</div>';
               if($prod->affiliate == 'Amazon') {
                    $html .= '<img loading="lazy" src="' . $prod->image . '" id="imgprod' . $prod->id . '" class="img-fluid product-img" alt="' . $prod->nameShow . '" >';
               } else {
                    $html .= '<img loading="lazy" src="'. asset('img/products/'.$prod->image) .'" id="imgprod' . $prod->id . '" class="img-fluid product-img" alt="' . $prod->nameShow . '" >';
               }

               $html .= '<img loading="lazy" src="'. asset('img/play4.png') .'" alt="Play Video" id="playbtn' . $prod->id . '" class="playbtn" >';
               $html .= '</div>';
            } else {
                $html .= '<div class="itemImg3 mb-3" >';
                $html .=    '<div class="fav-btn" id="likes-' . $prod->id . '" onclick="likeProduct(event, ' . $prod->id . ')" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="I love it!" >' . $prod->likes;
                $html .=    '</div>';

                if($prod->affiliate == 'Amazon') {
                    $html .= '<img loading="lazy" src="' . $prod->image . '" id="imgprod' . $prod->id . '" class="img-fluid product-img" alt="' . $prod->nameShow . '" >';
                } else {
                    $html .= '<img loading="lazy" src="'. asset('img/products/'.$prod->image) .'" id="imgprod' . $prod->id . '" class="img-fluid product-img" alt="' . $prod->nameShow . '" >';
                }
                $html .= '</div>';
            }

            $html .= '<div class="cat-title">';
            $html .= '<a href="' .url('/').'/p/'. $prod->slug . '" title="' . $prod->name . '" >';
            $html .= $prod->nameShow . '</a>';
            $html .= '</div>';

             $html .= '<div class="text-left">';
            $html .= ' <p class="cutoff-text2">';
            $html .= $prod->description;
            $html .= ' </p>';
            $html .= ' <input type="checkbox" class="expand-btn text-center almost-half">';
            $html .=    '<a href="' . $prod->link . '" title="' . $prod->name . '" rel="nofollow" target="_blank" class="boton-comprar-amz almost-half float-right" > Buy Now </a>';
            $html .= '</div>';


            $html .= '</div></div></div>';
        }

        return $html;
    }


    public function getProductsOfCategory($category) {
        
        $cat = Category::where('slug', $category)->first();

        //if(!$cat) return view('error', compact('menuItems'));

        $items = $cat->products;     
        $itemsArray = $items->all();   

        usort($itemsArray, function($a, $b) {
            return $b->id - $a->id;
        });

        return $itemsArray;
    }

    public function getProductsOfTag($tag) {
        
        $tg = Tag::where('slug', $tag)->first();

        //if(!$cat) return view('error', compact('menuItems'));

        $items = $tg->products;     
        $itemsArray = $items->all();   

        usort($itemsArray, function($a, $b) {
            return $b->id - $a->id;
        });

        return $itemsArray;
    }

    public function tag($tagslug) {
        $menuItems = Menu::all();
        $tg = Tag::where('slug', $tagslug)->first();
        if(!$tg) return view('error', compact('menuItems'));
        
        $allTags = Tag::all()->sortBy('name');
        $products = [];
        $tags = [];

        foreach($allTags as $tag) {
            if($tag->products->count() > 0) array_push($tags, $tag);
        }

        $items = $this->getProductsOfTag($tagslug);


        if(count($items) > 0) {

            $firstTen = [];
            $counter = 0;

            for($i = 0; $i < count($items); $i++) {
                array_push($firstTen, $items[$i]);

                if($items[$i]->affiliate == 'Amazon') $counter++;

                if($counter == 10) break;
            }

            $products = $this->processedProducts($firstTen);            
        }


        return view('tag', compact('tags', 'tg', 'products', 'menuItems'));
    }


    public function productPage($slug) {
        $menuItems = Menu::all();    
        $prod = Product::where('slug', $slug)->first();
        if(!$prod) return view('error', compact('menuItems'));

        $allProducts = [$prod];
        
        $tags = [];

        $tempProds = [];

        $productTags = $prod->tags;

        foreach($productTags as $pt) {
            $prods = $pt->products;
            foreach($prods as $p) {
                if($p->id != $prod->id) {
                     if(array_key_exists($p->id, $tempProds)) {
                        $tempProds[$p->id]++;
                    } else {
                        $tempProds[$p->id] = 1;
                    }                   
                }
            }
        }

        arsort($tempProds);

        $ntp = array_slice($tempProds, 0, 9, true);

        $query = array_keys($ntp);

        $related = Product::findMany($query);

        foreach($query as $q) {
            $prod = $related->find($q);

            array_push($allProducts, $prod);
        }

        $res = $this->processedProducts($allProducts);

        if(!$res) return view('error', compact('menuItems'));

        $product = $res[0];

        $relatedProds = array_slice($res, 1);

        return view('product', compact('tags', 'product', 'menuItems', 'relatedProds'));
    }


    public function category($category){
        $menuItems = Menu::all();    
        $cat = Category::where('slug', $category)->first();
        if(!$cat) return view('error', compact('menuItems'));

            
        $allTags = Tag::all()->sortBy('name');
        $products = [];
        $tags = [];

        foreach($allTags as $tag) {
            if($tag->products->count() > 0) array_push($tags, $tag);
        }


        $items = $this->getProductsOfCategory($category);

        if(count($items) > 0) {

        /*    $firstTen = [];
            $counter = 0;

            for($i = 0; $i < count($items); $i++) {
                array_push($firstTen, $items[$i]);

                if($items[$i]->affiliate == 'Amazon') $counter++;

                if($counter == 10) break;
            }

            $products = $this->processedProducts($firstTen);            */

            if(count($items) > 10) {
                $firstLoad = array_slice($items, 0, 10);
            } else {
                $firstLoad = $items;
            }



            $products = $this->processedProducts($firstLoad); 
        }

        $interlinks = [];

        if($cat->interlink_1 != null) {
            $il = Category::find($cat->interlink_1);
            array_push($interlinks, $il);
        }

        if($cat->interlink_2 != null) {
            $il = Category::find($cat->interlink_2);
            array_push($interlinks, $il);
        }

        if($cat->interlink_3 != null) {
            $il = Category::find($cat->interlink_3);
            array_push($interlinks, $il);
        }

        if($cat->interlink_4 != null) {
            $il = Category::find($cat->interlink_4);
            array_push($interlinks, $il);
        }

        $bImages = ['fun', 'useful', 'home', 'tech', 'kitchen', 'office', 'car', 'phone', 'travel', 'men', 'women', 'kids', 'gamers', 'geeks', 'pets', 'outdoor', 'fitness'];

        $nameWords = explode(' ', $cat->name);

        $backimage = '';

        foreach($nameWords as $nw) {
            if(in_array(strtolower($nw), $bImages)) $backimage = 'var(--'.strtolower($nw).')';
        }

        $description = explode('[[ sep ]]', $cat->description_long);

        if(count($description) == 2) {
            $descriptionShort = $description[0];
            $descriptionLong = $description[1];
        } else {
            $descriptionShort = 'Discover some of the best and coolest car gadgets here and enhance your car driving experience to the fullest. Here you will find the unique and most preferred types of car gadgets and other accessories here.';
            $descriptionLong = $description[0];           
        }


        return view('category', compact('tags', 'cat', 'products', 'interlinks', 'menuItems', 'backimage', 'descriptionShort', 'descriptionLong'));

    }

    public function morePopular() {

        $menuItems = Menu::all();
        $allTags = Tag::all()->sortBy('name');
        $tags = [];

        foreach($allTags as $tag) {
            if($tag->products->count() > 0) array_push($tags, $tag);
        }

        $allProducts = Product::orderBy('likes', 'desc')->orderBy('id', 'ASC')->take(9)->get();

        $products = $this->processedProducts($allProducts);

        $title = 'Most Popular Products';

        $description = 'The title is self-explanatory: The most popular items on our website, chosen by our users.';

        return view('popular', compact('tags', 'menuItems', 'products', 'title', 'description'));        
    }

    public function categoryReload($category, $nItems) {

        $products = [];

        if($category == 'popular') {
            $tempItems = Product::orderBy('likes', 'desc')->orderBy('id', 'ASC')->take($nItems + 9)->get();
            $allItems = $tempItems->all();
        } else {
            $allItems = $this->getProductsOfCategory($category);
        }


        $items = array_slice($allItems, $nItems);

        /* Si es la página inicial recortamos sólo 6 resultados */
        if($category == 'popular' && $nItems == 0) {
            $items = array_slice($items, 0, 6);
        }
        
        if(count($items) > 0) {
            if($category == 'popular') {
                $products = $this->processedProducts($items);
            } else {
                $firstTen = [];
                $counter = 0;

                for($i = 0; $i < count($items); $i++) {
                    array_push($firstTen, $items[$i]);

                    if($items[$i]->affiliate == 'Amazon') $counter++;

                    if($counter == 10) break;
                }


                $products = $this->processedProducts($firstTen);

            }

            return $this->parseResults($products);         
        }

        
        return '';
    }

    public function popTest($items = 0) {
        $allProducts = Product::orderBy('likes', 'desc')->orderBy('id', 'ASC')->take($items + 9)->get();

        $ids = [];

        foreach($allProducts as $prod) {
            array_push($ids, $prod->id);
        }

        return implode(', ', $ids);

    }


    public function tagReload($tag, $nItems) {
        $products = [];

        $allItems = $this->getProductsOfTag($tag);

        $items = array_slice($allItems, $nItems);

        if(count($items) > 0) {

            $firstTen = [];
            $counter = 0;

            for($i = 0; $i < count($items); $i++) {
                array_push($firstTen, $items[$i]);

                if($items[$i]->affiliate == 'Amazon') $counter++;

                if($counter == 10) break;
            }


            $products = $this->processedProducts($firstTen);   

            return $this->parseResults($products);         
        }

        
        return '';

    }


    public function likeProduct($id) {

        $product = Product::findOrFail($id);

        $product->likes++;

        $product->save();

        return $product->likes;

    }


    public function contact(){
        $allTags = Tag::all()->sortBy('name');
        $tags = [];

        foreach($allTags as $tag) {
            if($tag->products->count() > 0) array_push($tags, $tag);
        }

        $menuItems = Menu::all();

        $title = 'Contact Page';

        $description = 'Do you have any questions, or requests? Please let us know.';

        return view('contact', compact('tags', 'menuItems', 'title', 'description'));
    }

    public function sendMessage(Request $request){

        $input = $request->all();
   



        $menuItems = Menu::all();
        
        if(!isset($request->flexCheckDefault)) {

            $name = $request->inputName;
            $email = $request->inputEmail;
            $subject = $request->inputSubject;
            $text = "El usuario $name ha enviado el siguiente mensaje a CoolGadgetsTube: ".$request->description;

            //Mail::to('ignaciomtp@gmail.com')->send(new ContactEmail($name, $email, $subject, $text));

            /**/
            $headers = 'From: '. $email . "\r\n" .
                'Reply-To: '. $email . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail('ignaciomtp@gmail.com', $subject , $text , $headers);           
        } 
        
        $successMsg = 'Your message was sent. Thanks for contacting us. We will get back to you ASAP.';

        return view('contact', compact('successMsg', 'menuItems'));
    }

    public function terms(){
        $menuItems = Menu::all();
        $allTags = Tag::all()->sortBy('name');
        $tags = [];

        foreach($allTags as $tag) {
            if($tag->products->count() > 0) array_push($tags, $tag);
        }

        $title = 'Our Terms and Conditions';
        $description = 'Please read these terms and conditions carefully before using Our Service.';

        return view('terms', compact('tags', 'menuItems', 'title', 'description'));
    }

    public function blog() {
        $menuItems = Menu::all();
        $allTags = Tag::all()->sortBy('name');
        $tags = [];

        foreach($allTags as $tag) {
            if($tag->posts->count() > 0) array_push($tags, $tag);
        }

        $latestPosts = Post::orderBy('id', 'desc')->take(3)->get();

        $posts = Post::orderBy('id', 'desc')->paginate(5);

        $title = 'Blog';
        $description = 'Cool and original blog gifts from Cool Gadgets Tube';

        return view('blog', compact('posts', 'tags', 'menuItems', 'title', 'description', 'latestPosts'));
    }

    public function postMultiProducts($tags, $prods = 0) {
            $a = 0;
            $tagsProds = [];

            $arrayTags = explode(',', $tags);

            foreach($arrayTags as $tagSlug) {
                $tag = Tag::where('slug', $tagSlug)->first();
                $tagsProds[$a] = [];
                foreach($tag->products as $tp) {
                    array_push($tagsProds[$a], $tp);
                }
                $a++;
            }

            $numTags = count($tagsProds);

            if($numTags == 1) $products = $tagsProds[0];

            if($numTags == 2){
                $a = $tagsProds[0];
                $b = $tagsProds[1];

                $products = findCommonElements($a, $b);
            } 
            
            if($numTags == 3) {
                $a = $tagsProds[0];
                $b = $tagsProds[1];
                $c = $tagsProds[2];

                $productsTemp = findCommonElements($a, $b);
                $products = findCommonElements($productsTemp, $c);
            } 

            if($numTags == 4) {
                $a = $tagsProds[0];
                $b = $tagsProds[1];
                $c = $tagsProds[2];
                $d = $tagsProds[3];

                $productsTemp = findCommonElements($a, $b);
                $productsTemp2 = findCommonElements($productsTemp, $c);
                $products = findCommonElements($productsTemp2, $d);
            } 

            $productsF = [];
            
            if($prods == -1) return $products;

            if(count($products) > 10) {
                $productsF = array_slice($products, $prods, 10, true);
            } else {
                if($prods > 0 && $prods <= count($products)) return $productsF;
                $productsF = $products;
            }  

            return $productsF;    
    }

    public function blogPost($slug) {
        $menuItems = Menu::all();
        $allTags = Tag::all()->sortBy('name');
        $tags = [];

        foreach($allTags as $tag) {
            if($tag->posts->count() > 0) array_push($tags, $tag);
        }

        $latestPosts = Post::orderBy('id', 'desc')->take(3)->get();

        $post = Post::where('slug', $slug)->first();
        if(!$post) return view('error', compact('menuItems'));

        $finalText = $post->text;

        $products = null;

        $finalText = '';

        $tagsString = '';

        $textBlocks = explode('[[ multiprods ]]', $post->text);

        if(count($textBlocks) == 2) {

            $tagsString = '';

            $a = 1;

            foreach($post->tags as $pt) {
                $tagsString .= $pt->slug;

                if($a < count($post->tags)) $tagsString .= ',';

                $a++;
            }

            $prods = $this->postMultiProducts($tagsString);

            $products = $this->processedProducts($prods);

            $finalText = $textBlocks[0];

            $finalText .= '<div id="items-div">';

            $b = 1;
            foreach($products as $prod) {
                $finalText .= $this->showProductPost2($prod, $b);
                $b++;
            }

            $finalText .= '</div>';

            $finalText .= $textBlocks[1];

        } else {

            $products = $this->processedProducts($post->products);

            $textBlocks = explode('[[ prod ]]', $post->text);

            // separamos la conclusión de la descripción del último artículo
            $finalBlock = explode('<br>', end($textBlocks));

            $numProducts = count($textBlocks) - 1;


            if($numProducts > 1) {
                $i = 1;

                $finalText = $textBlocks[0];

                foreach($products as $product) {                    

                    if($i < $numProducts) {
                        $finalText .= $this->showProductPost2NoDescription($product, $i, $textBlocks[$i]);
                    } else {
                        $finalText .= $this->showProductPost2NoDescription($product, $i, $finalBlock[0]);
                    }   
                  
                    $i++;
                }

                $finalText .= $finalBlock[1];

            } else {
                $finalText .= $textBlocks[0];
            }



        }

        $related = [];

        $rel1 = Post::find($post->related_1);
        if($rel1) array_push($related, $rel1);

        $rel2 = Post::find($post->related_2);
        if($rel2) array_push($related, $rel2);

        $rel3 = Post::find($post->related_3);
        if($rel3) array_push($related, $rel3);

        $rel4 = Post::find($post->related_4);
        if($rel4) array_push($related, $rel4);

        return view('post', compact('post', 'finalText', 'menuItems', 'related', 'tagsString', 'tags', 'latestPosts'));

    }

    public function blogPostReload($tags, $prods = 0) {
        $result = '';

        $pds = $this->postMultiProducts($tags, $prods);

        if(count($pds) == 0) return $result;

        $products = $this->processedProducts($pds);

        $a = intval($prods) + 1;
        foreach($products as $key=>$value) {
            $result .= $this->showProductPost2($value, $key + $a);
        }

        return $result;
    }

    public function blogPost2($slug) {
        $menuItems = Menu::all();

        $post = Post::where('slug', $slug)->first();
        if(!$post) return view('error', compact('menuItems'));

        $finalText = $post->text;

        

        $products = $this->processedProducts($post->products);

        $textBlocks = explode('[[ prod ]]', $post->text);

        $finalText = '';

        for($i = 0; $i < count($textBlocks); $i++) {
            $finalText .= $textBlocks[$i];
            if(isset($products[$i])) $finalText .= $this->showProductPost4($products[$i], $i + 1);
        }

        

        $related = [];

        $rel1 = Post::find($post->related_1);
        if($rel1) array_push($related, $rel1);

        $rel2 = Post::find($post->related_2);
        if($rel2) array_push($related, $rel2);

        $rel3 = Post::find($post->related_3);
        if($rel3) array_push($related, $rel3);

        $rel4 = Post::find($post->related_4);
        if($rel4) array_push($related, $rel4);

        return view('post', compact('post', 'finalText', 'menuItems', 'related'));

    }

    public function blogTag($tagslug) {

        $menuItems = Menu::all();
        $allTags = Tag::all()->sortBy('name');
        $tags = [];

        foreach($allTags as $tag) {
            if($tag->posts->count() > 0) array_push($tags, $tag);
        }

        $tg = Tag::where('slug', $tagslug)->first();

        if(!$tg) return view('error', compact('menuItems'));

        $tagName = $tg->name;

        $posts = $tg->posts()->paginate(5);

        $latestPosts = Post::orderBy('id', 'desc')->take(3)->get();

        return view('blog', compact('posts', 'tags', 'menuItems', 'tagName', 'tg', 'latestPosts'));
    }

    public function blogSearch(Request $request) {
        $menuItems = Menu::all();
        $allTags = Tag::all()->sortBy('name');
        $tags = [];

        foreach($allTags as $tag) {
            if($tag->posts->count() > 0) array_push($tags, $tag);
        }

        $term = $request->term;

        $posts = Post::where('name', 'like', '%' . $term . '%')->get();

        $latestPosts = Post::orderBy('id', 'desc')->take(3)->get();

        return view('blogsearchresults', compact('posts', 'tags', 'menuItems', 'term', 'latestPosts'));
        
    }

    public function showProductPost($prod, $num) {

        $res = '';

        $res .= '<a href="'. $prod->link .'" class="post-prod-title" title="'. $prod->name .'" rel="nofollow" target="_blank" >';
        $res .= '<h3>'. $num. ' - ' . $prod->nameShow . '</h3>';
        $res .= '</a>';

        $res .= '<p>' . $prod->description . '</p>';

        $res .= '<div class="post-prod">';

        $res .= '   <div class="row">';
        $res .= '       <div class="col-md-3 col-sm-12">';
        /***-----------------------------------------****/
        if($prod->video) {
            $res .= '<div class="itemImg mb-3" onmouseover="showVideo('. $prod->id .')" onclick="loadVideoBig('. $prod->id . ')" onmouseout="hideVideo('. $prod->id .')">';
                
            $res .= '    <div class=" " id="vid-'. $prod->id .'">';
            $res .= '        <video id="video'. $prod->id .'" src="'. asset('vid/products/' . $prod->video) .'" muted="muted" preload="none" poster="'. $prod->image.'" ></video>';
            $res .= '    </div>';

                
                if($prod->affiliate == 'Amazon') {
                    $res .= '<img loading="lazy" src="'. $prod->image .'" id="imgprod'. $prod->id .'" class="img-fluid product-img" alt="'. $prod->nameShow .'" >';
                } else {
                    $res .= '<img loading="lazy" src="'. asset('img/products/'.$prod->image) .'" id="imgprod'. $prod->id .'" class="img-fluid product-img" alt="'. $prod->nameShow .'" >';
                }
                
                $res .= '<img loading="lazy" src="'. asset('img/play6.png') .'" id="playbtn'. $prod->id .'" alt="Play Video" class="playbtn2" >';
                
            $res .= '</div>';
        } else {

            $res .= '<div class="itemImg4 mb-3" >';


                     
            if($prod->affiliate == 'Amazon') {
                $res .= '<img loading="lazy" src="'. $prod->image .'" id="imgprod'. $prod->id .'" class="img-fluid product-img" alt="'. $prod->nameShow .'" >';
            } else {
                $res .= '<img loading="lazy" src="'. asset('img/products/'.$prod->image) .'" id="imgprod'. $prod->id .'" class="img-fluid product-img" alt="'. $prod->nameShow .'" >';
            }
            
            $res .= '</div>';          
            

        }       

        /***-----------------------------------------****/
        $res .= '       </div>';
        $res .= '       <div class="col-md-9 col-sm-12">';


        if(isset($prod->features)) {
            if(is_array($prod->features)) {
                $res .= '<div class="prod-features"><ul>';
                foreach($prod->features as $feat) {
                    $res .= '<li>' . $feat . '</li>';
                }
                $res .= '</ul></div>';

            } else {
                $res .= '<p class="prod-features">';
                $res .= $prod->features;
                $res .= '</p>';
            }            
        }




        $res .= '<div class="dv-btn-post ">';

        if(isset($prod->price)) {
            $res .= '   <span class="mr-3 pricetext">'. $prod->price .'</span>';
        }


        $res .= '<a class="btn btn-lg btn-post" href="'. $prod->link .'" title="'. $prod->name .'" rel="nofollow" target="_blank" >';
    //    $res .= 'Get it at '.$prod->affiliate.' '. '<i class="ml-2 fab fa-'.strtolower($prod->affiliate).' "></i>';
    
        if($prod->affiliate == 'Etsy') {
            $res .= 'Get it at Etsy <i class="ml-2 fab fa-etsy "></i>';
        } else {
            $res .= 'Get it at Amazon <i class="ml-2 fab fa-amazon "></i>';
        }

        

        $res .= '</a>';
        $res .= '</div>';

        $res .= '       </div>';
        $res .= '   </div>';
        $res .= '</div>';

        return $res;

    }


    public function showProductPost2($prod, $num) {


        $prodImage = $prod->image;

        if($prod->image2) $prodImage = $prod->image2;

        $res = '<div class="mb-5">';

        $res .= '<a href="'. route('productPage', ['slug' => $prod->slug]) .'" class="post-prod-title" title="'. $prod->name .'" target="_blank" >';
        $res .= '<h3 class="card-title">'. $num. ' - ' . $prod->nameShow . '</h3>';
        $res .= '</a>';
        /***-----------------------------------------****/
        if($prod->video) {
            $res .= '<div class="itemImg6 mb-3"  onclick="loadVideoBig('. $prod->id . ')" onmouseout="hideVideo('. $prod->id .')">';
                
            $res .= '    <div class="vid-container" id="vid-'. $prod->id .'">';
            $res .= '        <video id="video'. $prod->id .'" src="'. asset('vid/products/' . $prod->video) .'" muted="muted" preload="none" poster="'. $prodImage.'"></video>';
            $res .= '    </div>';

                
                if($prod->affiliate == 'Amazon') {
                    $res .= '<img loading="lazy" src="'. $prodImage .'" id="imgprod'. $prod->id .'" class="img-fluid product-img2" alt="'. $prod->nameShow .'" >';
                } else {
                    $res .= '<img loading="lazy" src="'. asset('img/products/'.$prodImage) .'" id="imgprod'. $prod->id .'" class="img-fluid product-img2" alt="'. $prod->nameShow .'" >';
                }
                
                $res .= '<img loading="lazy" src="'. asset('img/play2.png') .'" id="playbtn'. $prod->id .'" alt="Play Video" class="playbtn2" >';
                
            $res .= '</div>';
        } else {

            $res .= '<div class="itemImg4 mb-3" >';


                     
            if($prod->affiliate == 'Amazon') {
                $res .= '<img loading="lazy" src="'. $prodImage .'" id="imgprod'. $prod->id .'" class="img-fluid product-img2" alt="'. $prod->nameShow .'" >';
            } else {
                $res .= '<img loading="lazy" src="'. asset('img/products/'.$prodImage) .'" id="imgprod'. $prod->id .'" class="img-fluid product-img2" alt="'. $prod->nameShow .'" >';
            }
            
            $res .= '</div>';          
            

        }       

        /***-----------------------------------------****/
        $res .= '<p>' . $prod->description . '</p>';



        $res .= '<a class="btn btn-post btn-block" href="'. $prod->link .'" title="'. $prod->name .'" rel="nofollow" target="_blank" style="font-size: 1.2rem;">';
    //    $res .= 'Get it at '.$prod->affiliate.' '. '<i class="ml-2 fab fa-'.strtolower($prod->affiliate).' "></i>';
    
        if($prod->affiliate == 'Etsy') {
            $res .= 'Get it at Etsy <i class="ml-2 fab fa-etsy "></i>';
        } else {
            $res .= 'Get it at Amazon <i class="ml-2 fab fa-amazon "></i>';
        }

        

        $res .= '</a>';

        $res .= '</div>';

        return $res;

    }

    public function showProductPost2NoDescription($prod, $num, $description) {


        $prodImage = $prod->image;

        if($prod->image2) $prodImage = $prod->image2;

        $res = '<div class="mb-5">';

        $res .= '<a href="'. route('productPage', ['slug' => $prod->slug]) .'" class="post-prod-title" title="'. $prod->name .'" target="_blank" >';
        $res .= '<h3 class="card-title">'. $num. ' - ' . $prod->nameShow . '</h3>';
        $res .= '</a>';
        /***-----------------------------------------****/
        if($prod->video) {
            $res .= '<div class="itemImg6 mb-3"  onclick="loadVideoBig('. $prod->id . ')" onmouseout="hideVideo('. $prod->id .')">';
                
            $res .= '    <div class="vid-container" id="vid-'. $prod->id .'">';
            $res .= '        <video id="video'. $prod->id .'" src="'. asset('vid/products/' . $prod->video) .'" muted="muted" preload="none" poster="'. $prodImage.'"></video>';
            $res .= '    </div>';

                
                if($prod->affiliate == 'Amazon') {
                    $res .= '<img loading="lazy" src="'. $prodImage .'" id="imgprod'. $prod->id .'" class="img-fluid product-img2" alt="'. $prod->nameShow .'" >';
                } else {
                    $res .= '<img loading="lazy" src="'. asset('img/products/'.$prodImage) .'" id="imgprod'. $prod->id .'" class="img-fluid product-img2" alt="'. $prod->nameShow .'" >';
                }
                
                $res .= '<img loading="lazy" src="'. asset('img/play2.png') .'" id="playbtn'. $prod->id .'" alt="Play Video" class="playbtn2" >';
                
            $res .= '</div>';
        } else {

            $res .= '<div class="itemImg4 mb-3" >';


                     
            if($prod->affiliate == 'Amazon') {
                $res .= '<img loading="lazy" src="'. $prodImage .'" id="imgprod'. $prod->id .'" class="img-fluid product-img2" alt="'. $prod->nameShow .'" >';
            } else {
                $res .= '<img loading="lazy" src="'. asset('img/products/'.$prodImage) .'" id="imgprod'. $prod->id .'" class="img-fluid product-img2" alt="'. $prod->nameShow .'" >';
            }
            
            $res .= '</div>';          
            

        }       

         $res .= '<p>' . $description . '</p>';


        $res .= '<a class="btn btn-post btn-block" href="'. $prod->link .'" title="'. $prod->name .'" rel="nofollow" target="_blank" style="font-size: 1.2rem;">';
    //    $res .= 'Get it at '.$prod->affiliate.' '. '<i class="ml-2 fab fa-'.strtolower($prod->affiliate).' "></i>';
    
        if($prod->affiliate == 'Etsy') {
            $res .= 'Get it at Etsy <i class="ml-2 fab fa-etsy "></i>';
        } else {
            $res .= 'Get it at Amazon <i class="ml-2 fab fa-amazon "></i>';
        }

        

        $res .= '</a>';

        $res .= '</div>';

        return $res;

    }


    public function blogPost3($slug) {
        $menuItems = Menu::all();
        $allTags = Tag::all()->sortBy('name');
        $tags = [];

        foreach($allTags as $tag) {
            if($tag->posts->count() > 0) array_push($tags, $tag);
        }

    //    $latestPosts = Post::orderBy('id', 'desc')->take(3)->get();

        $post = Post::where('slug', $slug)->first();
        if(!$post) return view('error', compact('menuItems'));

        $finalText = $post->text;

        $products = null;

        $finalText = '';

        $tagsString = '';

        $textBlocks = explode('[[ multiprods ]]', $post->text);

        if(count($textBlocks) == 2) {

            $tagsString = '';

            $a = 1;

            foreach($post->tags as $pt) {
                $tagsString .= $pt->slug;

                if($a < count($post->tags)) $tagsString .= ',';

                $a++;
            }

            $prods = $this->postMultiProducts($tagsString, -1);

            $products = $this->processedProducts($prods);

            $finalText = $textBlocks[0];

            $finalText .= '<div id="items-div">';

            $b = 1;
            foreach($products as $prod) {
                $finalText .= $this->showProductPost3($prod, $b);
                $b++;
            }

            $finalText .= '</div>';

            $finalText .= $textBlocks[1];

        } else {

            $products = $this->processedProducts($post->products);

            $textBlocks = explode('[[ prod ]]', $post->text);

            $finalText = $textBlocks[0];

            

            foreach($products as $key=>$value) {
                $finalText .= $this->showProductPost3($value, $key + 1);
            }

            

            $finalText .= end($textBlocks);

        }



        return view('post2', compact('post', 'finalText', 'menuItems'));

    }  

    public function showProductPost3($prod, $num) {

        $res = '<div class="mb-5">';

        $res .= '<a href="'. route('productPage', ['slug' => $prod->slug]) .'" class="post-prod-title" title="'. $prod->name .'" target="_blank" >';
        $res .= '<h3 class="card-title">'. $num. ' - ' . $prod->nameShow . '</h3>';
        $res .= '</a>';
        /***-----------------------------------------****/


        $res .= '<div class="itemImg4 mb-3" >';

$res .= '<a href="'. route('productPage', ['slug' => $prod->slug]) .'" class="post-prod-title" title="'. $prod->name .'" target="_blank" >';
                 
        if($prod->affiliate == 'Amazon') {
            $res .= '<img loading="lazy" src="'. $prod->image .'" id="imgprod'. $prod->id .'" class="img-fluid product-img2" alt="'. $prod->nameShow .'" >';
        } else {
            $res .= '<img loading="lazy" src="'. asset('img/products/'.$prod->image) .'" id="imgprod'. $prod->id .'" class="img-fluid product-img2" alt="'. $prod->nameShow .'" >';
        }
        
         

$res .= '</a>';

$res .= '</div>';      

        /***-----------------------------------------****/
        $res .= '<p>' . $prod->description . '</p>';




        $res .= '</div>';

        return $res;

    }

    public function showProductPost4($prod) {
        $res = '<div class="mb-5 framed-box">';
        $res .= ' <div class="row text-center p-2">';
        $res .= '   <div class="col-3">';

        $res .= '<img loading="lazy" src="'. $prod->image .'" id="imgprod'. $prod->id .'" class="img-fluid " alt="'. $prod->nameShow .'" >';
        $res .= '   </div>';

        $res .= '   <div class="col-9 article-name text-center pt-3">';

        $res .= '<a href="'. route('productPage', ['slug' => $prod->slug]) .'" class="" title="'. $prod->name .'" target="_blank" >';

        $res .= '   <h3 class="mb-3">'. $prod->name .'</h3>';
/*        $res .= '   Check it out in '.$prod->affiliate. ' <i class="ml-2 fab fa-'.strtolower($prod->affiliate);   
        $res .= '"></i>';*/
        
        $res .= '</a>';

        $res .= '   </div>';

        $res .= ' </div>';

        $res .= '</div>';

        return $res;
    }


}
