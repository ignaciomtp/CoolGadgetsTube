<?php

use App\AwsV4;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PublicController;
use App\Models\Category;
use App\Models\Product;

if (! function_exists('homeCatName')) {
    function homeCatName($catName) {
        
        $catArray = explode(' ', $catName);

        foreach($catArray as $ci){
            $ci2 = strtolower($ci);
            if($ci2 != 'miter' && $ci2 != 'saw' && $ci2 != 'saws'){
                $resulArray[] = $ci;
            }
        }

        $result = implode(' ', $resulArray);

        return $result;

    }
}

if (! function_exists('findCommonElements')) {
    function findCommonElements($array1, $array2) {
        $commonElements = array();
        foreach ($array1 as $object1) {
            foreach ($array2 as $object2) {
                if ($object1->id == $object2->id) {
                    $commonElements[] = $object1;
                }
            }
        }
        return $commonElements;
    }

}


if (! function_exists('titleCapitals')) {
    function titleCapitals($catName) {
        
        $catArray = explode(' ', $catName);

        foreach($catArray as $ci){
            $ci = preg_replace("/\xEF\xBB\xBF/", "", $ci);
            if($ci != 'for' && $ci != 'that' && $ci != 'with' && $ci != 'iRobot'){
                $ci = ucfirst($ci);
            }   

            $resulArray[] = ucfirst($ci);
        }

        $result = implode(' ', $resulArray);

        return $result;

    }
}



if (! function_exists('randomItemsSelect')) {
    function randomItemsSelect($array, $numItems){
        $indexes = [];

        while (count($indexes) < $numItems) {
           $a = array_rand($array);

           if(!in_array($a, $indexes)) array_push($indexes, $a);
        }

        $results = [];

        foreach ($indexes as $i) {
            array_push($results, $array[$i]);
        }

        return $results;

    } 
}


if (! function_exists('getItemsFromApi')){
    function getItemsFromApi($searchTerm, $itemPage, $count = 10, $brand = ''){
        if($brand != ''){
            $brand = " \"Brand\": \"$brand\",";
        }

        $serviceName="ProductAdvertisingAPI";
        $region="us-east-1";
        $accessKey=config("amazonapi.amazon_access_key");
        $secretKey=config("amazonapi.amazon_secret_key");
        $payload="{"
                ." \"Keywords\": \"$searchTerm\","
                ." \"Resources\": ["
                ."  \"BrowseNodeInfo.BrowseNodes.SalesRank\","
                ."  \"Images.Primary.Large\","
                ."  \"ItemInfo.ByLineInfo\","
                ."  \"ItemInfo.ContentInfo\","
                ."  \"ItemInfo.Classifications\","
                ."  \"ItemInfo.Features\","
                ."  \"ItemInfo.ManufactureInfo\","
                ."  \"ItemInfo.ProductInfo\","
                ."  \"ItemInfo.TechnicalInfo\","
                ."  \"ItemInfo.Title\","
                ."  \"ItemInfo.TradeInInfo\","
                ."  \"Offers.Listings.Price\","
                ."  \"Offers.Summaries.OfferCount\""
                ." ],"
                ." \"ItemCount\": $count,"
                .$brand
                ." \"ItemPage\": $itemPage,"
                ." \"PartnerTag\": \"nint06-20\","
                ." \"PartnerType\": \"Associates\","
                ." \"Marketplace\": \"www.amazon.com\""
                ."}";
        $host="webservices.amazon.com";
        $uriPath="/paapi5/searchitems";
        $awsv4 = new AwsV4 ($accessKey, $secretKey);
        $awsv4->setRegionName($region);
        $awsv4->setServiceName($serviceName);
        $awsv4->setPath ($uriPath);
        $awsv4->setPayload ($payload);
        $awsv4->setRequestMethod ("POST");
        $awsv4->addHeader ('content-encoding', 'amz-1.0');
        $awsv4->addHeader ('content-type', 'application/json; charset=utf-8');
        $awsv4->addHeader ('host', $host);
        $awsv4->addHeader ('x-amz-target', 'com.amazon.paapi5.v1.ProductAdvertisingAPIv1.SearchItems');
        $headers = $awsv4->getHeaders ();
        $headerString = "";

        foreach ( $headers as $key => $value ) {
            $headerString .= $key . ': ' . $value . "\r\n";
        }

        $params = array (
            'http' => array (
                'header' => $headerString,
                'method' => 'POST',
                'content' => $payload
            )
        );

        $stream = stream_context_create ( $params );

        $fp = @fopen ( 'https://'.$host.$uriPath, 'rb', false, $stream );

        if (! $fp) {
            throw new Exception ( "Exception Occured" );
        }

        $response = @stream_get_contents ( $fp );

        if ($response === false) {
            throw new Exception ( "Exception Occured" );
        }

        return $response;

    }
}


