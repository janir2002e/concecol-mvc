<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\ApiVendedores;
use MVC\Router;
use Controllers\LoginController;

use Controllers\PaginasController;
use Controllers\DashboardController;
use Controllers\AutomovilesController;
use Controllers\VendedoresController;

$router = new Router();

$router->get('/', [PaginasController::class, 'index']);
$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
$router->post('/logout', [LoginController::class, 'logout']);
$router->get('/registro', [LoginController::class, 'registro']); 
$router->post('/registro', [LoginController::class, 'registro']);
$router->get('/olvide', [LoginController::class, 'olvide']);
$router->post('/olvide', [LoginController::class, 'olvide']);
$router->get('/reestablecer', [LoginController::class, 'reestablecer']);
$router->post('/reestablecer', [LoginController::class, 'reestablecer']);

// confirmar cuenta
$router->get('/mensaje', [LoginController::class, 'mensaje']);
$router->get('/confirmar-cuenta', [LoginController::class, 'confirmar']);

// Área de Administracion
$router->get('/admin/dashboard', [DashboardController::class, 'index']);
$router->get('/admin/usuarios', [DashboardController::class, 'usuarios']);
// Automoviles
$router->get('/admin/automoviles', [AutomovilesController::class, 'index']);

// Vendedores
$router->get('/admin/vendedores', [VendedoresController::class, 'index']);
$router->get('/admin/vendedores/crear', [VendedoresController::class, 'crear']);
$router->post('/admin/vendedores/crear', [VendedoresController::class, 'crear']);
$router->get('/admin/vendedores/editar', [VendedoresController::class, 'editar']);
$router->post('/admin/vendedores/editar', [VendedoresController::class, 'editar']);
$router->get('/admin/vendedores/eliminarValidar', [VendedoresController::class, 'EliminarValidar']);
$router->post('/admin/vendedores/eliminar', [VendedoresController::class, 'eliminar']);

// Automoviles
$router->get('/admin/automoviles', [AutomovilesController::class, 'index']);
$router->post('/admin/automoviles', [AutomovilesController::class, 'index']);
$router->get('/admin/automoviles/crear', [AutomovilesController::class, 'crear']);
$router->post('/admin/automoviles/crear', [AutomovilesController::class, 'crear']);
$router->get('/admin/automoviles/update', [AutomovilesController::class, 'editar']);
$router->post('/admin/automoviles/update', [AutomovilesController::class, 'editar']);
$router->post('/admin/automoviles/eliminar', [AutomovilesController::class, 'eliminar']);

// Apis
$router->get('/api/vendedores', [ApiVendedores::class, 'index']);
$router->get('/api/vendedor', [ApiVendedores::class, 'vendedor']);

// Aréa publica
$router->get('/automoviles', [PaginasController::class, 'automoviles']);
$router->get('/automovil', [PaginasController::class, 'automovil']);
$router->get('/contacto', [PaginasController::class, 'contacto']);
$router->post('/contacto', [PaginasController::class, 'contacto']);
$router->get('/consejos', [PaginasController::class, 'consejos']);



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();