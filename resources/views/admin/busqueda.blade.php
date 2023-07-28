 @extends('layouts.baseadmin')

    @section('title', 'Admin')

    @section('content')


      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h2 class="h2">Resultados búsqueda: {{ $query }} ({{ count($items) }})</h2>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <a href="{{ route('addproduct') }}" class="btn btn-info">Añadir</a>
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
          
                <td><a class="btn btn-sm btn-info" href="{{ route('editproduct', ['id' => $item->id]) }}" >Editar</a></td>
                <td>
                  <button class="btn btn-sm btn-danger" 
                          data-id="{{ $item->id }}" data-name="{{ $item->name }}" >
                    Borrar
                  </button>
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
      <form method="post" action="{{ route('deleteproduct') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">¿Seguro que quieres borrar este artículo?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h2 id="artName"></h2>
          <input type="text" name="id" id="productId" readonly />
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

    $('#artName').html(name);
    $('#productId').val(id);

    $('#confirmDelete').modal('show');
  }

</script>

@endsection

