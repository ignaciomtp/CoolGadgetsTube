    @extends('layouts.basepost')

    @section('title', 'Blog')

    @section('content')

    <div id="clip" onclick="closeVideoBig()">
            <b class="close" onclick="closeVideoBig()">Close</b >
            <video id="big-video" controls muted="muted"></video>
            
    </div>

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
     
                            <span class="fb-share-button" data-href="{{ $post->slug }}">
                                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ route('blogpost', ['slug' => $post->slug]) }}&amp;src=sdkpreparse" >
                                    <img loading="lazy" src="{{ asset('img/icono-facebook.gif') }}" alt="Facebook" width="32">
                                </a>
                            </span>


                            <a href="https://www.twitter.com/share?url={{ route('blogpost', ['slug' => $post->slug]) }}"  target="_blank">
                                <img loading="lazy" src="{{ asset('img/icono-twitter.gif') }}" alt="Twitter" width="32">
                            </a -->

                            <a href="https://api.whatsapp.com/send?text={{ route('blogpost', ['slug' => $post->slug]) }}" target="_blank" >
                                <img loading="lazy" src="{{ asset('img/icono-whatsapp.gif') }}" alt="Whatsapp" width="32">
                            </a>    

                        </div>

                        <div class="blogtext " id="blogtext">
                            {!! $finalText !!}
                        </div>

                        <div id="loading" class="mb-4">
                            <img src="{{ asset('img/loading.gif') }}" alt="Loading..." width="120" >
                        </div>

                        <div class="mt-3 mb-3 tag-container">
                            @foreach($post->tags as $tag)
                            <a href="{{ route('blogtag', ['tagslug' => $tag->slug]) }}">
                                <span class="badge tagpill danger2"><i class="fa fa-tag mr-2"></i>{{ $tag->name }}</span>
                            </a>
                            @endforeach
                        </div>           

                        <hr>

                        <div class="spacer"></div>

                    </div>              
                </div>

            </div>         


            @if(count($related) > 0)
            <h3>Related Articles</h3>
            <div class="row">
                @foreach($related as $rel)
                <div class="col-md-3 col-sm-12">
                    <div class="card sombra" >
                        <a href="{{ route('blogpost', ['slug' => $rel->slug]) }}">
                            <img class="img-fluid post-img" src="{{ asset('img/posts/'.$rel->image) }}" alt="{{ $rel->name }}">
                        </a>
                      <div class="card-body">
                        <a href="{{ route('blogpost', ['slug' => $rel->slug]) }}" title="{{ $rel->name }}" >
                            <h4 class="card-title related-title" >{{ strlen($rel->name) > 98 ? substr($rel->name, 0, 95).'...' : $rel->name }}</h4>
                        </a>
                      </div>
                    </div>
                </div>
                @endforeach 

            </div>
            @endif

            <div class="spacer"></div>
            <div style="visibility: hidden;">
                <input id="posttagsslugs" value="{{ $tagsString }}" >
            </div>
            
        </div>
    </main>

    @include('layouts.jquery')

    @include('layouts.jquerypost')

    @endsection