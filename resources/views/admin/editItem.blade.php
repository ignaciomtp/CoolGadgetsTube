    @extends('layouts.baseadmin')

    @section('title', 'Page Title')

    @section('content')


      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Editar Artículo</h1>

      </div>

<form enctype="multipart/form-data" action="{{ route('updateproduct', ['id' => $product->id]) }}" method="post">
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
            <input type="text" class="form-control" name="name" id="name" value="{{ $product->name }}" >
          </div>

          <div class="col-md-6">
            <label for="price">Precio</label>
            <input type="text" class="form-control" name="price" id="price" value="{{ $product->price }}" >
          </div>
          
        </div>

        <div class="row mb-2">
          <div class="col-md-6">
            <label for="affiliate">Afiliado</label>
           
            <select class="form-control" name="affiliate" id="affiliate">
              @foreach($affiliates as $af)
                <option value="{{ $af }}" 
                  @if($af == $product->affiliate) 
                    selected="selected"
                  @endif
                >
                  {{ $af }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="col-md-6">
            <label for="code">Código</label>
            <input type="text" class="form-control" name="affiliate_code" id="code" value="{{ $product->affiliate_code }}" required>
          </div>          
        </div>


        <div class="mb-2">
          <label for="description">Descripción</label>
          <textarea name="description_long" id="description_long" class="form-control" cols="30" rows="4">
            {{ $product->description_long }}
          </textarea>
          
        </div>

        <div class="row mb-2">
          <div class="col-md-6">
            <label for="image">Imagen</label>
            @if($product->image)
              <img src="{{ $product->image }}" class="img-thumbnail" >
            @endif
            <input type="file" class="form-control" name="image" id="image" >
          </div>

          <div class="col-md-6">
            <label for="video">Video: @if($product->video) {{ $product->video }}  @endif</label>
            <input type="file" class="form-control" name="video" id="video" >
          </div>        
        </div>

        <div class="row mb-4">
          <div class="col-md-6">
            <label for="image2">Imagen 2</label>
            @if($product->image2)
              <img src="{{ $product->image2 }}" class="img-thumbnail" >
            @endif
            <input type="file" class="form-control" name="image2" id="image2" >
          </div>
          <div class="col-md-6">
            <label for="link">Link</label>
            <input type="text" class="form-control" name="link" id="link" value="{{ $product->link }}" >
          </div>
          
          
        </div>

          <button class="btn btn-primary btn-lg btn-block" type="submit">Guardar</button>
       
      </div>


      <div class="col-md-6">
        <h3>Categorías</h3>
        <div class="cat-checks">
          @foreach($allCategories as $cat)
          <div class="form-check2">
            @if(in_array($cat->id, $currentCats))
              <input class="form-check-input" type="checkbox" name="categories[]" id="{{ 'ck'.$cat->slug }}" value="{{ $cat->id }}" checked />
              <label class="form-check-label" for="{{ 'ck'.$cat->name }}">{{ $cat->name }}</label>
            @else
              <input class="form-check-input" type="checkbox" name="categories[]" id="{{ 'ck'.$cat->slug }}" value="{{ $cat->id }}"/>
              <label class="form-check-label" for="{{ 'ck'.$cat->name }}">{{ $cat->name }}</label>
            @endif
          </div>
           @endforeach
       </div>

       <h3>Tags</h3>
       <div class="cat-checks">
        @foreach($allTags as $ctag)
        <div class="form-check2">
          @if(in_array($ctag->id, $currentTags))
          <input class="form-check-input" type="checkbox" name="tags[]" id="{{ 'ckt'.$ctag->slug }}" value="{{ $ctag->id }}" checked />
          <label class="form-check-label" for="{{ 'ck'.$ctag->name }}">{{ $ctag->name }}</label>
          @else
          <input class="form-check-input" type="checkbox" name="tags[]" id="{{ 'ckt'.$ctag->slug }}" value="{{ $ctag->id }}"  />
          <label class="form-check-label" for="{{ 'ck'.$ctag->name }}">{{ $ctag->name }}</label>
          @endif
        
        </div>
        @endforeach
         
       </div>

      </div>
  </div>
 </form>
@endsection