if (! function_exists('getItemsByAsinFromApi')) {
    function getItemsByAsinFromApi($asins){
        $t = "";
        foreach($asins as $as){
            $t .= "  \"$as\",";
        }
        $t = substr($t, 0, -1);

        $serviceName="ProductAdvertisingAPI";
        $region="us-east-1";
        $accessKey=config("amazonapi.amazon_access_key");
        $secretKey=config("amazonapi.amazon_secret_key");
        $payload="{"
                ." \"ItemIds\": ["
                . $t 
                ." ],"
                ." \"Resources\": ["
                ."  \"CustomerReviews.Count\","
                ."  \"CustomerReviews.StarRating\","
                ."  \"Images.Primary.Large\","
     //           ."  \"Images.Variants.Large\","
                ."  \"ItemInfo.ByLineInfo\","
                ."  \"ItemInfo.ContentInfo\","
                ."  \"ItemInfo.ContentRating\","
                ."  \"ItemInfo.Features\","
                ."  \"ItemInfo.ManufactureInfo\","
                ."  \"ItemInfo.ProductInfo\","
                ."  \"ItemInfo.TechnicalInfo\","
                ."  \"ItemInfo.Title\","
                ."  \"Offers.Listings.DeliveryInfo.IsFreeShippingEligible\","
                ."  \"Offers.Listings.DeliveryInfo.IsPrimeEligible\","
                ."  \"Offers.Listings.Price\","
                ."  \"Offers.Listings.SavingBasis\""
                ." ],"
                ." \"PartnerTag\": \"nint06-20\","
                ." \"PartnerType\": \"Associates\","
                ." \"Marketplace\": \"www.amazon.com\""
                ."}";
        $host="webservices.amazon.com";
        $uriPath="/paapi5/getitems";
        $awsv4 = new AwsV4 ($accessKey, $secretKey);
        $awsv4->setRegionName($region);
        $awsv4->setServiceName($serviceName);
        $awsv4->setPath ($uriPath);
        $awsv4->setPayload ($payload);
        $awsv4->setRequestMethod ("POST");
        $awsv4->addHeader ('content-encoding', 'amz-1.0');
        $awsv4->addHeader ('content-type', 'application/json; charset=utf-8');
        $awsv4->addHeader ('host', $host);
        $awsv4->addHeader ('x-amz-target', 'com.amazon.paapi5.v1.ProductAdvertisingAPIv1.GetItems');
        $headers = $awsv4->getHeaders ();
        $headerString = "";

        foreach ( $headers as $key => $value ) {
            $headerString .= $key . ': ' . $value . "\r\n";
        }

        $params = array (
                'http' => array (
                    'header' => $headerString,
                    'method' => 'POST',
                    'content' => $payload
                )
            );

        $stream = stream_context_create ( $params );

        $fp = @fopen ( 'https://'.$host.$uriPath, 'rb', false, $stream );

        if (! $fp) {
            throw new Exception ( "Exception Occured" );
        }

        $response = @stream_get_contents ( $fp );
        
        if ($response === false) {
            throw new Exception ( "Exception Occured" );
        }

        return $response;
    }
}



