<!DOCTYPE html>
<html>
<head>
	<title>Youtube</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  @include('ytlayouts.links')       
 

</head>
<body>
<!-- Top navbar -->
<nav class="container-fluid fixed-top bg-white pt-2" id="top_nav">
   	<div class="row">
  		<div class="col-4 pl-4">
    		<a class="navbar-brand" href="index.html"><img src="{{{ asset('images/logo.JPG') }}}"></a>
    	</div>
    	<div class="col-4">
    		<form action="result.html" method="get">
		    <div class="input-group mb-3">
			  <input type="text" class="form-control search" placeholder="Search">
			  <div class="input-group-append">
			    <button type="submit" class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" title="Search!"><i class="fas fa-search"></i></button>
			  </div>
			</div>
		</form>
		</div>
		<div class="col-4 text-right">
			<a href="login.html" class="btn btn-outline-primary"><i class="fas fa-user-circle" style="font-size: 20px;"></i> <span style="font-size:14px; font-weight: 600;">SIGN IN</span></a>
		</div>
	</div>
</nav>
<!-- Top navbar -->

<!-- mobile top navbar -->
<nav class="container-fluid fixed-top bg-white pt-3" id="top_nav_mobile">
   	<div class="row">
  		<div class="col-3 pl-4">
    		<a class="navbar-brand" href="index.html"><img src="images/logo.jpg" class="mb-2"></a>
    	</div>
    	<div class="col-7">
    		<form>
		    <div class="input-group mb-3">
			  <input type="text" class="form-control search" placeholder="Search">
			  <div class="input-group-append">
			    <button class="btn btn-outline-secondary" data-toggle="tooltip" data-placement="bottom" title="Search!"><i class="fas fa-search"></i></button>
			  </div>
			</div>
		</form>
		</div>
		<div class="col-2 text-right">
			<a href="login.html"><i class="fas fa-user-circle" style="font-size: 30px;"></i></a>
		</div>
	</div>
</nav>
<!-- mobile top navbar -->

@include('ytlayouts.sidebar')       