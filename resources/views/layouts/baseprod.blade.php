<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <title>★ {{ $product->nameShow }} 😎 ★ Cool Gadgets Tube </title>

        <meta name="description" content="{{ substr($product->description, 0, 155).'...' }}">
        
        @include('layouts.links')

        @include('layouts.analytics')
        
    </head>
    <body>
        @include('layouts.header')

        @yield('content')

        @include('layouts.footer')

    </body>
</html>