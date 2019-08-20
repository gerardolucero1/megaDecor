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
Route::get('/dashboard', 'CMS\IndexController@dashboard');
Route::view('/examples/plugin-helper', 'examples.plugin_helper');
Route::view('/examples/plugin-init', 'examples.plugin_init');
Route::view('/examples/blank', 'examples.blank');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Rutas del CMS
    // API Formularios

    /*
    Route::get('/telefonos', function(){
        return App\Telephone::orderBy('id', 'DESC')->get();
    });

    Route::get('/categorias', function(){
        return App\MoralCategory::orderBy('id', 'DESC')->get();
    });

    Route::get('/about-categorias', function(){
        return App\AboutCategory::orderBy('id', 'DESC')->get();
    });

    Route::post('/viejo-telefono', function(Request $request){

        $cliente = DB::table('moral_people')
            ->join('telephones', 'telephones.cliente_id', '=', 'moral_people.cliente_id')
            ->select('moral_people.nombre')
            ->get();

        $tamano = count($cliente);
        
        if($tamano == 0){

            $cliente = DB::table('physical_people')
            ->join('telephones', 'telephones.cliente_id', '=', 'physical_people.cliente_id')
            ->select('physical_people.nombre')
            ->get();

        }

        
        return $cliente;
    });
    */
    //clientes
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


// Todo lo referente a clientes
Route::post('/clientes/create', 'CMS\ClientController@store')->name('cliente.store');