if (! function_exists('getOneItemFromApi')) {
    function getOneItemFromApi($asin){
        $serviceName="ProductAdvertisingAPI";
        $region="us-east-1";
        $accessKey=config("amazonapi.amazon_access_key");
        $secretKey=config("amazonapi.amazon_secret_key");
        $payload="{"
                ." \"ItemIds\": ["
                ."  \"$asin\""
                ." ],"
                ." \"Resources\": ["
                ."  \"CustomerReviews.Count\","
                ."  \"CustomerReviews.StarRating\","
                ."  \"Images.Primary.Large\","
                ."  \"Images.Variants.Large\","
                ."  \"ItemInfo.ByLineInfo\","
                ."  \"ItemInfo.ContentInfo\","
                ."  \"ItemInfo.ContentRating\","
                ."  \"ItemInfo.Features\","
                ."  \"ItemInfo.ManufactureInfo\","
                ."  \"ItemInfo.ProductInfo\","
                ."  \"ItemInfo.TechnicalInfo\","
                ."  \"ItemInfo.Title\","
                ."  \"Offers.Listings.Price\","
                ."  \"Offers.Listings.SavingBasis\""
                ." ],"
                ." \"PartnerTag\": \"nint06-20\","
                ." \"PartnerType\": \"Associates\","
                ." \"Marketplace\": \"www.amazon.com\""
                ."}";
        $host="webservices.amazon.com";
        $uriPath="/paapi5/getitems";
        $awsv4 = new AwsV4 ($accessKey, $secretKey);
        $awsv4->setRegionName($region);
        $awsv4->setServiceName($serviceName);
        $awsv4->setPath ($uriPath);
        $awsv4->setPayload ($payload);
        $awsv4->setRequestMethod ("POST");
        $awsv4->addHeader ('content-encoding', 'amz-1.0');
        $awsv4->addHeader ('content-type', 'application/json; charset=utf-8');
        $awsv4->addHeader ('host', $host);
        $awsv4->addHeader ('x-amz-target', 'com.amazon.paapi5.v1.ProductAdvertisingAPIv1.GetItems');
        $headers = $awsv4->getHeaders ();
        $headerString = "";

        foreach ( $headers as $key => $value ) {
            $headerString .= $key . ': ' . $value . "\r\n";
        }

        $params = array (
                'http' => array (
                    'header' => $headerString,
                    'method' => 'POST',
                    'content' => $payload
                )
            );

        $stream = stream_context_create ( $params );

        $fp = @fopen ( 'https://'.$host.$uriPath, 'rb', false, $stream );

        if (! $fp) {
            throw new Exception ( "Exception Occured" );
        }

        $response = @stream_get_contents ( $fp );
        
        if ($response === false) {
            throw new Exception ( "Exception Occured" );
        }

        return $response;
    }
}



if (! function_exists('categoryBrand')){
    function categoryBrand($categoryName){
        $brand = '';
        $catArray = explode(' ', $categoryName);
        
        $brands = Config::get('phrases.brand');
        
        foreach($brands as $br){
            $br2 = strtolower($br);

            if(in_array($br2, $catArray) || in_array($br, $catArray)){
                return ucfirst($br);
            }

        }

        return $brand;

    }
}

if (! function_exists('processedProducts')) {
    function processedProducts($allProducts) {
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
            $p = $product->affiliate == 'Amazon' ? findInArray($productsA, $product->affiliate_code) : findInArray($productsNA, $product->affiliate_code);

            if($p) array_push($products, $p);
        }


        if(count($errors) > 0) PublicController::processErrors($errors);

        return $products;
    }
}

if (! function_exists('findInArray')) {
    function findInArray($array, $needle) {
        $result = null;
        for($i = 0; $i < count($array); $i++) {
            if($array[$i]->affiliate_code == $needle) {
                $result = $array[$i];
                break;
            }
        }

        return $result;
    }
}


if (! function_exists('processErrors')) {

}

