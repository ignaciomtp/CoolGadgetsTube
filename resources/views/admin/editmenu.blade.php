    @extends('layouts.baseadmin')

    @section('title', 'Page Title')

    @section('content')


      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Editar Artículo</h1>

      </div>

<form enctype="multipart/form-data" action="{{ route('updatemenu', ['id' => $menu->id]) }}" method="post">
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
      <div class="col-md-5">        

        <div class="row mb-2">
          <div class="col-md-12">
            <label for="nombre">Nombre</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $menu->name }}" >
          </div>

          
        </div>



          <button class="btn btn-primary btn-lg btn-block" type="submit">Guardar</button>
       
      </div>


  </div>
 </form>
@endsection