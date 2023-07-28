    @extends('layouts.basepost')

    @section('title', 'Blog')

    @section('content')

    <main class="album pt-4 bg-light">
        <div class="container ">   
            <div class="row">
                <div class="col-md-12">
                    <div class="text-left">
                        <div class="text-center">
                            <img src="{{ asset('img/posts/'.$post->image) }}" class="img-fluid" alt="{{ $post->name }}">
                        </div>
                        
                        <h1 class="mt-3">{{ $post->name }}</h1>

                        <div class="updated">Updated: {{ date_format($post->updated_at, 'M d Y') }}</div>

                        <div class="mt-3 mb-3 share-post">
                            <div>Share this: </div>                             
                                            
                            <a href="https://www.twitter.com/share?url={{ app()->basePath('/blog/' . $post->slug)  }}"  target="_blank">
                                <img loading="lazy" src="{{ asset('img/icono-twitter.gif') }}" alt="Twitter" width="32">
                            </a -->
                        
                            <span class="fb-share-button" data-href="{{ $post->slug }}">
                                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ app()->basePath('/blog/' . $post->slug) }}&amp;src=sdkpreparse" >
                                    <img loading="lazy" src="{{ asset('img/icono-facebook.gif') }}" alt="Facebook" width="32">
                                </a>
                            </span>
                        </div>

                        <div class="blogtext " id="blogtext">
                            {!! $finalText !!}
                        </div>

        

                        <hr>

                        <div class="spacer"></div>

                    </div>              
                </div>

            </div>         




            <div class="spacer"></div>

            
        </div>
    </main>


    @endsection