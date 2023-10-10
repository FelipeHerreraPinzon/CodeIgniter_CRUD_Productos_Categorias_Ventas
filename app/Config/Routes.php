<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'VentaController::index');


$routes->get('categorias', 'CategoriaController::index', ['as'=>'categorias_index']);
$routes->post('categoria/agregar', 'CategoriaController::agregar', ['as'=>'agregar_categoria']);
$routes->get('categoria/mostrar', 'CategoriaController::mostrar', ['as'=>'mostrar_categoria']);
$routes->get('categoria/editar/(:num)', 'CategoriaController::editar/$1', ['as'=>'editar_categoria']);
$routes->get('categoria/eliminar/(:num)', 'CategoriaController::eliminar/$1', ['as'=>'eliminar_categoria']);
$routes->post('categoria/actualizar', 'CategoriaController::actualizar', ['as'=>'actualizar_categoria']);


$routes->get('productos', 'ProductoController::index', ['as'=>'producto_index']);
$routes->post('producto/agregar', 'ProductoController::agregar', ['as'=>'agregar_producto']);
$routes->get('producto/mostrar', 'ProductoController::mostrar', ['as'=>'mostrar_producto']);
$routes->get('producto/editar/(:num)', 'ProductoController::editar/$1', ['as'=>'editar_producto']);
$routes->get('producto/eliminar/(:num)', 'ProductoController::eliminar/$1', ['as'=>'eliminar_producto']);
$routes->post('producto/actualizar', 'ProductoController::actualizar', ['as'=>'actualizar_producto']);

$routes->get('ventas', 'VentaController::index', ['as'=>'venta_index']);
$routes->post('venta/agregar', 'VentaController::agregar', ['as'=>'agregar_venta']);
$routes->get('venta/mostrar', 'VentaController::mostrar', ['as'=>'mostrar_venta']);
$routes->get('venta/editar/(:num)', 'VentaController::editar/$1', ['as'=>'editar_venta']);
$routes->get('venta/eliminar/(:num)', 'VentaController::eliminar/$1', ['as'=>'eliminar_venta']);
$routes->post('venta/actualizar', 'VentaController::actualizar', ['as'=>'actualizar_venta']);








       