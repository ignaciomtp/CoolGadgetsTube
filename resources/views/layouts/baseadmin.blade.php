<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>App Name - @yield('title')</title>

        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->

        <link rel="stylesheet" href="{{ URL::to('css/styles-admin.css') }}" />
        <link rel="stylesheet" href="{{ URL::to('css/app.css') }}" />
        <link rel="stylesheet" href="{{ URL::to('css/dashboard.css') }}" />


        <script
            src="https://code.jquery.com/jquery-3.4.1.slim.js"
            integrity="sha256-BTlTdQO9/fascB1drekrDVkaKd9PkwBymMlHOiG+qLI="
            crossorigin="anonymous"></script>

        <script src="{{ asset('js/app.js') }}" defer></script>
        
    </head>
    <body>

        <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
          <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">@yield('title')</a>
          <ul class="navbar-nav px-3">
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
          </ul>
        </nav>


<div class="container-fluid">
  <div class="row">
    <nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('admin') }}">
              <span data-feather="home"></span>
              Categorías 
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('products') }}">
              <span data-feather="file"></span>
              Productos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('menus') }}">
              <span data-feather="file"></span>
              Opciones Menú
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('tags') }}">
              <span data-feather="file"></span>
              Tags
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('posts') }}">
              <span data-feather="file"></span>
              Posts
            </a>
          </li>
        </ul>


      </div>
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      

        @yield('content')

    </main>
  </div>
</div>

    </body>
</html>