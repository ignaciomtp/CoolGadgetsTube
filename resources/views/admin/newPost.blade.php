    @extends('layouts.baseadmin')

    @section('title', 'Page Title')

    @section('content')


      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Crear Post</h1>

      </div>

<form enctype="multipart/form-data" action="{{ route('createpost') }}" method="post">
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
        <input type="text" class="form-control" name="name" id="name" >

        <div class="mb-2">
          <label for="description">Descripción</label>
          <input type="text" class="form-control" name="description" id="description"  >
        </div>

        <div class="mb-2">
          <label for="text">Texto</label>
          <textarea name="text" id="text" class="form-control" cols="30" rows="6"></textarea>
          
        </div>

        <div class="mb-2 row">
          <div class="col-8">
            <label for="image">Imagen</label>
            <input type="file" class="form-control" name="image" id="image" >
          </div>

          <div class="col-4">
            <label for="icon">Icono</label>
            <input type="text" class="form-control" name="icon" id="icon" >
          </div>
          
        </div>

        <button class="btn btn-primary btn-lg btn-block" type="submit">Guardar</button>
      
    </div>

    <div class="col-md-6">     

      <h3>Tags</h3>
        <div class="cat-checks">
          @foreach($allTags as $tag)
          <div class="form-check2">
            <input class="form-check-input" type="checkbox" name="tags[]" id="{{ 'ck'.$tag->name }}" value="{{ $tag->id }}"/>
              <label class="form-check-label" for="{{ 'ck'.$tag->name }}">{{ $tag->name }}</label>
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
          <input class="form-control mr-sm-2" type="text" id="selectedProducts" name="products" >
        </div>

        <div>
          <ul id="searchResults">
            
          </ul>    
        </div>

        <hr>

        <h3>Relacionados</h3>
        <div class="row">
          <div class="col-3">
            <input type="text" class="form-control" name="related_1" >
          </div>
          <div class="col-3">
            <input type="text" class="form-control" name="related_2" >
          </div>
          <div class="col-3">
            <input type="text" class="form-control" name="related_3" >
          </div>
          <div class="col-3">
            <input type="text" class="form-control" name="related_4" >
          </div>
        </div>
    </div>
  </div>
</form>
@endsection

@include('admin.jqproduct');