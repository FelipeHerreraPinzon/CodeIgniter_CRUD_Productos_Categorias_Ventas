<?= $this->extend('layouts/template')  ?>

<?= $this->section('contenido')  ?>

 <!-- add new post modal start -->
 <div class="modal fade" id="modal_agregar_venta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Crear Venta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="POST" id="form_agregar_venta" novalidate>
          <div class="modal-body p-5">
            

            <div class="mb-3">
              <label>Producto</label>
              <select name="producto" class="form-control" id="producto" required>
          
              <option disabled selected>Seleccione un producto</option>
                                <?php
                                foreach($productos as $producto)
                                {
                                    echo '<option value="'.$producto["id"].'" data-stock="'.$producto["stock_producto"].'">'.$producto["nombre_producto"].'</option>';
                                }
                                ?>
            
              </select>
              <div class="invalid-feedback">Producto es obligatorio!</div>
              <div id="infoStock"></div>
            </div>

       

            <div class="mb-3">
              <label>Cantidad</label>
              <input type="number" name="cantidad" id="cantidad" class="form-control" placeholder="Ingresa Cantidad" required>
              <div class="invalid-feedback">La cantidad es requerida!</div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-success" id="boton_agregar_venta">Registrar Venta</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- add new post modal end -->






    <!-- edit post modal start -->
    <div class="modal fade" id="modal_editar_venta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Editar Venta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="POST"  id="form_editar_venta" novalidate>
          <input type="hidden" name="id" id="pid">
          <div class="modal-body p-5">
          <div class="mb-3">
              <label>Producto</label>
              <select name="producto" class="form-control" id="producto" required>
          
              <?php
                                foreach($productos as $producto)
                                {
                                    echo '<option value="'.$producto["id"].'">'.$producto["nombre_producto"].'</option>';
                                }
                                ?>
            
              </select>
              <div class="invalid-feedback">Producto es obligatorio!</div>
            </div>

          
 
            <div class="mb-3">
              <label>Cantidad</label>
              <input type="number" name="cantidad" id="cantidad" class="form-control" required>
              <div class="invalid-feedback">La cantidad es requerida!</div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-success" id="boton_editar_venta">Actualizar Venta</button>
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
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal_agregar_venta">Crear Venta</button>
          </div>
          <table class="table-bordered mt-3">
    <th>ID</th>
    <th>Producto</th>
    <th>Cantidad</th>
    <th>Fecha Creación</th>
    <th>Editar</th>
    <th>Eliminar</th> 
    <tbody id="mostrar_ventas">
   
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

     
      
// Agregar venta..
$("#form_agregar_venta").submit(function(e) {
    e.preventDefault(); // Evita el envío del formulario por defecto
    const formData = new FormData(this);

    var stock = parseInt($("#producto option:selected").data("stock"), 10); // Obtener el stock como un número entero
    var cantidadCompra = parseInt($("#cantidad").val(), 10); // Obtener la cantidad de compra como un número entero

    if (cantidadCompra > stock) {
      Swal.fire({
      icon: 'warning',
      title: 'No hay Stock suficiente',
      text: 'Intenta de nuevo',
})
    } else if (!this.checkValidity()) {
        $(this).addClass('was-validated');
    } else {
        $("#boton_agregar_venta").text("Agregando...");
        $.ajax({
            url: '<?= base_url('venta/agregar') ?>',
            method: 'post',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                $("#modal_agregar_venta").modal('hide');
                $("#form_agregar_venta")[0].reset();
                $("#form_agregar_venta").removeClass('was-validated');
                Swal.fire(
                    'Agregado !',
                    response.message,
                    'success'
                );
                fetchAllPosts();

                $("#boton_agregar_venta").text("Agregar Venta");
            }
        });
    }
});

/// Validar Stock
$("#producto").change(function() {
                var productoSeleccionado = $("#producto").val();
                var stock = $("#producto option:selected").data("stock");
                $("#infoStock").html("Del producto: " + productoSeleccionado + ", hay: " + stock + " unidades en stock");
            
            });



      // Editar Venta
      
      $(document).delegate('.boton_editar_venta', 'click', function(e) {
        e.preventDefault();
        const id = $(this).attr('id');
        $.ajax({
          url: '<?= base_url('venta/editar/') ?>/' + id,
          method: 'get',
          success: function(response) {
            $("#pid").val(response.message.id);
          
            $("#producto").val(response.message.producto);
            $("#cantidad").val(response.message.cantidad);
          }
        });
      });





      // Actualizar Venta
      $("#form_editar_venta").submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        if (!this.checkValidity()) {
          e.preventDefault();
          $(this).addClass('was-validated');
        } else {
          $("#boton_editar_venta").text("Actualizando...");
          $.ajax({
            url: '<?= base_url('venta/actualizar') ?>',
            method: 'post',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
              $("#modal_editar_venta").modal('hide');
              Swal.fire(
                'Actualizado !!!',
                 response.message,
                'success'
              );
              fetchAllPosts();
              $("#boton_editar_venta").text("Actualizar Venta");
            }
          });
        }
      });

      // eliminar venta
      $(document).delegate('.boton_eliminar_venta', 'click', function(e) {
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
              url: '<?= base_url('venta/eliminar/') ?>/' + id,
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




      // Mostrar Ventas Realizadas
      fetchAllPosts();

      function fetchAllPosts() {
        $.ajax({
          url: '<?= base_url('venta/mostrar') ?>',
          method: 'get',
          success: function(response) {
            $("#mostrar_ventas").html(response.message);
          }
        });
      }
    });




  </script>



<?= $this->endSection()  ?>