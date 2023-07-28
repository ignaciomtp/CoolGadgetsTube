    @extends('layouts.baseadmin')

    @section('title', 'Page Title')

    @section('content')


      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Añadir Tag</h1>

      </div>


    <div class="col-md-6">
      <form  action="{{ route('createtag') }}" method="post" enctype="multipart/form-data">
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

        <div class="mb-3 row">
          <div class="col-5">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" name="name" id="name" required >
          </div>

          <div class="col-5">
            <label for="category_id">Categoría</label>
            <select class="form-control" name="category_id" id="category_id">
              <option value="0"> -- </option>
              @foreach($categories as $cat)
              <option value="{{ $cat->id }}">{{ $cat->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-2">
            <label for="icon">Icono</label>
            <input type="text" class="form-control" name="icon" id="icon" >
          </div>
          
        </div>


        <div class="mb-3">
          <label for="description">Descripción corta:</label>
          <textarea class="form-control" name="description" rows="6" id="description" ></textarea>
        </div>

        <div class="mb-3">
          <label for="description_long">Descripción larga:</label>
          <textarea class="form-control" name="description_long" rows="6" id="description_long" ></textarea>
        </div>


        <button class="btn btn-primary btn-lg btn-block" type="submit">Guardar</button>
      </form>
    </div>
@endsection