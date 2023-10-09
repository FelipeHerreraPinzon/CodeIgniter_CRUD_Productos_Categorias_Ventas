<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Categoria;

class CategoriaController extends BaseController
{
    public function index() {

       return view('categorias/index');
    }

     // agregar nueva categoria
     public function agregar() {
       

        $datos = [
            'nombre_categoria' => $this->request->getPost('nombre_categoria'),
            'created_at' => date('Y-m-d H:i:s')
        ];

       
            $ModelCateg = new Categoria();
            $ModelCateg->save($datos);
            return $this->response->setJSON([
                'error' => false,
                'message' => 'Categoría agregada exitosamente !!!'
            ]);
        
    }


     // mostrar categorias
     public function mostrar() {
        $ModelCateg = new Categoria();
        $categorias = $ModelCateg->findAll();
        $datos = '';

        if ($categorias) {
            foreach ($categorias as $categoria) {
                $datos .= '<tr>
                <td>' . $categoria['id'] . '</td>
                <td>' . $categoria['nombre_categoria'] . '</td>
                <td>' . date('d F Y', strtotime($categoria['created_at'])) . '</td>
                <td><a href="#" id="' . $categoria['id'] . '" data-bs-toggle="modal" data-bs-target="#modal_editar_categoria" class="btn btn-warning btn-sm boton_editar_categoria">Editar</a></td>
                <td><a href="#" id="' . $categoria['id'] . '" class="btn btn-danger btn-sm post_delete_btn">Eliminar</a></td>
                </tr>';
            }
            return $this->response->setJSON([
                'error' => false,
                'message' => $datos
            ]);
        } else {
            return $this->response->setJSON([
                'error' => false,
                'message' => '<div class="text-secondary text-center fw-bold my-5">Aun no hay categorías...</div>'
            ]);
        }
    }


    // handle edit post ajax request
    public function editar($id = null) {
        $ModelCateg = new Categoria();
        $categoria = $ModelCateg->find($id);
        return $this->response->setJSON([
            'error' => false,
            'message' => $categoria
        ]);
    }


   // handle update post ajax request
   public function actualizar() {
    $id = $this->request->getPost('id');
 
 
    $datos = [
        'nombre_categoria' => $this->request->getPost('nombre_categoria'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    $ModelCateg = new Categoria();
    $ModelCateg->update($id, $datos);
    return $this->response->setJSON([
        'error' => false,
        'message' => 'Categoría Actualizada !!!'
    ]);
}

  // handle delete post ajax request
  public function eliminar($id = null) {
    $ModelCateg = new Categoria();
    $categoria = $ModelCateg->find($id);
    $ModelCateg->delete($id);
   
    return $this->response->setJSON([
        'error' => false,
        'message' => 'Categoria Eliminada !!!'
    ]);
}


}
