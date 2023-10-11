<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\Venta;
use App\Models\Producto;

class VentaController extends BaseController
{




    public function index()
    {
        $productoModel = new Producto();

		$data['productos'] = $productoModel->findAll();

        return view('ventas/index', $data);

        
    }

    public function cargarProductos(){
        $model = new Producto();
          $prod = $model->findAll();
            echo json_encode($prod);
    }


      // agregar venta
      public function agregar() {

        $id_producto = $this->request->getPost('id_producto'); // obtener el id del producto para actualizar stock

       
        $datos = [
        
            'producto' => $this->request->getPost('producto'),
            'cantidad' => $this->request->getPost('cantidad'),
            'created_at' => date('Y-m-d H:i:s')
        ];
   
        $modelProducto = new Producto();
        $producto = $modelProducto->where('id', $id_producto)->first();
        $stockActual = $producto['stock_producto'];
        $cantidadComprada = $datos['cantidad'];
           
        $nuevoStock = $stockActual - $cantidadComprada;
       //  $id = $datos['producto'];


 
    $updateData = [
     
        'stock_producto' => $nuevoStock
    ];

    $modelProducto->update($id_producto, $updateData);

    $ModelVenta = new Venta();
    $ModelVenta->save($datos);


    return $this->response->setJSON([
        'error' => false,
        'message' => 'Venta Registrada exitosamente !!!'
    ]);



    return $this->response->setJSON([
        'error' => false,
        'message' => 'Stock Actualizado !!!'
    ]);



        
      /*
        return $this->response->setJSON([
            'producto' => $producto,
            'stocactual' =>  $stockActual,
            'cantidadComprada' =>  $cantidadComprada,
            'nuevoStock' =>   $nuevoStock,
            'id' =>   $id,

        ]);

        die();

        */

           
        
            
    }

     // mostrar ventas
     public function mostrar() {
        $ModelVenta = new Venta();
        $ventas = $ModelVenta->findAll();
        $datos = '';

        if ($ventas) {
            foreach ($ventas as $venta) {
                $datos .= '<tr>
                <td>' . $venta['id'] . '</td>
                <td>' . $venta['producto'] . '</td>
                <td>' . $venta['cantidad'] . '</td>
                <td>' . date('d F Y', strtotime($venta['created_at'])) . '</td>
                <td><a href="#" id="' . $venta['id'] . '" data-bs-toggle="modal" data-bs-target="#modal_editar_venta" class="btn btn-warning btn-sm boton_editar_venta">Editar</a></td>
                <td><a href="#" id="' . $venta['id'] . '" class="btn btn-danger btn-sm boton_eliminar_venta">Eliminar</a></td>
                </tr>';
            }
            return $this->response->setJSON([
                'error' => false,
                'message' => $datos
            ]);
        } else {
            return $this->response->setJSON([
                'error' => false,
               
                'message' => '<td class="text-secondary text-center fw-bold p-5" colspan="7">Aun no hay ventas registradas...</td>'
            ]);
        } 
    }


     // Editar Venta
     public function editar($id) {
        $ModelVenta = new Venta();
        $venta = $ModelVenta->find($id);
        return $this->response->setJSON([
            'error' => false,
            'message' => $venta
        ]);

    }

           // Actualizar Venta
   public function actualizar() {
    $id = $this->request->getPost('id');
 
    $datos = [
        'producto' => $this->request->getPost('producto'),
        'cantidad' => $this->request->getPost('cantidad'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    $ModelVenta = new Venta();
    $ModelVenta->update($id, $datos);
    return $this->response->setJSON([
        'error' => false,
        'message' => 'Venta Actualizada !!!'
    ]);
}

  // Eliminar Venta
  public function eliminar($id = null) {
    $ModelVenta = new Venta();
    $venta = $ModelVenta->find($id);
    $ModelVenta->delete($id);
   
    return $this->response->setJSON([
        'error' => false,
        'message' => 'Venta Anulada !!!'
    ]);
}



}
