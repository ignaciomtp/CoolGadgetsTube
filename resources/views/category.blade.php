    @extends('layouts.basecat')

    @section('title', $cat->name)

    @section('content')

    <div id="clip" onclick="closeVideoBig()">
    		<b class="close" onclick="closeVideoBig()">Close</b >
    		<video id="big-video" controls muted="muted"></video>
    		
    </div>

    <main class="album pt-4 bg-light">
		<div class="container text-center">
			<div class="cat-img mb-4 sombra" style="--image:{{ $backimage }};" >
				<div class="cat-img-bgcolor p-3">
					<h1 class="titlecard mt-3 mb-5">Cool {{ $cat->name }}</h1>
					<p class=" cat-desc-text">
					 {{ $descriptionShort }}
					</p>
				</div>
			</div>

			
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
										{!! $prod->description !!}
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

			@if(isset($cat->description_long))
			<div class="white-back sombra p-3 mt-5 ">
				
				<div class="text-left categoryText">
					{!! $descriptionLong !!}
				</div>

			</div>
			@endif

			<div class="spacer"></div>

		</div>


		<input id="category" value="{{ $cat->slug }}" >
		<div class="dark-back text-center pt-3 pb-5 mb-0">
			<div class="container">
				<div class="row2  mt-2">
				@foreach($interlinks as $il)
					<div class="col-md-3 mt-3 mb-3">
						<a href="{{ route('categoria', ['category' => $il->slug]) }}" 
						  		title="{{ $il->name }}" >
							<h4>{{ $il->name }}</h4>
							<div class="white-back interlink p-2">
								<img src="{{ asset('img/categories/'. $il->image) }}" class="img-fluid" alt="{{ $il->name }}" />
								
							</div>
						</a>
					</div>
				@endforeach
				</div>
			</div>
		</div>
	</main>

@include('layouts.jquery')

@include('layouts.jquerycategory')

@endsection