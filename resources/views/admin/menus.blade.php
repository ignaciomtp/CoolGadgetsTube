    @extends('layouts.baseadmin')

    @section('title', 'Admin')

    @section('content')


      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Elementos Menú </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <a href="{{ route('addmenu') }}" class="btn btn-info">Añadir</a>
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th>Id</th>
              <th>Nombre</th>
            
             
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @if($items->count())  
              @foreach($items as $item)  
              <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->name }}</td>
          
                <td><a class="btn btn-sm btn-info" href="{{ route('editmenu', ['id' => $item->id]) }}" >Editar</a></td>
                <td>
                  <a class="btn btn-sm btn-danger" href="#" data-id="{{ $item->id }}" data-name="{{ $item->name }}" >
                    Borrar
                  </a>
                </td>
              </tr>
              @endforeach 
               @else
               <tr>
                <td colspan="8">No hay registro !!</td>
              </tr>
            @endif
          </tbody>
        </table>

       
      </div>
    
   
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="{{ route('deletecategory') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">¿Seguro que quieres borrar esta categoría?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h2 id="catName"></h2>
          <input type="text" name="id" id="catId" readonly />
        </div>
        <div class="modal-footer">
          <button type="submit" id="buttonDelete" class="btn btn-primary">Borrar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>

  $(document).ready(function() {
      
      $('.btn-danger').on("click", borrar);
    });
  
  function borrar(){

    let id = this.dataset.id;
    let name = this.dataset.name;

    $('#catName').html(name);
    $('#catId').val(id);

    $('#confirmDelete').modal('show');
  }

</script>


@endsection