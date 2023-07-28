    @extends('layouts.basecat')

    @section('title', 'Random Items')

    @section('content')

    <div id="clip" onclick="closeVideoBig()">
    		<b class="close" onclick="closeVideoBig()">Close</b >
    		<video id="big-video" controls muted="muted"></video>
    		
    </div>

    <main class="album pt-5 bg-light">
		<div class="container text-center">
			<div class="input-group mb-3">
			  <input type="text" class="form-control" placeholder="Search" id="searchTerm" >
			  <div class="input-group-append">
			    <span class="input-group-text" id="basic-addon2" onclick="goSearch()">
			    	<img src="{{ asset('img/magnifying-glass-black.png') }}" alt="search">
			    </span>
			  </div>
			</div>

			<div id="resultstitle" class="mt-2 mb-2" style="display:none;">
				<h1><span id="numberresults"></span> results for '<span id="termspan"></span>': </h1>
			</div>

			<div class="row" id="prodsdiv" >
				

			</div>

			<div id="divref">

			</div>

			<div id="loading">
				<img src="{{ asset('img/loading.gif') }}" alt="Loading..." width="120" >
			</div>

			<div id="noResults" style="display:none;">
				<span>Sorry, no results.</span>
			</div>

			<div class="spacer"></div>
		</div>



	</main>

@include('layouts.jquery')

<script>


	function searchFor(term) {

		if(term.length) {
			reset();

			loading(true);

			let url = window.location.origin + '/searching/' + term;

			$.ajax({
	            url: url,
	            type : 'GET',
	            success: function(result){
	            	let res = JSON.parse(result);
	            	if(res.html.length) {
	            		$('#prodsdiv').append(res.html);
	            		$('#numberresults').html(res.total);
	            		mylikes.forEach(elem => deactivateLike(elem));            	
	            		setTimeout(resetReloaded, 500);
	            		$('#termspan').html(term);
	            		$('#resultstitle').css('display', 'block');
	            		loading(false);
	            	} else {
	            		$('#noResults').css('display', 'block');
	            		loading(false);
	            	}

	            	
	            },
	        });		
		}
        
	}

	function goSearch() {
		let term = $('#searchTerm').val();

		searchFor(term);
	}

	function reset() {
		//$('#searchTerm').val('');
		$('#prodsdiv').html('');
		$('#noResults').css('display', 'none');
		$('#resultstitle').css('display', 'none');
	}

	$(window).on('scroll', function(){

		stickyNavbar();
		
		let scrollPosition = $(window).scrollTop() + $(window).height();

		let pageSize = $('#prodsdiv').height();

		if(!reloaded && scrollPosition > pageSize) {
			reloaded = 1;
			loadMoreSearch();
		} 

	});


	$( document ).ready(function() {
		reloaded = 1;

		$('#searchTerm').on('keypress', function (e) {
	         if(e.which === 13){

	            //Disable textbox to prevent multiple submit
	            $(this).attr("disabled", "disabled");

	            goSearch();

	            //Enable the textbox again if needed.
	            $(this).removeAttr("disabled");
	         }
	    });
	    
	});



</script>

@endsection