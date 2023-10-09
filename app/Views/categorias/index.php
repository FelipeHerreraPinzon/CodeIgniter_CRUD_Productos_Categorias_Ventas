<?= $this->extend('layouts/template')  ?>

<?= $this->section('contenido')  ?>

 <!-- add new post modal start -->
 <div class="modal fade" id="modal_agregar_categoria" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Crear Categoría</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="POST" id="form_agregar_categoria" novalidate>
          <div class="modal-body p-5">
            <div class="mb-3">
              <label>Nombre Categoría</label>
              <input type="text" name="nombre_categoria" class="form-control" placeholder="Ingresa Categoría" required>
              <div class="invalid-feedback">El nombre Categoria es requerido!</div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-success" id="boton_agregar_categoria">Crear Categoría</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- add new post modal end -->






    <!-- edit post modal start -->
    <div class="modal fade" id="modal_editar_categoria" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Editar Categoria</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="#" method="POST"  id="form_editar_categoria" novalidate>
          <input type="hidden" name="id" id="pid">
          <div class="modal-body p-5">
            <div class="mb-3">

              <label>Categoria</label>
              <input type="text" name="nombre_categoria" id="nombre_categoria" class="form-control" required>
              <div class="invalid-feedback">Categoría es obligatoria</div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-success" id="boton_editar_categoria">Actualizar Categoría</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- edit post modal end -->








  <div class="container p-1">
    <div class="row my-4">
      <div class="col-12">
       
        
            <div class="text-secondary fw-bold fs-3">Lista de Categorías</div>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal_agregar_categoria">Agregar Nueva Categoría</button>
          </div>
          <table class="table-bordered mt-3">
    <th>ID</th>
    <th>Nombre</th>
    <th>Fecha Creación</th>
    <th>Editar</th>
    <th>Eliminar</th> 
    <tbody id="mostrar_categorias">
   
    <tr>
        <td colspan="5">
            <h1 class="text-center m-3">Cargando Categorías.....</h1>
        </td>
    </tr>
            
    </tbody>

  </table>
         
            
      
        </div>
      </div>
   







  <script>
    $(function() {
      // Agregar Categoria
      $("#form_agregar_categoria").submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        if (!this.checkValidity()) {
          e.preventDefault();
          $(this).addClass('was-validated');
        } else {
          $("#boton_agregar_categoria").text("Agregando...");
          $.ajax({
            url: '<?= base_url('categoria/agregar') ?>',
            method: 'post',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                $("#modal_agregar_categoria").modal('hide');
                $("#form_agregar_categoria")[0].reset();
                $("#form_agregar_categoria").removeClass('was-validated');
                Swal.fire(
                  'Agregada !',
                  response.message,
                  'success'
                );
                fetchAllPosts();
              
              $("#boton_agregar_categoria").text("Agregar Categoria");
            }
          });
        }
      });

      // Editar Categoria
      $(document).delegate('.boton_editar_categoria', 'click', function(e) {
        e.preventDefault();
        const id = $(this).attr('id');
        $.ajax({
          url: '<?= base_url('categoria/editar/') ?>/' + id,
          method: 'get',
          success: function(response) {
            $("#pid").val(response.message.id);
          
            $("#nombre_categoria").val(response.message.nombre_categoria);
          }
        });
      });

      // Actualizar Categoria
      $("#form_editar_categoria").submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        if (!this.checkValidity()) {
          e.preventDefault();
          $(this).addClass('was-validated');
        } else {
          $("#boton_editar_categoria").text("Actualizando...");
          $.ajax({
            url: '<?= base_url('categoria/actualizar') ?>',
            method: 'post',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
              $("#modal_editar_categoria").modal('hide');
              Swal.fire(
                'Actualizado !!!',
                 response.message,
                'success'
              );
              fetchAllPosts();
              $("#boton_editar_categoria").text("Actualizar Categoria");
            }
          });
        }
      });

      // Eliminar Categoria
      $(document).delegate('.post_delete_btn', 'click', function(e) {
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
              url: '<?= base_url('categoria/eliminar/') ?>/' + id,
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
          url: '<?= base_url('categoria/mostrar') ?>',
          method: 'get',
          success: function(response) {
            $("#mostrar_categorias").html(response.message);
          }
        });
      }
    });
  </script>



<?= $this->endSection()  ?>