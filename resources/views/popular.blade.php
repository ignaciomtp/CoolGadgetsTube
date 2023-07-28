    @extends('layouts.basecat')

    @section('title', 'Most Popular Items')

    @section('content')

    <div id="clip" onclick="closeVideoBig()">
    		<b class="close" onclick="closeVideoBig()">Close</b >
    		<video id="big-video" controls muted="muted"></video>
    		
    </div>

    <main class="album pt-4 bg-light">
		<div class="container text-center">
			<h1>Most Popular </h1>

			<div class="row mt-3" id="prodsdiv">
				@foreach($products as $prod)
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

			</div>

			<div id="divref">

			</div>

			<div id="loading" class="mb-4">
				<img src="{{ asset('img/loading.gif') }}" alt="Loading..." width="120" >
			</div>

			<br>

		</div>

		<div class="dark-back text-center pt-3 pb-5 mt-4 mb-0">
			<div class="container">

				<input id="category" value="popular" >
			</div>
		</div>

	</main>

@include('layouts.jquery')

@include('layouts.jquerycategory')

@endsection