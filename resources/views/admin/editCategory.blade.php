    @extends('layouts.baseadmin')

    @section('title', 'Page Title')

    @section('content')


      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Editar Categoría</h1>

      </div>

  <form enctype="multipart/form-data" action="{{ route('updatecategory', ['id' => $category->id] ) }}" method="post">
        @csrf
 <div class="row">


        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <div class="col-md-6">
      

        <div class="mb-3">
          <label for="nombre">Nombre</label>
          <input type="text" class="form-control" name="name" id="name" required value="{{ $category->name }}" >
        </div>

        <div class="mb-3 row">
          <div class="col-6">
            <label for="image">Imagen</label>
            <input type="file" class="form-control" name="image" id="image"  >
          </div>
          <div class="col-6">
            <label for="icon">Icono</label>
            <input type="text" class="form-control" name="icon" id="icon" value="{{ $category->icon }}">
          </div>
          
        </div>

        <div class="mb-3">
          <label for="description_short">Descripción corta</label>
          <textarea class="form-control" name="description_short" id="description_short" rows="3"  >{{ $category->description_short }}</textarea>
        </div>

        <div class="mb-3">
          <label for="description_long">Descripción larga</label>
          <textarea class="form-control" name="description_long" id="description_long" rows="6"  >{{ $category->description_long }}</textarea>
        </div>

        <button class="btn btn-primary btn-lg btn-block" type="submit">Guardar</button>
      
    </div>

    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ asset('img/' . $category->image ) }}" class="img-fluid" alt="{{ $category->name }}" />
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                  <label for="interlink_1">Interlink 1</label>
                  <select class="form-control" name="interlink_1" id="interlink_1" >
                      <option value="0"> -- enlace a -- </option>
                      @foreach($allCategories as $cat)
                        @if($cat->id != $category->id)
                          @if($cat->id == $category->interlink_1)
                            <option value="{{ $cat->id }}" selected >{{ $cat->name }}</option>
                          @else
                            <option value="{{ $cat->id }}"  >{{ $cat->name }}</option>
                          @endif
                        @endif
                      @endforeach
                  </select>

              </div>

              <div class="mb-3">
                  <label for="interlink_2">Interlink 2</label>
                  <select class="form-control" name="interlink_2" id="interlink_2" >
                      <option value="0"> -- enlace a -- </option>
                      @foreach($allCategories as $cat)
                        @if($cat->id != $category->id)
                          @if($cat->id == $category->interlink_2)
                            <option value="{{ $cat->id }}" selected >{{ $cat->name }}</option>
                          @else
                            <option value="{{ $cat->id }}"  >{{ $cat->name }}</option>
                          @endif
                        @endif
                      @endforeach
                  </select>

              </div>

              <div class="mb-3">
                  <label for="interlink_3">Interlink 3</label>
                  <select class="form-control" name="interlink_3" id="interlink_3" >
                      <option value="0"> -- enlace a -- </option>
                      @foreach($allCategories as $cat)
                        @if($cat->id != $category->id)
                          @if($cat->id == $category->interlink_3)
                            <option value="{{ $cat->id }}" selected >{{ $cat->name }}</option>
                          @else
                            <option value="{{ $cat->id }}"  >{{ $cat->name }}</option>
                          @endif
                        @endif
                      @endforeach
                  </select>

              </div>

              <div class="mb-3">
                  <label for="interlink_4">Interlink 4</label>
                  <select class="form-control" name="interlink_4" id="interlink_4" >
                      <option value="0"> -- enlace a -- </option>
                      @foreach($allCategories as $cat)
                        @if($cat->id != $category->id)
                          @if($cat->id == $category->interlink_4)
                            <option value="{{ $cat->id }}" selected >{{ $cat->name }}</option>
                          @else
                            <option value="{{ $cat->id }}"  >{{ $cat->name }}</option>
                          @endif
                        @endif
                      @endforeach
                  </select>

              </div>
              
              <hr/>

              <div class="mb-3">
                <label for="menu_id">Incluída en menú</label>
                <select class="form-control" name="menu_id" id="menu_id">
                  <option value="0"> -- </option>
                  @foreach($menus as $mi)
                    @if($mi->id == $category->menu_id)
                      <option value="{{ $mi->id }}" selected>{{ $mi->name }}</option>
                    @else
                      <option value="{{ $mi->id }}">{{ $mi->name }}</option>
                    @endif
                  @endforeach
                </select>
              </div>


            </div>
        </div>

                
    </div>

</div>
</form>
@endsection