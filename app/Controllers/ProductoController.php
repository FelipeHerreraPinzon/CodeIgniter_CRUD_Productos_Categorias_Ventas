<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Producto;
use App\Models\Categoria;

class ProductoController extends BaseController
{
    public function index()
    {
        $categoriaModel = new Categoria();

		$data['categorias'] = $categoriaModel->findAll();
        
        return view('productos/index', $data);
    }

     // agregar nuevo producto
     public function agregar() {
       

        $datos = [
            'nombre_producto' => $this->request->getPost('nombre_producto'),
            'categoria_producto' => $this->request->getPost('categoria_producto'),
            'stock_producto' => $this->request->getPost('stock_producto'),
            'created_at' => date('Y-m-d H:i:s')
        ];

       
            $ModelProducto = new Producto();
            $ModelProducto->save($datos);
            return $this->response->setJSON([
                'error' => false,
                'message' => 'Producto agregado exitosamente !!!'
            ]);
        
    }

     // mostrar productos
     public function mostrar() {
        $ModelProducto = new Producto();
        $productos = $ModelProducto->findAll();
        $datos = '';

        if ($productos) {
            foreach ($productos as $producto) {
                $datos .= '<tr>
                <td>' . $producto['id'] . '</td>
                <td>' . $producto['nombre_producto'] . '</td>
                <td>' . $producto['categoria_producto'] . '</td>
                <td>' . $producto['stock_producto'] . '</td>
                <td>' . date('d F Y', strtotime($producto['created_at'])) . '</td>
                <td><a href="#" id="' . $producto['id'] . '" data-bs-toggle="modal" data-bs-target="#modal_editar_producto" class="btn btn-warning btn-sm boton_editar_producto">Editar</a></td>
                <td><a href="#" id="' . $producto['id'] . '" class="btn btn-danger btn-sm boton_eliminar_producto">Eliminar</a></td>
                </tr>';
            }
            return $this->response->setJSON([
                'error' => false,
                'message' => $datos
            ]);
        } else {
            return $this->response->setJSON([
                'error' => false,
               
                'message' => '<td class="text-secondary text-center fw-bold p-5" colspan="7">Aun no hay productos...</td>'
            ]);
        } 
    }

     // Editar Producto
     public function editar($id = null) {
        $ModelProducto = new Producto();
        $producto = $ModelProducto->find($id);
        return $this->response->setJSON([
            'error' => false,
            'message' => $producto
        ]);

    }

       // Actualizar Producto
   public function actualizar() {
    $id = $this->request->getPost('id');
 
    $datos = [
        'nombre_producto' => $this->request->getPost('nombre_producto'),
        'categoria_producto' => $this->request->getPost('categoria_producto'),
        'stock_producto' => $this->request->getPost('stock_producto'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    $ModelProducto = new Producto();
    $ModelProducto->update($id, $datos);
    return $this->response->setJSON([
        'error' => false,
        'message' => 'Producto Actualizado !!!'
    ]);
}


  // Eliminar Producto
  public function eliminar($id = null) {
    $ModelProducto = new Producto();
    $producto = $ModelProducto->find($id);
    $ModelProducto->delete($id);
   
    return $this->response->setJSON([
        'error' => false,
        'message' => 'Producto Eliminado !!!'
    ]);
}

     




}
