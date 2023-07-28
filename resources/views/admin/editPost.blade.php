    @extends('layouts.baseadmin')

    @section('title', 'Page Title')

    @section('content')


      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Editar Post</h1>

      </div>

<form enctype="multipart/form-data" action="{{ route('updatepost', ['id' => $post->id]) }}" method="post">
      @csrf

      @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

  <div class="row">
    <div class="col-md-6">     

        <label for="nombre">Título</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ $post->name }}" >

        <div class="mb-2">
          <label for="description">Descripción</label>
          <input type="text" class="form-control" name="description" id="description" value="{{ $post->description }}" >
        </div>

        <div class="mb-2">
          <label for="text">Texto</label>
          <textarea name="text" id="text" class="form-control" cols="30" rows="6">
            {{ $post->text }}
          </textarea>
          
        </div>

        <div class="mb-2 row">
          <div class="col-8">
            <label for="image">Imagen</label>
            <input type="file" class="form-control" name="image" id="image" >
            <input type="text" class="form-control" value="{{ $post->image }}" readonly>
          </div>

          <div class="col-4">
            <label for="icon">Icono</label>
            <input type="text" class="form-control" name="icon" id="icon" value="{{ $post->icon }}">
          </div>
          
        </div>

        <button class="btn btn-primary btn-lg btn-block" type="submit">Guardar</button>
      
    </div>

    <div class="col-md-6">     

      <h3>Tags</h3>
        <div class="cat-checks">
          @foreach($allTags as $tag)
          <div class="form-check2">
            @if(in_array($tag->id, $currentTags))
              <input class="form-check-input" type="checkbox" name="tags[]" id="{{ 'ck'.$tag->name }}" value="{{ $tag->id }}" checked />
              <label class="form-check-label" for="{{ 'ck'.$tag->name }}">{{ $tag->name }}</label>
            @else
              <input class="form-check-input" type="checkbox" name="tags[]" id="{{ 'ck'.$tag->name }}" value="{{ $tag->id }}"/>
              <label class="form-check-label" for="{{ 'ck'.$tag->name }}">{{ $tag->name }}</label>
            @endif
          </div>
           @endforeach
        </div>

        <hr>

        <h3>Productos</h3>
        <div class="btn-group mb-3" >
          <input class="form-control mr-sm-2" type="text" id="busqueda" placeholder="buscar" >
          <button class="btn btn-outline-success my-2 my-sm-0" type="button" onclick="buscar()">Buscar</button>
        </div>

        <div class="btn-group mb-3">
          <input class="form-control mr-sm-2" type="text" id="selectedProducts" name="products" value="{{ implode(',', $prodsIds) }}" >
        </div>

        <div class="row">
          <div class="col-6">
            <ul id="searchResults">
            
            </ul>          
          </div>
          <div class="col-6">
            <ul>
              @foreach($post->products as $product)
              <li>{{ $product->name }}</li>
              @endforeach
            </ul>
          </div>

        </div>

        <hr>

        <h3>Relacionados</h3>
        <div class="row">
          <div class="col-3">
            <input type="text" class="form-control" name="related_1" value="{{ $post->related_1 }}">
          </div>
          <div class="col-3">
            <input type="text" class="form-control" name="related_2" value="{{ $post->related_2 }}">
          </div>
          <div class="col-3">
            <input type="text" class="form-control" name="related_3" value="{{ $post->related_3 }}">
          </div>
          <div class="col-3">
            <input type="text" class="form-control" name="related_4" value="{{ $post->related_4 }}">
          </div>
        </div>
    </div>
  </div>
</form>
@endsection

@include('admin.jqproduct');

