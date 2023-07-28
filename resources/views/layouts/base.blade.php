<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>★ CoolGadgetsTube.com ★ Cool Things You Didn’t Know You Needed</title>

        <meta name="description" content="😎 Discover the latest and coolest gadgets on Cool Gadgets Tube. Browse our collection of innovative and unique cool gadgets to enhance your lifestyle.">

        <meta name="msvalidate.01" content="E85E692F02DC20A672BF0373A508D0EC" />

        <meta name="p:domain_verify" content="8d0f4948cd30d77f949b5ddb886ac2ae"/>

        @if(isset($canon))
         {!! $canon !!}
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