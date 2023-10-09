<?= $this->extend('layouts/template')  ?>

<?= $this->section('contenido')  ?>

 <!-- add new post modal start -->
 <div class="modal fade" id="modal_agregar_producto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Crear Venta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="POST" id="form_agregar_producto" novalidate>
          <div class="modal-body p-5">
            <div class="mb-3">
              <label>Nombre Producto</label>
              <input type="text" name="nombre_producto" class="form-control" placeholder="Ingresa Producto" required>
              <div class="invalid-feedback">El nombre Producto es requerido!</div>
            </div>

            <div class="mb-3">
              <label>Categoría Producto</label>
              <select name="categoria_producto" class="form-control" id="categoria_producto" required>
          
              <option disabled selected>Seleccione una categoría...</option>
                                <?php
                              /*  foreach($categorias as $categoria)
                                {
                                    echo '<option value="'.$categoria["id"].'">'.$categoria["nombre_categoria"].'</option>';
                                }
                              */  ?>
            
              </select>
              <div class="invalid-feedback">Categoria de productto es requerida!</div>
            </div>

            <div class="mb-3">
              <label>Stock</label>
              <input type="number" name="stock_producto" class="form-control" placeholder="Ingresa Stock" required>
              <div class="invalid-feedback">El stock es requerido!</div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-success" id="boton_agregar_producto">Crear Producto</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- add new post modal end -->






    <!-- edit post modal start -->
    <div class="modal fade" id="modal_editar_producto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Editar Productoo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="POST"  id="form_editar_producto" novalidate>
          <input type="hidden" name="id" id="pid">
          <div class="modal-body p-5">
            <div class="mb-3">

              <label>Producto</label>
              <input type="text" name="nombre_producto" id="nombre_producto" class="form-control" required>
              <div class="invalid-feedback">Producto es obligatoria</div>
            </div>

            <div class="mb-3">
              <label>Categoría Producto</label>
              <select name="categoria_producto" class="form-control" id="categoria_producto" required>
              
                     <?php /*
                                foreach($categorias as $categoria)
                                {
                                    echo '<option value="'.$categoria["id"].'">'.$categoria["nombre_categoria"].'</option>';
                                } */
                    ?>
              </select>
              <div class="invalid-feedback">Categoria de producto es requerida!</div>
            </div>
 

            <div class="mb-3">
              <label>Stock</label>
              <input type="number" name="stock_producto" id="stock_producto" class="form-control" required>
              <div class="invalid-feedback">El stock es requerido!</div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-success" id="boton_editar_producto">Actualizar Producto</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- edit post modal end -->








  <div class="container p-1">
    <div class="row my-4">
      <div class="col-12">
       
        
            <div class="text-secondary fw-bold fs-3">Ventas</div>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal_agregar_producto">Crear Venta</button>
          </div>
          <table class="table-bordered mt-3">
    <th>ID</th>
    <th>Nombre</th>
    <th>Categoría</th>
    <th>Stock</th>
    <th>Fecha Creación</th>
    <th>Editar</th>
    <th>Eliminar</th> 
    <tbody id="mostrar_productos">
   
    <tr>
        <td colspan="5">
            <h1 class="text-center m-3">Cargando Ventas.....</h1>
        </td>
    </tr>
            
    </tbody>

  </table>
         
            
      
        </div>
      </div>
   







  <script>
    $(function() {
      // add new post ajax request
      $("#form_agregar_producto").submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        if (!this.checkValidity()) {
          e.preventDefault();
          $(this).addClass('was-validated');
        } else {
          $("#boton_agregar_producto").text("Agregando...");
          $.ajax({
            url: '<?= base_url('producto/agregar') ?>',
            method: 'post',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                $("#modal_agregar_producto").modal('hide');
                $("#form_agregar_producto")[0].reset();
                $("#form_agregar_producto").removeClass('was-validated');
                Swal.fire(
                  'Agregado !',
                  response.message,
                  'success'
                );
                fetchAllPosts();
              
              $("#boton_agregar_producto").text("Agregando...");
            }
          });
        }
      });




      // Editar Categoria
      
      $(document).delegate('.boton_editar_producto', 'click', function(e) {
        e.preventDefault();
        const id = $(this).attr('id');
        $.ajax({
          url: '<?= base_url('producto/editar/') ?>/' + id,
          method: 'get',
          success: function(response) {
            $("#pid").val(response.message.id);
          
            $("#nombre_producto").val(response.message.nombre_producto);
            $("#categoria_producto").val(response.message.categoria_producto);
            $("#stock_producto").val(response.message.stock_producto);
          }
        });
      });





      // Actualizar Categoria
      $("#form_editar_producto").submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        if (!this.checkValidity()) {
          e.preventDefault();
          $(this).addClass('was-validated');
        } else {
          $("#boton_editar_producto").text("Actualizando...");
          $.ajax({
            url: '<?= base_url('producto/actualizar') ?>',
            method: 'post',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
              $("#modal_editar_producto").modal('hide');
              Swal.fire(
                'Actualizado !!!',
                 response.message,
                'success'
              );
              fetchAllPosts();
              $("#boton_editar_producto").text("Actualizar Producto");
            }
          });
        }
      });

      // delete post ajax request
      $(document).delegate('.boton_eliminar_producto', 'click', function(e) {
        e.preventDefault();
        const id = $(this).attr('id');
        Swal.fire({
          title: 'Seguro que deseas borrar esto?',
          text: "Esta acción es irreversible!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sí, Borralo!',
          cancelButtonText: 'cancelar'
          
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '<?= base_url('producto/eliminar/') ?>/' + id,
              method: 'get',
              success: function(response) {
                Swal.fire(
                  'Eliminado!',
                  response.message,
                  'success'
                )
                fetchAllPosts();
              }
            });
          }
        })
      });




      // Mostrar Listado de Categorias
      fetchAllPosts();

      function fetchAllPosts() {
        $.ajax({
          url: '<?= base_url('producto/mostrar') ?>',
          method: 'get',
          success: function(response) {
            $("#mostrar_productos").html(response.message);
          }
        });
      }
    });




  </script>



<?= $this->endSection()  ?>