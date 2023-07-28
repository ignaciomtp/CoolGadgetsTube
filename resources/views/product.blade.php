    @extends('layouts.baseprod')

    @section('title', $product->name)

    @section('content')

    <div id="clip" onclick="closeVideoBig()">
            <b class="close" onclick="closeVideoBig()">Close</b >
            <video id="big-video" controls muted="muted"></video>
            
    </div>

    <main class="album pt-4 bg-light">
		<div class="container text-center">
            <div class="card-product-page row sombra mt-3">
                <div class="col-lg-6 col-md-12 p-3">
                    @if($product->video)
                    <div class="itemImg5 mb-3" onmouseover="showVideo({{ $product->id }})" onclick="loadVideoBig({{ $product->id }})" onmouseout="hideVideo({{ $product->id }})">
                        
                        <div class="vid-container" id="vid-{{ $product->id }}">
                            <video id="video{{ $product->id }}" src="{{ asset('vid/products/' . $product->video) }}" muted="muted" preload="none" width="100%" poster="{{ $product->image }}"></video>
                        </div>
                        <div class="fav-btn" id="likes-{{ $product->id }}" onclick="likeProduct(event, {{ $product->id }})" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="I love it!" data-bs-custom-class="custom-tooltip" >
                            {{ $product->likes }}
                        </div>
                        
                        @if($product->affiliate == 'Amazon')
                        <img loading="lazy" src="{{ $product->image }}" id="imgprod{{ $product->id }}" class="img-fluid " alt="{{ $product->nameShow }}" >
                        @else
                        <img loading="lazy" src="{{ asset('img/products/'.$product->image) }}" id="imgprod{{ $product->id }}" class="img-fluid " alt="{{ $product->nameShow }}" >
                        @endif
                        <img loading="lazy" src="{{ asset('img/play-600x520.png') }}" id="playbtn{{ $product->id }}" alt="Play Video" class="playbtn2" >
                        
                    </div>

                    @else
                    <div class="itemImg5 mb-3" >
                        <div class="fav-btn" id="likes-{{ $product->id }}" onclick="likeProduct(event, {{ $product->id }})" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="I love it!" >
                            {{ $product->likes }}
                        </div>
                        @if($product->affiliate == 'Amazon')
                        <img loading="lazy" src="{{ $product->image }}" id="imgprod{{ $product->id }}" class="img-fluid " alt="{{ $product->nameShow }}" >
                        @else
                        <img loading="lazy" src="{{ asset('img/products/'.$product->image) }}" id="imgprod{{ $product->id }}" class="img-fluid " alt="{{ $product->nameShow }}" >
                        @endif
                        
                    </div>

                    @endif      
                </div>
                <div class="col-lg-6 col-md-12 mb-3 p-3">
                    <h1>{{ $product->nameShow }}</h1>
                    <p class="mt-3 text-left product-page-desc" >{!! $product->description !!}</p>
                    
                    <div class="mt-3 " style="display: flex;">                       
                            <div class="col-8 text-left" style="padding-left: 0;">    
                                <span class="fb-share-button" data-href="{{ route('productPage', ['slug' => $product->slug]) }}">
                                    <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ route('productPage', ['slug' => $product->slug]) }}&amp;src=sdkpreparse" class=" fb-xfbml-parse-ignore share-btn" >
                                        <img loading="lazy" src="{{ asset('img/icono-facebook.gif') }}" alt="Facebook">
                                    </a>
                                </span>  
                                <a href="https://www.twitter.com/share?url={{ route('productPage', ['slug' => $product->slug]) }}"  target="_blank" class="share-btn">
                                    <img loading="lazy" src="{{ asset('img/icono-twitter.gif') }}" alt="Twitter">
                                </a>                                                                
                                <a href="https://api.whatsapp.com/send?text={{ route('productPage', ['slug' => $product->slug]) }}" target="_blank" class="share-btn">
                                    <img loading="lazy" src="{{ asset('img/icono-whatsapp.gif') }}" alt="Whatsapp">
                                </a>                                  
          
                            </div>

                            <div class="col-4 text-right " style="padding-right: 0;">
                                <span class="mr-2 pt-3" style="font-size: 1.3em; font-weight: bold">{{ $product->price }}</span>
                                
                            </div>     

                                            
                        
                    </div>

                    <div class="mt-3">
                        <a href="{{ $product->link }}" 
                                            title="{{ $product->name }}" 
                                            rel="nofollow" target="_blank" class="btn btn-lg btn-block btn-post">Check it out in {{ $product->affiliate }}<i class="ml-2 fab fa-{{ strtolower($product->affiliate) }} "></i>
                                </a>   
                    </div>
                </div>
            </div>
			

            <div class="row mt-5" style="padding: 0;">
                <h2 class="titlecard">Consider these other Cool Gadgets</h2>
                @foreach($relatedProds as $prod)
                        <div class="col-sm-12 col-md-6 col-lg-4">
                          <div class="card mb-4 sombra">
                            
                            <div class="card-body">

                                @if($prod->video)
                                <div class="itemImg mb-3" onmouseover="showVideo({{ $prod->id }})" onclick="loadVideoBig({{ $prod->id }})" onmouseout="hideVideo({{ $prod->id }})">
                                    
                                    <div class=" " id="vid-{{ $prod->id }}">
                                        <video id="video{{ $prod->id }}" src="{{ asset('vid/products/' . $prod->video) }}" muted="muted" preload="none" width="310" poster="{{ $prod->image }}"></video>
                                    </div>
                                    <div class="fav-btn" id="likes-{{ $prod->id }}" onclick="likeProduct(event, {{ $prod->id }})" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="I love it!" data-bs-custom-class="custom-tooltip" >
                                        {{ $prod->likes }}
                                    </div>
                                    
                                    @if($prod->affiliate == 'Amazon')
                                    <img loading="lazy" src="{{ $prod->image }}" id="imgprod{{ $prod->id }}" class="img-fluid product-img" alt="{{ $prod->nameShow }}" >
                                    @else
                                    <img loading="lazy" src="{{ asset('img/products/'.$prod->image) }}" id="imgprod{{ $prod->id }}" class="img-fluid product-img" alt="{{ $prod->nameShow }}" >
                                    @endif
                                    <img loading="lazy" src="{{ asset('img/play4.png') }}" id="playbtn{{ $prod->id }}" alt="Play Video" class="playbtn" >
                                    
                                </div>

                                @else
                                <div class="itemImg3 mb-3" >
                                    <div class="fav-btn" id="likes-{{ $prod->id }}" onclick="likeProduct(event, {{ $prod->id }})" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="I love it!" >
                                        {{ $prod->likes }}
                                    </div>
                                    @if($prod->affiliate == 'Amazon')
                                    <img loading="lazy" src="{{ $prod->image }}" id="imgprod{{ $prod->id }}" class="img-fluid product-img" alt="{{ $prod->nameShow }}" >
                                    @else
                                    <img loading="lazy" src="{{ asset('img/products/'.$prod->image) }}" id="imgprod{{ $prod->id }}" class="img-fluid product-img" alt="{{ $prod->nameShow }}" >
                                    @endif
                                    
                                </div>

                                @endif                      

                                <div class="cat-title">
                                    <a href="{{ route('productPage', ['slug' => $prod->slug]) }}" title="{{ $prod->name }}"  >
                                    {{ $prod->nameShow }}
                                    </a>
                                </div>

                                <div class="text-left">
                                    <p class="cutoff-text2 " >
                                        {{ $prod->description }}
                                    </p>    
                                    <input type="checkbox" class="expand-btn text-center almost-half">
                                    <a href="{{ $prod->link }}" 
                                        title="{{ $prod->name }}" 
                                        rel="nofollow" target="_blank" class="boton-comprar-amz almost-half float-right" >
                                            Buy Now
                                            
                                    </a>
                                </div>
                                
                            </div>
                          </div>
                        </div>

                    @endforeach
            </div> <!-- prodsdiv -->


        </div>

    <div class="spacer"></div>

    </main>

@include('layouts.jquery')

@include('layouts.jquerycategory')

@endsection