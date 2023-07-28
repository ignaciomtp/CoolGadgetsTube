<script>
  
var products = [];

function buscar() {
  let term = $('#busqueda').val();

  let url = window.location.origin + '/admin/product/search2/' + term;

      $.ajax({
          url: url,
          type : 'GET',
          success: function(result){
            $('#searchResults').html(result);
           
          },
      });   
}

function addProduct(id) {
  products.push(id);
  $('#selectedProducts').val(products);
}

</script>