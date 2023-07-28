    @extends('layouts.base')

    @section('title', 'Home')

    @section('content')

    <div id="clip" onclick="closeVideoBig()">
    		<b class="close" onclick="closeVideoBig()">Close</b >
    		<video id="big-video" controls muted="muted"></video>
    		
    </div>

    <main class="album pt-4 bg-light">
		<div class="container text-center ">
			<div class="cat-img mb-4 sombra" style="--image: var(--gadgets);" >
				<div class="cat-img-bgcolor p-3">
					<h1 class="titlecard mt-3 mb-5">Cool Gadgets Tube</h1>
					<p class=" cat-desc-text">
					Welcome to CoolGadgetsTube. We are a website dedicated to discovering the coolest gadgets and things you can buy online. Discover our carefully curated collection of unique gadgets, useful gizmos, funny gifts and geeky products.
					</p>				
				</div>
			</div>

			<div class="row mt-5" >
				<h2 class="titlecard">LATEST GADGETS</h2>
				@foreach($products as $prod)
						<div class="col-sm-12 col-md-6 col-lg-4">
						  <div class="card mb-4 sombra">
						  	
						    <div class="card-body">

						    	@if($prod->video)
						    	<div class="itemImg mb-3" onmouseover="showVideo({{ $prod->id }})" onclick="loadVideoBig({{ $prod->id }})" onmouseout="hideVideo({{ $prod->id }})">
						    		
						    		<div class="vid-container" id="vid-{{ $prod->id }}">
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
			</div> <!-- prodsdiv -->

			<div class="mt-5 mb-5">
				<a href="{{ route('latest') }}" class=" btn-seemore">See More Gadgets</a>
			</div>

		</div>

			<hr>

			<div class="mt-3 mb-3 container">
				<div class="flex flex-fluid">
					<article class="featured-item">
						<div class="featured-wrapper mh-360">
							<a href="{{ route('categoria', ['category' => 'useful-gadgets']) }}">
								<img width="333" height="360" src="{{ asset('img/cover/useful.jpg') }}" alt="Useful Gadgets">
								<h3 class="entry-title">Cool Useful Gadgets</h3>
							</a>
						</div>
					</article>
					<article class="featured-item">
						<div class="featured-wrapper mh-360">
							<a href="{{ route('categoria', ['category' => 'car-gadgets']) }}">
								<img width="333" height="360" src="{{ asset('img/cover/car-gadgets.jpg') }}" alt="Car Gadgets">
								<h3 class="entry-title">Cool Car Gadgets</h3>
							</a>
						</div>
					</article>
					<article class="featured-item">
						<div class="featured-wrapper mh-360">
							<a href="{{ route('categoria', ['category' => 'tech-gadgets']) }}">
								<img width="333" height="360" src="{{ asset('img/cover/tech.webp') }}" alt="Tech Gadgets">
								<h3 class="entry-title">Cool Tech Gadgets</h3>
							</a>
						</div>
					</article>
					<article class="featured-item">
						<div class="featured-wrapper mh-360">
							<a href="{{ route('categoria', ['category' => 'home-gadgets']) }}">
								<img width="333" height="360" src="{{ asset('img/cover/home.webp') }}" alt="Home Gadgets">
								<h3 class="entry-title">Cool Home Gadgets</h3>
							</a>
						</div>
					</article>
					<article class="featured-item">
						<div class="featured-wrapper mh-360">
							<a href="{{ route('categoria', ['category' => 'office-gadgets']) }}">
								<img width="333" height="360" src="{{ asset('img/cover/office.jpg') }}" alt="Office Gadgets">
								<h3 class="entry-title">Cool Office Gadgets</h3>
							</a>
						</div>
					</article>
					<article class="featured-item">
						<div class="featured-wrapper mh-360">
							<a href="{{ route('categoria', ['category' => 'kitchen-gadgets']) }}">
								<img width="333" height="360" src="{{ asset('img/cover/kitchen.webp') }}" alt="Kitchen Gadgets">
								<h3 class="entry-title">Cool Kitchen Gadgets</h3>
							</a>
						</div>
					</article>
				</div>
			</div>

			<hr>

			<div class="container text-center mt-5">
				<h2 class="titlecard">BEST GADGETS</h2>
				<p class="cat-desc-text">
					These are the top gadgets on our site, as rated by our users. 
				</p>

				<div class="row mt-3" id="prodsdiv">

				</div>

				<div id="divref">

				</div>

				<div id="loading" class="mb-4">
					<img src="{{ asset('img/loading.gif') }}" alt="Loading..." width="120" >
				</div>

				<div class="mt-5 mb-5 pb-5 borderbottom" >
					<a href="{{ route('popular') }}" class="btn-seemore">See Best Rated Gadgets</a>
				</div>

				<!-- cluster user -->
				<div class="row mt-3 pb-5 borderbottom">
					<div class="col-md-4 col-sm-6">
			          <div class="card mb-4 shadow-sm cat">
			          	<a href="{{ route('categoria', ['category' => 'gadgets-for-men']) }}" title="Cool Gadgets for Men">
				          	<img src="{{ asset('img/cover/men-gadgets.jpg') }}" class="img-fluid card-img-top" width="100%" alt="Cool Gadgets for Men" />
				            <div class="card-body">
				              <h3 class="title-for">
				              	Gadgets For Men
				              </h3>
			
				            </div>
				        </a>
			          </div>
			        </div>

			        <div class="col-md-4 col-sm-6">
			          <div class="card mb-4 shadow-sm cat">
			          	<a href="{{ route('categoria', ['category' => 'gadgets-for-women']) }}" title="Cool Gadgets for Women">
				          	<img src="{{ asset('img/cover/women-gadgets.jpg') }}" class="img-fluid card-img-top" width="100%" alt="Cool Gadgets For Women" />
				            <div class="card-body">
				              <h3 class="title-for">
				              	Gadgets For Women
				              </h3>
				     
				            </div>
				        </a>
			          </div>
			        </div>

					<div class="col-md-4 col-sm-6">
			          <div class="card mb-4 shadow-sm cat">
			          	<a href="{{ route('categoria', ['category' => 'gadgets-for-kids']) }}" title="Cool Gadgets For Kids">
				          	<img src="{{ asset('img/cover/kids-gadgets.jpg') }}" class="img-fluid card-img-top" width="100%" alt="Cool Gadgets For Kids" />
				            <div class="card-body">
				              <h3 class="title-for">
				              	Gadgets For Kids
				              </h3>
				        
				            </div>
				        </a>
			          </div>
			        </div>

			        <div class="col-md-4 col-sm-6">
			          <div class="card mb-4 shadow-sm cat">
			          	<a href="{{ route('categoria', ['category' => 'gadgets-for-geeks']) }}" title="Cool Gadgets For Geeks">
				          	<img src="{{ asset('img/cover/geek-gadgets.jpg') }}" class="img-fluid card-img-top" width="100%"  alt="Cool Gadgets For Geeks" />
				            <div class="card-body">
				              <h3 class="title-for">
				              	Gadgets For Geeks
				              </h3>
				           
				            </div>
				        </a>
			          </div>
			        </div>

			        <div class="col-md-4 col-sm-6">
			          <div class="card mb-4 shadow-sm cat">
			          	<a href="{{ route('categoria', ['category' => 'gadgets-for-gamers']) }}" title="Cool Gadgets For Gamers">
				          	<img src="{{ asset('img/cover/gamers-gadgets.jpg') }}" class="img-fluid card-img-top" width="100%" alt="Cool Gadgets For Gamers" />
				            <div class="card-body">
				              <h3 class="title-for">
				              	Gadgets For Gamers
				              </h3>
				              
				            </div>
				        </a>
			          </div>
			        </div>

			        <div class="col-md-4 col-sm-6">
			          <div class="card mb-4 shadow-sm cat">
			          	<a href="{{ route('categoria', ['category' => 'gadgets-for-pets']) }}" title="Gadgets For Pets">
				          	<img src="{{ asset('img/cover/pet-gadgets.jpg') }}" class="img-fluid card-img-top" width="100%"  alt="Cool Gadgets For Pets" />
				            <div class="card-body">
				              <h3 class="title-for">
				              	Gadgets For Pets
				              </h3>
				              
				            </div>
				        </a>
			          </div>
			        </div>

				</div>
				<!-- end cluster user -->

				<div class="mt-5 mb-5">
					<h3>Check Out Our Unique Gifts and Gadgets</h3>
					<p class="justified">In the 21st century, cool gadgets have become a lifeline for some of us. From smart home devices to Internet-based fitness trackers, cool tech is everywhere in our lives. The best part is that they make mundane tasks much easier - they're like tiny robots working around the clock! Whether you need convenience or just a cool tool to show off to friends, there's something on our website for everyone. From voice activated subwoofers to robotic vacuums that scour your floors while you sleep, we collect the best gadgets on Amazon for you. So don't be afraid to take advantage of the latest and greatest - if it makes your life easier, it's worth considering!
					</p>
				</div>

