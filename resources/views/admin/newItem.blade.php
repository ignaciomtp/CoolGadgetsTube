    @extends('layouts.baseadmin')

    @section('title', 'Page Title')

    @section('content')


      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Añadir Producto</h1>

      </div>

<form enctype="multipart/form-data" action="{{ route('createproduct') }}" method="post">
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

        <div class="row mb-2">
          <div class="col-md-6">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" name="name" id="name" >
          </div>

          <div class="col-md-6">
            <label for="price">Precio</label>
            <input type="text" class="form-control" name="price" id="price" >
          </div>
          
        </div>

        <div class="row mb-2">
          <div class="col-md-6">
            <label for="affiliate">Afiliado</label>
           
            <select class="form-control" name="affiliate" id="affiliate">
              @foreach($affiliates as $af)
                <option value="{{ $af }}"  >{{ $af }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-md-6">
            <label for="code">Código</label>
            <input type="text" class="form-control" name="affiliate_code" id="code" required>
          </div>          
        </div>

        <div class="mb-2">
          <label for="description_long">Descripción</label>
          <textarea name="description_long" id="description_long" class="form-control" cols="30" rows="4"></textarea>
          
        </div>

        <div class="row mb-2">
          <div class="col-md-6">
            <label for="image">Imagen</label>
            <input type="file" class="form-control" name="image" id="image" >
          </div>

          <div class="col-md-6">
            <label for="video">Video</label>
            <input type="file" class="form-control" name="video" id="video" >
          </div>        
        </div>

        <div class="mb-4">
          <label for="link">Link</label>
          <input type="text" class="form-control" name="link" id="link" >
          
        </div>

        <button class="btn btn-primary btn-lg btn-block" type="submit">Guardar</button>
      
    </div>

    <div class="col-md-6">     
      <h3>Categorías</h3>
        <div class="cat-checks">
          @foreach($allCategories as $cat)
          <div class="form-check2">
            <input class="form-check-input" type="checkbox" name="categories[]" id="{{ 'ck'.$cat->name }}" value="{{ $cat->id }}"/>
              <label class="form-check-label" for="{{ 'ck'.$cat->name }}">{{ $cat->name }}</label>
          </div>
          @endforeach
      </div>
      <h3>Tags</h3>
        <div class="cat-checks">
          @foreach($allTags as $tag)
          <div class="form-check2">
            <input class="form-check-input" type="checkbox" name="tags[]" id="{{ 'ck'.$tag->name }}" value="{{ $tag->id }}"/>
              <label class="form-check-label" for="{{ 'ck'.$tag->name }}">{{ $tag->name }}</label>
          </div>
          @endforeach
      </div>
    </div>
  </div>
</form>
@endsection