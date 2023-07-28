    @extends('layouts.basecat')

    @section('title', 'Blog')

    @section('content')

    <main class="album pt-4 bg-light">
        <div class="container text-center ">
            @if(isset($tagName))
            <h1 class="mt-3 mb-3">{{ $tagName }}</h1>
            @else
            <h1 class="mt-3 mb-3">Blog</h1>
            @endif
            

            <div class="row">
                <div class="col-md-8 ">
                    @foreach($posts as $post)
                    <div class="card mb-5 blogcard sombra" >
                      <img src="{{ asset('img/posts/'.$post->image) }}" class="card-img-top" alt="{{ $post->name }}">
                      <div class="card-body text-left">
                        <a href="{{ route('blogpost', ['slug' => $post->slug]) }}">
                            <h3 class="card-title">{{ $post->name }}</h3>
                        </a>
                        
                        <p class="blogtext">{{ substr($post->text, 3, 225) }}...</p>
                        <a href="{{ route('blogpost', ['slug' => $post->slug]) }}" class="btn danger2 btn-block">Read More...</a>
                      </div>
                    </div>
                    @endforeach

                    {!! $posts->links() !!}

                    <div class="spacer"></div>
                </div>
                <div class="col-md-4">
                    <div id="blogsidebar">
                        <div class="card text-left p-3 sombra">
                            <form class="form-inline mt-2 mt-0 mb-4" method="get" action="{{ route('blogsearch') }}">
                            <div class="input-group">
                              <input type="text" class="form-control" name="term" placeholder="Search" >
                              <div class="input-group-append">
                                
                                    <button type="submit" class="input-group-text" >
                                        <img src="{{ asset('img/magnifying-glass-black.png') }}" alt="search">
                                    </button>
                                
                              </div>
                            </div>        
                            </form>

                            <h4>Latest Posts</h4>
                            <div class="side-box mb-4">
                                @foreach($latestPosts as $lp)
                                <div class="row2 mb-3"  style="justify-content: space-between;">
                                    <a href="{{ route('blogpost', ['slug' => $lp->slug]) }}" class="mb-2">
                                        <img src="{{ asset('img/posts/'.$lp->image) }}" class="sidethumb" alt="{{ $lp->image }}">
                                    </a>
                                    <div class="pl-2 sidetitle" >
                                        <a href="{{ route('blogpost', ['slug' => $lp->slug]) }}">
                                            <h5 >{{ $lp->name }}</h5>
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
<!--
                            <h4>Tags</h4>
                            <div class="mb-3 tag-container">
                                @foreach($tags as $tag)
                                <a href="{{ route('blogtag', ['tagslug' => $tag->slug]) }}">
                                    <span class="badge tagpill danger2"><i class="fa fa-tag mr-2"></i>{{ $tag->name }}</span>
                                </a>
                                @endforeach
                            </div>       
-->                                
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="spacer"></div>
    </main>

    @include('layouts.jquery')

    @include('layouts.jqueryindex')

    @endsection