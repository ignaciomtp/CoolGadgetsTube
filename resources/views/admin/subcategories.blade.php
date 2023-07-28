    @extends('layouts.base')

    @section('title', 'Page Title')

    @section('content')

    <div class="album py-5 bg-light">
		<div class="container text-center">
			<h1>{{ $category->category }}</h1>

			<div class="row">
				@foreach($subcategories as $subcat)
					<div class="card mb-4 shadow-sm">
	                    <div class="card-header">
	                      <h4 class="my-0 font-weight-normal">{{ $subcat->category }}</h4>
	                    </div>
	                    <div class="card-body">
	                      

	                      <a href="{{ url('/category/'.$subcat->id) }}" 
	                        class="btn btn-lg btn-block btn-outline-primary">{{ $subcat->category }}</a>
	                    </div>
	                 </div>

				@endforeach

			</div>
		</div>
	</div>
    @endsection