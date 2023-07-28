<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        
        @if(isset($cat))
            <title>★ Cool {{ $cat->name }} ★ - CoolGadgetsTube.com</title>
            <meta name="description" content="{{ $cat->icon ? $cat->icon : '😎' }} {{ $cat->description_short }}">                   

        @elseif(isset($tg))
            <title>★ {{ $tg->name }} ★ CoolGadgetsTube.com</title>

            @if(isset($tg->description))
            <meta name="description" content="{{ $tg->icon ? $tg->icon : '😎' }} {{ $tg->description }}"> 
            @else
            <meta name="description" content="{{ $tg->icon ? $tg->icon : '😎' }} Check out the best collection of cool things you can buy online. Tech gadgets, funny gifts, useful gizmos and geeky products, you’ll decide you need them all.">
            @endif    
            
        @else
            <title>★ {{ $title ?? '' }} ★ CoolGadgetsTube.com</title>
                
            @if(isset($description))
            <meta name="description" content="{{ $description }}"> 
            @else
            <meta name="description" content="Check out the best collection of cool things you can buy online. Tech gadgets, funny gifts, useful gizmos and geeky products, you’ll decide you need them all.">
            @endif  
            
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