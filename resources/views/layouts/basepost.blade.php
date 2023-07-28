<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        
        @if(isset($post))
            <title>★ {{ $post->name }} ★ CoolGadgetsTube.com</title>
            <meta name="description" content="{{ $post->icon ? $post->icon : '😎' }} {{ $post->description }}">                             
        @else
            <title>★ CoolGadgetsTube.com ★ Cool Things You Didn’t Know You Needed</title>

            <meta name="description" content="Check out the best collection of cool things you can buy online. Tech gadgets, funny gifts, useful gizmos and geeky products, you’ll decide you need them all.">
            
        @endif


        @include('layouts.links')

        @include('layouts.analytics')        
        
    </head>
    <body>
        @include('layouts.header')

        @yield('content')

        @include('layouts.footer')

    </body>
</html>