<header >
  <div class="header text-center">
    <a href="{{ route('inicio') }}" >
    	<span>Cool<span style="color:#ff0000;">Gadgets</span>Tube</span>
    </a>
    <div class="subtitle">
      COOL THINGS YOU DIDN'T KNOW YOU NEEDED
    </div>
  </div>

  <nav class="navbar navbar-expand-lg navbar-dark bg-black">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <span id="logosmall">
      <a href="{{ route('inicio') }}" >
        Cool<span>Gadgets</span>Tube
      </a>
    </span>

    <div class="collapse navbar-collapse justify-content-md-center" id="navbarsExample08">
      <ul class="navbar-nav">

      	<li class="nav-item nav-item-icon" id="navhome">
          <a class="nav-link" href="{{ route('inicio') }}"  >HOME</a>
        </li>
        <li class="nav-item nav-item-icon" id="navfavs">
          <a class="nav-link" href="{{ route('popular') }}"  >MOST POPULAR</a>
        </li>
        <li class="nav-item nav-item-icon" id="navrandom">
          <a class="nav-link" href="{{ route('random') }}"  >RANDOM</a>
        </li>

        <li class="nav-item nav-item-icon dropdown" id="navcategory">
            <a class="nav-link dropdown-toggle" href="#" id="d2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{ strtoupper ($menuItems[2]->name) }}
            </a>
            <div class="dropdown-menu" aria-labelledby="d2">
              @foreach($menuItems[2]->categories as $cat)
              <a class="dropdown-item" href="{{ route('categoria', ['category' => $cat->slug]) }}">
                {{ $cat->name }}
              </a>
              @endforeach
            </div>
        </li>

        <li class="nav-item nav-item-icon dropdown" id="navsmartphone">
            <a class="nav-link dropdown-toggle" href="#" id="dd2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             GADGETS BY USER
            </a>
            <div class="dropdown-menu" aria-labelledby="dd2">
              @foreach($menuItems[0]->categories as $cat)
              <a class="dropdown-item" href="{{ route('categoria', ['category' => $cat->slug]) }}">
                {{ $cat->name }}
              </a>
              @endforeach
            </div>
        </li>


        <li class="nav-item nav-item-icon" id="navsearch">
          <a class="nav-link" href="{{ route('search') }}"  >SEARCH</a>
        </li>
        <!-- <li class="nav-item nav-item-icon" id="navhall">
          <a class="nav-link" href="{{ route('tag', ['tagslug' => 'halloween-stuff']) }}"  >HALLOWEEN</a>
        </li>  --> 

        <li class="nav-item nav-item-icon" id="navblog">
          <a class="nav-link" href="{{ route('blog') }}"  >BLOG</a>
        </li>
  		
      </ul>
    </div>

  </nav>
</header>