<div class="container">
<div class="accordion accordion-flush" id="accordionGadget">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
        What is a Gadget?
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionGadget">
      <div class="accordion-body" style="font-size: 1.1rem;">Basically, a small tool or device that does something useful.</div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
        What kind of gadgets we feature
      </button>
    </h2>
    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionGadget">
      <div class="accordion-body" style="font-size: 1.1rem;">We specialize in <strong>unique gifts and gadgets</strong>. Amazingly useful devices that make your life easier, and you probably didn't know they existed. We also have fun, original gifts.
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingThree">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
        Affiliate Disclosure
      </button>
    </h2>
    <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionGadget">
      <div class="accordion-body" style="font-size: 1.1rem;">
      	Yes, we receive compensation when you purchase products from links on our site. We do not sell products, only link to sites that do. We collect the <strong>best gadgets on Amazon</strong> and other websites for you.
      </div>
    </div>
  </div>
</div>
</div>

<div class="spacer"></div>

		@if(count($posts) > 0)
				<div class="row mb-5" id="posts-bar" style="justify-content: space-between;">
					<h2>Latest Blog Posts</h2>
					@foreach($posts as $post)
					<article class="featured-item dilb">
						<div class="featured-wrapper ">
							<a href="{{ route('blogpost', ['slug' => $post->slug]) }}" class="cover-post featured-item">
								<img src="{{ asset('img/posts/'.$post->image) }}" alt="{{ $post->name }}">
								<h4 class="post-title">{{ $post->name }}</h4>
							</a>
						</div>
					</article>
					@endforeach
				</div>

				<div class="mt-5 mb-5">
					<a href="{{ route('blog') }}" class="btn-seemore">See All Blog Posts</a>
				</div>

			</div>
		@endif

<input id="category" value="popular" >


	</main>

	@include('layouts.jquery')

	@include('layouts.jqueryindex')

    @endsection