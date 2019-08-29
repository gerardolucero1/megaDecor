<?php

use App\Telephone;
use App\AboutCategory;
use App\MoralCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Example Routes
Route::view('/', 'landing');
Route::match(['get', 'post'], '/dashboard', function(){
    return view('dashboard');
});



Auth::routes();

Route::group(['middleware' => ['auth'] 
], function(){

//ruta dashboard
Route::get('/dashboard', 'CMS\IndexController@dashboard');

// Rutas del CMS
    // API Clientes
    Route::get('/telefonos', 'CMS\ClientController@telefonos');
    Route::get('/categorias', 'CMS\ClientController@categorias');
    Route::get('/about-categorias', 'CMS\ClientController@aboutCategorias');
    Route::post('/viejo-telefono', 'CMS\ClientController@viejoTelefono');
    Route::post('/clientes/crearTipoEmpresa', 'CMS\ClientController@createC')->name('NuevoTipo.createC');
    Route::get('/clientes/tipo-empresa', 'CMS\ClientController@TipoEmpresa');
    Route::delete('/viejo-telefono/{id}', 'CMS\ClientController@deleteViejoTelefono');
    Route::delete('/clientes/eliminar-tipo-empresa/{id}', 'CMS\ClientController@deleteTipo');
    //Como supo de nosotors
    Route::post('/clientes/crearComoSupo', 'CMS\ClientController@createComoSupo')->name('NuevoComoSupo.createComoSupo');
    Route::get('/clientes/comoSupo', 'CMS\ClientController@ComoSupo');
    Route::delete('/clientes/eliminar-comoSupo/{id}', 'CMS\ClientController@deleteComoSupo');
    //Tareas
    Route::get('/tareas/categorias-tareas', 'CMS\TareasController@Categorias');
    Route::get('/tareas/editar-categorias-tareas', 'CMS\TareasController@editarCategoria');
    Route::delete('/tareas/eliminar-categoria/{id}', 'CMS\TareasController@deleteCategoria');
    Route::delete('/tareas/eliminar-tarea/{id}', 'CMS\TareasController@deleteTarea');
    Route::get('/tareas/obtener-tareas', 'CMS\TareasController@ObtenerTareas');
    Route::get('/tareas/clientes-fisicos', 'CMS\TareasController@ClientesF');
    Route::post('/tareas/create', 'CMS\TareasController@store')->name('NuevaTarea.store');
    Route::post('/tareas/createcategory', 'CMS\TareasController@createC')->name('NuevaCategory.createC');

Route::get('/clientes', 'CMS\IndexController@clientes')->name('clientes');
Route::get('/presupuestos', 'CMS\IndexController@presupuestos')->name('presupuestos');
Route::get('/contratos', 'CMS\IndexController@contratos')->name('contratos');
Route::get('/comisiones', 'CMS\IndexController@comisiones')->name('comisiones');

    // API Presupuestos
    Route::get('/usuarios', 'CMS\BudgetController@usuarios');
    Route::post('/obtener-cliente', 'CMS\BudgetController@cliente');
    Route::get('/obtener-clientes', 'CMS\BudgetController@clientes');
    Route::get('/obtener-inventario', 'CMS\BudgetController@inventario');


    //Pantalla Usuarios
    Route::get('/pantallaUsuarios', 'CMS\IndexController@pantallaUsuarios')->name('pantallaUsuarios');


// Todo lo referente a presupuestos
Route::get('/presupuestos', 'CMS\IndexController@presupuestos')->name('presupuestos');
Route::post('/presupuestos/create', 'CMS\BudgetController@store')->name('presupuestos.store');

// Todo lo referente a clientes
Route::get('/clientes', 'CMS\IndexController@clientes')->name('clientes');
Route::post('/clientes/create', 'CMS\ClientController@store')->name('cliente.store');

});
  
    //clientes






Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function(){
    Route::post('roles/store')->name('roles.store')
    ->middleware('permission:roles.create');
});





//Rutas para permisos