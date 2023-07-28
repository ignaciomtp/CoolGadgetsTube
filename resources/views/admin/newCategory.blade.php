    @extends('layouts.baseadmin')

    @section('title', 'Page Title')

    @section('content')


      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Añadir Categoría</h1>

      </div>


    <div class="col-md-6" >
      <form  action="{{ route('createcategory') }}" method="post" enctype="multipart/form-data">
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

        <div class="mb-3">
          <label for="name">Nombre</label>
          <input type="text" class="form-control" name="name" id="name" required >
        </div>

        <div class="mb-3 row">
          <div class="col-6">
            <label for="image">Imagen</label>
            <input type="file" class="form-control" name="image" id="image"  >
          </div>
          <div class="col-6">
            <label for="icon">Icono</label>
            <input type="text" class="form-control" name="icon" id="icon">
          </div>
          
        </div>

        <div class="mb-3">
          <label for="description_short">Descripción corta</label>
          <textarea class="form-control" name="description_short" id="description_short" ></textarea>
        </div>

        <div class="mb-3">
          <label for="description_long">Descripción larga</label>
          <textarea class="form-control" name="description_long" rows="6" id="description_long" ></textarea>
        </div>

        <div class="mb-3">
          <label for="menu_id">Incluída en menú</label>
                <select class="form-control" name="menu_id" id="menu_id">
                  <option value="0"> -- </option>
                  @foreach($menus as $mi)
                    <option value="{{ $mi->id }}">{{ $mi->name }}</option>
                  @endforeach
                </select>
        </div>

        <button class="btn btn-primary btn-lg btn-block" type="submit">Guardar</button>
      </form>
    </div>
@endsection